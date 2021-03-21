@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ Календарь ♥   @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно@endsection



@section('css_path')/css/kalendar.css @endsection
<!-- <script src="https://itchief.ru/examples/vendors/jquery/jquery-3.3.1.min.js"></script>
<script src="https://itchief.ru/examples/vendors/bootstrap-3.3.7/js/bootstrap.min.js"></script> -->
@section('content')


<link rel="stylesheet" href="https://snipp.ru/cdn/jqueryui/1.12.1/jquery-ui.min.css">
<script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>
<script src="https://snipp.ru/cdn/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="/js/libs/jquery.modal.js"></script>


    <div class="container main">
        @include('layouts.mynote_bl')
        <div class="calendar-section">
            <h2><img src="/img/kalendar_ico.png" alt="image description">Календарь</h2>
            <div class="table-holder"></div>
            <div class="right_panel">
                <div class="calendar">
                    <div class="top-calendar"><?php $ldate = date('d'); echo $ldate;?></div>
                    <div id="datepicker"></div>
                </div>

                <a class="bt_sob" href="javascript:void(0);" data-toggle="modal">ДОБАВИТЬ СОБЫТИЕ?</a>

                <div class="kalendar2">
                    <div class="kl2_data">24.07.2016</div>
                    <div class="kl2_data2">осталось <br>159 <br>дней</div>
                    <div class="kl2_data3">20.02.2017</div>
                </div>

                <a class="kons" href="+">Консультант</a>
                <a class="kons2" href="+"></a>
            </div>

            <div class="org">
                <div class="writeinfo"></div>
                <input type="hidden" id="datepicker_value" value="01.08.2019">
            </div>

                <meta name="csrf-token" content="{{ csrf_token() }}" />

        </div>
    </div>


    <div class="popup" style="display: none" id="modal_window_1">
<!--       <div class="kalendar3">
        <div class="kl2_data" id="current_date">
          24.07.2016
        </div>
        <div class="kl2_data2">
         осталось <br><span id="job_diff"></span> <br>дней
       </div>
       <div class="kl2_data3" id="job_event_deadline">
         20.02.2017
       </div>
     </div> -->
     <div class="input-group">
      <div class="col-row">
        <div class="col l-12">
          <div class="row">
            <input class="text" type="text" placeholder="Название события" id="job_name">
          </div>
        </div>
        <div class="col l-6">
          <div class="row">
            <input class="text" type="date" placeholder="Дата" id="job_deadline" maxlength="10">
          </div>
        </div>
        <div class="col l-6">
          <div class="row">
            <input class="text" type="text" placeholder="Место" id="job_place" maxlength="10">
          </div>
        </div>
        <div class="col l-12">
          <div class="row">
            <input class="text" type="text" placeholder="Комментарий" id="job_description">
          </div>
        </div>
        <div class="center_button">
          <button id="submit_send">Добавить в календарь</button>
          <button id="submit_cancel">Закрыть</button>
        </div>
      </div>
    </div>
  </div>

        <div class="popup" id="modal_window_delete" style="width: 400px; text-align: center; display: none;">
            <h3 style="display: inline;">Подтвердите удаление</h3>
            <br>
            <button id="submit_delete">Удалить</button>
            <button id="submit_cancel">Отмена</button>
        </div>


</body>

<script type="text/javascript">
$.datepicker.regional['ru'] = {
    closeText: 'Закрыть',
    prevText: 'Предыдущий',
    nextText: 'Следующий',
    currentText: 'Сегодня',
    monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
    monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
    dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
    dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
    dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
    weekHeader: 'Не',
    dateFormat: 'yy-mm-dd',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['ru']);


$(document).ready(function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var d = new Date();


                $.ajax({
                url: '{{route('kalendar.send')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN},
                dataType: 'HTML',
                success: function (data) {
                    $('.writeinfo').html(data);
                }
            });

    //            Выбираем дату из календаря
    $( "#datepicker" ).datepicker({
        onSelect: function(d, i){
            $.ajax({
                url: '{{route('kalendar.send')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, message: d},
                dataType: 'HTML',
                success: function (data) {
                    $('.writeinfo').html(data);
                }
            });
        }
    });
});  


  $(document).on('click', ".bt_sob", function () {
    $("#modal_window_1").modal({
      'showClose': false
    }).attr('jobid', $(this).parent().find('.sps_txt').attr('jobid'));
  });

  $(document).on('click', "#submit_cancel", function () {
    $.modal.close();
  });

$(document).on('click', "#submit_send", function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var job_id = 0;
    var job_event = $('#job_name').val();
    var job_place = $('#job_place').val();
    var job_description = $('#job_description').val();
    var job_deadline = $('#job_deadline').val();
            $.ajax({
                url: '{{route('kalendar.store')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, job_id, job_event, job_place, job_description, job_deadline,},
                dataType: 'HTML',
                success: function (data) { 
                        var d = new Date();
    var strDate = d.getFullYear() + "-0" + (d.getMonth()+1) + "-" + d.getDate();

                $.ajax({
                url: '{{route('kalendar.send')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN},
                dataType: 'HTML',
                success: function (data) { 
                    $('.writeinfo').html(data);
                }
            });
                }
            }); 
            $.modal.close();
            // location.reload();
      });



  $(document).on('click', ".delete", function () {
    $("#modal_window_delete").modal({
      'showClose': false
    }).attr('jobid', $(this).parent().attr('jobid'));
  });


$(document).on('click', "#submit_delete", function (){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var jobid = $(this).parent().attr('jobid');
            $.ajax({
                url: '{{route('kalendar.delete')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, jobid,},
                dataType: 'HTML',
                success: function (data) { 
                    var d = new Date();
    var strDate = d.getFullYear() + "-0" + (d.getMonth()+1) + "-" + d.getDate();

                $.ajax({
                url: '{{route('kalendar.send')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, message: strDate},
                dataType: 'HTML',
                success: function (data) { 
                    $('.writeinfo').html(data);
                }
            }); 
                }
            }); 
            $.modal.close();
            // location.reload();

  });


</script>
@endsection
