<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUserCreateNewAccount extends Notification
{
    use Queueable;

    public $company_name;
    public $password;
    public $email;
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($company_name,$password,$email,$url)
    {
        $this->company_name = $company_name;
        $this->password = $password;
        $this->email = $email;
        $this->url = $url;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->from('info@boxbyld.com','Installer Boxbyld - App')
            ->line('Congratulation')
            ->line("Hello ".$this->company_name)
            ->line("email : ".$this->email)
            ->line("password : ".$this->password)
            ->line("You Can Login From Here")
            ->action('Login', $this->url)
            ->line('Thank you for using our APP!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
