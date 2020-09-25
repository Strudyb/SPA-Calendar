<div class="shop-product-wrap grid row no-gutters mb-35">
    @php
        $catProducts = Helper::findCategoryPosts($itemId);
    @endphp

        <div class="tab-content">
            <div id="grid" class="tab-pane fade active in">
                <div class="row">
                    <!--single product-->
                    @forelse($catProducts as $product)
                        <div class="col-sm-6 col-md-3">
                            <div class="sin-product">
                                <div class="product-top">
                                    <div class="pro-img">
                                        <a href="{{route('product.find',$product->slug)}}">
                                            <img src="{{$product->thumbnail}}" alt="">
                                        </a>
                                    </div>
                                    @isset($product->discounted_price) <div class="label_sale"><span>İndirim</span></div>@endisset
                                    <div class="label_new"><span>Yeni</span></div>
                                    <div class="name"><a href="{{route('product.find',$product->slug)}}">{{$product->title}}</a></div>
                                    <div class="price">
                                        @if(isset($product->discounted_price))
                                            <span class="price-old">₺{{$product->price}}</span>
                                            <span class="price-new">₺{{$product->discounted_price}}</span>
                                        @else
                                            <span class="price-new">₺{{$product->price}}</span>
                                        @endif
                                    </div>

                                    <div class="pro-bottom">
                                        <a target="_blank"
                                           href="https://wa.me/905302931809?text={{$product->title}}%20adlı%20ürünü%20sipariş%20vermek%20istiyorum"><button
                                                type="button" class="btn-add-card"><i
                                                    class="fa fa-whatsapp"></i> Hızlı
                                                Sipariş</button></a>
                                        <a href="{{route('product.find',$product->slug)}}"><button type="button"
                                                                                                   class="btn-quickview"><i class="fa fa-search-plus"></i>
                                                Görüntüle</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            <div id="list" class="tab-pane fade ">
                <div class="row">
                    <!--SINGLE PRODUCT-->
                    @forelse($catProducts as $product)
                        <div class="single-list-product">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <div class="product-top">
                                    <div class="pro-img">
                                        <a href="{{route('product.find',$product->slug)}}">
                                            <img src="{{$product->thumbnail}}" alt="">
                                        </a>
                                    </div>
                                    @isset($product->discounted_price) <div class="label_sale"><span>İndirim</span></div>@endisset
                                    <div class="label_new"><span>Yeni</span></div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8">
                                <div class="list-detail">
                                    <div class="name"><a href="{{route('product.find',$product->slug)}}">{{$product->title}}</a></div>
                                    <div class="price">
                                        @if(isset($product->discounted_price))
                                            <span class="price-new">₺{{$product->discounted_price}}</span>
                                            <span class="price-old">₺{{$product->price}}</span>
                                        @else
                                            <span class="price-new">₺{{$product->price}}</span>
                                        @endif
                                    </div>
                                    <p class="description">{{$product->content}}</p>
                                    <div class="pro-bottom">
                                        <a target="_blank"
                                           href="https://wa.me/905302931809?text={{$product->title}}%20adlı%20ürünü%20sipariş%20vermek%20istiyorum"><button
                                                type="button" class="btn-add-card"><i
                                                    class="fa fa-whatsapp"></i> Hızlı
                                                Sipariş</button></a>
                                        <a href="{{route('product.find',$product->slug)}}"><button type="button"
                                                                                                   class="btn-quickview"><i class="fa fa-search-plus"></i>
                                                Görüntüle</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                @empty
                @endforelse
                <!--SINGLE PRODUCT-->
                </div>
            </div>
        </div>



</div>
