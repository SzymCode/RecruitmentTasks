<?php

namespace App\Models;

use App\Contracts\PatientContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property int id
 * @property string name
 * @property string surname
 * @property string sex
 * @property string birth_date
 * @property string created_at
 * @property string updated_at
 * @property int getId()
 * @property string getName()
 * @property string getSurname()
 * @property string getSex()
 * @property string getBirthDate()
 * @property string getCreatedAt()
 * @property string getUpdatedAt()
 * @property Order[] orders
 * @property string getJWTIdentifier()
 * @property array getJWTCustomClaims()
 */
class Patient extends Authenticatable implements JWTSubject, PatientContract
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'sex',
        'birth_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     *  Instance methods
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getSex(): string
    {
        return strtolower($this->sex);
    }

    public function getBirthDate(): string
    {
        return $this->birth_date->format('Y-m-d');
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
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * JWTSubject methods
     */
    public function getJWTIdentifier(): string
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
