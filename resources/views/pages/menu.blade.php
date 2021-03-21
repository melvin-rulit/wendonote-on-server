@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ Календарь ♥   @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно@endsection



@section('css_path')/css/kalendar.css @endsection

@section('extra_scripts')
<script src="https://use.fontawesome.com/00df6a5bc5.js"></script>

@endsection

@section('content')

<?php
    if (Auth::user()) {
        $getGuestsNumber = \App\Guest::getGuestsNumber(\Illuminate\Support\Facades\Auth::user()->events()->first()['id']);
    }else{
        $getGuestsNumber = 2;
    }
?>

    <div class="container main">
        @include('layouts.mynote_bl')
        <div class="calendar-section">
            <h2><img src="/img/kalendar_ico.png" alt="image description">Расчёт меню</h2>
            <div class="right_panel">
                <div class="coun_guest">
                    <span>Всего гостей</span>
                        <p class="num">{{$getGuestsNumber}}</p>
                </div>
                    <div class="menu_list"></div>
            </div>

            <meta name="csrf-token" content="{{ csrf_token() }}" />

            <div class="org">
                <div id="menu"></div>
                <div class="org_bottom"></div>
            </div>
        </div>


    <div class="popup" id="delete" style="width: 420px; text-align: center; display: none;">
        <p>Вы увурены что хотите удалить группу меню ?</p>
        <p>Так же удаляться все меню из группы</p>
        <button id="submit_delete_group">Удалить</button>
        <button id="submit_no">Отмена</button>
    </div>

    <div class="popup" id="add" style="width: 420px; text-align: center; display: none;">
        <p>Введите имя группы меню</p><br>
        <input type="text" class="name_group"><br>
        <button id="submit_add_group">Создать</button>
        <button id="submit_no">Отмена</button>
    </div>


    <div class="popup" id="register_modal" style="width: 400px; text-align: center; display: none;">
        <h3 style="display: inline;">Для больших возможностей Вам необходимо войти или зарегистрироваться</h3>
        <br>
        <a href="{{route('login')}}">Войти</a>
        <a href="{{route('wedding-create')}}">Зарегестрироваться</a>
    </div>

    </div>

<style type="text/css">
    .total {
    position: absolute;
    top: 0;
    left: 50%;
    width: 140px;
    border: 2px solid #d83e8c;
    margin: 0 0 0 -41px;
    background: #fff;
    text-align: center;
    padding: 16px 4px;
    color:#5aa6c9;
    font-size: 14px;
    text-transform: uppercase;
    -webkit-border-radius: 8px;
    border-radius: 8px;
    -webkit-box-shadow: 0 0 8px 0 rgba(215,39,132,0.44);
    box-shadow: 0 0 8px 0
    rgba(215,39,132,0.44);
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.total .num {
    display: block;
    font-size: 30px;
    line-height: 32px;
    color: 
    #5aa6c9;
}

.org {
    position: relative;
    width: 820px;
    float: left;
    background: #f0f1f1;
    border-top: 20px solid;
    border-top-color: currentcolor;
    border-bottom: 20px solid;
    border-bottom-color: currentcolor;
    border-radius: 5px;
    border-color:#99ccee;
    font-family: "a_FuturicaLt";
    font-weight: bold;
    overflow: auto;
}

.org_bottom {
    position: absolute;
    bottom: 0;
    width: 100%;
}

input[name=name]{
   width:200px;
}input[name=kolvo]{
   width:60px;
}input[name=weight]{
   width:60px;
}input[name=price]{
   width:60px;
}input[name=summ]{
   width:60px;
}

.new_add {
    padding: 20px;
    text-align: center;
    display: block;
}

.add {
    background-color: #529cc1;
    color: #e3edf3;
    padding: 1px 9px;
    border-radius: 5px;
    font-size: 16px;
}

.fa-trash{
    color: red;
}

.group {
    color: #09f;
    padding: 6px 0;  
}

.fa.fa-plus {
    color: #16d216;
    font-size: 16px;
    padding-left: 7px;
}

.right_panel {
    width: 242px;
}

.org{
    width: 800px;
}

.coun_guest {
    border: 2px solid #d83e8c;
    margin: 0 40px 20px;
    padding: 10px 20px;
    color:#5aa6c9;
    font-size: 14px;
    border-radius: 8px;
    text-align: center;
    text-transform: uppercase;
    box-shadow: 0 0 8px 0
        rgba(215,39,132,0.44);
    background-color: white;
}

.num {
    display: block;
    font-size: 30px;
    line-height: 32px;
    color: #5aa6c9;
    text-align: center;
}

.menu_list .link{
    color: #09f;
    padding-right: 7px;
}

</style>

<script type="text/javascript">

$( document ).ready(function() {

    menuList();
});

    if(!isAuth){
            reload(1);
        }

    $(document).on('click', '.link', function() {
            if(!isAuth){
                $("#register_modal").modal();
                return false;
            }
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       var id = $(this).attr('id');
             $.ajax({
                url: '{{route('menu.getmenu')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, id,},
                dataType: 'HTML',
                success: function (data) { 
                    $('#menu').html(data);
                        menuList();
                        getInfo();
                      $("#price").change(function () {
                        updateDif();
                      });

                      $("#price").keyup(function () {
                        updateDif();
                      });
                }
            }); 
    });


    function getInfo() {
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      var msg   = $('#f').serialize();
        $.ajax({
          type: 'POST',
          url: '{{route('menu.totalinfo')}}',
          data: msg +"&_token="+ CSRF_TOKEN,
            success: function(data) {
               $('.org_bottom').html(data);
             },
          error:  function(xhr, str){

          }
        });
    }


    function menuList() {
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      var msg   = $('#fq').serialize();
        $.ajax({
          type: 'POST',
          url: '{{route('menu.menulist')}}',
          data: msg +"&_token="+ CSRF_TOKEN,
            success: function(data) {
               $('.menu_list').html(data);
             },
          error:  function(xhr, str){

          }
        });
    }

    $(document).on('click', '.fa-trash', function send() {
            if(!isAuth){
                $("#register_modal").modal();
                return false;
            }
        var id   = $(this).parent().attr('id');
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
              type: 'POST',
              url: '{{route('menu.delete')}}',
              data: {_token: CSRF_TOKEN, id}, 
                success: function(data) {
                    jQuery('table #'+id).remove();
                        getInfo();
                        menuList();
                    // $('#table1').find('tr#id123').remove();
                 },
              error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
              }
            });
    });

    $(document).on('click', '#submit_no', function() {
        $.modal.close();
    });


    $(document).on('click', '.delete-group', function() {
        $("#delete").modal();
    });

    $(document).on('click', '.add-group', function() {
        $("#add").modal();
    });


    $(document).on('click', '#submit_delete_group', function() {
            if(!isAuth){
                $("#register_modal").modal();
                return false;
            }
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       var id = $('a.delete_group').attr('id');
             $.ajax({
                url: '{{route('menu.deletegroup')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, id,},
                dataType: 'HTML',
                success: function (data) { 
                    menuList();
                    $.modal.close();
                }
            }); 
    });


    $(document).on('click', '#submit_add_group', function() {
            if(!isAuth){
                $("#register_modal").modal();
                return false;
            }
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       var name = $('.name_group').val();
             $.ajax({
                url: '{{route('menu.addgroup')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, name,},
                dataType: 'HTML',
                success: function (data) { 
                    menuList();
                    $.modal.close();
                }
            }); 
    });


    function send() {
            if(!isAuth){
                $("#register_modal").modal();
                return false;
            }
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      var msg   = $('#formsend').serialize();
      var id = $('form.new_add').attr('name');
        $.ajax({
          type: 'POST',
          url: '{{route('menu.store')}}',
          data: msg +"&menu_group_id="+ id +"&_token="+ CSRF_TOKEN,
            success: function(data) {
                getInfo();
                reload(id);
             },
          error:  function(xhr, str){

          }
        });
    }


    function reload(id) {
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
             $.ajax({
                url: '{{route('menu.getmenu')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, id,},
                dataType: 'HTML',
                success: function (data) { 
                    $('#menu').html(data);
                        menuList();
                        getInfo();
                      $("#price").change(function () {
                        updateDif();
                      });

                      $("#price").keyup(function () {
                        updateDif();
                      });
                }
            }); 
    }


    function addGroup() {
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      var msg   = $('#formsend').serialize();
        $.ajax({
          type: 'POST',
          url: '{{route('menu.store')}}',
          data: msg +"&_token="+ CSRF_TOKEN,  
            success: function(data) {
                setTimeout(function() {window.location.reload();}, 1);
             },
          error:  function(xhr, str){

          }
        });
    }


function updateDif() {

    $(".summ-input").val(parseInt($("#kolvo").val()) * parseInt($("#price").val()));
}


  $("#price").change(function () {
    updateDif();
  });

  $("#price").keyup(function () {
    updateDif();
  });

</script>

@endsection
