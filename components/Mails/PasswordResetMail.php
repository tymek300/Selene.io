<?php
//PHPMailer import
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../components/PHPMailer/Exception.php'; 
require '../components/PHPMailer/PHPMailer.php'; 
require '../components/PHPMailer/SMTP.php';

function SendPasswordResetMail($token, $userMail)
{

  $content = '
    <body>
      <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="background-color: #f4f5f6; width: 100%;">
          <tr>
              <td>&nbsp;</td>
              <td class="container" style="margin: 0 auto !important; max-width: 600px; padding: 24px 0 0; width: 600px;">
                  <div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 600px; padding: 0;">
                      <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="main" style="background: #ffffff; border: 1px solid #eaebed; border-radius: 16px; width: 100%;">
                          <tr>
                              <td class="wrapper" style="box-sizing: border-box; padding: 24px;">
                                  <p style="font-family: Helvetica, sans-serif; font-size: 16px; font-weight: normal; margin: 0 0 16px;">Hello there,</p>
                                  <p style="font-family: Helvetica, sans-serif; font-size: 16px; font-weight: normal; margin: 0 0 16px;">We understand that sometimes you may need to reset your password. To make the process simple and straightforward, click the button below:</p>
                                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="box-sizing: border-box; min-width: 100% !important; width: 100%;">
                                      <tbody>
                                          <tr>
                                              <td align="left" style="padding-bottom: 16px;">
                                                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: auto;">
                                                      <tbody>
                                                          <tr>
                                                              <td><a href="http://localhost/Selene.io/passwordReset?token=' . $token . '" target="_blank" style="background-color: #532acc; border: solid 2px #532acc; border-radius: 4px; box-sizing: border-box; color: #ffffff; cursor: pointer; display: inline-block; font-size: 16px; font-weight: bold; margin: 0; padding: 12px 24px; text-decoration: none; text-transform: capitalize;">Reset Password</a></td>
                                                          </tr>
                                                      </tbody>
                                                  </table>
                                              </td>
                                          </tr>
                                      </tbody>
                                  </table>
                                  <p style="font-family: Helvetica, sans-serif; font-size: 16px; font-weight: normal; margin: 0 0 16px;">This email template is designed to guide you seamlessly through the password reset process. Click the button above with no distractions to get started.</p>
                                  <p style="font-family: Helvetica, sans-serif; font-size: 16px; font-weight: normal; margin: 0 0 16px;">Best of luck! We hope it works smoothly for you.</p>
                              </td>
                          </tr>
                      </table>
                      <div class="footer" style="clear: both; padding-top: 24px; text-align: center; width: 100%;">
                          <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                  <td class="content-block" style="color: #9a9ea6; font-size: 16px; text-align: center;"><span class="apple-link">Selene.io, your favourite software shop.</span></td>
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
    $mail->Subject = "Recover your password";
    $mail->Body = $content;

    if($mail->send())
    {
      return 1;
    }
    
    return 0;
}

?>
