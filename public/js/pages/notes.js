//Joblsit main functionality

/* Misc functions */
function pad(str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}
function formatDate(date) {
  return pad(date.getDate(), 2) + "." + pad(date.getMonth() + 1, 2) + "." + date.getFullYear();
}
function diffInDays(date1, date2) {
  return Math.ceil(Math.abs(date2.getTime() - date1.getTime()) / (1000 * 24 * 3600));
}

//Да что вы знаете о магии, черт ее дери?!
function updateCards(job_id, cat_id) {
  if (cat_id === undefined) {
    var parent = $(".b_spsdl[jobid='" + job_id + "']").parent();
    var job_category_id = parent.attr('job_category_id');
    var category_id = parseInt(job_category_id);
  } else {

    var category_id = parseInt(cat_id);
    var parent = $(".tab[job_category_id='" + category_id + "']");

  }

  $.post('/ajax/getNoteCards', {
    '_token': window.laravel.csrfToken,
    'job_category_id': category_id
  }, function (data) {
    parent.find('.b_spsdl:not(:last-child)').remove();
    parent.prepend(data);
  });
}

function updateDif() {
  if (parseInt($("#job_qnt").val()) >= parseInt($("#job_price").val()))
    $("#job_dif").val(parseInt($("#job_qnt").val()) - parseInt($("#job_price").val()));
}

$(document).ready(function () {
  /* Init stuff */
  $('#job_deadline').mask('00.00.0000');
  $('#job_date').mask('00.00.0000');
  $(".numeric").numeric();


  $(document).on('click', ".sps_txt:not(:last-child)", function () {

    if (isAuth)
      $("#modal_window_1").modal({
        'showClose': false,
        'sender': $(this).attr('jobid'),
        'sender_element': $(this)
      });


    return false;
  });

  $(".add_job_button").click(function (e) {
    e.preventDefault();

    var job_category_id = $(this).parent().parent().attr('job_category_id');

    $("#modal_window_1").modal({
      'showClose': false,
      'new_job': true,
      'job_category_id': job_category_id
    });

  });

  /* Dump job data from the server */
  $("#modal_window_1").on($.modal.BEFORE_OPEN, function (event, modal) {


    if (modal.options.new_job != true) {
      $.post('/ajax/getNoteData',
        {
          '_token': window.laravel.csrfToken,
          'job_id': parseInt(modal.options.sender)
        },
        function (data) {

          if (typeof data['error'] !== 'undefined') {
            alert('Что-то пошло не так!');
            return false;
          }

          $("#job_name").val(data.job.name);
          $("#job_note").val(data.job.note);

          $("#job_date").val(data.job.seqid);
          $("#job_deadline").val(formatDate(new Date(data.job.calendar__event.deadline)));


          $("#current_date").html(formatDate(new Date(data.job.currentDate.date)));


          $("#job_diff").html(
            diffInDays(new Date(data.job.currentDate.date), new Date(data.job.calendar__event.deadline))
          );

          $("#job_event_deadline").html(formatDate(new Date(data.job.calendar__event.deadline)));

          if (data.job.budget != null) {
            if (data.job.budget.qty == 0 && data.job.budget.price == 0 && data.job.budget.difference == 0) {
              $("#job_qnt").val('');
              $("#job_price").val('');
              $("#job_dif").val('');
            } else {
              $("#job_qnt").val(data.job.budget.qty != null ? data.job.budget.qty : '');
              $("#job_price").val(data.job.budget.price != null ? data.job.budget.price : '');
              $("#job_dif").val(data.job.budget.difference != null ? data.job.budget.difference : '');
            }
          } else {
            $("#job_qnt").val('');
            $("#job_price").val('');
            $("#job_dif").val('');
          }

          window.job_data = data;
          window.job_mode = 'create';

          /* Events */

        });
    } else {
      $.post('/ajax/getNewJobData',
        {
          '_token': window.laravel.csrfToken,
          'job_category_id': modal.options.job_category_id
        }, function (data) {

          $("#job_name").val('');
          $("#job_note").val('');

          $("#job_price").val('');
          $("#job_qnt").val('');
          $("#job_dif").val('0');

          $("#current_date").html(formatDate(new Date(data.time.current.date)));

          $("#job_date").val(formatDate(new Date(data.time.current.date)));

          $("#job_diff").html('');

          $("#job_event_deadline").html('');

          window.job_data = data;
          window.job_mode = 'updation';

          /* Deadline */

          $("#job_deadline").val('');
        });
    }
  });


  $('#job_deadline').focusout(function () {

    if (window.job_mode == 'create') {
      function reset() {
        $("#job_deadline").val(formatDate(new Date(window.job_data.job.calendar__event.deadline)));
        return false;
      }


      var current = $(this).val().split('.');


      if (current.length != 3) return reset();

      var date = new Date(current[2] + "-" + current[1] + "-" + current[0]);


      if (!(new Date(window.job_data.job.currentDate.date).getTime() < date.getTime() &&
        date.getTime() < new Date(window.job_data.job.job_category.event.date).getTime()))
        {
          alert('Дата не должна быть позже даты самого события и не раньше сегодняшней даты!');
          return reset();
        }

      $("#job_diff").html(
        diffInDays(new Date(window.job_data.job.currentDate.date), date)
      );

      $("#job_event_deadline").html(formatDate(date));
    } else {

      function reset() {
        $("#job_deadline").val('');
        return false;
      }

      var current = $(this).val().split('.');


      if (current.length != 3) return reset();

      var date = new Date(current[2] + "-" + current[1] + "-" + current[0]);


      if (!(new Date(window.job_data.time.current.date).getTime() < date.getTime() &&
        date.getTime() < new Date(window.job_data.event.date).getTime())){
        alert('Дата не должна быть позже даты самого события и не раньше сегодняшней даты!');
        return reset();
      }

      $("#job_diff").html(
        diffInDays(new Date(window.job_data.time.current.date), date)
      );

      $("#job_event_deadline").html(formatDate(date));
    }

  });

  $('#job_date').focusout(function () {

    if (window.job_mode == 'create') {
      function reset() {
        $("#job_date").val(formatDate(new Date(window.job_data.job.calendar__event.creation)));
        return false;
      }


      var current = $(this).val().split('.');


      if (current.length != 3) return reset();

      var date = new Date(current[2] + "-" + current[1] + "-" + current[0]);


      if (!(date.getTime() < new Date(window.job_data.job.job_category.event.date).getTime()))
        return reset();
    } else {
      function reset() {
        $("#job_date").val(formatDate(new Date(window.job_data.time.current.date)));
        return false;
      }


      var current = $(this).val().split('.');

      if (current.length != 3) return reset();

      var date = new Date(current[2] + "-" + current[1] + "-" + current[0]);


      if (!(date.getTime() < new Date(window.job_data.event.date).getTime()))
        return reset();
    }

  });

  $("#job_qnt").focusout(function () {
    if ($("#job_price").val() == "") {
      $("#job_price").val('0');
    } else if (parseInt($("#job_qnt").val()) < parseInt($("#job_price").val()))
      $("#job_qnt").val($("#job_price").val());
  });

  $("#job_price").focusout(function () {
    if ($("#job_qnt").val() == "") {
      $("#job_qnt").val($(this).val());
    } else if (parseInt($("#job_qnt").val()) < parseInt($("#job_price").val())) $("#job_price").val($("#job_qnt").val());
  });

  $("#job_qnt").change(function () {
    updateDif();
  });

  $("#job_qnt").keyup(function () {
    updateDif();
  });

  $("#job_price").change(function () {
    updateDif();
  });

  $("#job_price").keyup(function () {
    updateDif();
  });


  $('#modal_window_1').on($.modal.BEFORE_CLOSE, function (event, modal) {

    var job_name = $("#job_name").val(),
      job_note = $("#job_note").val(),
      job_date = $("#job_date").val(),
      job_deadline = $("#job_deadline").val(),
      job_qnt = parseInt($("#job_qnt").val()),
      job_price = parseInt($("#job_price").val()),
      job_dif = parseInt($("#job_dif").val());


    if (modal.options.new_job != true) {
      $.post('/ajax/saveNoteData',
        {
          '_token': window.laravel.csrfToken,
          'job_id': parseInt(modal.options.sender),
          'job_name': job_name,
          'job_note': job_note,
          'job_date': job_date,
          'job_deadline': job_deadline,
          'job_qty': job_qnt,
          'job_price': job_price,
          'job_dif': job_dif
        }, function (data) {
          console.log(data);
          updateCards(parseInt(modal.options.sender));
        });


      modal.options.sender_element.html(job_name);
    } else {
      $.post('/ajax/createNewNote',
        {
          '_token': window.laravel.csrfToken,
          'job_category_id': modal.options.job_category_id,
          'job_name': job_name,
          'job_note': job_note,
          'job_date': job_date,
          'job_deadline': job_deadline,
          'job_qty': job_qnt,
          'job_price': job_price,
          'job_dif': job_dif
        }, function (data) {
          console.log(data);
          updateCards(0, modal.options.job_category_id);
        });
    }

  });

  $(".cancel_modal").click(function () {
    $.modal.close();
  });


  $(document).on('click', ".btn-done", function () {
    if (!isAuth) return false;

    if ($(this).hasClass('green')) {

      var jobid = $(this).parent().attr('jobid');

      $.post('/ajax/setNoteNotDone',
        {
          '_token': window.laravel.csrfToken,
          'job_id': jobid
        }, function (data) {

          if (typeof data['error'] !== 'undefined') {
            alert('Что-то пошло не так!');
            return false;
          }

          $.modal.close();
          $(".sps_txt[jobid='" + jobid + "']").parent().find('.btn-done').removeClass('green');
          updateCards(jobid);
        });

      return false;
    }

    $("#modal_window_submit").modal({
      'showClose': false
    }).attr('jobid', $(this).parent().find('.sps_txt').attr('jobid'));
  });
  $("#submit_done").click(function () {
    var jobid = $(this).parent().attr('jobid');

    $.post('/ajax/setNoteDone',
      {
        '_token': window.laravel.csrfToken,
        'job_id': jobid
      }, function (data) {

        if (typeof data['error'] !== 'undefined') {
          alert('Что-то пошло не так!');
          return false;
        }

        $.modal.close();
        $(".sps_txt[jobid='" + jobid + "']").parent().find('.btn-done').addClass('green');
        updateCards(jobid);
      });
  });

  $(document).on('click', ".btn-delete", function () {
    if (!isAuth) return false;
    $("#modal_window_delete").modal({
      'showClose': false
    }).attr('jobid', $(this).parent().find('.sps_txt').attr('jobid'));
  });

  $("#submit_delete").click(function () {
    var jobid = $(this).parent().attr('jobid');
    $.post('/ajax/deleteJob',
      {
        '_token': window.laravel.csrfToken,
        'job_id': jobid
      }, function (data) {

        if (typeof data['error'] !== 'undefined') {
          alert('Что-то пошло не так!');
          return false;
        }

        $.modal.close();
        $(".sps_txt[jobid='" + jobid + "']").parent().fadeOut(500, function () {
          $(this).remove();
          deleteGroup();
        });
        //delete group if not exist

      });

  });

    $("#submit_delete_job").click(function () {
    var jobid = $(this).parent().attr('jobid');

    $.post('/ajax/deleteNoteOnly',
      {
        '_token': window.laravel.csrfToken,
        'job_id': jobid
      }, function (data) {

        if (typeof data['error'] !== 'undefined') {
          alert('Что-то пошло не так!');
          return false;
        }

        $.modal.close();
        $(".sps_txt[jobid='" + jobid + "']").parent().fadeOut(500, function () {
          $(this).remove();
          deleteGroup();
        });
        //delete group if not exist

      });

  });

    // Send to calendar

      $(".cal-ico").click(function () {


    $.post('/ajax/sendCalendarOnly',
      {
        '_token': window.laravel.csrfToken,
        'job_name':  $("#job_name").val(),
        'job_note':  $("#job_note").val(),
        'job_date':  $("#job_date").val(),
      }, function (data) {

        $.modal.close();
            $("#modal_window_sendcalendar").modal({
      'showClose': false
    })

      });

  });


});


