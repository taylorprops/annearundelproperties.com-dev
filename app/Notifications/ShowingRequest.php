<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Config;

class ShowingRequest extends Notification {
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($showing) {
        $this -> showing = $showing;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        $ccs = Config::get('email_routing.showing_request_ccs.emails');
        if($ccs != '') {
            return (new MailMessage)
                -> from('clientservices@taylorprops.com', 'Anne Arundel Properties - Showing Requests')
                -> cc(explode(',', Config::get('email_routing.showing_request_ccs.emails')))
                -> subject('Showing Request from www.AnneArundelProperties.com')
                -> markdown('mail.listings.showing_request', ['showing' => $this -> showing]);
        } else {
            return (new MailMessage)
            -> from('clientservices@taylorprops.com', 'Anne Arundel Properties - Showing Requests')
                -> subject('Showing Request from www.AnneArundelProperties.com')
                -> markdown('mail.listings.showing_request', ['showing' => $this -> showing]);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
