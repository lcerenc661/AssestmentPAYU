<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PayUController extends Controller
{


    public function realizarPago(Request $request)
    { // Data
        $payerData = $request->input('buyer');
        $payerfullname = $payerData['fullName'];
        $payeremail = $payerData['emailAddress'];
        $payerphone = $payerData['contactPhone'];
        $payerdninumber = $payerData['dniNumber'];


        // $apiKey = "4Vj8eK4rloUd272L48hsrarnUA";
        // $apiLogin = "pRRXKOl8ikMmt9u";
        // $merchantId = "508029";
        $apiKey = env("PAYU_API_KEY");
        $apiLogin = env("PAYU_API_LOGIN");
        $merchantId = env("PAYU_MERCHANT_ID");
        $accountId = "512321";
        $referenceCode = 'TEST_2019-08-16T17:56:25.659Z';
        $txValue = '5000';
        $currency = 'COP';
        $signatureString = "$apiKey~$merchantId~$referenceCode~$txValue~$currency";
        $signature = md5($signatureString);
        $deviceSessionId = md5(session_id() . microtime());
        $payload = [
            "language" => "es",
            "command" => "SUBMIT_TRANSACTION",
            "merchant" => [
                "apiKey" => $apiKey,
                "apiLogin" => $apiLogin
            ],
            "transaction" => [
                "order" => [
                    "accountId" => $accountId,
                    "referenceCode" => $referenceCode,
                    "description" => "Payment test description",
                    "language" => "es",
                    "signature" => $signature,
                    "notifyUrl" => "http://www.payu.com/notify",
                    "additionalValues" => [
                        "TX_VALUE" => [
                            "value" => $txValue,
                            "currency" => $currency
                        ],
                        "TX_TAX" => [
                            "value" => "1000",
                            "currency" => $currency
                        ],
                        "TX_TAX_RETURN_BASE" => [
                            "value" => "4000",
                            "currency" => $currency
                        ]
                    ],
                    "buyer" => [
                        "merchantBuyerId" => "1",
                        "fullName" => $payerfullname,
                        "emailAddress" => $payeremail,
                        "contactPhone" => $payerphone,
                        "dniNumber" => $payerdninumber,
                        "shippingAddress" => [
                            "street1" => "Cr 23 No. 53-50",
                            "street2" => "5555487",
                            "city" => "Bogotá",
                            "state" => "Bogotá D.C.",
                            "country" => "CO",
                            "postalCode" => "000000",
                            "phone" => "7563126"
                        ]
                    ],
                    "shippingAddress" => [
                        "street1" => "Cr 23 No. 53-50",
                        "street2" => "5555487",
                        "city" => "Bogotá",
                        "state" => "Bogotá D.C.",
                        "country" => "CO",
                        "postalCode" => "0000000",
                        "phone" => "7563126"
                    ]
                ],
                "payer" => [
                    "merchantPayerId" => "1",
                    "fullName"=> "First name and second payer name",
                    "emailAddress"=> "payer_test@test.com",
                    "contactPhone"=> "7563126",
                    "dniNumber"=> "5415668464654",
                    "billingAddress" => [
                        "street1" => "Cr 23 No. 53-50",
                        "street2" => "125544",
                        "city" => "Bogotá",
                        "state" => "Bogotá D.C.",
                        "country" => "CO",
                        "postalCode" => "000000",
                        "phone" => "7563126"
                    ]
                ],
                "creditCard" => [
                    "number" => "4037997623271984",
                    "securityCode" => "321",
                    "expirationDate" => "2030/12",
                    "name" => "APPROVED"
                ],
                "extraParameters" => [
                    "INSTALLMENTS_NUMBER" => 1
                ],
                "type" => "AUTHORIZATION_AND_CAPTURE",
                "paymentMethod" => "VISA",
                "paymentCountry" => "CO",
                "deviceSessionId" => $deviceSessionId,
                "ipAddress" => "127.0.0.1",
                "cookie" => "pt1t38347bs6jc9ruv2ecpv7o2",
                "userAgent" => "Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0",
                "threeDomainSecure" => [
                    "embedded" => false,
                    "eci" => "01",
                    "cavv" => "AOvG5rV058/iAAWhssPUAAADFA==",
                    "xid" => "Nmp3VFdWMlEwZ05pWGN3SGo4TDA=",
                    "directoryServerTransactionId" => "00000-70000b-5cc9-0000-000000000cb"
                ]
            ],
            "test" => true
        ];
        $response = Http::post('https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi', $payload);


        //Manage Response

        $resData = $response->body();

        // return $resData;

        return view('res', [
            'response' => $resData,
            'username' => $payerfullname,
            'dni' => $payerdninumber,
        ]);
    }
}