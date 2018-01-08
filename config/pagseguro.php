<?php
  return [
    'environment' => env('PAGSEGURO_ENVIRONMENT'),
    'email' => env('PAGSEGURO_EMAIL'),
    'token' => env('PAGSEGURO_TOKEN'),
    'url_checkout_sandbox' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout',
    'url_checkout_production' => 'https://ws.pagseguro.uol.com.br/v2/checkout',
    'url_redirect_after_request_production' => 'https://pagseguro.uol.com.br/v2/checkout/payment.html?code=',
    'url_redirect_after_request_sandbox' => 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=',
    /*
      Para iniciar um Checkout Transparente é necessário ter um ID de sessão válido.
      Este serviço retorna o ID de sessão que será usado nas chamadas JavaScript.
      A chamada deve ser efetuada para a URL abaixo utilizando o método POST.
    */
    'url_session_payment_production' => 'https://ws.pagseguro.uol.com.br/v2/sessions',
    'url_session_payment_sandbox' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions',

    'url_api_checkout_transparent_production' => "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js",
    'url_api_checkout_transparent_sandbox' => "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js",

    'url_transparent_sandbox' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions',
    'url_transparent_production' => 'https://ws.pagseguro.uol.com.br/v2/transactions'
  ];

?>