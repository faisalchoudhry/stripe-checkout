<?php
session_start();
$paymentMessage = '';
if (!empty($_POST['stripeToken'])) {

    // get token and user details
    $stripeToken = $_POST['stripeToken'];
    $customerName = $_POST['customerName'];
    $customerlastName = $_POST['customerLastName'];
    $customerEmail = $_POST['emailAddress'];

    $cardNumber = $_POST['cardNumber'];
    $cardCVC = $_POST['cardCVC'];
    $cardExpMonth = $_POST['cardExpMonth'];
    $cardExpYear = $_POST['cardExpYear'];

    //include Stripe PHP library
    require_once('stripe-php/init.php');

    //set stripe secret key and publishable key
    $stripe = array(
        "secret_key" => "sk_test_QpO6f3ESy6hfbGzKzdVwrbBx",
        "publishable_key" => "pk_test_HBUY6uUd8f24PGoEe66UAZtW"
    );

    \Stripe\Stripe::setApiKey($stripe['secret_key']);

    //add customer to stripe
    $customer = \Stripe\Customer::create(array(
        'name' => $customerName . ' ' . $customerlastName,
        'description' => 'test description',
        'email' => $customerEmail,
        'source' => $stripeToken
    ));

    // item details for which payment made
    $itemName = $_POST['item_details'];
    $itemNumber = $_POST['item_number'];
    $itemPrice = $_POST['price'];
    $totalAmount = $_POST['total_amount'];
    $currency = $_POST['currency_code'];
    $orderNumber = $_POST['order_number'];

    // details for which payment performed
    $payDetails = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount' => $totalAmount,
        'currency' => $currency,
        'description' => $itemName,
        'metadata' => array(
            'order_id' => $orderNumber
        )
    ));

    // get payment details
    $paymenyResponse = $payDetails->jsonSerialize();

    // check whether the payment is successful
    if ($paymenyResponse['amount_refunded'] == 0 && empty($paymenyResponse['failure_code']) && $paymenyResponse['paid'] == 1 && $paymenyResponse['captured'] == 1) {

        // transaction details
        $amountPaid = $paymenyResponse['amount'];
        $balanceTransaction = $paymenyResponse['balance_transaction'];
        $paidCurrency = $paymenyResponse['currency'];
        $paymentStatus = $paymenyResponse['status'];
        $paymentDate = date("Y-m-d H:i:s");
        $paymentMessage = "The payment was successful.";
    } else {
        $paymentMessage = "failed";
    }
} else {
    $paymentMessage = "failed";
}
$_SESSION["message"] = $paymentMessage;
header('location:index.php');
