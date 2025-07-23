<?php

namespace Modules\User\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Email\App\Models\Email;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plainPassword;

    public function __construct($user, $plainPassword)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        $emailTemplate = Email::whereSlug('register_user')->first(['subject', 'description']);

        if (isset($emailTemplate)) {
            $subject = $emailTemplate->subject;
            $content = $emailTemplate->description;

            // Replace placeholders in subject
            $subject = str_replace('%USER_NAME%', $this->user->first_name, $subject);        
            $subject = str_replace('%APP_NAME%', env('APP_NAME'), $subject);

            // Replace placeholders in content
            $content = str_replace('%APP_NAME%', env('APP_NAME'), $content);
            $content = str_replace('%APP_LOGO%', asset('images/logo.png'), $content);
            $content = str_replace('%EMAIL_FOOTER%', config('get.email_footer_text'), $content);
            $content = str_replace('%SUPPORT_EMAIL%', config('get.support_email'), $content);
            $content = str_replace('%USER_NAME%', $this->user->first_name, $content);
            $content = str_replace('%EMAIL_ADDRESS%', $this->user->email, $content);
            $content = str_replace('%PASSWORD%', $this->plainPassword, $content);
            
            return $this->subject($subject)
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'))
                ->view('admin::email.master')
                ->with(['template' => $content]);
        } else {
            info('Email template for welcome email not found. Please create it in the Email module.');
        }      
    }
}
