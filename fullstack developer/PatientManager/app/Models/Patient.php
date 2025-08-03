<?php

namespace App\Models;

use App\Contracts\PatientContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 */
class Patient extends Model implements PatientContract
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
        return $this->sex;
    }

    public function getBirthDate(): string
    {
        return $this->birth_date->toDateTimeString();
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
}
