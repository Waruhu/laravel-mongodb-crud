<!DOCTYPE html>
<html>
<head>
	<title>Vehicle Search</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="http://demo.expertphp.in/css/jquery.ui.autocomplete.css" rel="stylesheet">
    <script src="http://demo.expertphp.in/js/jquery.js"></script>
    <script src="http://demo.expertphp.in/js/jquery-ui.min.js"></script>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  	<style type="text/css">
  		.ajax-load{
  			background: #e1e1e1;
		    padding: 10px 0px;
		    width: 100%;
  		}
          .itemconfiguration
        {
            height: 150px;
            width: 215px;
            overflow: auto;
            float: left;
            position: relative;
            margin-left: -5px;
        }
        .left_contentlist{
        width:215px;
        float:left;
        padding:0 0 0 5px;
        position:relative;
        float:left;
        border-right: 1px #f8f7f3 solid;
        /* background-image:url(images/bubble.png); */
        /* background-color: black; */
        }
        .txtbox{
            display: block;
            float: left;
            height:35px;
            width: 1000px;
        }

        .btncls{
            display: block;
            float: left;
            height: 40px;
            margin: -1px -2px -2px;
            width: 80px;
        }
  	</style>
</head>
<body>
    <section id="advertisement">
        <div class="container">
        <h1 align="center">Products Vehicles</h1>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <br>
                    {{ csrf_field() }}
                    {!! Form::open(['method' => 'get', 'url' =>  route('api.searchVehicle')]) !!}
                    {!! Form::text('q', "", array('placeholder' => 'Cari mobil idamanmu disini','class' => 'form-control','id'=>'q')) !!}
                    <!-- <input type="text" name="q" id='q' value="{{ Input::old('q')}}" placeholder="search text here" class="txtbox" />
                    <input type="submit" value=" Search "  class="btncls" /> -->
                    {{ Form:: close() }}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="left_contentlist">
                    <div class="brands-name">
                        <h3>Brands</h3>
                        <div class="itemconfiguration" style="padding-left: 30px;">
                                <ul class="nav nav-pills nav-stacked">
                                    @if(!empty($vehiclesAggreagationBrand))
                                        @foreach($vehiclesAggreagationBrand as $key => $value)
                                            <li class="brandLi"><input type="checkbox" id="brandId" value="{{$value['key']}}" class="brands" name="brand[]"/>
                                            <span>{{$value['key']}}{{' ('}}{{$value['doc_count']}}{{')'}}</span>
                                        @endforeach
                                    @endif
                               </ul>
                        </div>
                    </div>
                    
                    <div class="colors-name">
                        <h3>Colors</h3>
                        <div class="itemconfiguration" style="padding-left: 30px;">
                                <ul class="nav nav-pills nav-stacked">
                                    @if(!empty($vehiclesAggreagationColor))
                                        @foreach($vehiclesAggreagationColor as $key => $value)
                                            <li class="brandLi"><input type="checkbox" id="colorId" value="{{$value['key']}}" class="colors" name="color[]"/>
                                            <span>{{$value['key']}}{{' ('}}{{$value['doc_count']}}{{')'}}</span>
                                        @endforeach
                                    @endif
                               </ul>
                        </div>
                    </div>

                    <div class="cities-name">
                        <h3>Location</h3>
                        <div class="itemconfiguration" style="padding-left: 30px;">
                                <ul class="nav nav-pills nav-stacked">
                                    @if(!empty($vehiclesAggreagationCities))
                                        @foreach($vehiclesAggreagationCities as $key => $value)
                                            <li class="brandLi"><input type="checkbox" id="cityId" value="{{$value['key']}}" class="cities" name="location[]"/>
                                            <span>{{$value['key']}}{{' ('}}{{$value['doc_count']}}{{')'}}</span>
                                        @endforeach
                                    @endif
                               </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-9 padding-right"  id="load-data" >
                <div class=class="col-md-12"> <!--features_items-->
                @if(!empty($vehicles))
                    @foreach($vehicles as $vehicle)
                    <div class="col-md-12">
                        <h3 class="text-danger" itemprop="brand"><a href="{{ route('api.searchview', ['id' => $vehicle{'_id'}])}}">{{ $vehicle['year'] }}{{' '}}{{ $vehicle['brand_model'] }}</a></h3>
                    </div>
                            <div class="col-md-7">
                                <p itemprop="description">{{ $vehicle['description'] }}</p>
                                    <ul>
                                        <li itemprop="name">Tipe :{{ $vehicle['body_name'] }}</li>
                                        <li itemprop="year">Tipe :{{ $vehicle['year'] }}</li> 
                                        <li>Kota :{{ $vehicle['city_name'] }}</li>
                                        <li>Warna :{{ $vehicle['color'] }}</li>
                                        <li>Kondisi :{{ $vehicle['condition'] }}</li>
                                        <li>Price :Rp.{{ $vehicle['price'] }}</li>
                                        <li>Tag :{{ $vehicle['caption'] }}</li>
                                    </ul>
                            </div>
                            <div class="col-md-4">
                                <img src="{{ URL::to('/') }}/images/{{ 'mobil.jpg' }}" alt="{{ 'Mobil Termahal' }}" />
                            </div>
                    @endforeach
                    <br>
                    @if(!empty($vehicle))
                    <div id="remove-row">
                        <button id="btn-more" data-id="{{ $vehicle['id'] }}" class="nounderline btn-block mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" > Load More </button>
                    </div>
                    @else
                        <h3 class="text-danger">{{ $error['error'] }}</h3>
                    @endif
            @else
                <h3 class="text-danger">{{ $error['error'] }}</h3>
            @endif
            
            </div><!--features_items-->
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(document).on('click','#btn-more',function(){
                var id = $(this).data('id');
                var q = $('#q').val();
                var brand = [];
                var brands = $('input[name="brand[]"]:checked');
                var len = brands.length;
                for (var i=0; i<len; i++) {
                     brand.push(brands[i].value);
                }
                Finalbrand  = brand.toString();
                var color = [];
                var colors = $('input[name="color[]"]:checked');
                var len = colors.length;
                for (var i=0; i<len; i++) {
                     color.push(colors[i].value);
                }
                Finalcolor  = color.toString();
                var city = [];
                var cities = $('input[name="location[]"]:checked');
                var len = cities.length;
                for (var i=0; i<len; i++) {
                     city.push(cities[i].value);
                }
                Finalcity  = city.toString();
                $("#btn-more").html("Loading....");
                src = "{{ route('api.searchVehicle') }}";
                $.ajax({
                    url : src,
                    method : "get",
                    data : {lastId:id, q:q, brand:Finalbrand, color:Finalcolor, location : Finalcity, _token:"{{csrf_token()}}"},
                    dataType : "text",
                    success : function (data)
                    {
                        if(data != '') 
                        {
                            $('#remove-row').remove();
                            $('#load-data').append(data);
                        }
                        else
                        {
                            $('#btn-more').html("No Data");
                        }
                    }
                });
            });  
        });

        $(document).ready(function() {
            src = "{{ route('api.searchajax') }}";
            $("#q").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: src,
                        dataType: "json",
                        data: {
                            term : request.term
                        },
                        success: function(data) {
                            response(data); 
                        }
                    });
                },
                minLength: 1,
            });
        });

        $(function () {
            $('.cities').click(function(){
                var cities = [];
                $('.cities').each(function(){
                    if($(this).is(":checked")){
                        cities.push($(this).val());
                    }
                });
                Finalcity  = cities.toString();
                var brand = [];
                var brands = $('input[name="brand[]"]:checked');
                var len = brands.length;
                for (var i=0; i<len; i++) {
                     brand.push(brands[i].value);
                }
                Finalbrand  = brand.toString();
                var color = [];
                var colors = $('input[name="color[]"]:checked');
                var len = colors.length;
                for (var i=0; i<len; i++) {
                     color.push(colors[i].value);
                }
                Finalcolor  = color.toString();
                var q = $('#q').val();
                src = "{{ route('api.searchVehicle') }}";
                $.ajax({
                    type: 'get',
                    dataType: 'html',
                    url: src,
                    data: {location : Finalcity, color : Finalcolor, brand : Finalbrand, q:q},
                    success: function (response) {
                        console.log(response);
                        $('#load-data').html(response);
                    }
                });
            });

            $('.colors').click(function(){
                var colors = [];
                $('.colors').each(function(){
                    if($(this).is(":checked")){
                        colors.push($(this).val());
                    }
                });
                Finalcolor  = colors.toString();
                var brand = [];
                var brands = $('input[name="brand[]"]:checked');
                var len = brands.length;
                for (var i=0; i<len; i++) {
                     brand.push(brands[i].value);
                }
                Finalbrand  = brand.toString();
                var city = [];
                var cities = $('input[name="location[]"]:checked');
                var len = cities.length;
                for (var i=0; i<len; i++) {
                     city.push(cities[i].value);
                }
                Finalcity  = city.toString();
                var q = $('#q').val();
                src = "{{ route('api.searchVehicle') }}";
                $.ajax({
                    type: 'get',
                    dataType: 'html',
                    url: src,
                    data: {location : Finalcity, color : Finalcolor, brand : Finalbrand, q:q},
                    success: function (response) {
                        console.log(response);
                        $('#load-data').html(response);
                    }
                });
            });

            $('.brands').click(function(){
                var brands = [];
                $('.brands').each(function(){
                    if($(this).is(":checked")){
                        brands.push($(this).val());
                    }
                });
                Finalbrand  = brands.toString();
                var color = [];
                var colors = $('input[name="color[]"]:checked');
                var len = colors.length;
                for (var i=0; i<len; i++) {
                     color.push(colors[i].value);
                }
                Finalcolor  = color.toString();
                var city = [];
                var cities = $('input[name="location[]"]:checked');
                var len = cities.length;
                for (var i=0; i<len; i++) {
                     city.push(cities[i].value);
                }
                Finalcity  = city.toString();
                var q = $('#q').val();
                src = "{{ route('api.searchVehicle') }}";
                $.ajax({
                    type: 'get',
                    dataType: 'html',
                    url: src,
                    data: {location : Finalcity, color : Finalcolor, brand : Finalbrand, q:q},
                    success: function (response) {
                        console.log(response);
                        $('#load-data').html(response);
                    }
                });
            });
        });
    </script>    
</body>

</html>