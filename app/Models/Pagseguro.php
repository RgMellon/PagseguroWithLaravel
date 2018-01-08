<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client as Guzzle;

class Pagseguro extends Model {

    public function generate(){
        $params = self::transformaUrl();
        $response = self::montaRequisicao($params, config('pagseguro.url_checkout_sandbox'));
        $bodyJson = self::xmlToJson($response);
        return $bodyJson->code;
    }

    public function getSessionId(){
        $params =  ['email' => config('pagseguro.email'),
                    'token' => config('pagseguro.token')];
        $params = self::buildUrl($params);
        $response = self::montaRequisicao($params, config('pagseguro.url_session_payment_sandbox'));
        $bodyJson = self::xmlToJson($response);
        return $bodyJson->id;
    }

    public function pagamentoBoleto($sendHash){
       $params = [
            'email' => config('pagseguro.email'),
            'token' => config('pagseguro.token'),
            'senderHash' => $sendHash,
            'paymentMode' => 'default',
            'paymentMethod' => 'boleto',
            'currency' => 'BRL',
            'itemId1' => '0001',
            'itemDescription1' => 'Produto PagSeguroI',
            'itemAmount1' => '99999.99',
            'itemQuantity1' => '1',
            'itemWeight1' => '1000',
            'itemId2' => '0002',
            'itemDescription2' => 'Produto PagSeguroII',
            'itemAmount2' => '99999.98',
            'itemQuantity2' => '2',
            'itemWeight2' => '750',
            'reference' => 'REF1234',
            'senderName' => 'Jose Comprador',
            'senderAreaCode' => '99',
            'senderPhone' => '99999999',
            'senderEmail' => 'c73904650353493991757@sandbox.pagseguro.com.br',
            'senderCPF' => '41366515897',
            'shippingType' => '1',
            'shippingAddressStreet' => 'Av. PagSeguro',
            'shippingAddressNumber' => '9999',
            'shippingAddressComplement' => '99o andar',
            'shippingAddressDistrict' => 'Jardim Internet',
            'shippingAddressPostalCode' => '99999999',
            'shippingAddressCity' => 'Cidade Exemplo',
            'shippingAddressState' => 'SP',
            'shippingAddressCountry' => 'ATA',
        ];
        $guzzle = new Guzzle();
        $response = $guzzle->request('POST', config('pagseguro.url_transparent_sandbox'), [
            'form_params' => $params
        ]);
        $body = $response->getBody();
        $contents = $body->getContents();
        $xml = simplexml_load_string($contents);
        return $xml->paymentLink;
    }

    private function transformaUrl(){
        $params = [
            'email' => config('pagseguro.email'),
            'token' => config('pagseguro.token'),
            'currency' => 'BRL',
            'itemId1' => '0001',
            'itemDescription1' => 'Produto PagSeguroI',
            'itemAmount1' => '99999.99',
            'itemQuantity1' => '1',
            'itemWeight1' => '1000',
            'itemId2' => '0002',
            'itemDescription2' => 'Produto PagSeguroII',
            'itemAmount2' => '99999.98',
            'itemQuantity2' => '2',
            'itemWeight2' => '750',
            'reference' => 'REF1234',
            'senderName' => 'Jose Comprador',
            'senderAreaCode' => '99',
            'senderPhone' => '99999999',
            'senderEmail' => 'comprador@uol.com.br',
            'shippingType' => '1',
            'shippingAddressStreet' => 'Av. PagSeguro',
            'shippingAddressNumber' => '9999',
            'shippingAddressComplement' => '99o andar',
            'shippingAddressDistrict' => 'Jardim Internet',
            'shippingAddressPostalCode' => '99999999',
            'shippingAddressCity' => 'Cidade Exemplo',
            'shippingAddressState' => 'SP',
            'shippingAddressCountry' => 'ATA',
        ];
        return self::buildUrl($params);
    }

    private function buildUrl($params) {
        return http_build_query($params);
    }

    private function montaRequisicao($params, $url, $formParams = '') {
        $g = new Guzzle();
        if(empty($formParams)){
            return $response = $g->request('POST', $url, [
                'query' => $params,
            ]);
        }else{
            return $response = $g->request('POST', $url, [
                'form_params' => $params,
            ]);
        }
    }

    private function xmlToJson($response){
        return simplexml_load_string($response->getBody()->getContents());
    }

    public function pagamentoCartao($request){
        
        $params = [
            'email' => config('pagseguro.email'),
            'token' => config('pagseguro.token'),
            'senderHash' => $request->senderHash,
            'paymentMode' => 'default',
            'paymentMethod' => 'creditCard',
            'currency' => 'BRL',
            
            'itemId1' => '0001',
            'itemDescription1' => 'Produto PagSeguroI',
            'itemAmount1' => '200.00',
            'itemQuantity1' => '1',
            'itemWeight1' => '1000',
            
            'reference' => 'REF1234',
            'senderName' => 'Jose Comprador',
            'senderAreaCode' => '99',
            'senderPhone' => '99999999',
            'senderEmail' => 'c73904650353493991757@sandbox.pagseguro.com.br',
            'senderCPF' => '41366515897',

            'shippingType' => '1',
            'shippingAddressStreet' => 'Av. PagSeguro',
            'shippingAddressNumber' => '9999',
            'shippingAddressComplement' => '99o andar',
            'shippingAddressDistrict' => 'Jardim Internet',
            'shippingAddressPostalCode' => '99999999',
            'shippingAddressCity' => 'Cidade Exemplo',
            'shippingAddressState' => 'SP',
            'shippingAddressCountry' => 'ATA',
            'creditCardToken'=>$request->cardToken,
            'installmentQuantity'=> '1',
            'installmentValue'=> '200.00',
            'noInterestInstallmentQuantity'=> '2',
            'creditCardHolderName'=>'Jose Comprador',
            'creditCardHolderCPF'=>'11475714734',
            'creditCardHolderBirthDate'=>'01/01/1900',
            'creditCardHolderAreaCode'=>99,
            'creditCardHolderPhone'=>99999999,
            'billingAddressStreet'=>'Av. PagSeguro',
            'billingAddressNumber'=>9999,
            'billingAddressComplement'=>'99o andar',
            'billingAddressDistrict'=>'Jardim Internet',
            'billingAddressPostalCode'=>99999999,
            'billingAddressCity'=>'Cidade Exemplo',
            'billingAddressState'=>'SP',
            'billingAddressCountry'=>'ATA',
        ];

        $guzzle = new Guzzle();
        $response = $guzzle->request('POST', config('pagseguro.url_transparent_sandbox'), [
            'form_params' => $params
        ]);
        $body = $response->getBody();
        $contents = $body->getContents();
        $xml = simplexml_load_string($contents);
        return $xml->code;
    }
}
