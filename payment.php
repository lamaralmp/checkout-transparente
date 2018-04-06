<?php
    require_once("display-errors.php");
    require_once 'vendor/autoload.php';
    
    MercadoPago\SDK::setAccessToken($_ENV["ACCESS_TOKEN"]);
    
    $payment = new MercadoPago\Payment();
    $payment->transaction_amount = round((float)$_REQUEST['amount'],2);
    $payment->token = $_REQUEST['token'];
    $payment->description = $_REQUEST['description'];
    $payment->installments = (int)$_REQUEST['installmentsOption'];
    $payment->payment_method_id = $_REQUEST['paymentMethodId'];
    $payment->payer = array("email" => $_REQUEST['email']);
    
    $payment->save();
    
    echo "<pre>";
    print_r($payment);
    echo "</pre>";
?>