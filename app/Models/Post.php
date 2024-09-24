<?php

namespace App\Models;

use App\Trait\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = 'posts';

    protected $fillable = [
        'slug',
        'title',
        'content',
        'author',
        'type',
        'status',
    ];
}
