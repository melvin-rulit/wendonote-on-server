// JavaScript Document
$(document).ready(function(){
 $('.spl_bt1').click(function(){
  $(this).closest('.note').toggleClass('open');
  $(this).closest('.note').find('.spldv1').slideToggle('normal');
  return false;
 });
});
