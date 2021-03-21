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
    var job_id = 500;
    var job_event = "Удалить кредит";
    var job_place = "Одесса";
    var job_description = "Избавится от кредита";
    var job_creation = "2020-02-05";
    var job_deadline = "2020-02-05";
            $.ajax({
                url: '{{route('kalendar.store')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, job_id, job_event, job_place, job_description, job_creation, job_deadline,},
                dataType: 'HTML',
                success: function (data) { 
                    $('.writeinfo').html(data);
                }
            }); 
            $.modal.close();
            location.reload();
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
                    $('.writeinfo').html(data);
                }
            }); 
            $.modal.close();
            location.reload();

  });


</script>