<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GoogleCalendarController;
use App\Mail\MasterClassInvitationNotification;
use App\Models\Event\EventCalendar;
use App\Models\Locations\Country;
use App\Models\Master\Goal;
use App\Models\Master\IndustryType;
use App\Models\Master\Skill;
use App\Models\MasterClass\MasterClass;
use App\Models\MasterClass\MasterClassesSessionMentor;
use App\Models\MasterClass\MasterClassMentee;
use App\Models\MasterClass\MasterClassSession;
use App\Models\MasterClass\SessionAttachment;
use App\Models\MasterClass\SessionFeedback;
use App\Models\Order;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MasterClassesController extends Controller
{
    public function index()
    {
        $breadcrumb = 'Master Classes';
        $user = auth()->user();
        $industry_type = IndustryType::all();
        $organizations = Organization::all();
        $your_organization = Organization::find(auth()->user()->organization_id);
        $skills = Skill::all();
        $goals = Goal::all();
        $users = User::all();
        $master_classes = MasterClass::where(['isActive' => true, 'user_id' => auth()->id()])->get();
        $draft_master_classes = MasterClass::where(['isActive' => null, 'user_id' => auth()->id()])->get();
        $relevant_master_classes = MasterClass::where('isActive', true)
            ->where('user_id', '!=', auth()->id())
            ->where('organization_id', null)
            ->get();
        $organization_master_class = MasterClass::where('isActive', true)
            ->whereNotNull('organization_id')
            ->where('organization_id', auth()->user()->organization_id)
            ->where('user_id', '!=', auth()->id())
            ->get();

        return view('frontend.master-classes', compact('breadcrumb', 'user', 'industry_type', 'skills', 'organizations', 'goals', 'users', 'master_classes', 'draft_master_classes', 'relevant_master_classes', 'organization_master_class', 'your_organization'));
    }

    public function create()
    {
        $current_user = Auth::user();
        $breadcrumb = 'Create Master Classes';
        $user = auth()->user();
        $industry_type = IndustryType::all();
        $organizations = Organization::all();
        $skills = Skill::all();
        $goals = Goal::all();
        $users = User::query()
            ->when($current_user->organization_id, function ($query, $orgId) use ($current_user) {
                $query->where('organization_id', $orgId)
                    ->where('id', '!=', $current_user->id);
            })
            ->get();

        $mentees = User::select('id', 'name')
            ->role('Mentee')
            ->when($current_user->organization_id, function ($query, $orgId) use ($current_user) {
                $query->where('organization_id', $orgId)
                    ->where('id', '!=', $current_user->id);
            })
            ->get();
        $countries = Country::all();
        return view('frontend.master-classes-create', compact('breadcrumb', 'user', 'industry_type', 'skills', 'organizations', 'goals', 'users', 'mentees', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'timezone' => 'required|string|max:100',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|max:5120', // max 5MB
            'price' => 'nullable|numeric|min:0',
            'discount_type' => ['nullable', Rule::in(['percent', 'amount'])],
            'discount_value' => 'nullable|integer|min:0',
            'contact_method' => 'required|in:email,whatsapp',
//            'attachments.*' => 'nullable|file|max:10240', // max 10MB each
            'mentee_ids' => 'nullable|array',
            'mentee_ids.*' => 'integer|exists:users,id',
            'classes' => 'required|array',
            'classes.*.session_type' => 'required|string',
            'classes.*.title' => 'required|string',
            'classes.*.start_date_time' => 'nullable|date',
            'classes.*.end_date_time' => 'nullable|date|after_or_equal:sessions.*.start_date_time',
            'classes.*.session_description' => 'nullable|string',
            'classes.*.price' => 'nullable|numeric',
            'classes.*.discount_type' => ['nullable', Rule::in(['percent', 'amount'])],
            'classes.*.discount_value' => 'nullable|integer|min:0',
            'classes.*.hide_price' => 'nullable|boolean',
            'classes.*.skills' => 'nullable|array',
            'classes.*.skills.*' => 'string',
        ]);


        DB::beginTransaction();

        try {
            $masterClass = new MasterClass();
            $masterClass->title = $request->input('title');
            $masterClass->slug = CommonController::generateSlugWithUniqueSuffix($masterClass->title);
            $masterClass->timezone = $request->input('timezone');
            $masterClass->description = $request->input('description');
            $masterClass->price = $request->input('price');
            $masterClass->discount_type = $request->input('discount_type');
            $masterClass->discount_value = $request->input('discount_value');
            $masterClass->user_id = auth()->id();
            if (auth()->check() && auth()->user()->organization_id) {
                $masterClass->organization_id = auth()->user()->organization_id;
            }
            if ($request->input('contact_method') === 'whatsapp') {
                $masterClass->whatsapp_notification = $request->input('contact_method') === 'whatsapp';
                $masterClass->email_notification = null;
            }
            if ($request->input('contact_method') === 'email') {
                $masterClass->whatsapp_notification = null;
                $masterClass->email_notification = $request->input('contact_method') === 'email';
            }

            if ($request->hasFile('banner_image')) {
                $photo = $request->file('banner_image');
                $path = $photo->store('banner_image', 'master_class_banner_image');
                $masterClass->banner_image = $path;
            }

            if ($request->has('isActive')){
                $masterClass->isActive = true;
            }

            $masterClass->save();

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachmentFile) {
                    $path = $attachmentFile->store('attachments', 'master_class_attachments');
                    $attachment = new SessionAttachment();
                    $attachment->master_class_id = $masterClass->id;
                    $attachment->user_id = auth()->id();
                    $attachment->attachment_path = $path;
                    $attachment->file_name = $attachmentFile->hashName();
                    $attachment->file_original_name = $attachmentFile->getClientOriginalName();
                    $attachment->file_size = $attachmentFile->getSize();
                    $attachment->file_extension = $attachmentFile->getClientOriginalExtension();
                    $attachment->save();
                }
            }

            $menteeIds = $request->input('mentee_ids', []);
            $emails = [];
            foreach ($menteeIds as $userId) {
                $user = User::find($userId);
                if ($user) {
                    $emails[] = $user->email;
                    // Send mail to mentee asynchronously (recommended)
                    Mail::to($user->email)->queue(new MasterClassInvitationNotification($masterClass, $user));
                    MasterClassMentee::updateOrCreate([
                        'master_class_id' => $masterClass->id,
                        'user_id' => $user->id,
                        'email' => $user->email,
                    ]);
                }
            }

            $newMentees = $request->input('new_mentee_emails', []);
            foreach ($newMentees as $mentees) {
                $emails[] = $mentees;
                // Send mail to mentee asynchronously (recommended)
//                Mail::to($user->email)->queue(new MasterClassInvitationNotification($masterClass, $user));
                MasterClassMentee::updateOrCreate([
                    'master_class_id' => $masterClass->id,
                    'user_id' => null,
                    'email' => $mentees,
                ]);
            }

            // Save sessions if any
            $sessions = $request->input('classes', []);
            foreach ($sessions as $i => $sessionData) {
                $session = new MasterClassSession($sessionData);
                $session->master_class_id = $masterClass->id ?? 1;
                $session->session_type = $sessionData['session_type'] ?? null;
                $session->seat_capacity_min = $sessionData['seat_capacity_min'] ?? null;
                $session->seat_capacity_max = $sessionData['seat_capacity_max'] ?? null;
                $session->title = $sessionData['title'] ?? null;
                $session->slug = CommonController::generateSlugWithUniqueSuffix($sessionData['title']);
                $session->skills = isset($sessionData['skills']) ? json_encode($sessionData['skills']) : null;
                $session->start_date_time = $sessionData['start_date_time'] ?? null;
                $session->end_date_time = $sessionData['end_date_time'] ?? null;
                $session->session_description = $sessionData['description'] ?? null;
                $session->session_price = $sessionData['session_price'] ?? null;
                $session->discount_type = $sessionData['discount_type'] ?? null;
                $session->session_price_discount = $sessionData['session_price_discount'] ?? null;
                $session->user_id = auth()->id();
                $session->isActive = true;
                if (isset($sessionData['skills'])) {
                    $session->skills = $sessionData['skills']; // no json_encode
                }

                if ($sessionData['session_type'] == 'face_to_face') {
                    $session->country = $sessionData['country'] ?? null;
                    $session->state = $sessionData['state'] ?? null;
                    $session->city = $sessionData['city'] ?? null;
                    $session->postal_code = $sessionData['postal_code'] ?? null;
                    $session->venue_address = $sessionData['venue_address'] ?? null;
                }

                $session->save();
                if ($sessionData['session_type'] == 'virtual') {
                    $eventRequest = new Request([
                        'summary' => $session->title,
                        'description' => $session->session_description ?? 'MasterClass session',
                        'start' => Carbon::parse($session->start_date_time)->toIso8601String(),
                        'end' => Carbon::parse($session->end_date_time)->toIso8601String(),
                        'attendees' => $emails,
                    ]);

                    /*$googleEvent = app(GoogleCalendarController::class)->createGoogleCalendarEvent($eventRequest);
                    if (!$googleEvent) {
                        $eventId = null;
                    }else{
                        $eventId = $googleEvent['eventId'];
                    }*/
                    $eventId = time() . random_int(1000, 9999);
                    EventCalendar::create([
                        'google_event_id' => $eventId,
                        'summary' => $eventRequest->summary,
                        'hangoutLink' => $eventRequest->hangoutLink,
                        'htmlLink' => $eventRequest->htmlLink,
                        'description' => $eventRequest->description,
                        'start' => $eventRequest->start,
                        'end' => $eventRequest->end,
                        'attendees' => $emails,
                        'master_class_id' => $masterClass->id,
                        'master_class_session_id' => $session->id,
                        'user_id' => auth()->id(),
                    ]);
                }
                if ($request->hasFile("classes.$i.session_attachments")) {
                    $attachments = $request->file("classes.$i.session_attachments") ?? [];
                    foreach ($attachments as $attachment) {
                        $path = $attachment->store('session_attachments', 'master_class_session_attachments');
                        SessionAttachment::create([
                            'master_class_id' => $masterClass->id,
                            'master_class_session_id' => $session->id,
                            'user_id' => auth()->id(),
                            'attachment_path' => $path,
                            'file_name' => $attachment->hashName(),
                            'file_original_name' => $attachment->getClientOriginalName(),
                            'file_size' => $attachment->getSize(),
                            'file_extension' => $attachment->getClientOriginalExtension(),
                        ]);
                    }
                }

                // Save session feedback
                $feedbacks = $sessionData['feedback'] ?? [];
                foreach ($feedbacks as $feedbackData) {
                    SessionFeedback::create([
                        'master_class_id' => $masterClass->id,
                        'session_id' => $session->id,
                        'feedback_type' => $feedbackData['feedback_type'] ?? null,
                        'feedback_question' => $feedbackData['feedback_question'] ?? null,
                    ]);
                }

                $mentors = $sessionData['mentors'] ?? [];
                foreach ($mentors as $mentorData) {
                    MasterClassesSessionMentor::create([
                        'master_class_id' => $masterClass->id,
                        'session_id' => $session->id,
                        'name' => $mentorData['name'],
                        'email' => $mentorData['email'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('frontend.master-classes')->with('success', 'Masterclass created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to create masterclass: ' . $e->getMessage()]);
        }
    }

    public function edit($masterClassSlug)
    {
        $breadcrumb = 'Edit Master Classes';
        $user = auth()->user();
        $industry_type = IndustryType::all();
        $organizations = Organization::all();
        $skills = Skill::all();
        $goals = Goal::all();
        $users = User::all();
        $countries = Country::all();
        $mentees = User::select('id', 'name')->role('Mentee')->get();
        $masterClass = MasterClass::where('slug', $masterClassSlug)->firstOrFail();
        return view('frontend.master-classes-edit', compact('breadcrumb', 'user', 'industry_type', 'skills', 'organizations', 'goals', 'users', 'mentees', 'masterClass', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'timezone' => 'required|string|max:100',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|max:5120', // max 5MB
            'price' => 'nullable|numeric|min:0',
            'discount_type' => ['nullable', Rule::in(['percent', 'amount'])],
            'discount_value' => 'nullable|integer|min:0',
            'contact_method' => 'required|in:email,whatsapp',
            'mentee_ids' => 'nullable|array',
            'mentee_ids.*' => 'integer|exists:users,id',
            'classes' => 'required|array',
            'classes.*.session_type' => 'required|string',
            'classes.*.title' => 'required|string',
            'classes.*.start_date_time' => 'nullable|date',
            'classes.*.end_date_time' => 'nullable|date|after_or_equal:classes.*.start_date_time',
            'classes.*.session_description' => 'nullable|string',
            'classes.*.price' => 'nullable|numeric',
            'classes.*.discount_type' => ['nullable', Rule::in(['percent', 'amount'])],
            'classes.*.discount_value' => 'nullable|integer|min:0',
            'classes.*.hide_price' => 'nullable|boolean',
            'classes.*.skills' => 'nullable|array',
            'classes.*.skills.*' => 'string',
        ]);

        DB::beginTransaction();

        try {
            $masterClass = MasterClass::findOrFail($id);

            /** ----------------------------
             *  Update MasterClass Main Info
             * ---------------------------- */
            $masterClass->title = $request->title;
//            $masterClass->slug = CommonController::generateSlugWithUniqueSuffix($request->title, $masterClass->id);
            $masterClass->timezone = $request->timezone;
            $masterClass->description = $request->description;
            $masterClass->price = $request->price;
            $masterClass->discount_type = $request->discount_type;
            $masterClass->discount_value = $request->discount_value;

            if ($request->contact_method === 'whatsapp') {
                $masterClass->whatsapp_notification = true;
                $masterClass->email_notification = null;
            } elseif ($request->contact_method === 'email') {
                $masterClass->whatsapp_notification = null;
                $masterClass->email_notification = true;
            }

            if ($request->hasFile('banner_image')) {
                $photo = $request->file('banner_image');
                $path = $photo->store('banner_image', 'master_class_banner_image');
                $masterClass->banner_image = $path;
            }
            if ($request->has('isActive')){
                $masterClass->isActive = true;
            }else{
                $masterClass->isActive = null;
            }
            $masterClass->save();

            /** ----------------------------
             *  Update Mentees
             * ---------------------------- */
            $menteeIds = $request->input('mentee_ids', []);


            $emails = [];
            $oldMenteeEmails = $request->get('old_mentee_emails');
            if (!empty($oldMenteeEmails) && is_array($oldMenteeEmails)) {
                foreach ($oldMenteeEmails as $email) {
                    $emails[] = $email;
                }
            }

            $menteeIds = $request->input('mentee_ids', []);

            foreach ($menteeIds as $userId) {
                $user = User::find($userId);
                if ($user) {
                    $emails[] = $user->email;
                    // Send mail to mentee asynchronously (recommended)
                    Mail::to($user->email)->queue(new MasterClassInvitationNotification($masterClass, $user));
                    MasterClassMentee::updateOrCreate([
                        'master_class_id' => $masterClass->id,
                        'user_id' => $user->id,
                        'email' => $user->email,
                    ]);
                }
            }

            $newMentees = $request->input('new_mentee_emails', []);
            foreach ($newMentees as $mentees) {
                $emails[] = $mentees;
                // Send mail to mentee asynchronously (recommended)
//                Mail::to($user->email)->queue(new MasterClassInvitationNotification($masterClass, $user));
                MasterClassMentee::updateOrCreate([
                    'master_class_id' => $masterClass->id,
                    'user_id' => null,
                    'email' => $mentees,
                ]);
            }

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachmentFile) {
                    $path = $attachmentFile->store('attachments', 'master_class_attachments');
                    $attachment = new SessionAttachment();
                    $attachment->master_class_id = $masterClass->id;
                    $attachment->user_id = auth()->id();
                    $attachment->attachment_path = $path;
                    $attachment->file_name = $attachmentFile->hashName();
                    $attachment->file_original_name = $attachmentFile->getClientOriginalName();
                    $attachment->file_size = $attachmentFile->getSize();
                    $attachment->file_extension = $attachmentFile->getClientOriginalExtension();
                    $attachment->save();
                }
            }


            /** ----------------------------
             *  Update Sessions
             * ---------------------------- */
            $sessionsData = $request->input('classes', []);
            $existingSessionIds = $masterClass->sessions()->pluck('id')->toArray();
            $submittedIds = [];


            foreach ($sessionsData as $index => $sessionData) {
                $sessionId = $sessionData['id'] ?? null;
                $submittedIds[] = $sessionId;
                $session = $sessionId
                    ? MasterClassSession::findOrFail($sessionId)
                    : new MasterClassSession();

                $session->master_class_id = $masterClass->id;
                $session->session_type = $sessionData['session_type'];
                $session->title = $sessionData['title'];
//                $session->slug = CommonController::generateSlugWithUniqueSuffix($sessionData['title'], $sessionId);
                $session->seat_capacity_min = $sessionData['seat_capacity_min'] ?? null;
                $session->seat_capacity_max = $sessionData['seat_capacity_max'] ?? null;
                $session->skills = isset($sessionData['skills']) ? $sessionData['skills'] : null;
                $session->start_date_time = $sessionData['start_date_time'] ?? null;
                $session->end_date_time = $sessionData['end_date_time'] ?? null;
                $session->session_description = $sessionData['description'] ?? null;
                $session->session_price = $sessionData['session_price'] ?? null;
                $session->discount_type = $sessionData['discount_type'] ?? null;
                $session->session_price_discount = $sessionData['session_price_discount'] ?? null;
                $session->isActive = true;
                $session->user_id = auth()->id();

                if ($sessionData['session_type'] === 'face_to_face') {
                    $session->country = $sessionData['country'] ?? null;
                    $session->state = $sessionData['state'] ?? null;
                    $session->city = $sessionData['city'] ?? null;
                    $session->postal_code = $sessionData['postal_code'] ?? null;
                    $session->venue_address = $sessionData['venue_address'] ?? null;
                }

                $session->save();

                /** ----------------------------
                 *  Handle Virtual Session (Google Calendar)
                 * ---------------------------- */
                if ($session->session_type === 'virtual') {
                    $existingEvent = EventCalendar::where(['master_class_id' => $id, 'master_class_session_id' => $session->id])->first();

                    $newEventData = [
                        'summary' => $session->title,
                        'description' => $session->session_description ?? 'MasterClass session',
                        'start' => Carbon::parse($session->start_date_time)->toIso8601String(),
                        'end' => Carbon::parse($session->end_date_time)->toIso8601String(),
                        'attendees' => $emails,
                    ];

                    $shouldUpdate = true;

                    if ($existingEvent) {
                        $oldAttendees = $existingEvent->attendees;
                        $oldData = [
                            'summary' => $existingEvent->summary,
                            'description' => $existingEvent->description,
                            'start' => Carbon::parse($existingEvent->start)->toIso8601String(),
                            'end' => Carbon::parse($existingEvent->end)->toIso8601String(),
                            'attendees' => $oldAttendees,
                        ];

                        $shouldUpdate = $newEventData != $oldData;
                    }


                    if ($shouldUpdate) {
                        $eventRequest = new Request($newEventData);

                        /* $googleEvent = app(GoogleCalendarController::class)->updateGoogleCalendarEvent(
                             $eventRequest,
                             $existingEvent->google_event_id ?? null
                         );*/

                        $eventId = time() .'_updated_'. random_int(1000, 9999);

                        EventCalendar::updateOrCreate(
                             ['master_class_session_id' => $session->id],
                             [
                                 'google_event_id' => $eventId,
                                 'summary' => $eventRequest->summary,
                                 'description' => $eventRequest->description,
                                 'hangoutLink' => $googleEvent['hangoutLink'] ?? null,
                                 'htmlLink' => $googleEvent['htmlLink'] ?? null,
                                 'start' => $eventRequest->start,
                                 'end' => $eventRequest->end,
                                 'attendees' => $emails,
                                 'master_class_id' => $masterClass->id,
                             ]
                         );
                    }
                }


                /** ----------------------------
                 *  Handle Attachments
                 * ---------------------------- */
                if ($request->hasFile("classes.$index.session_attachments")) {
                    foreach ($request->file("classes.$index.session_attachments") as $attachment) {
                        $path = $attachment->store('session_attachments', 'master_class_session_attachments');
                        SessionAttachment::create([
                            'master_class_id' => $masterClass->id,
                            'master_class_session_id' => $session->id,
                            'user_id' => auth()->id(),
                            'attachment_path' => $path,
                            'file_name' => $attachment->hashName(),
                            'file_original_name' => $attachment->getClientOriginalName(),
                            'file_size' => $attachment->getSize(),
                            'file_extension' => $attachment->getClientOriginalExtension(),
                        ]);
                    }
                }

                /** ----------------------------
                 *  Handle Feedbacks
                 * ---------------------------- */
                $feedbacks = $sessionData['feedback'] ?? [];
                SessionFeedback::where('session_id', $session->id)->delete();

                foreach ($feedbacks as $feedbackData) {
                    SessionFeedback::create([
                        'master_class_id' => $masterClass->id,
                        'session_id' => $session->id,
                        'feedback_type' => $feedbackData['feedback_type'] ?? null,
                        'feedback_question' => $feedbackData['feedback_question'] ?? null,
                    ]);
                }


                $mentors = $sessionData['mentors'] ?? [];
                MasterClassesSessionMentor::where('session_id', $session->id)->delete();
                foreach ($mentors as $mentorData) {
                    MasterClassesSessionMentor::create([
                        'master_class_id' => $masterClass->id,
                        'session_id' => $session->id,
                        'name' => $mentorData['name'],
                        'email' => $mentorData['email'],
                    ]);
                }

            }

            /** ----------------------------
             *  Delete Removed Sessions
             * ---------------------------- */
            $deletedSessions = array_diff($existingSessionIds, array_filter($submittedIds));
            if (!empty($deletedSessions)) {
                MasterClassSession::whereIn('id', $deletedSessions)->delete();
                EventCalendar::whereIn('master_class_session_id', $deletedSessions)->delete();
            }

            DB::commit();

            return redirect()->route('frontend.master-classes')->with('success', 'Masterclass updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to update masterclass: ' . $e->getMessage()]);
        }
    }


    public function removeMentee($id)
    {
        try {
            $mentee = MasterClassMentee::findOrFail($id);
            $mentee->delete();

            return response()->json([
                'success' => true,
                'message' => 'Mentee removed successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing mentee: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeAttachment($id)
    {
        try {
            $attachment = SessionAttachment::findOrFail($id);
            $attachment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Attachment removed successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing attachment: ' . $e->getMessage()
            ], 500);
        }
    }


    public function show($slug)
    {
        /*$breadcrumb = 'Master Classes';
        $user = auth()->user();
        $industry_type = IndustryType::all();
        $organizations = Organization::all();
        $skills = Skill::all();
        $goals = Goal::all();
        $users = User::all();
        $master_classes = MasterClass::where('slug', $slug)->first();
        return view('frontend.master-classes-detail', compact('breadcrumb', 'user', 'industry_type', 'skills', 'organizations', 'goals', 'users', 'master_classes'));*/

        $authUser = auth()->user();
        $masterClass = MasterClass::where('slug', $slug)->first();
        return view('frontend.master-class-detail', compact(
            'authUser',
            'masterClass'
        ));
    }

    public function addMoreSessions($number)
    {
        $skills = Skill::all();
        $countries = Country::all();
        $view = view('frontend._partial._session_form', compact('number', 'skills', 'countries'))->render();
        return response()->json(['view' => $view]);
    }

    public function addMoreSessionsFeedback($number, $feedback_number)
    {
        $view = view('frontend._partial._session_feedback_form', compact('number', 'feedback_number'))->render();
        return response()->json(['view' => $view]);
    }

    public function addMoreSessionsMentor($number, $mentor_number)
    {
        $view = view('frontend._partial._session_mentor_form', compact('number', 'mentor_number'))->render();
        return response()->json(['view' => $view]);
    }

}
