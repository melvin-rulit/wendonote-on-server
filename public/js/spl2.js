$(document).ready(function(){
$(".spldv2 p").hide();
    $('.spldv2 h3 a[href="' + window.location.href + '"]').parent().next("p").show();
 
    $(".spldv2 h3").on('click', function(e){
 		if(e.target.tagName != 'A'){
	        $(this).next("p").slideToggle("slow")
	        .siblings("p:visible").slideUp("slow");
	        $(this).toggleClass("spl2btact");
	        $(this).siblings("h3").removeClass("spl2btact");
        };
     });
  
 });