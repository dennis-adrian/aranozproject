<?php

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

use classes\ctrl_sesion\Ctrl_Sesion;

require 'app/start.php';
include_once '../classes/array_list.php';
include_once '../classes/ctrl_sesion.php';
include_once '../classes/ctrl_sesion.php';
include_once '../classes/detalleventa.php';
Ctrl_Sesion::activar_sesion();

if (!($_GET["op"] == "confirmar" && isset($_SESSION["carrito"]))) {
    die();
}
// if (isset($_GET["op"]) && $_GET["op"] == "confirmar" && isset($_SESSION["carrito"])) {
//     $objCarrito = $_SESSION["carrito"];
//     if ($objCarrito->Size() < 1)
//         header('location:../index.php?msg=Carrito vacio');
// }

//definir el payment method
$payer = new Payer();
$payer->setPaymentMethod('paypal');

$item = new Item();
$itemList = new ItemList();

$carrito = $_SESSION["carrito"];
$total = 0;
foreach ($carrito->list as $key => $registro) {
    $item->setName($registro->getNombre());
    $item->setCurrency('USD');
    $item->setPrice($registro->getPrecio());
    $item->setQuantity($registro->getCantidad());
    $subtotal = $item->getQuantity() * $item->getPrice();
    $total = $total + $subtotal;
    $itemList->setItems($item);
}

$amount = new Amount();
$amount->setCurrency('USD')
    ->setTotal($total);
$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription('PayPal Payment')
    ->setInvoiceNumber(uniqid());

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl(SITE_URL . '/pay.php?success=true')
    ->setCancelUrl(SITE_URL . '/pay.php?success=false');

$payment = new Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions([$transaction]);

//enviamos los datos a Paypal
try {
    $payment->create($paypal);
} catch (Exception $e) {
    die($e);
}

$approvalUrl = $payment->getApprovalLink();

header("Location: {$approvalUrl}");
