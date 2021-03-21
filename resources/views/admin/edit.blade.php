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

    <?php //$groups = \App\Http\Controllers\CatalogController::getGroups();?>


    <div class="container">
  <div class="py-5 text-center">
    <h2>Каталог</h2>
    <p class="lead">Административная панель управления каталогом.</p>
  </div>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin">В список артистов</a></li>
    <li class="breadcrumb-item"><a href="/">Перейти в публичный каталог</a></li>
  </ol>
</nav>

<div class="row">

  <div class="col-md-9 order-md-1 main_catalog">

      <div class="text-center">
              <img src="{{ asset('storage'.str_replace('public' , '', $artist->photo)) }}" class="bd-placeholder-img card-img-top">
      </div>

      <h4><b>Название: </b>{{ $artist->name }}</h4>
      <p><b>Описание: </b>{{ $artist->description }}</p>
      <p><b>Цена от: </b>{{ $artist->price_from }}</p>
      <p><b>Цена до: </b>{{ $artist->price_up_to }}</p>
      <p><b>Ссылка на Youtube: </b>{{ $artist->youtube }}</p>
      <p><b>Телефон: </b>{{ $artist->tel }}</p>
      <p><b>Телефон рабочий: </b>{{ $artist->tel_work }}</p>
      <p><b>Место в каталоге : </b>{{ $artist->position }}</p>

      <hr>


            <form class="{{ $artist->id }}" method="POST" id="editid" action="{{route('admin.editid')}}" enctype="multipart/form-data"onsubmit="edit()">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $artist->id }}">
                    <div class="form-group">
                        <label for="title">Название</label>
                        <input class="form-control"  name="name" type="text" value="{{$artist->name}}" required>
                    </div>

                  <div class="form-group">
                    <label for="groups">Группа</label>
                    <select class="form-control" name="catalog_groups_id" value="{{$artist->id}}">
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea class="form-control" name="description" rows="3" value="{{$artist->description}}"></textarea>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col">
                      <input type="text" name="price_from" class="form-control" placeholder="Цена от" value="{{$artist->price_from}}" required>
                    </div>
                    <div class="col">
                      <input type="text" name="price_up_to" class="form-control" placeholder="Цена до" value="{{$artist->price_up_to}}" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="youtube">Сылка на Youtube</label>
                    <input type="text" name="youtube" class="form-control" value="{{$artist->youtube}}">
                  </div>

                  <div class="form-group">
                      <label for="photo">Фото главное</label>
                      <input type="file" name="photo" class="form-control-file" value="{{$artist->photo}}">
                  </div>

                  <div class="form-group">
                    <label for="tel">Телефон</label>
                    <input type="text" name="tel" class="form-control" value="{{$artist->tel}}" required>
                  </div>

                  <div class="form-group">
                    <label for="tel_work">Рабочий телефон</label>
                    <input type="text" name="tel_work" class="form-control" value="{{$artist->tel_work}}">
                  </div>

                  <div class="form-group">
                    <label for="position">Позиция</label>
                    <select class="form-control" name="position">
                      <option value="{{ $artist->position  }}">{{ $artist->position  }}</option>

                      @for ($i = 1; $i < 11; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                      @endfor
                    </select>
                  </div>
                  <!-- <input type="hidden" name="position" value="1"> -->
                  <input type="hidden" name="group" value="0">
                  <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Изменить">
                    <input class="btn btn-danger delete-artist" type="submit" value="Удалить">
                </div>
            </form>


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


$(document).on('click', '.delete-artist', function() {
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       var id = $('form').attr('class');
             $.ajax({
                url: '{{route('admin.deleteid')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, id,},
                dataType: 'HTML',
                success: function (data) { 
                    window.location.replace("/admin");
                }
            }); 
    });


  function edit(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id = $('form').attr('class');
    var msg   = $('#editid').serialize();
      $.ajax({
        type: 'POST',
        url: '{{route('admin.editid')}}',
        data: msg +"&_token="+ CSRF_TOKEN+"&id="+ id,
        success: function(data) {
        window.location.replace("/admin");
       },
       error:  function(xhr, str){

      }
    });
  }

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>