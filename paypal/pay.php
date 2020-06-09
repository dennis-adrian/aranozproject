<?php

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

use \classes\ctrl_sesion\Ctrl_Sesion;

require 'app/start.php';
include_once '../classes/ctrl_sesion.php';
Ctrl_Sesion::activar_sesion();

//hacemos este proceso para confirmar el pago y se haga la transferencia
if (!isset($_GET['success'], $_GET['paymentId'], $_GET['PayerID'])) {
  die();
}
if ((bool) $_GET['success'] === false) {
  die();
}
$paymentId = $_GET['paymentId'];
$payerId = $_GET['PayerID'];

$payment = Payment::get($paymentId, $paypal);

$execute = new PaymentExecution();
$execute->setPayerId($payerId);

try {
  $result = $payment->execute($execute, $paypal);
} catch (Exception $e) {
  $data = json_decode($e);
  var_dump($data);
  die();
}

header("location:../process/guardar_venta.php?op=pagoconfirmado&pagoid=$paymentId");
