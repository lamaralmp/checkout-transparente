<?php
    require_once("display-errors.php");
    require_once 'vendor/autoload.php';
    
    MercadoPago\SDK::setAccessToken("TEST-3676651262361900-040314-cf060faae054e1792bf6449fe3d8eb84-301120448");
    
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