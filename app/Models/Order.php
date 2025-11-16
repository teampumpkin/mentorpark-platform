<?php

namespace App\Models;

use App\Models\MasterClass\MasterClass;
use App\Models\MasterClass\MasterClassSession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'orderId',
        'purchase_orderId',
        'order_type',
        'master_class_id',
        'session_id',
        'title',
        'description',
        'original_price',
        'discount_value',
        'final_price',
        'discount_type',
        'timezone',
        'name',
        'email',
        'phone',
        'country',
        'state',
        'city',
        'postal_code',
        'venue_address',
        'payment_status',
        'payment_method',
        'transaction_id',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'organization_id',
        'isActive',
    ];

    // 👇 Cast attributes to proper types
    protected $casts = [
        'original_price' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'final_price' => 'decimal:2',
        'isActive' => 'boolean',
    ];

    // ----------------------------
    // 🔗 Relationships
    // ----------------------------

    /**
     * The user who placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The master class related to the order.
     */
    public function masterClass()
    {
        return $this->belongsTo(MasterClass::class);
    }

    /**
     * The specific session related to the order (if applicable).
     */
    public function session()
    {
        return $this->belongsTo(MasterClassSession::class, 'session_id');
    }

    /**
     * The organization associated with the order.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    // ----------------------------
    // ⚙️ Accessors / Helpers
    // ----------------------------

    /**
     * Check if the order is for a masterclass.
     */
    public function isMasterClassOrder(): bool
    {
        return $this->order_type === 'master_class';
    }

    /**
     * Check if the order is for a session.
     */
    public function isSessionOrder(): bool
    {
        return $this->order_type === 'session';
    }

    /**
     * Scope for completed payments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('payment_status', 'completed');
    }

    /**
     * Scope for pending payments.
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function assignments()
    {
        return $this->hasMany(OrderAssignment::class);
    }
}
