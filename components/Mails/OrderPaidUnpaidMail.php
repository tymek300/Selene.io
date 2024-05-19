<?php
//PHPMailer import
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php'; 
require '../PHPMailer/PHPMailer.php'; 
require '../PHPMailer/SMTP.php';

function SendOrderPaidUnpaidMail($name, $surname, $status, $orderID, $phoneNumber, $adress, $orderTotal, $invoicePath, $userMail)
{

    $content = '
    <body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">

    <div class="container" style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border: 1px solid #dddddd;">
        <h1 style="font-size: 24px; color: #333333;">Order Confirmation</h1>

        <p style="font-size: 16px; color: #333333;">Dear <b>[CustomerName]</b>,</p>
        <p style="font-size: 16px; color: #333333;">Thank you for your order! We are pleased to confirm your order has been placed successfully.
        Current status of your order is <b>[OrderStatus]</b>. You can check status any time on our website: http://localhost/Selene.io/orderStatus/index.php?orderID='.$orderID.'
        </p>

        <div class="order-details" style="border: 1px solid #dddddd; padding: 10px; margin-top: 20px;">
            <h2 style="font-size: 24px; margin-bottom: 10px;">Order Details</h2>
            <p style="font-size: 16px; color: #333333;"><strong>Order Number:</strong> [OrderNumber]</p>
            <p style="font-size: 16px; color: #333333;"><strong>Order Date:</strong> [OrderDate]</p>
            <p style="font-size: 16px; color: #333333;"><strong>Phone number:</strong> [PhoneNumber]</p>
            <p style="font-size: 16px; color: #333333;"><strong>Shipping Address:</strong> [ShippingAddress]</p>

            <p style="font-size: 16px; color: #333333;"><strong>Total:</strong> $[OrderTotal]</p>
        </div>';

        if ($status == 'Unpaid') {
            $content .= '<p style="font-size: 16px; color: red; text-align: center;">Attention: Your order will be cancelled if it is not paid within the next 48 hours.</p>';
        }

        $content .= '<p style="font-size: 16px; color: #333333; text-align:center;">If you have any questions about your order, please contact us at urygajakub@gmail.com</p>

        <div class="footer" style="margin-top: 20px; text-align: center; color: #888888;">
            <p>&copy; 2024 Selene.io || All rights reserved.</p>
        </div>
    </div>  
    ';

    //Generating neccessary data
    $orderDate = new DateTime();
    $orderDate = $orderDate->format('d/m/Y');

    //Genereting placeholder with provided data
    $content = str_replace(
        ['[CustomerName]', '[OrderStatus]', '[OrderNumber]', '[OrderDate]', '[PhoneNumber]','[ShippingAddress]', '[OrderTotal]'],
        ["$name $surname", $status, $orderID, $orderDate, $phoneNumber, $adress, $orderTotal],
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
    $mail->Subject = $name." ".$surname." Order Status";
    $mail->Body = $content;

    //Adding generated invoice as attachment
    $mail->addAttachment($invoicePath);

    //Sending mail with order confirmation and invoice
    $mail->send();
}
?>
