<?php
//PHPMailer import
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../components/PHPMailer/Exception.php'; 
require '../components/PHPMailer/PHPMailer.php'; 
require '../components/PHPMailer/SMTP.php';

function SendAccountVerificationMail($token, $userMail)
{

  $content = '
    <body style="font-family: Helvetica, sans-serif; background-color: #f4f5f6; margin: 0; padding: 0;">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="width: 100%;">
            <tr>
                <td>&nbsp;</td>
                <td class="container" style="margin: 0 auto !important; max-width: 600px; padding: 24px 0 0; width: 600px;">
                    <div class="content">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="main" style="background: #ffffff; border: 1px solid #eaebed; border-radius: 16px; width: 100%;">
                            <tr>
                                <td class="wrapper" style="padding: 24px;">
                                    <p style="font-size: 16px; font-weight: normal; margin: 0 0 16px;">Hello,</p>
                                    <p style="font-size: 16px; font-weight: normal; margin: 0 0 16px;">Thank you for registering an account with us. To complete the registration process and verify your email address, please click the button below:</p>
                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="min-width: 100% !important; width: 100%;">
                                        <tbody>
                                            <tr>
                                                <td align="left">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: auto;">
                                                        <tbody>
                                                            <tr>
                                                                <td> <a href="http://localhost/Selene.io/loginForm?token=' . $token . '&mail='. $userMail .'" target="_blank" style="background-color: #532acc; border: solid 2px #532acc; border-radius: 4px; color: #ffffff; cursor: pointer; display: inline-block; font-size: 16px; font-weight: bold; margin: 0; padding: 12px 24px; text-decoration: none; text-transform: capitalize;">Verify Email Address</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <p style="font-size: 16px; font-weight: normal; margin: 0 0 16px;">This email template is designed to make the verification process quick and easy. Click the button above to verify your email address and unlock access to your account.</p>
                                    <p style="font-size: 16px; font-weight: normal; margin: 0 0 16px;">If you have any questions or need assistance, please do not hesitate to contact our support team.</p>
                                </td>
                            </tr>
                        </table>
                        <div class="footer">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-block" style="color: #9a9ea6; font-size: 16px; text-align: center;"><span class="apple-link">Selene.io, your favourite gift-card shop.</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </body>
  ';

    //Creating new PHPMailer object
    $mail = new PHPMailer(true);

    //Configuring SMTP
    $mail->isSMTP();
    $mail->Host = 's1.ct8.pl';
    $mail->SMTPAuth = true;
    $mail->Username = 'supportnoreply@seleneio.ct8.pl';  
    $mail->Password = 'Kuba2007_';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;  

    //Setting email details
    $mail->setFrom('supportnoreply@seleneio.ct8.pl', 'Selene.io | Support');
    $mail->addAddress($userMail); 

    //Setting email type to HTML
    $mail->isHTML();

    //Setting email content
    $mail->Subject = "Verify your account";
    $mail->Body = $content;

    if($mail->send())
    {
      return 1;
    }
    
    return 0;
}

?>
