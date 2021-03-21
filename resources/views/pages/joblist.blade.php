
@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ Список дел ♥   @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно@endsection

@section('css_path')/css/dela.css @endsection

@section('extra_scripts')
    <script src="/js/pages/joblist.js"></script>
@endsection

@section('content')

<div class="main">

    @include('layouts.mynote_bl')

    <div class="mn_cont">

        <div class="shrt_descr">

            <p>
            <h2 class="h_spd">список дел</h2>
            Мы подобрали для вас список самых необходимых дел без которых не обойдётся ни одно торжество. Вы можете добавлять и редактировать списки.
            </p>
            <a class="bt_blue" href="manual.php" target="blanc">КАК ЭТО РАБОТАЕТ?</a>
            <br>
        </div>

        <div class="tabset">
            <ul class="tab-controls">
					<?php $i = 0; ?>

					@foreach($job_categories as $job_category)
						<li data-color="{{ $job_category->color }}" job_category_id="{{$job_category->id}}" @if( ($new_job_category == null && $i == 0) || ($new_job_category != null && $job_category->id == $new_job_category->id))class="active"@endif><a href="#">{{ $job_category->name }}</a></li>
						<?php $i++; ?>
					@endforeach
              <li data-color="fuchsia"><a href="#" class="btn-add">добавить группу +</a></li>
            </ul>
          <div class="tab-body">

			  @foreach($job_categories as $job_category)
				  <div class="tab" job_category_id="{{$job_category->id}}">

                      @include('dynamic.job_card', ['job_category' => $job_category])

						  <span class="b_spsdl">
							<a class="sps_txt add_job_button" href="#">добавить дело ✚</a>
						  </span>
				  </div>

			  @endforeach


              {{-- Ну прекрати мне все ломать, а?--}}

          <div class="tab">
            <form action="{{route('joblist')}}" method="post" class="default-form">
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
            <!--/Дополнительно-->
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


         <div class="popup" style="display: none" id="modal_window_1">
             <a href="#close" rel="modal:close" class="close-popup">x</a>
             <a class="cal-ico tooltip-holder">X
             <span class="tooltip">Запланировать в календаре</span>
             </a>
                  <div class="kalendar2">
                      <div class="kl2_data" id="current_date">
                            24.07.2016
                     </div>
                     <div class="kl2_data2">
                           осталось <br><span id="job_diff"></span> <br>дней
                     </div>
                         <div class="kl2_data3" id="job_event_deadline">
                           20.02.2017
                     </div>
                    </div>
                        <div class="input-group">
                            <div class="col-row">
                                <div class="col l-12">
                                    <div class="row">
                                          <input class="text" type="text" placeholder="название дела" id="job_name">
                                          <span class="tooltip-msg">изменить</span>
                                    </div>
                                 </div>
                                <div class="col l-6">
                                    <div class="row">
                                        <input class="text" type="text" placeholder="дата создания" id="job_date" maxlength="10">
                                        <span class="tooltip-msg">дата создания. изменить</span>
                                    </div>
                                </div>
                                <div class="col l-6">
                                    <div class="row">
                                        <input class="text" type="text" placeholder="дедлайн" id="job_deadline" maxlength="10">
                                        <span class="tooltip-msg">рекомендуемая дата. изменить</span>
                                  </div>
                                 </div>
                                <div class="col l-4">
                                    <div class="row">

                                        <input class="text numeric" type="text" placeholder="цена" id="job_qnt">

                                        <span class="tooltip-msg">изменить</span>
                                    </div>
                                </div>
                                <div class="col l-4">
                                    <div class="row">
                                        <input class="text numeric" type="text" placeholder="задаток" id="job_price">
                                        <span class="tooltip-msg">изменить</span>
                                    </div>
                                </div>
                                <div class="col l-4">
                                    <div class="row">
                                        <input class="text numeric" type="text" placeholder="остаток" disabled id="job_dif">
                                    </div>
                              </div>
                         </div>
                     </div>
                        <textarea placeholder="примечания..." id="job_note"></textarea>
                        <div class="product-item">
                            <div class="visual">
                                    <ul class="slide-list">
                                        <li>
                                          <a href="#"><img src="images/img6.jpg" alt="image description"></a>
                                          <a href="#" class="star">&nbsp;</a>
                                          <div class="inner">
                                            <span class="title">Декоратор &laquo;Cкоро Свадьба&raquo;</span>
                                            <span class="price">от 490$</span>
                                          </div>
                                        </li>
                                        <li>
                                          <a href="#"><img src="images/img6.jpg" alt="image description"></a>
                                          <a href="#" class="star">&nbsp;</a>
                                          <div class="inner">
                                            <span class="title">Декоратор &laquo;Cкоро Свадьба&raquo;</span>
                                            <span class="price">от 490$</span>
                                          </div>
                                        </li>
                                        <li>
                                          <a href="#"><img src="images/img6.jpg" alt="image description"></a>
                                          <a href="#" class="star">&nbsp;</a>
                                          <div class="inner">
                                            <span class="title">Декоратор &laquo;Cкоро Свадьба&raquo;</span>
                                            <span class="price">от 490$</span>
                                          </div>
                                        </li>
                                        <li>
                                          <a href="#"><img src="images/img6.jpg" alt="image description"></a>
                                          <a href="#" class="star">&nbsp;</a>
                                          <div class="inner">
                                            <span class="title">Декоратор &laquo;Cкоро Свадьба&raquo;</span>
                                            <span class="price">от 490$</span>
                                          </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <button class="cancel_modal">Закрыть</button>
                            <button id="send">Добавить</button>
                  </div>

        <div class="popup" id="modal_window_delete" style="width: 400px; text-align: center; display: none;">
            <h3 style="display: inline;">Подтвердите удаление</h3>
            <br>
            <button id="submit_delete_job">Удалить только из списка дел</button>
            <button id="submit_delete">Удалить оба</button>
            <button class="cancel_modal">Отмена</button>
        </div>

        <div class="popup" id="modal_window_submit" style="width: 400px; text-align: center; display: none;">
            <h3 style="display: inline;">Подтвердите то, что дело было выполнено</h3>
            <br>
            <button id="submit_done">Подтвердить </button>
            <button class="cancel_modal">Отмена</button>
        </div>

        <div class="popup" id="modal_window_sendcalendar" style="width: 400px; text-align: center; display: none;">
            <h3 style="display: inline;">Дело успешно улетело в календарь</h3>
            <br>
            <button class="cancel_modal">Закрыть</button>
        </div>

</body>
</html>

@endsection
