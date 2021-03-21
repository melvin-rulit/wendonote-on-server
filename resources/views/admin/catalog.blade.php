<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Пример на bootstrap 4: Checkout - пользовательская форма заказа, показывающая компоненты формы и функции проверки.">

    <title>Пользовательская форма | Checkout example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
<link href="https://bootstrap-4.ru/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="apple-touch-icon" href="https://bootstrap-4.ru/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="https://bootstrap-4.ru/docs/4.4/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="https://bootstrap-4.ru/docs/4.4/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="https://bootstrap-4.ru/docs/4.4/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="https://bootstrap-4.ru/docs/4.4/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
<link rel="icon" href="https://bootstrap-4.ru/docs/4.4/assets/img/favicons/favicon.ico">
<meta name="msapplication-config" content="https://bootstrap-4.ru/docs/4.4/assets/img/favicons/browserconfig.xml">
<meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

.container {
    max-width: 1400px;
}
    </style>
    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

  </head>

  <body class="bg-light">

    <div class="container">
  <div class="py-5 text-center">
    <h2>Каталог</h2>
    <p class="lead">Административная панель управления каталогом.</p>
  </div>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Перейти в публичный каталог</a></li>
  </ol>
</nav>

  <div class="row">
    <div class="col-md-3 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Список групп</span>
        <span class="badge badge-secondary badge-pill">{{ count($groups) }}</span>
      </h4>
      <div class="list-group groups_list"></div>

<div class="py-4 pb-4 button-add text-center">
  <button data-toggle="modal" data-target="#add_group" type="button" class="btn btn-success btn-sm">Добавить группу</button>
  <button data-toggle="modal" data-target="#add_catalog" type="button" class="btn btn-danger btn-sm">Добавить артиста</button>
</div>

    </div>
    <div class="col-md-9 order-md-1 main_catalog">
      <div class="card-deck">
  @foreach($catalogs as $catalog)
  <div class="col-md-4 mb-4">
      <div class="card">

      @if ($catalog->photo)
          <img src="{{ asset('storage'.str_replace('public' , '', $catalog->photo)) }}" class="bd-placeholder-img card-img-top" width="100%" height="180">
      @else
          <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Image cap"><title>Placeholder</title><rect fill="#868e96" width="100%" height="100%"></rect><text fill="#dee2e6" dy=".3em" x="50%" y="50%">Изображение</text></svg>
      @endif

        <div class="card-body">
          <h5 class="card-title">{{ $catalog->name }}</h5>
          <p class="card-text">{{ $catalog->description }}</p>
        </div>
        <div class="card-footer">
          <!-- <small class="text-muted">Активно</small> -->
        <a href="admin/artist/{{ $catalog->id }}/edit" class="card-link">Посмотреть</a>
        </div>
      </div>
      </div>
  @endforeach
</div>


<!--       <h4 class="mb-3">Billing address</h4>
      <form class="needs-validation" novalidate>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="firstName">First name</label>
            <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
            <div class="invalid-feedback">
              Valid first name is required.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="lastName">Last name</label>
            <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
            <div class="invalid-feedback">
              Valid last name is required.
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="username">Username</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">@</span>
            </div>
            <input type="text" class="form-control" id="username" placeholder="Username" required>
            <div class="invalid-feedback" style="width: 100%;">
              Your username is required.
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="email">Email <span class="text-muted">(Optional)</span></label>
          <input type="email" class="form-control" id="email" placeholder="you@example.com">
          <div class="invalid-feedback">
            Please enter a valid email address for shipping updates.
          </div>
        </div>

        <div class="mb-3">
          <label for="address">Address</label>
          <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
          <div class="invalid-feedback">
            Please enter your shipping address.
          </div>
        </div>

        <div class="mb-3">
          <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
          <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
        </div>

        <div class="row">
          <div class="col-md-5 mb-3">
            <label for="country">Country</label>
            <select class="custom-select d-block w-100" id="country" required>
              <option value="">Choose...</option>
              <option>United States</option>
            </select>
            <div class="invalid-feedback">
              Please select a valid country.
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="state">State</label>
            <select class="custom-select d-block w-100" id="state" required>
              <option value="">Choose...</option>
              <option>California</option>
            </select>
            <div class="invalid-feedback">
              Please provide a valid state.
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <label for="zip">Zip</label>
            <input type="text" class="form-control" id="zip" placeholder="" required>
            <div class="invalid-feedback">
              Zip code required.
            </div>
          </div>
        </div>
        <hr class="mb-4">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="same-address">
          <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
        </div>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="save-info">
          <label class="custom-control-label" for="save-info">Save this information for next time</label>
        </div>
        <hr class="mb-4">

        <h4 class="mb-3">Payment</h4>

        <div class="d-block my-3">
          <div class="custom-control custom-radio">
            <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
            <label class="custom-control-label" for="credit">Credit card</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
            <label class="custom-control-label" for="debit">Debit card</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required>
            <label class="custom-control-label" for="paypal">PayPal</label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="cc-name">Name on card</label>
            <input type="text" class="form-control" id="cc-name" placeholder="" required>
            <small class="text-muted">Full name as displayed on card</small>
            <div class="invalid-feedback">
              Name on card is required
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="cc-number">Credit card number</label>
            <input type="text" class="form-control" id="cc-number" placeholder="" required>
            <div class="invalid-feedback">
              Credit card number is required
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 mb-3">
            <label for="cc-expiration">Expiration</label>
            <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
            <div class="invalid-feedback">
              Expiration date required
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <label for="cc-cvv">CVV</label>
            <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
            <div class="invalid-feedback">
              Security code required
            </div>
          </div>
        </div>
        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
      </form> -->
    </div>
  </div>


<!-- Modal -->
<div class="modal fade" id="add_group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Добавить группу</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form method="POST" id="store_group" action="{{route('admin.addArtist')}}" enctype="multipart/form-data" onsubmit="add_group()">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="name">Имя группы</label>
              <input type="text" class="form-control" name="name" aria-describedby="emailHelp" required>
            </div>
            <div class="form-group">
              <label for="description">Описание</label>
              <textarea class="form-control" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="photo">Фото группы</label>
                <input id="photo" type="file" name="photo">
            </div>
            <input type="hidden" name="group" value="1">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="submit" class="btn btn-primary">Добавить</button>
      </div>
          </form>
    </div>
  </div>
</div>





<!-- Modal -->
<div class="modal fade" id="add_catalog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Добавить артиста</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="store_group" action="{{route('admin.addArtist')}}" enctype="multipart/form-data" onsubmit="add_artist()">
            {{ csrf_field() }}
        <div class="form-group">
          <label for="name">Название</label>
          <input name="name" type="text" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="groups">Группа</label>
          <select class="form-control" name="catalog_groups_id" required>
            @foreach ($groups as $key => $value)
              <option value="{{ $value->id }}">{{ $value->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="description">Описание</label>
          <textarea class="form-control" name="description" rows="3"></textarea>
        </div>

        <div class="form-row mb-3">
          <div class="col">
            <input type="text" name="price_from" class="form-control" placeholder="Цена от" required>
          </div>
          <div class="col">
            <input type="text" name="price_up_to" class="form-control" placeholder="Цена до" required>
          </div>
        </div>

        <div class="form-group">
          <label for="youtube">Сылка на Youtube</label>
          <input type="text" name="youtube" class="form-control">
        </div>

        <div class="form-group">
            <label for="photo">Фото главное</label>
            <input type="file" name="photo" class="form-control-file">
        </div>

        <div class="form-group">
          <label for="tel">Телефон</label>
          <input type="text" name="tel" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="tel_work">Рабочий телефон</label>
          <input type="text" name="tel_work" class="form-control">
        </div>

        <div class="form-group">
          <label for="position">Позиция</label>
          <select class="form-control" name="position">

            @for ($i = 1; $i < 11; $i++)
              <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
        </div>

        <!-- <input type="hidden" name="position" value="1"> -->
        <input type="hidden" name="group" value="0">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="submit" type="button" class="btn btn-primary">Добавить</button>
      </div>
      </form>
    </div>
  </div>
</div>



  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2017-2019 Company Name</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
  </footer>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="https://bootstrap-4.ru/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="https://bootstrap-4.ru/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
        <script src="form-validation.js"></script></body>
</html>


<script>

$( document ).ready(function() {

    getGroup();
});

$(document).on('click', '.list-group-item', function() {
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       var id = $(this).attr('id');
        $(this).addClass('active').siblings().removeClass('active');
             $.ajax({
                url: '{{route('admin.store')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, id,},
                dataType: 'HTML',
                success: function (data) { 
                    $('.card-deck').html(data);
                }
            }); 
    });


  function add_group() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var msg   = $('#store_group').serialize();
      $.ajax({
        type: 'POST',
        url: '{{route('admin.addArtist')}}',
        data: msg +"&_token="+ CSRF_TOKEN,
        success: function(data) {
         $('#store_group')[0].reset();
         $('.menu_list').html(data);
         getGroup();
       },
       error:  function(xhr, str){
        
      }
    });
  }


  function add_artist() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var msg   = $('#store_artist').serialize();
      $.ajax({
        type: 'POST',
        url: '{{route('admin.addArtist')}}',
        data: msg +"&_token="+ CSRF_TOKEN,
        success: function(data) {
         $('.menu_list').html(data);
         $('#store_artist')[0].reset();
       },
       error:  function(xhr, str){
        
      }
    });
  }


  function getGroup(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var msg = "1";
      $.ajax({
        type: 'POST',
        url: '{{route('admin.getGroup')}}',
        data: msg +"&_token="+ CSRF_TOKEN,
        success: function(data) {
         $('.groups_list').html(data);
       },
       error:  function(xhr, str){
        alert('Ошибка');
      }
    });
  }

  // $(function() {
  //   $('#save').on('click',function(){
  //     var title = $('#name').val();
  //     var text = $('#text').val();
  //     $.ajax({
  //       url: '{{ route('admin.store') }}',
  //       type: "POST",
  //       data: {title:title,text:text},
  //       headers: {
  //         'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
  //       },
  //       success: function (data) {
  //         $('#addArticle').modal('hide');
  //         $('#articles-wrap').removeClass('hidden').addClass('show');
  //         $('.alert').removeClass('show').addClass('hidden');
  //         var str = '<tr><td>'+data['id']+
  //         '</td><td><a href="/article/'+data['id']+'">'+data['title']+'</a>'+
  //         '</td><td><a href="/article/'+data['id']+'" class="delete" data-delete="'+data['id']+'">Удалить</a></td></tr>';
  //         $('.table > tbody:last').append(str);
  //       },
  //       error: function (msg) {
  //         alert('Ошибка');
  //       }
  //     });
  //   });
  // })

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>