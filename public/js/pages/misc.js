$(document).ready(function(){
 	initDatePicker();
	initTabs();
	initProductSlider();
    initSelect();

	if(isAuth){
        initSortable();
    }
});



function initSelect() {
    $("select").each(function() {
        var self = this;
        var plh = $(this).data('placeholder') || '';
    $(self).select2({
      placeholder: plh,
      language: "ru"
    });
        if(plh && plh.length > 0){
            $(this).val('').change();
        }
        $(window).on('resize', function() {
      $(self).select2({
        placeholder: plh,
        language: "ru"
      });
        });
    });
};


function initProductSlider() {
	var sliderLoad = false;
  $('.open-add-popup, .sps_txt').on('click', function(){
    if(!sliderLoad){
      $('.product-item .slide-list').each(function(){
        $(this).slick({
          slidesToShow:3,
          slidesToScroll:1
        })
      });
      sliderLoad = true;
    } else {
      $(window).trigger('resize')	;
    }
    var color = $(this).closest('.tabset').find('.tab-controls li.active').data('color');
    $('#modal_window_1').attr('data-color', color);
    
    console.log($('#modal_window_1')[0])
  });
  if(!sliderLoad){
    $('.product-item .slide-list').each(function(){
      $(this).slick({
        slidesToShow:3,
        slidesToScroll:1
      })
    });
    sliderLoad = true;
	}
};
function initDatePicker() {
	$( ".datepicker" ).datepicker({
		showOtherMonths:true,
		selectOtherMonths:true,
		prevText: "",
		nextText: ""
	});
    $( ".date" ).datepicker({
        showOtherMonths:true,
        selectOtherMonths:true,
        prevText: "",
        nextText: ""
    });
};
function initTabs() {
	$('.tab-controls li.active').each(function() {
		$(this).closest('.tabset').find('.tab').eq($(this).index()).addClass('active');
	});
	$('.tab-controls li[data-color].active').each(function() {
		$(this).closest('.tabset').find('.tab-body').css('background-color', $(this).find('a').css('background-color'));
		$(this).closest('.tabset').find('.tab-body').css('color', $(this).find('a').css('color'));
	});
	$('.tab-controls li[data-color]').each(function(index) {
		$(this).css('z-index', function() {
			return $(this).closest('ul').find('li').length - index;
		});
	});
	$('.tab-controls a').on('click', function() {
		$(this).closest('li').addClass('active').siblings('li').removeClass('active');
		$(this).closest('.tabset').find('.tab.active').removeClass('active');
		$(this).closest('.tabset').find('.tab').eq($(this).closest('li').index()).addClass('active');
		if($(this).closest('li').data('color').length){
			$(this).closest('.tabset').find('.tab-body').css('background-color', $(this).css('background-color'));
			$(this).closest('.tabset').find('.tab-body').css('color', $(this).css('color'))
		}
		return false;
	});
};

function initSortable()
{
	var prevPagesOrder = [];
    $(".tab").sortable({
        stop: function (event, ui) {
            //console.log(ui.item.data('startindex'));
            //console.log(ui.item.index())

			var category = $(this).attr('job_category_id');

			var sequence = [];

			$(this).find('.b_spsdl').each(function (i, item) {
				sequence[$(item).attr('jobid')] = i;
            });

			//console.log(sequence);

            $.post('/ajax/swapJobs', {
                '_token': window.laravel.csrfToken,
                'category_id': category,
				'sequence': sequence
            }, function(data){
            	//console.log(data)
            });

        }
    });

}

function deleteGroup()
{
    if($('.tab.ui-sortable.active span[jobid]').length === 0)
    {
        var currentGroup = $('.tab.ui-sortable.active'),
            job_category_id = currentGroup.attr('job_category_id');

        var data = {
            '_token': window.laravel.csrfToken,
            'job_category_id': job_category_id
        };

        $.ajax({
            'type': 'POST',
            'url': '/ajax/deleteJobCategory',
            'data': data,
            'success': function(data){
                if(typeof data.success === 'undefined'){
                    alert(data.error);
                    return false;
                }
                currentGroup.fadeOut(500, function(){
                    $(this).remove();
                });

                $('[job_category_id='+job_category_id+']').fadeOut(500, function(){$(this).remove();});
                $('.tab-controls li:first-of-type').addClass('active');
                $('.tab-body .tab:first-of-type').addClass('active');
            }
        });
    }
}