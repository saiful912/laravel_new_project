<div class="left-sidebar">
    <h2>Category</h2>
    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
        <div class="panel panel-default">
            @foreach($categories as $cat)
                @if($cat->status=="1")
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordian" href="#main-{{$cat->id}}">
                                <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                {{$cat->name}}
                            </a>
                        </h4>
                    </div>
                    <div id="main-{{$cat->id}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                @foreach($cat->categories as $sub_cat)
                                    @if($sub_cat->status=="1")
                                        <li><a href="{{asset('/products/'.$sub_cat->url)}}"> {{$sub_cat->name}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div><!--/category-products-->

    <div class="brands_products"><!--brands_products-->
        <h2>Brands</h2>
        <div class="brands-name">
            <ul class="nav nav-pills nav-stacked">
                <li><a href=""> <span class="pull-right">(50)</span>Acne</a></li>
                <li><a href=""> <span class="pull-right">(56)</span>Grüne Erde</a></li>
                <li><a href=""> <span class="pull-right">(27)</span>Albiro</a></li>
                <li><a href=""> <span class="pull-right">(32)</span>Ronhill</a></li>
                <li><a href=""> <span class="pull-right">(5)</span>Oddmolly</a></li>
                <li><a href=""> <span class="pull-right">(9)</span>Boudestijn</a></li>
                <li><a href=""> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
            </ul>
        </div>
    </div><!--/brands_products-->

    <div class="price-range"><!--price-range-->
        <h2>Price Range</h2>
        <div class="well">
            <div class="slider slider-horizontal" style="width: 174px;"><div class="slider-track"><div class="slider-selection" style="left: 41.6667%; width: 33.3333%;"></div><div class="slider-handle round left-round" style="left: 41.6667%;"></div><div class="slider-handle round" style="left: 75%;"></div></div><div class="tooltip top" style="top: -30px; left: 68.5px;"><div class="tooltip-arrow"></div><div class="tooltip-inner">250 : 450</div></div><input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" style=""></div><br>
            <b>$ 0</b> <b class="pull-right">$ 600</b>
        </div>
    </div><!--/price-range-->

    <div class="shipping text-center"><!--shipping-->
        <img src="images/home/shipping.jpg" alt="">
    </div><!--/shipping-->

</div>
