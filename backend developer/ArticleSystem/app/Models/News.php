<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int id
 * @property string title
 * @property string description
 * @property array authors
 * @property DateTime created_at
 * @property DateTime updated_at
 */

class News extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'authors'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'authors' => 'array',
    ];
}
