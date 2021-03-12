<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;

class TopicSubscriber extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'subscriber_topic';

    protected $primaryKey =  'topic_id';
    protected $fillable = [
        'id',
        'topic_slug',
        'user_id',
        'url'
    ];

    public function routeNotificationForMail()
    {
        return $this->email_address;
    }
}
