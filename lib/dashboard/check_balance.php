<?php
session_start();
include_once '../databaseHandler/connection.php';
require_once '../authentication/paypal.php';

if (isset($_POST["fetch"])) {

    $paypal = new Paypal('sb-wccoz26819420_api1.business.example.com', 'QNHBUMAU8WCKK6EV', 'AErUJZx.Btq3.dnDQaYLyX-ypnZAAuIxEG4xJmtDpoxgdB.JpM6cFyx0', 'sandbox');

    // Make an API call to get balance
    $response = $paypal->call('GetBalance');

    $balance = $response['L_AMT0'] * 55.88;
    $amount = number_format($balance, 2, '.', ',');
    $amountUSD = number_format($response['L_AMT0'], 2, '.', ',');

    $output = array();

    array_push($output, (object)[
        'phpBalance' => $amount
    ]);
    array_push($output, (object)[
        'usdBalance' => $amountUSD
    ]);


    echo json_encode($output);
}
