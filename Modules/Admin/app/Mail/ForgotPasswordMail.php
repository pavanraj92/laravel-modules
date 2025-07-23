<?php

namespace Modules\Admin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Modules\Email\App\Models\Email;

/**
 * This class used for frontend user as customer/home owner user
 */
class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $reset_link = url('admin/reset-password') . '/' . $this->user->token . '?email=' . $this->user->email;
        $emailTemplate = Email::whereSlug('password_reset')->first(['subject', 'description']);

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

            //reset button link html
            $content = str_replace('%RESET_LINK%', '<a href="' . $reset_link . '" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Reset Password</a>', $content);
                
            return $this->subject($subject)
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'))
                ->view('admin::email.master')
                ->with(['template' => $content]);
        } else {
            info('Email template for password reset not found. Please create it in the Email module.');
        }
    }
}
