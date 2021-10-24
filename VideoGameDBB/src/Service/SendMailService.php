<?php 
namespace App\Service;

use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class SendMailService
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    public function send($user, $from, $subject, $emailHtml) :void
    {
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
        (new TemplatedEmail())
            ->from($from)
            ->to($user->getEmail())
            ->subject($subject)
            ->htmlTemplate($emailHtml)
        );
    }
}