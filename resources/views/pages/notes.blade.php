
@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ Список дел ♥   @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно@endsection

@section('css_path')/css/dela.css @endsection

@section('extra_scripts')
    <script src="/js/pages/notes.js"></script>
@endsection

@section('content')

<div class="main">

    @include('layouts.mynote_bl')

    <div class="mn_cont">

        <div class="shrt_descr">

            <p>
            <h2 class="h_spd">Заметки</h2>
            </p>
            <br>
        </div>

        <div class="tabset">
            <ul class="tab-controls">
					<?php $i = 0; ?>

					@foreach($job_categories as $job_category)
						<li data-color="{{ $job_category->color }}" job_category_id="{{$job_category->id}}" @if( ($new_job_category == null && $i == 0) || ($new_job_category != null && $job_category->id == $new_job_category->id))class="active"@endif><a href="#">{{ $job_category->name }}</a></li>
						<?php $i++; ?>
					@endforeach
              <li data-color="fuchsia"><a href="#" class="btn-add">добавить группу заметок +</a></li>
            </ul>
          <div class="tab-body">

			  @foreach($job_categories as $job_category)
				  <div class="tab" job_category_id="{{$job_category->id}}">

                      @include('dynamic.note_card', ['job_category' => $job_category])

						  <span class="b_spsdl">
							<a class="sps_txt add_job_button" href="#">добавить заметку ✚</a>
						  </span>
				  </div>

			  @endforeach

          <div class="tab">
            <form action="{{route('notes')}}" method="post" class="default-form">
              <fieldset>
                <div class="form-row">
                  <input type="text" class="text" name="name" required placeholder="название группы:">
                </div>
                <div class="form-row">
                  <div class="color-picker">
                    <span class="active-color" style="background-color:blue;">&nbsp;</span>
                    <input type="text" class="text" value="выбрать цвет:" readonly="true">
                    <div class="radio-popup-holder">
                      <ul class="radio-list">
                        <li>
                          <label>
                            <input name="color" type="radio" checked value="blue">
                            <span style="background-color:blue;">&nbsp;</span>
                          </label>
                        </li>
                        <li>
                          <label>
                            <input name="color" type="radio" value="cora    l">
                            <span style="background-color:coral;">&nbsp;</span>
                          </label>
                        </li>
                        <li>
                          <label>
                            <input name="color" type="radio" value="purple">
                            <span style="background-color:purple">&nbsp;</span>
                          </label>
                        </li>
                        <li>
                          <label>
                            <input name="color" type="radio" value="violet">
                            <span style="background-color:violet;">&nbsp;</span>
                          </label>
                        </li>
                        <li>
                          <label>
                            <input name="color" type="radio" value="pink">
                            <span style="background-color:pink;">&nbsp;</span>
                          </label>
                        </li>
                        <li>
                          <label>
                            <input name="color" type="radio" value="#ba88d9">
                            <span style="background-color:#ba88d9;">&nbsp;</span>
                          </label>
                        </li>
                        <li>
                          <label>
                            <input name="color" type="radio" value="#543673">
                            <span style="background-color:#543673;">&nbsp;</span>
                          </label>
                        </li>
                        <li>
                          <label>
                            <input name="color" type="radio" value="#2e5d81">
                            <span style="background-color:#2e5d81;">&nbsp;</span>
                          </label>
                        </li>
                        <li>
                          <label>
                            <input name="color" type="radio" value="#aab2f2">
                            <span style="background-color:#aab2f2;">&nbsp;</span>
                          </label>
                        </li>
                        <li>
                          <label>
                            <input name="color" type="radio" value="#5f7baa">
                            <span style="background-color:#5f7baa;">&nbsp;</span>
                          </label>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="submit-row">
                  <input type="submit" value="создать" class="btn-new">
                </div>
              </fieldset>

                {{csrf_field()}}

            </form>
          </div>
        </div>
       </div>
        <script>

            $('.default-form .active-color').on('click', function () {
                $(this).closest('.color-picker').addClass('open');
            });

            $(document).on('click', function (e) {
                if ($(e.target).closest('.color-picker').length) return
                $('.default-form .color-picker').removeClass('open');
            });

            $('.default-form .radio-list input[type="radio"]').on('change', function () {
                var newColor = $(this).val();
                $(this).closest('.color-picker').find('.active-color').css('background-color', newColor);
                $('.default-form .color-picker').removeClass('open');
            });
        </script>

    </div>
</div>

{{-- Модальное окно Добовление заметки --}}
         <div class="popup" style="display: none" id="modal_window_1">
             <a href="#close" rel="modal:close" class="close-popup">x</a>
             <a class="cal-ico tooltip-holder">X
             </a>
                        <div class="input-group">
                            <div class="col-row">
                                <div class="col l-12">
                                    <div class="row">
                                          <input class="text" type="text" placeholder="Название заметки" id="job_name">
                                          <span class="tooltip-msg">изменить</span>
                                    </div>
                                 </div>
                                <div class="col l-12">
                                    <div class="row">
                                        <input class="text" type="date" placeholder="дата создания" id="job_date" maxlength="10">
                                        <span class="tooltip-msg">дата создания. изменить</span>
                                    </div>
                                </div>
                         </div>
                     </div>
                        <textarea placeholder="Примечания..." id="job_note"></textarea>
                            <button class="cancel_modal">Закрыть</button>
                  </div>

        <div class="popup" id="modal_window_delete" style="width: 400px; text-align: center; display: none;">
            <h3 style="display: inline;">Подтвердите удаление</h3>
            <br>
            <button id="submit_delete_job">Удалить заметку</button>
            <button class="cancel_modal">Отмена</button>
        </div>

        <div class="popup" id="modal_window_submit" style="width: 400px; text-align: center; display: none;">
            <h3 style="display: inline;">Подтвердите то, что заметка была выполнена</h3>
            <br>
            <button id="submit_done">Подтвердить </button>
            <button class="cancel_modal">Отмена</button>
        </div>

</body>
</html>

@endsection
