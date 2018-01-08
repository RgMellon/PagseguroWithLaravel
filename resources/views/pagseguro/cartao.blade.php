<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <title>Cartao</title>
</head>
  <body>
    <div class="container">
     <h1>Credit Card</h1>
      <form id="pagamento-cartao">
        <label for="">Numero Cartão </label>
          <div class="input-group">
            <input type="text" id="valorCartao" value="4111111111111111" name="cardNumber" class="form-control" placeholder="Numero">
          </div>
        <label for=""> Mes expiracao </label>
          <div class="input-group">
            <input type="text" value="12" name="cardExpiryMonth" class="form-control" placeholder="Mes expiracao">
          </div>
        <label for=""> Ano expiracao </label>
        <div class="input-group">
          <input type="text" value="2030" name="cardExpiryYear" class="form-control" placeholder="Ano expiracao">
        </div>
        <label for=""> CVV </label>
        <div class="input-group">
          <input type="text" value="123" name="cardCVV" class="form-control" placeholder="CVV">
        </div>
        <div class="input-group">
          <button id="envia-form" type="button" class="btn btn-default">Enviar</button>
        </div>
        <input type="hidden" id="marcaCartao" name="cardName">
        <input type="hidden" id="token" name="cardToken">
      </form>
  <script src="{{ config('pagseguro.url_api_checkout_transparent_sandbox') }}"></script>
  <script>
      /*Requisição para pegar a sessao */
      let url = "{{route('pg.getcode')}}";
      fetch(url, {
        method: 'GET',
      }).then(data => data.text())
        .then(id => PagSeguroDirectPayment.setSessionId(id))
        .catch(err => console.log(err))
      /*fim da requisicao */

      let btn = document.querySelector("#envia-form");
      btn.addEventListener('click', () => {
        let card = document.querySelector('#valorCartao').value.replace(/ /g, '');
        PagSeguroDirectPayment.getBrand({
          cardBin: card,
          success: function(response) {
            document.querySelector("#marcaCartao").value = response.brand.name;
            getCardToken();
          },
          error: function(response) {
            //tratamento do erro
          },
        });
      });
       
       function getCardToken(){
          let form = document.querySelector("#pagamento-cartao");
          let cartao = {
            numero : form.cardNumber.value,
            mesExpiracao : form.cardExpiryMonth.value,
            anoExpiracao : form.cardExpiryYear.value,
            cvv : form.cardCVV.value,
          }

          PagSeguroDirectPayment.createCardToken({
            cardNumber: cartao.numero,
            cvv: cartao.cvv,
            expirationMonth: cartao.mesExpiracao,
            expirationYear: cartao.anoExpiracao,
            success: function(response) {
              document.querySelector("#token").value = response.card.token;
              createTransactionCard();
            },
            error: function(response) {
              //tratamento do erro
            },
          });
        }

        function createTransactionCard(){
          let form = document.querySelector("#pagamento-cartao");
          let data = new FormData(form);
          data.append('senderHash', PagSeguroDirectPayment.getSenderHash());
          let url = "{{route('pg.cartao.request')}}";
          fetch(url, {
            method: "POST",
            body: data,
          }).then(res => res.text())
            .then(res => console.log(res))
        }

  </script>
</body>
</html>