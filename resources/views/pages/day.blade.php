@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ Календарь ♥   @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно@endsection



@section('css_path')/css/kalendar.css @endsection

@section('extra_scripts')
<script src="https://use.fontawesome.com/00df6a5bc5.js"></script>

@endsection

@section('content')

    <div class="container main">
        @include('layouts.mynote_bl')
        <div class="calendar-section">
        <div class="">
            <h2 class="h_spd">Расписания дня события Свадьба</h2>
        </div>
            <div class="right_panel">
                    <div class="menu_list"></div>
            </div>

            <meta name="csrf-token" content="{{ csrf_token() }}" />

            <div class="org">
                <div id="menu"></div>
                <div class="org_bottom"></div>
            </div>
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

  .h_spd {
    text-transform: uppercase;
    height: 45px;
    margin: auto;
    padding-left: 40px;
    line-height: 45px;
}

</style>

<script type="text/javascript">

$( document ).ready(function() {        // Это все условие не работает, нужно выводить событие при условии залогиненого юзера
  var Aut = '<?php echo Auth::id();?>';
    if(Aut != null){
    reload('<?php echo Auth::user()->events()->first()->id;?>');
  }else{
    reload(1);
  }

});

    if(!isAuth){
            reload('<?php echo Auth::user()->events()->first()->id;?>');
        }

    $(document).on('click', '.link', function() {
            if(!isAuth){
                $("#register_modal").modal();
                return false;
            }
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       var id = $(this).attr('id');
             $.ajax({
                url: '{{route('day.getmenu')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, id,},
                dataType: 'HTML',
                success: function (data) { 
                    $('#menu').html(data);
                }
            }); 
    });


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
              url: '{{route('day.delete')}}',
              data: {_token: CSRF_TOKEN, id}, 
                success: function(data) {
                    jQuery('table #'+id).remove();
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
          url: '{{route('day.store')}}',
          data: msg +"&menu_group_id="+ id +"&_token="+ CSRF_TOKEN,
            success: function(data) {
                reload('<?php echo Auth::user()->events()->first()->id;?>');
             },
          error:  function(xhr, str){

          }
        });
    }


    function reload(id) {
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
             $.ajax({
                url: '{{route('day.getmenu')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, id,},
                dataType: 'HTML',
                success: function (data) { 
                    $('#menu').html(data);
                }
            }); 
    }

</script>

@endsection
