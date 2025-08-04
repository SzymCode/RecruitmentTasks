<?php

namespace App\Models;

use App\Contracts\OrderContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 * @property int patient_id
 * @property string created_at
 * @property string updated_at
 * @property int getId()
 * @property int getPatientId()
 * @property string getCreatedAt()
 * @property string getUpdatedAt()
 * @property Patient patient
 * @property TestResult[] testResults
 */
class Order extends Model implements OrderContract
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'patient_id',
    ];

    /**
     *  Instance methods
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getPatientId(): int
    {
        return $this->patient_id;
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
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }
}
