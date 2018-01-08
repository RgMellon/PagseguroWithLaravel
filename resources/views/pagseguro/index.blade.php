<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PagSeguro Tranparent</title>
</head>
<body>
  {{ csrf_field() }}
  <button type="button" class="boleto"> Pagamento Com boleto </button>
  
</body>
<script src="{{ config('pagseguro.url_api_checkout_transparent_sandbox') }}"></script>
<script>
  let boleto = document.querySelector('.boleto');
  let url = "{{route('pg.getcode')}}";
  console.log(url);
  fetch(url, {
   method: 'GET',
  }).then(data => data.text())
    .then(id => PagSeguroDirectPayment.setSessionId(id))
    .catch(err => console.log(err))


  boleto.addEventListener('click', () =>{
    let url = "{{ route('pg.boleto')}}";
    let sendHash = PagSeguroDirectPayment.getSenderHash();
    let paramsBusca = new URLSearchParams();
    paramsBusca.append('sendHash', sendHash);

      fetch(url, {
        method: "POST",
        body: paramsBusca,
      }).then(data => data.text())
        .then(url => window.location.href = url);
    })

</script>

</html>