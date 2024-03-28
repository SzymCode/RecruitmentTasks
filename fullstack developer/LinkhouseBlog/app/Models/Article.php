<?php

namespace App\Models;

use App\Contracts\ArticleShouldReceiveFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int id
 * @property string guid
 * @property string title
 * @property string link
 * @property string description
 * @property string category
 * @property string pub_date
 */
class Article extends Model implements ArticleShouldReceiveFields
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guid',
        'title',
        'link',
        'description',
        'category',
        'pub_date'
    ];

    public function getId(): int
    {
        return $this->id;
    }
    public function getGuid(): string
    {
        return $this->guid;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getLink(): string
    {
        return $this->link;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getCategory(): string
    {
        return $this->category;
    }
    public function getPubDate(): string
    {
        return $this->pub_date;
    }
}
