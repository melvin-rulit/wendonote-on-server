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

          <meta name="csrf-token" content="{{ csrf_token() }}" />

          <div class="card-deck"></div>


<ul class="products clearfix">


</ul>
<div class="right_panel">
  <ul class="catalog">
  @foreach($catalog_groups as $catalog_group)
    <h3><a class="catalog_item" id="{{ $catalog_group->id }}" href="javascript:void(0);">{{ $catalog_group->name }}</a></h3>
  @endforeach
</ul>
</div>


<script type="text/javascript">
  
  $(document).on('click', '.catalog_item', function() {
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       var id = $(this).attr('id');
       var type = "prodaction";
       // alert(id);
        $(this).addClass('active').siblings().removeClass('active');
             $.ajax({
                url: '{{route('admin.store')}}',
                type: 'POST',
                data: {_token: CSRF_TOKEN, id, type},
                dataType: 'HTML',
                success: function (data) { 
                    $('.products').html(data);
                }
            }); 
    });
</script>


<style type="text/css">
  .product-wrapper {
  display: block;
  width: 100%;
  float: left;
  transition: width .2s;
}

@media only screen and (min-width: 450px) {
  .product-wrapper {
    width: 50%;
  }
}

@media only screen and (min-width: 768px) {
  .product-wrapper {
    width: 33.333%;
  }
}

@media only screen and (min-width: 1000px) {
  .product-wrapper {
    width: 25%;
  }
}

.product {
  display: block;
  border: 1px solid #b5e9a7;
  border-radius: 3px;
  position: relative;
  background: #fff;
  margin: 0 20px 20px 0;
  text-decoration: none;
  color: #474747;
  z-index: 0;
  /*height: 300px;*/
}

.products {
  list-style: none;
  margin: 0 -20px 0 0;
  padding: 0;
}

.product-photo {
  position: relative;
  padding-bottom: 70%;
  overflow: hidden;
}

.product-photo img {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  max-width: 100%;
  max-height: 100%;
  margin: auto;
  transition: transform .4s ease-out;
}


.product:hover .product-photo img {
  transform: scale(1.05);
}

.product p {
  position: relative;
  margin: 0;
  font-size: 1em;
  line-height: 1.4em;
  height: 5.6em;
  overflow: hidden;
  padding: 10px;
}

.product h4 {
  color: #37bfbf;
  padding: 10px;
}

.catalog {
    font-family: 'a_FuturicaLt';
    font-weight: 600;
    color: #807970;
}

.catalog a{
    color: #807970;
}

.main {
    max-width: 1600px;
  }


</style>

        </div>
    </div>


@endsection
