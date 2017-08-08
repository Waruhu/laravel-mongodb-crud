<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <title>Search with Laravel Elasticquent!</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
        <link href="http://demo.expertphp.in/css/jquery.ui.autocomplete.css" rel="stylesheet">
        <script src="http://demo.expertphp.in/js/jquery.js"></script>
        <script src="http://demo.expertphp.in/js/jquery-ui.min.js"></script>
    </head>
    <br>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        {{ csrf_field() }}
                        {!! Form::open(['method' => 'get', 'route' => 'api.search']) !!}
                            {!! Form::text('q', "", array('placeholder' => 'Search brand name or model name','class' => 'form-control','id'=>'q')) !!}
                        {{ Form:: close() }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3">
                    @if(!empty($vehiclesAggreagation))
                    
                    <h4 class="text-danger">Color :</h4>
                        @foreach($vehiclesAggreagation as $key => $data)
                        <ul>
                            @foreach($data['buckets'] as $key => $value)
                                <li>{{$value['key']}}{{' ('}}{{$value['doc_count']}}{{') '}}</li>
                                <h5 class="text-danger">Min-Max :</h5>
                                <h5>{{$value['prices']['min']}}{{' - '}}{{$value['prices']['max']}}</h5>
                            @endforeach
                        </ul>
                        @endforeach
                   @endif
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8">
                    <div id="products" class="row list-group">
                        <div class="col-lg-12">
                            @if(!empty($vehicles))
                            <div itemscope itemtype="http://schema.org/Vehicle">
                            <?php $i=0;?>
                                @foreach($vehicles as $key => $value)
                                <div class="col-md-12">
                                    <h3 class="text-danger" itemprop="brand"><?php echo ++$i .'. '?><a href="{{ route('api.searchview', ['id' => $value{'_id'}])}}">{{ $value['brand_model'] }}</a></h3>
                                    <div class="col-md-5">
                                        <p itemprop="description">{{ $value['description'] }}</p>
                                        <ul>
                                            <li itemprop="name">Tipe :{{ $value['body_name'] }}</li>
                                            <li>Kota :{{ $value['city_name'] }}</li>
                                            <li>Warna :{{ $value['color'] }}</li>
                                            <li>Kondisi :{{ $value['condition'] }}</li>
                                            <li>Price :Rp.{{ $value['price'] }}</li>
                                            <li>Tag :{{ $value['caption'] }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-5">
                                        <img src="{{ URL::to('/') }}/images/{{ 'mobil.jpg' }}" alt="{{ 'Mobil Termahal' }}" />
                                    </div>
                                    
                                    
                                </div>
                                @endforeach
                            @else
                                <h3 class="text-danger">{{ $error['error'] }}</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <script>
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
            </script>
        </div>
    </body>
</html>