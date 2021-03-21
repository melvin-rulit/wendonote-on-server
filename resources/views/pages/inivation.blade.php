@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ Календарь ♥   @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно@endsection



@section('css_path')/css/kalendar.css @endsection

@section('extra_scripts')
<script src="/js/pages/inivation.js"></script>
<script src="https://use.fontawesome.com/00df6a5bc5.js"></script>

@endsection

@section('content')

    <div class="container main">
        @include('layouts.mynote_bl')
        <div class="calendar-section">
            <h2><img src="/img/kalendar_ico.png" alt="image description">Пригласительные</h2>
            <div class="table-holder"></div>
            <div class="right_panel">
                <input id="submit_addinivation" value="Создать приглашение" type="submit">
                <div class="note_ini">
                    <a href="/mynote" class="mynote">Список гостей</a>
                        <div class="spldv1">
                            <div class="spldv2">
                                <h3><a href="#">Свидетели</a></h3>
                                @if(!Auth::check())
                                        <?php $id_event = 0 ?>
                                        <?php $guests = \App\Guest::getGuests(1, 'male', 'witness');?>
                                        <?php $witnesses = \App\Guest::getGuests(1, 'female', 'witness');?>
                                    @else
                                        <?php $id_event = \Illuminate\Support\Facades\Auth::user()->events()->first()['id']; ?>
                                        <?php $guests = \App\Guest::getGuests($id_event, 'male', 'witness');?>
                                        <?php $witnesses = \App\Guest::getGuests($id_event, 'female', 'witness');?>
                                    @endif
                                    <p>
                                        @forelse($guests as $guest)
                                            <a href="/">{{$guest->name}}</a><span id="{{$guest->name}}" class="add_guest"><i class="fa fa-plus" aria-hidden="true"></i></span><br>
                                        @empty
                                            <a href="javascript:void(0)">Список пуст</a><br>
                                        @endforelse
                                        @foreach($witnesses as $witness)
                                            <a href="javascript:void(0)">{{$witness->name}}</a><span id="{{$guest->name}}" class="add_guest"><i class="fa fa-plus" aria-hidden="true"></i></span><br>
                                        @endforeach
                                    </p>
                                <h3><a href="#">Родственники жениха</a></h3>
                                    <?php $guests = \App\Guest::getGuests($id_event, 'male', 'relatives');?>
                                    <p>
                                        @forelse($guests as $guest)
                                            <a href="javascript:void(0)">{{$guest->name}}</a><span id="{{$guest->name}}" class="add_guest"><i class="fa fa-plus" aria-hidden="true"></i></span><br>
                                        @empty
                                            <a href="javascript:void(0)">Список пуст</a><br>
                                        @endforelse
                                    </p>

                                <h3><a href="#">Родственники невесты</a></h3>
                                    <?php $guests = \App\Guest::getGuests($id_event, 'female', 'relatives');?>
                                    <p>
                                        @forelse($guests as $guest)
                                            <a href="javascript:void(0)">{{$guest->name}}</a><span id="{{$guest->name}}" class="add_guest"><i class="fa fa-plus" aria-hidden="true"></i></span><br>
                                        @empty
                                            <a href="javascript:void(0)">Список пуст</a><br>
                                        @endforelse
                                    </p>
                                <h3><a href="#">Друзья жениха</a></h3>
                                    <?php $guests = \App\Guest::getGuests($id_event, 'male', 'friends');?>
                                    <p>
                                        @forelse($guests as $guest)
                                            <a href="javascript:void(0)">{{$guest->name}}</a><span id="{{$guest->name}}" class="add_guest"><i class="fa fa-plus" aria-hidden="true"></i></span><br>
                                        @empty
                                            <a href="javascript:void(0)">Список пуст</a><br>
                                        @endforelse
                                    </p>

                                <h3><a href="#">Друзья невесты</a></h3>
                                    <?php $guests = \App\Guest::getGuests($id_event, 'female', 'friends');?>
                                    <p>
                                        @forelse($guests as $guest)
                                            <a href="javascript:void(0)">{{$guest->name}}</a><span id="{{$guest->name}}" class="add_guest"><i class="fa fa-plus" aria-hidden="true"></i></span><br>
                                        @empty
                                            <a href="javascript:void(0)">Список пуст</a><br>
                                        @endforelse
                                    </p>
                            </div>
                        </div>
                </div>

                <meta name="csrf-token" content="{{ csrf_token() }}" />

                <div class="inivation">
                    <a href="/mynote" class="mynote">Список приглашений</a><br>
                        @if(!Auth::check())
                            <?php $login_inivation = App\User::find(1)->inviteelist ; ?>
                        @else
                            <?php $login_inivation = App\User::find(auth()->id())->inviteelist;?>
                        @endif
                        @foreach ($login_inivation as $key => $value)
                          <br><a class="view" href="javascript:void(0)" id="{{$value->id}}">{{$value->name}}</a>
                          <span id="{{$value->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
                          @if ($value->status == 1)
                          <span><i class="fa fa-check" aria-hidden="true"></i></span>
                          @elseif ($value->status == 2)
                          <span><i class="fa fa-ban" aria-hidden="true"></i></span>
                          @endif
                        @endforeach
                </div>

            </div>

            <div class="org">
                <div class="input-group">
                    <h3 class="title_ini">@if(Auth::check()) {{$event->name}} @else <?php echo "Свадьба Ивановых"; ?> @endif</h3>
                    <div id="results"></div>
                    <div class="col-row">
                        <form method="POST" id="formx" action="javascript:void(null);" onsubmit="send()">

                            <div class="col l-12">
                              <div class="row">
                                <p>
                                    <p><b>Выберите фон для приглашения</b></p>
                                    <p><input name="background" type="radio" value="1">Цветочки</p>
                                    <p><input name="background" type="radio" value="2">Звездочки</p>
                                    <p><input name="background" type="radio" value="3" checked>Вагинки</p>
                                </p>
                            </div>
                        </div>

                        <div class="col l-12">
                          <div class="row">
                            <input class="text" type="text" placeholder="Название приглашения" id="name" name="name">
                        </div>
                    </div>
                    <div class="col l-12">
                      <div class="row">
                        <textarea class="text" type="text" placeholder="Текс приглашения" id="text" name="text"></textarea>
                    </div>
                </div>
                <div class="col l-12 in">
                  <div class="row">
                   <input class="text pole" id="pole" type="text" name="rol[]" placeholder="Введите имя гостя">
                   <i class="fa fa-trash" aria-hidden="true"></i><i class="add-name fa fa-plus" aria-hidden="true"></i>
               </div>
           </div>
           <input id="submit_send" value="Сохранить" type="submit"> 
       </form>
   </div>
</div>
</div>

            </div>

        </div>
    </div>


    <div class="popup" id="view_inivation" style="width: 800px; text-align: center; display: none;"></div>

    <div class="popup" id="register_modal" style="width: 400px; text-align: center; display: none;">
        <h3 style="display: inline;">Для создания приглашения Вам необходимо войти или зарегистрироваться</h3>
        <br>
        <a href="{{route('login')}}">Войти</a>
        <a href="{{route('wedding-create')}}">Зарегестрироваться</a>
    </div>

</body>



<style type="text/css">

.title_ini {
    text-align: center;
    padding-top: 10px;
}

.bt_sob {
    display: block;
    position: relative;
    width: 200px;
    height: 25px;
    background: #529cc1;
    border-radius: 2px;
    box-shadow: 0px 2px 1px #34667f;
    color: #e3edf3;
    font-family: "a_FuturicaLt";
    font-size: 90%;
    font-weight: bold;
    text-align: center;
    line-height: 25px;
    margin:20px;
    float: left;
}

.add-foto {
    text-align: center;
}

.add{
    color: #d72784;
    font-size: 46px;
}

.add_guest {
    padding-left: 5px;
    color: #2ed72e;
}

.spldv2 p {
    overflow: hidden;
    white-space: nowrap;
    -ms-text-overflow: ellipsis;
    text-overflow: ellipsis;
}

.note_ini {
    margin-bottom: 30px;
    margin-top: 10px;
}

.add-name {
    font-size: 22px;
    text-align: center;
    display: block;
    padding-top: 7px;
}

textarea {
    text-align: left;
    padding: 4px 14px 10px;
    height: 100px;
    resize: none;
    margin: 0 0 15px;
    font-size: 18px;
    line-height: 21px;
}
textarea, .input-group input.text {
    display: block;
    background: 
#fff;
border: 1px solid
#5aa6c9;
color:
#5aa6c9;
width: 100%;
font-size: 23px;
line-height: 26px;
font-weight: bold;
font-family: 'a_FuturicaLt';
text-align: center;
-webkit-border-radius: 8px;
border-radius: 8px;
padding: 0 6px;
webkit-box-shadow: 0 0 10px 0 rgba(90,166,201,0.6);
box-shadow: 0 0 10px 0
    rgba(90,166,201,0.6);
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.fa{
    padding-left: 7px;
}

.fa-ban{
    color: red;
}

#results {
    background-color: #17ea17;
    padding: 13px;
    margin: 13px;
    text-align: center;
    display: none;
}

.response{
    display: block;
}

.hidden{
    display: none;
}

</style>


<script type="text/javascript">


    var deletes = document.getElementsByClassName('pole');
if (deletes.length == 1) {
    $(".fa-trash").addClass("hidden");
}else{
    $(".fa-trash").removeClass("hidden");
}



    $(document).on('click', '.add-name', function(){
        var deletes = document.getElementsByClassName('pole');
            if (deletes.length >= 1) {
                $(".fa-trash").removeClass("hidden");
            }else{
                $(".fa-trash").addClass("hidden");
            }
        var cloned = $(this).parent().clone();
        cloned.find('input').attr('value', '').val('').addClass('new');
        $(this).parent().parent().append(cloned);
        return false;
    });

    $(document).on('click', '.fa-trash', function() {
            $(this).closest('div.row').remove();
            var deletes = document.getElementsByClassName('pole');
            if (deletes.length == 1) {
                $(".fa-trash").addClass("hidden");
            }else{
                $(".fa-trash").removeClass("hidden");
            }
    });



    $('.add_guest').click(function(e) { 
          var value = $(this).closest('.add_guest').attr('id');
          $('.in').append(`<div class="row"><input class="text pole" id="pole" type="text" placeholder="Введите имя гостя" name="rol[]" value="${value}"/><i class="fa fa-trash" aria-hidden="true"></i><i class="add-name fa fa-plus" aria-hidden="true"></i></div>`);
        });


        $(document).on('click', '.view', function(){
            $("#view_inivation").modal();
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          var msg   = $(this).attr('id');
            $.ajax({
              type: 'POST',
              url: '{{route('inivation.view')}}',
              data: {_token: CSRF_TOKEN, msg}, 
                success: function(data) {
                    $('#view_inivation').html(data);
                 },
              error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
              }
            });
    });


    $(document).on('click', '#submit_addinivation', function(){
        setTimeout(function() {window.location.reload();}, 100);
    });

        $(document).on('click', '.fa-pencil-square-o', function(){
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          var msg   = $(this).parent().attr('id');
            $.ajax({
              type: 'POST',
              url: '{{route('inivation.edit')}}',
              data: {_token: CSRF_TOKEN, msg}, 
                success: function(data) {
                    $('.input-group').html(data);
                        var deletes = document.getElementsByClassName('pole');
                        if (deletes.length == 1) {
                            $(".fa-trash").addClass("hidden");
                        }else{
                            $(".fa-trash").removeClass("hidden");
                        }
                 },
              error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
              }
            });

    });


    function send() {
            if(!isAuth){
                $("#register_modal").modal();
                return false;
            }

      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      var msg   = $('#formx').serialize();
        $.ajax({
          type: 'POST',
          url: '{{route('inivation.store')}}',
          data: msg +"&_token="+ CSRF_TOKEN,  
            success: function(data) {
                $('#name').val('');
                $('#text').val('');
                $('#pole').val('');
                $('#formx').remove();
                $("#view_inivation").modal();
                $('#view_inivation').html(data);
                setTimeout(function() {window.location.reload();}, 1000);
             },
          error:  function(xhr, str){
        alert('Заполните все поля для добавления приглашения: ' + xhr.responseCode);
          }
        });
    }

    function edit() {
            if(!isAuth){
                $("#register_modal").modal();
                return false;
            }

      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      var msg   = $('#form_editsave').serialize();
        $.ajax({
          type: 'POST',
          url: '{{route('inivation.editsave')}}',
          data: msg +"&_token="+ CSRF_TOKEN,  
            success: function(data) {
                $('#view_inivation').html(data);
                $('#form_editsave').remove();
                $("#view_inivation").modal();
                $('#view_inivation').html(data);
                setTimeout(function() {window.location.reload();}, 1000);
             },
          error:  function(xhr, str){
        alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });
    }

</script>

@endsection
