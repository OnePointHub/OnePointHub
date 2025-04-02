<?php

namespace App\Modules\Team\Notifications;

use App\Models\User;
use App\Modules\Team\Models\UserInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class UserInvited extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $sender, public UserInvitation $invitation)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $appName = config('app.name');

        $url = $this->generateInvitationUrl($this->invitation->invitation_token);

        return (new MailMessage)
            ->subject('Personal Invitation')
            ->greeting('Hello!')
            ->line("You have been invited by {$this->sender->name} to join $appName Team")
            ->action('Click here to join', url($url))
            ->line('Note: this link expires in 24 hours.');
    }

    /**
     * Generate a unique signed URL that the mail receiver can use to register.
     * The URL contains the receiver's email address and will be valid for 1 day.
     */
    public function generateInvitationUrl(string $token): string
    {
        return URL::temporarySignedRoute('register', now()->addDay(), ['invitation_token' => $token]);
    }
}
