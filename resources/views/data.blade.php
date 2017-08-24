
<div class=class="col-md-12"> <!--features_items-->
                @if(!empty($vehicles))
                    @foreach($vehicles as $vehicle)
                    <div class="col-md-12">
                        <h3 class="text-danger" itemprop="brand"><a href="{{ route('api.searchview', ['id' => $vehicle{'_id'}])}}">{{ $vehicle['brand_model'] }}</a></h3>
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
                    <?php $position=1;?>
                    <br>
                        <div id="remove-row">
                            <button id="btn-more" data-id="{{ $vehicles[$vehicles->count()-1]['id'] }}" class="nounderline btn-block mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" > Load More </button>
                        </div>
                    
            @else
                <h3 class="text-danger">{{ $error['error'] }}</h3>
            @endif
            </div><!--features_items-->
