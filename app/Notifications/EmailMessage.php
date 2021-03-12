<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailMessage extends Notification
{
    use Queueable;
    private $details;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {


        return (new MailMessage)
            
            ->greeting($this->details['greeting'])

            ->line($this->details['body'])

            ->action($this->details['actionText'], $this->details['actionURL'])

            ->line($this->details['thanks'])
            ->cc($this->details['email']);
    }
  
    // Mail::send('emails.activation', $data, function($message) use ($email, $subject) {
    //     $message->to($email)->subject($subject);
    // });

    public function toDatabase($notifiable)
    {
        return [
            'data'=>$this->details['body'],
            'to' => $this->details['email']
        ];
    }
    // public function toDatabase($notifiable)

    // {

    //     return [

    //         'order_id' => $this->details['order_id']

    //     ];

    // }


}
