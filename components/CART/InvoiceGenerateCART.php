<?php
//Importing order invoice generating scripts
use Konekt\PdfInvoice\InvoicePrinter;
include("../FPDF/fpdf.php");
include("../pdf-invoice-master/src/InvoicePrinter.php"); 

function GenerateAndSaveInvoice($cartID, $userID, $invoiceID, $subtotal, $total)
{
    //Importing database connection
    include('../databaseConn.php');

    //Fetching info about cart products neccessary to create invoice
    $stmt = $conn -> prepare("SELECT * FROM cart LEFT JOIN promo_code USING(promo_code_id) JOIN cart_product USING(cart_id) JOIN product USING(product_id) WHERE cart_id = :cartID");
    $stmt->bindParam(":cartID", $cartID , PDO::PARAM_INT);
    $stmt->execute();
    $cartProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Fetching info about user neccessary to create invoice
    $stmt = $conn -> prepare("SELECT * FROM order_ JOIN user_adress USING(user_adress_id) WHERE order_id  = :orderID");
    $stmt->bindParam(":orderID", $invoiceID , PDO::PARAM_INT);
    $stmt->execute();
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    $invoice = new InvoicePrinter();
    /* Header Settings */
    $invoice->setLogo("../../photos/logotypes/mainlogo.png");
    $invoice->setColor('#696cff');
    $invoice->setType('Sale Invoice');
    $invoice->setReference("INV/".$invoiceID);
    $invoice->setDate(date('  M dS ,Y', time()));
    $invoice->setTime(date('h:i:s A', time()));
    $invoice->setFrom(['Lunar', 'Selene.io', 'Kamionka Mała 203', '34-602 Laskowa', 'Poland']);
    $invoice->setTo([$userInfo['name']." ".$userInfo['surname'], $userInfo['street']." ".$userInfo['house_number'], $userInfo['postal_code']." ".$userInfo['city'], $userInfo['country']]);
    $invoice->changeLanguageTerm("vat", "tax");
    /* Adding Items in table */
    foreach($cartProducts as $product)
    {
        $invoice->addItem($product['name'], false, $product['quantity'], number_format($product['total_price']*0.13, 2, "."), $product['total_price'], number_format($product['total_price'] * 1.13 * $product['discount'], 2, "."), number_format($product['total_price'] * (1-$product['discount']) * 1.13, 2, "."));
    }
    /* Set totals alignment */
    $invoice->setTotalsAlignment('horizontal');
    /* Add totals */
    $invoice->addTotal('Subtotal', $subtotal);
    $invoice->addTotal('Digital Services Tax 13%', number_format($subtotal * 0.13, 2, "."));
    $invoice->addTotal('Promo code', number_format($cartProducts['0']['discount'] * ($subtotal * 1.13), 2, "."));
    $invoice->addTotal('Total', $total, true);
    /* Set badge */
    $invoice->addBadge('Payment Paid');
    /* Add title */
    $invoice->addTitle('Important Notice');
    /* Add Paragraph */
    $invoice->addParagraph("No item will be replaced or refunded if you don't have the invoice with you. You can refund within 2 days of purchase.");
    /* Set footer note */
    $invoice->setFooternote('© 2024 Selene.io || All rights reserved.');
    /* Render */
    $invoice->render('../../companyFiles/invoices/INV'.$invoiceID.'.pdf', 'F'); /* I => Display on browser, D => Force Download, F => local path save, S => return document path */

    return '../../companyFiles/invoices/INV'.$invoiceID.'.pdf';
}

?>