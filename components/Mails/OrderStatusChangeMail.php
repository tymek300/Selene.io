<?php
//PHPMailer import
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/Exception.php'; 
require '../../PHPMailer/PHPMailer.php'; 
require '../../PHPMailer/SMTP.php';

function SendOrderStatusChangeMail($name, $surname, $status, $orderID, $userMail)
{

    $content = '
    <body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1);">
        <h2 style="color: #333; margin-bottom: 20px;">Order Status Update</h2>
        <p style="color: #666;">Dear Customer, [CustomerName]</p>
        <p style="color: #666;">We would like to inform you that the status of your order has been updated.</p>
        <p style="color: #666;">New status: <strong style="color: #333;">[OrderStatus]</strong></p>
        <p style="color: #666;">To track the progress of your order, you can use button below.</p>
        <p style="text-align: start; margin-top: 20px;">
            <a href="http://localhost/Selene.io/orderStatus/index.php?orderID=[OrderNumber]" style="display: inline-block; background-color: #532acc; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;">Track Order</a>
        </p>
        <p style="color: #666;">If you have any questions, please feel free to contact us at <a href="mailto:urygajakub@gmail.com" style="color: #333; text-decoration: none;">urygajakub@gmail.com</a>.</p>
        <div class="footer" style="margin-top: 20px; text-align: center; color: #888888;">
            <p>&copy; 2024 Selene.io || All rights reserved.</p>
        </div>
    </div>

    </body>
    ';

    //Genereting placeholder with provided data
    $content = str_replace(
        ['[CustomerName]', '[OrderStatus]', '[OrderNumber]'],
        ["$name $surname", $status, $orderID],
        $content
    );

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
    $mail->setFrom('supportnoreply@seleneio.ct8.pl', 'Selene.io | Customer Service');
    $mail->addAddress($userMail); 

    //Setting email type to HTML
    $mail->isHTML();

    //Setting email content
    $mail->Subject = $name." ".$surname." Order Status Change";
    $mail->Body = $content;

    //Sending mail with order confirmation and invoice
    if($mail->send())
    {
        return 1;
    }
    else
    {
        return 0;
    }
}
?>
