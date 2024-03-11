<?php

namespace App\Models;

use App\Contracts\NewsShouldReceiveFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int id
 * @property string title
 * @property string description
 * @property string created_at
 * @property string updated_at
 * @property BelongsToMany authors
 * @property int getId
 * @property string getTitle
 * @property string getDescription
 * @property string getCreatedAt
 * @property string getUpdatedAt
 */

class News extends Model implements NewsShouldReceiveFields
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getDescription(): string
    {
        return $this->description;
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

