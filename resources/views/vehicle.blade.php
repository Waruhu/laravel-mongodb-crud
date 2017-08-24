<!DOCTYPE html>
<html>
<head>
<title>Vehicle</title>

<!-- COMMON TAGS -->
<meta charset="utf-8">
<title>Vehicle</title>

<!-- Search Engine -->
<meta name="description" content="{{ $vehicle['description'] }}">
<meta name="image" content="http://426ce2f9.ngrok.io/images/mobil.jpg">

<!-- Schema.org for Google -->
<meta itemprop="name" content="{{ $vehicle['brand'] }}">
<meta itemprop="description" content="{{ $vehicle['description'] }}">
<meta itemprop="image" content="http://426ce2f9.ngrok.io/images/mobil.jpg">

<!-- Twitter -->
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $vehicle['brand'] }}">
<meta name="twitter:description" content="{{ $vehicle['description'] }}">
<meta name="twitter:image:src" content="http://426ce2f9.ngrok.io/images/mobil.jpg">
<meta name="twitter:data1" content="{{ $vehicle['price'] }}">
<meta name="twitter:label1" content="PRICE">
<meta name="twitter:data2" content="{{ $vehicle['city_name'] }}">
<meta name="twitter:label2" content="LOCATION">
<!-- Twitter - Product (e-commerce) -->

<!-- Open Graph general (Facebook, Pinterest & Google+) -->
<!-- FACEBOOK'S OPEN GRAPH PROTOCOL -->
<meta property="og:title" content="{{ $vehicle['brand'] }}">
<meta property="og:type" content="product">
<meta property="og:description" content="{{ $vehicle['description'] }}">
<meta property="og:image:src" content="http://426ce2f9.ngrok.io/images/mobil.jpg">
<meta property="og:url" content="http://426ce2f9.ngrok.io/api/searchview/5975d31b5250e13f3e11dc8e">
<meta property="og:site_name" content="http://426ce2f9.ngrok.io">
<meta property="og:locale" content="en_GB" />

 <!-- <meta name="fb:admins" content="100006319181647"> -->
 <meta name="fb:app_id" content="780921495419990">  
<!-- Open Graph - Product (e-commerce) -->
<meta name="product:name" content="{{ $vehicle['body_type'] }}">
<meta name="product:availability" content="instock">
<meta name="product:price:currency" content="Rp.">
<meta name="product:price:amount" content="{{ $vehicle['price'] }}">
<meta name="product:brand" content="{{ $vehicle['brand'] }}">
</head>
<body>

  <div class="container"> 
    <div class="col-md-10">
      <div class="col-xs-12 col-sm-12 col-md-8">
        <div id="products" class="row list-group">
          <div class="col-lg-12">
            <div>
              <div class="col-md-12" itemscope itemtype="http://schema.org/Person">
                <strong>Contact Name: </strong> <span itemprop="name givenName">Garasi</span>
                  <div itemprop="makesOffer" itemscope itemtype="http://schema.org/Offer" itemref="product">
                    <p><strong>Price: </strong>
                    <span itemprop="priceSpecification" itemscope
                        itemtype="http://schema.org/UnitPriceSpecification">
                      <meta itemprop="priceCurrency" content="Rp.">Rp.
                      <meta itemprop="price" content="{{ $vehicle['price'] }}">{{ $vehicle['price'] }}
                    </span>
                    </p>
                  </div>
                </div>
                <!-- Car Details -->
                  <div id="product" itemprop="itemOffered" itemscope itemtype="http://schema.org/Vehicle">
                    <strong itemprop="name">{{ $vehicle['body_type'] }}</strong>
                    <strong>Brand Name:</strong>
                    <strong itemprop="brand">{{ $vehicle['brand'] }}</strong></p>
                    <strong>Model Name:</strong>
                    <strong itemprop="model">{{ $vehicle['model'] }}</strong>
                    <p><strong>Color: </strong><span itemprop="color">{{ $vehicle['color'] }}</span></p>
                    <p><strong>Machine Capacity: </strong><span itemprop="fuelCapacity">{{ $vehicle['machine_capacity'] }}</span></p>
                    <p itemprop="description">{{ $vehicle['description'] }}</p>
                    <img itemprop="image" src="{{ URL::to('/') }}/images/{{ 'mobil.jpg' }}" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br/><hr/>  
</body>
</html>