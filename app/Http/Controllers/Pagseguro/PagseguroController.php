<?php

namespace App\Http\Controllers\Pagseguro;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pagseguro;

class PagseguroController extends Controller {

    public function pagSeguro(Pagseguro $pgs){
        $code = $pgs->generate();
        $r = config('pagseguro.url_redirect_after_request_sandbox');
        $urlRedirect = $r.$code;
        return redirect()->away($urlRedirect);
    }

    public function getCode(Pagseguro $pgs){
        return $pgs->getSessionId();
    }

    public function transparent(){
        return view('pagseguro.index');
    }

    public function boleto(Request $r, Pagseguro $pg){
        return $pg->pagamentoBoleto($r->sendHash);
    }

    public function cartaoCredito(){
        return view('pagseguro.cartao');
    }

    public function cartaoRequest(Request $r, Pagseguro $pg){
        return $pg->pagamentoCartao($r);
    }

}
