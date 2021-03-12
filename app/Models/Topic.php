<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model{
    use HasFactory;
    protected $table = 'topic';

    protected $primaryKey =  'topic_id';
    protected $fillable = [
        'topic_id',
        'slug',
        'subject',
        'body'
    ];

    const UPDATED_AT = null;
}
