@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ Календарь ♥   @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно@endsection



@section('css_path')/css/kalendar.css @endsection

@section('extra_scripts')
    <script src="/js/pages/inivation.js"></script>
    <script src="/js/spl2.js"></script>

<script src="https://use.fontawesome.com/00df6a5bc5.js"></script>

@endsection

@section('content')

    <div class="container main">
        @include('layouts.mynote_bl')
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

	<div class="popup" id="view_inivation" style="width: 400px; text-align: center; display: none;">
		<?php foreach ($view_inivation as $key => $value) {
			echo '<p class="hidden" id="'.$value->id.'"></p>';
			echo $value->name.'<br>';
			echo $value->text.'<br>';
		}?>
		<button id="submit_yes">Пойду</button>
		<button id="submit_no">Не смогу пойти</button>
	</div>


    <div class="popup" id="register_modal" style="width: 400px; text-align: center; display: none;">
        <h3 style="display: inline;">Для просмотра приглашения Вам необходимо войти или зарегистрироваться</h3>
        <br>
        <a href="{{route('login')}}">Войти</a>
        <a href="{{route('wedding-create')}}">Зарегестрироваться</a>
    </div>


	<script type="text/javascript">

		$( document ).ready(function() {
			if(!isAuth){
	            $("#register_modal").modal();
	            return false;
	        }
	            $("#view_inivation").modal();
	    });

		$(document).on('click', '#submit_yes', function(){
			  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	          var status   = 1;
	          var id   = $(this).parent().find('.hidden').attr('id');
	            $.ajax({
	              type: 'POST',
	              url: '{{route('inivation.yes')}}',
	              data: {_token: CSRF_TOKEN, status, id }, 
	                success: function(data) {
			            $("#view_inivation").modal();
		                $('#view_inivation').html(data);
		                setTimeout(function() {window.location.replace("/");}, 1000);
	                 },
	              error:  function(xhr, str){
	            alert('Возникла ошибка: ' + xhr.responseCode);
	              }
	            });
	            $.modal.close();
    	});

		$(document).on('click', '#submit_no', function(){
			  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	          var status   = 2;
	          var id   = $(this).parent().find('.hidden').attr('id');
	            $.ajax({
	              type: 'POST',
	              url: '{{route('inivation.yes')}}',
	              data: {_token: CSRF_TOKEN, status, id }, 
	                success: function(data) {
			            $("#view_inivation").modal();
		                $('#view_inivation').html(data);
		                setTimeout(function() {window.location.replace("/");}, 1000);
	                 },
	              error:  function(xhr, str){
	            alert('Возникла ошибка: ' + xhr.responseCode);
	              }
	            });
	            $.modal.close();
   		 });

	</script>

@endsection