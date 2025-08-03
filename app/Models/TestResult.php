<?php

namespace App\Models;

use App\Contracts\TestResultContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int order_id
 * @property string test_name
 * @property string test_value
 * @property string test_reference
 * @property string created_at
 * @property string updated_at
 * @property int getId()
 * @property int getOrderId()
 * @property string getTestName()
 * @property string getTestValue()
 * @property string getTestReference()
 * @property string getCreatedAt()
 * @property string getUpdatedAt()
 * @property Order order
 * @property Patient patient
 */
class TestResult extends Model implements TestResultContract
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'test_name',
        'test_value',
        'test_reference',
    ];

    /**
     *  Instance methods
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->order_id;
    }

    public function getTestName(): string
    {
        return $this->test_name;
    }

    public function getTestValue(): string
    {
        return $this->test_value;
    }

    public function getTestReference(): string
    {
        return $this->test_reference;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at->toDateTimeString();
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at->toDateTimeString();
    }

    /**
     *  Relationship methods
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function patient(): BelongsTo
    {
        return $this->order->patient();
    }
}
