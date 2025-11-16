<?php

namespace App\Http\Controllers;

use App\Models\MasterClass\MasterClass;
use App\Models\MasterClass\MasterClassSession;
use App\Models\Order;
use App\Models\OrderAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Razorpay\Api\Api;

class OrdersController extends Controller
{
    public function captureOrder(Request $request)
    {
        // Validate request data
        $data = $request->validate([
            'tab' => 'required',
            'order_type'       => 'required|in:master_class,session',
            'sessions' => [
                'required_if:order_type,session',
                'array',
                'min:1'
            ],
            'sessions.*' => [
                'integer',
                'exists:master_class_sessions,id'
            ],
            'master_class_id'  => 'required|integer|exists:master_classes,id',
//            'session_id'       => 'nullable|integer|exists:master_class_sessions,id', // For single session purchase
//            'session_ids'      => 'nullable|array',                                   // For multi-session purchase
//            'session_ids.*'    => 'integer|exists:master_class_sessions,id',
//            'payment_method'   => 'nullable|string',
//            'transaction_id'   => 'nullable|string',
//            'payment_status'   => 'required|in:pending,completed,failed',
            'organization_id'  => 'nullable|integer|exists:organizations,id',
//            'name'             => 'nullable|string',
//            'email'            => 'nullable|string',
//            'phone'            => 'nullable|string',
            'venue_address'    => 'nullable|string',
            'country'          => 'nullable|string',
            'state'            => 'nullable|string',
            'city'             => 'nullable|string',
            'postal_code'      => 'nullable|string',
        ]);

        $user = auth()->user();
        $masterClass = MasterClass::findOrFail($data['master_class_id']);

        // Initialize order data array
        $orderData = [
            'user_id'           => $user->id,
            'organizer_id'      => $masterClass->user_id,
            'order_type'        => $data['order_type'],
            'purchase_orderId'  => 'purchase_order_' . Carbon::now('Asia/Kolkata')->timestamp,
            'master_class_id'   => $masterClass->id,
            'session_id'        => null,
            'organization_id'   => $data['organization_id'] ?? null,
            'timezone'          => $masterClass->timezone,
            'name'              => $data['name'] ?? $user->name,
            'email'             => $data['email'] ?? $user->email,
            'phone'             => $data['phone'] ?? $user->phone,
            'venue_address'     => $user->information->address ?? null,
            'country'           => $user->information->countryRel->name ?? null,
            'state'             => $user->information->stateRel->name ?? null,
            'city'              => $user->information->cityRel->name ?? null,
            'postal_code'       => $user->information->postal_code ?? null,
            'payment_status'    => 'pending',
//            'payment_method'    => $data['payment_method'],
//            'transaction_id'    => $data['transaction_id'] ?? null,
//            'isActive'          => true,
        ];
        $payableAmount = 0;
        if ($data['order_type'] === 'master_class') {
            $orderData['title'] = $masterClass->title;
            $orderData['orderId'] = 'order_' . Carbon::now('Asia/Kolkata')->timestamp . '_' . uniqid();
            $orderData['description'] = $masterClass->description;
            $orderData['original_price'] = $masterClass->price ?? 0;
            $orderData['discount_value'] = $masterClass->discount_value ?? 0;
            $orderData['discount_type'] = $masterClass->discount_type ?? null;

            $finalPrice = $masterClass->price;
            if (!empty($masterClass->discount_type) && $masterClass->discount_value) {
                if ($masterClass->discount_type === 'percent') {
                    $finalPrice -= ($masterClass->price * $masterClass->discount_value) / 100;
                } else {
                    $finalPrice -= $masterClass->discount_value;
                }
            }
            $orderData['final_price'] = $finalPrice;
            $order = Order::create($orderData);
            $payableAmount = $payableAmount + $orderData['final_price'];
        } elseif ($data['order_type'] === 'session') {
            // For multi-session support (frontend passing array of sessions)
            $sessionId = $data['sessions'] ?? null;
            $sessionIds = $data['sessions'] ?? ($sessionId ? [$sessionId] : []);
            $finalPrice = 0;
            $titles = [];
            $descriptions = [];

            foreach ($sessionIds as $sid) {

                $session = MasterClassSession::findOrFail($sid);
                $titles[] = $session->title;
                $descriptions[] = $session->session_description;

                $discount = 0;
                $price = $session->session_price;
                if (!empty($session->discount_type) && $session->session_price_discount) {
                    $discount = $session->discount_type === 'percent'
                        ? ($price * $session->session_price_discount) / 100
                        : $session->session_price_discount;
                    $price -= $discount;
                }
                $finalPrice = $price;

                $orderData['orderId'] = 'order_' . Carbon::now('Asia/Kolkata')->timestamp . '_' . uniqid();
                $orderData['session_id'] = $session->id;
                $orderData['title'] = $session->title;
                $orderData['organization_id'] = $masterClass->organization_id;
                $orderData['description'] = $session->session_description;
                $orderData['original_price'] = $session->session_price; // Optional: could sum original session prices
                $orderData['discount_value'] = $discount; // Optional: could sum per-session discounts
                $orderData['discount_type'] = $session->discount_type;  // Optional: could note mixed discounts
                $orderData['final_price'] = $finalPrice;
                $order = Order::create($orderData);

                $payableAmount += $orderData['final_price'];
            }
        }

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $razorpayOrder = $api->order->create([
            'receipt' => $order->purchase_orderId,
            'amount' => $payableAmount * 100,
            'currency' => 'INR',
            'payment_capture' => 1,
        ]);

        $rzpData = array_merge($razorpayOrder->toArray(), [
            'purchase_order_id' => $order->purchase_orderId,
            'key' => env('RAZORPAY_KEY'),
            'name' => $masterClass->title ?? 'MasterClass',
            'description' => $masterClass->title ?? '',
            'image' => '', // optional; update with your logo URL
//            'amount' => $payableAmount * 100, // in paise
            'currency' => 'INR',
            'order_id' => $razorpayOrder->id, // for Razorpay JS SDK
        ]);

//        dd($razorpayOrderData);

        return response()->json([
            'status' => true,
            'message' => 'Order captured successfully.',
            'order_id' => $order->orderId,
            'payment_status' => $order->payment_status,
            'razorpayOrderData' => $rzpData
        ]);
    }

    /*public function add_assignments(Request $request)
    {
        try {
            // Step 1: Validate input
            $validated = $request->validate([
                'order_id' => 'required|exists:orders,id',
                'master_class_id' => 'nullable|exists:master_classes,id',
                'session_id' => 'nullable|exists:master_class_sessions,id',
                'file' => 'required|file|mimes:pdf|max:2048', // 2 MB limit
            ]);

            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getClientMimeType();
            $fileSize = $file->getSize();

            // Step 2: Store file (uploaded by organizer while assigning)
            $path = $file->store('assignments/organizer', 'public');

            // Step 3: Create assignment record
            $assignment = \App\Models\OrderAssignment::create([
                'order_id'           => $validated['order_id'],
                'master_class_id'    => $validated['master_class_id'] ?? null,
                'session_id'         => $validated['session_id'] ?? null,
                'organizer_id'       => auth()->id(), // organizer creating assignment
                'organizer_file_path'=> $path,
                'organizer_file_name'=> $originalName,
                'organizer_file_mime'=> $mimeType,
                'organizer_file_size'=> $fileSize,
                'status'             => 'assigned',
                'remarks'            => null,
                'uploaded_by'        => auth()->id(),
            ]);

            // Step 4: Return structured JSON response
            return response()->json([
                'success' => true,
                'message' => 'Assignment created and assigned successfully.',
                'data' => [
                    'assignment_id'   => $assignment->id,
                    'file_url'        => $assignment->organizer_file_url,
                    'original_name'   => $assignment->organizer_file_name,
                    'size'            => $assignment->readable_organizer_file_size,
                    'status'          => $assignment->status,
                ],
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while assigning the task.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function reuploadAssignment(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:order_assignments,id',
            'file' => 'required|mimes:pdf|max:2048',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $assignment = OrderAssignment::findOrFail($request->assignment_id);

        // Store new file
        $file = $request->file('file');
        $path = $file->store('assignments/reuploads', 'public');

        // Update assignment record
        $assignment->update([
            'file_path' => $path,
            'original_file_name' => $file->getClientOriginalName(),
            'file_mime' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'status' => 'redo', // stays redo until mentor re-reviews
            'remarks' => $request->remarks,
            'uploaded_by' => auth()->id(),
            'submitted_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Assignment reuploaded successfully!',
            'assignment' => $assignment
        ]);
    }*/


    public function organizerUploadAssignment(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'master_class_id' => 'nullable|exists:master_classes,id',
            'session_id' => 'nullable|exists:master_class_sessions,id',
            'file' => 'required|file|mimes:pdf|max:2048', // 2MB
        ]);

        $file = $request->file('file');
        $path = $file->store('assignments/organizer', 'public');

        $assignment = OrderAssignment::create([
            'order_id' => $validated['order_id'],
            'master_class_id' => $validated['master_class_id'] ?? null,
            'session_id' => $validated['session_id'] ?? null,
            'organizer_file_path' => $path,
            'organizer_file_name' => $file->getClientOriginalName(),
            'organizer_file_mime' => $file->getClientMimeType(),
            'organizer_file_size' => $file->getSize(),
            'status' => 'assigned',
            'uploaded_by' => Auth::id(),
            'user_uploaded_at' => Carbon::now(), // organizer uploaded
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Assignment uploaded successfully by organizer.',
            'data' => $assignment,
        ]);
    }

    public function userUploadAssignment(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|exists:order_assignments,id',
            'order_id' => 'required|exists:orders,id',
            'master_class_id' => 'nullable|exists:master_classes,id',
            'session_id' => 'nullable|exists:master_class_sessions,id',
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->store('assignments/user', 'public');

        $assignment = OrderAssignment::findOrFail($validated['assignment_id']);

        $assignment->update([
            'user_file_path' => $path,
            'user_file_name' => $file->getClientOriginalName(),
            'user_file_mime' => $file->getClientMimeType(),
            'user_file_size' => $file->getSize(),
            'status' => 'uploaded',
            'uploaded_by' => Auth::id(),
            'user_uploaded_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Assignment uploaded successfully.',
            'data' => $assignment,
        ]);
    }

    public function userReuploadAssignment(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|exists:order_assignments,id',
            'order_id' => 'required|exists:orders,id',
            'master_class_id' => 'nullable|exists:master_classes,id',
            'session_id' => 'nullable|exists:master_class_sessions,id',
            'file' => 'required|file|mimes:pdf|max:2048',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $assignment = OrderAssignment::findOrFail($validated['assignment_id']);

        // Optional: prevent reupload if not marked as redo
        if ($assignment->status !== 'redo') {
            return response()->json([
                'success' => false,
                'message' => 'You can only reupload assignments marked for redo.',
            ], 403);
        }

        // Store new file
        $file = $request->file('file');
        $path = $file->store('assignments/reuploads', 'public');

        // Optionally, remove old file
        if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->update([
            'file_path' => $path,
            'original_file_name' => $file->getClientOriginalName(),
            'file_mime' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'status' => 'submitted', // move back to submitted for review
            'remarks' => $validated['remarks'] ?? null,
            'resubmitted_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Assignment successfully reuploaded for review.',
            'data' => $assignment,
        ]);
    }

    public function organizerReUploadAssignment(Request $request)
    {
        // ✅ Validate input
        $validated = $request->validate([
            'assignment_id' => 'required|exists:order_assignments,id',
            'order_id' => 'required|exists:orders,id',
            'master_class_id' => 'nullable|exists:master_classes,id',
            'session_id' => 'nullable|exists:master_class_sessions,id',
            'file' => 'nullable|file|mimes:pdf|max:2048',
            'remarks' => 'nullable|string|max:1000',
            'progress_status' => 'required|string|in:assigned,uploaded,under_review,redo,submitted',
        ]);



        // ✅ Find existing assignment
        $assignment = OrderAssignment::findOrFail($validated['assignment_id']);

        // Prepare data to update
        $updateData = [
            'status' => $validated['progress_status'],
            'remarks' => $validated['remarks'],
            'organizer_reviewed_at' => Carbon::now(),
            'uploaded_by' => Auth::id(),
            'final_submitted_at' => Carbon::now(),
        ];

        // ✅ Handle file if uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('assignments/reuploads', 'public');

            // Remove old file if exists
            if ($assignment->organizer_file_path && Storage::disk('public')->exists($assignment->organizer_file_path)) {
                Storage::disk('public')->delete($assignment->organizer_file_path);
            }

            // Add file details to update data
            $updateData = array_merge($updateData, [
                'organizer_file_path' => $path,
                'organizer_file_name' => $file->getClientOriginalName(),
                'organizer_file_mime' => $file->getClientMimeType(),
                'organizer_file_size' => $file->getSize(),
            ]);
        }

        // ✅ Update assignment
        $assignment->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Assignment successfully reuploaded for review.',
            'data' => $assignment,
        ]);
    }

    public function markSubmitted(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|exists:order_assignments,id',
            'order_id' => 'required|exists:orders,id',
            'master_class_id' => 'nullable|exists:master_classes,id',
            'session_id' => 'nullable|exists:master_class_sessions,id',
        ]);

        $assignment = OrderAssignment::findOrFail($validated['assignment_id']);

        $assignment->update([
            'status' => 'submitted',
            'uploaded_by' => Auth::id(),
            'final_submitted_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Assignment status updated to submitted.',
            'data' => $assignment,
        ]);
    }


}
