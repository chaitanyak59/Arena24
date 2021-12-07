<?php
namespace Arena\Helpers;

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

class Mail {
    public static function notifyUserCreated(string $toAddress, string $userName): string {
        try {
            $body = sprintf("<h2>Hello <b>%s</b>,</h2>
                                <h3>Your account has been created succesfully.<br>
                                 You can login to website and start booking your spots.<br>

                                 <mark><a href='https://arena-24.herokuapp.com/login.php' target='_blank' style='text-decoration:underline'>Click to login</a></mark><br><br><br>
                                 Thankyou,<br>Team Arena24.</h3>",$userName);
            self::prepareMailing($toAddress, "Account Created Successfully", $body);
            return "Success";
        } catch(Exception $e) {
            echo $e;
            return "Failed";
        }
    }

    public static function notifySpotBooked(string $toAddress, string $userName): string {
        try {
            $body = sprintf("<h2>Hello <b>%s</b>,</h2>
                                <h3>Your arena spot has been booked successfully.<br>
                                 Please reach on time and enjoy playing .<br>
                                 Thankyou,<br>Team Arena24.</h3>",$userName);
            self::prepareMailing($toAddress, "Booking Created Successfully", $body);
            return "Success";
        } catch(Exception $e) {
            return "Failed";
        }
    }

    private static function prepareMailing(string $toAddress, string $subject, string $body)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        //Connection
        $fromAddress = Env::getEmailSender();
        $mail->Host       = Env::getEmailHostProvider();
        $mail->SMTPAuth   = true;
        $mail->Username   = Env::getEmailUser();
        $mail->Password   =  Env::getEmailKey();
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = Env::getEmailPort();
        $mail->setFrom($fromAddress, 'Arena24');
        $mail->addAddress($toAddress);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->send();
    }
}

?>