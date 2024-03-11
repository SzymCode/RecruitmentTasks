<?php

namespace App\Models;

use App\Contracts\AuthorShouldReceiveFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int id
 * @property string name
 * @property string created_at
 * @property string updated_at
 * @property BelongsToMany news
 * @property int getId
 * @property string getName
 * @property string getCreatedAt
 * @property string getUpdatedAt
 */

class Author extends Model implements AuthorShouldReceiveFields
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}
