@php($categoryName = \App\utils\Helpers\Helper::urlToCategory($itemId))
<div class="bread-crumb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="/">Anasayfa</a></li>
                    <li>@isset($categoryName) {{$categoryName->title}}@endisset</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--BREADCRUMB AREA END-->
<div class="shop-area-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="shop-product">
                    <h2>@isset($categoryName) {{$categoryName->title}}@endisset </h2>  <!--category-->

					<!--=======  End of Shop header  =======-->

					<!--=======  Grid list view  =======-->
                    <div id="filter_drop">
                        @include('components.detail_components.partials.category_product_list')
                    </div>
                </div>
                <!--pagination-->
                <div class="pagination-content text-center" style="width: 100%">
                    <br>
                    <div class="col-12 d-flex justify-content-center bg-white pt-3" >
{{--                        {{ $products->links('vendor.pagination.default')}}--}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!--ORDER AREA START-->
<div class="order-area order-style-two">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="sin-order">
                    <span><i class="fa fa-phone-square"></i></span>
                    <div class="order-right">
                        <p class="title">HIZLI SİPARİŞ OLANAĞI</p>
                        <p class="subline">Bizi Arayın: <span>0530 293 18 09</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sin-order">
                    <span><i class="fa fa-plane"></i></span>
                    <div class="order-right">
                        <p class="title">ÜCRETSİZ KARGO İMKANI</p>
                        <p class="subline">100₺ üzeri alışverişlerde</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sin-order">
                    <span><i class="fa fa-money"></i></span>
                    <div class="order-right">
                        <p class="title">HAVALE & EFT İMKANI</p>
                        <p class="subline">2 - 3 iş gününde teslim</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--ORDER AREA END-->
<!--FOOTER AREA START-->

<!--FOOTER AREA END-->
<!-- QUICKVIEW PRODUCT -->
