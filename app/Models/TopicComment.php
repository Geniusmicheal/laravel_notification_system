<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicComment extends Model
{
    use HasFactory;

    protected $table = 'comment_topic';

    protected $primaryKey =  'id';
    protected $fillable = [
        'id',
        'topic_id',
        'user_id',
        'body'
    ];
}
