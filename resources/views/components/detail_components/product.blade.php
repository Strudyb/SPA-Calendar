@php
    $post = Helper::findProduct($itemId);
    $relatedProducts = Helper::relatedProducts($post->title);
    $options = Helper::jsonToArray($post->options);
    $randomProducts = \App\utils\Helpers\Helper::randomProducts();
@endphp
<!--HEADER AREA END-->
<!--BREADCRUMB AREA START-->
<div class="bread-crumb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="/">Anasayfa</a></li>
                    <li><a href="#">{{$post->category->title}}</a></li>
                    <li>{{$post->title}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!--BREADCRUMB AREA END-->
<!--SINGLE PRODUCT AREA START-->

<section class="sin-product-page">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-9">
                <div class="row">
                    <div class="col-sm-6 col-md-6 ">
                        <div class="zoom-Wrapper">
                            <div id="img-1" class="zoomWrapper single-zoom">
                                <a href="" class="">
                                    <img id="zoom1" src="{{$post->thumbnail}}"
                                         data-zoom-image="{{$post->thumbnail}}" alt="big-6">
                                </a>
                            </div>
                            <div class="single-zoom-thumb">
                                <ul class="zoom-slider" id="gallery_01">
                                    @forelse($options['gallery'] as $key => $option)
                                        <li>
                                            <a href="#" class="elevatezoom-gallery active" data-update=""
                                               data-image="{{$option}}"
                                               data-zoom-image="{{$option}}">
                                                <img src="{{$option}}" alt="zo-th-1" />
                                            </a>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 text-center">
                        <div class="product-laft-info">
                            <h2 class="pro-name">{{$post->title}}</h2>
                            <ul class="list-info-product">
                                <li>Malzeme: <a href="#">Swarovski Taş</a></li>
                                <li class="text_stock">Stok Durumu: Mevcut</li>
                            </ul>
                            <div class="price text-center">
                                @if(isset($post->discounted_price))
                                    <span class="price-old">₺{{$post->price}}</span>
                                    <span class="price-new">₺{{$post->discounted_price}}</span>
                                @else
                                    <span class="price-new">₺{{$post->price}}</span>
                                @endif
                            </div>
                            <div class="group-two-btn orderOptionsArea">
                                <h4>Sipariş Seçenekleri</h4>
                                <a target="_blank"
                                   href="https://wa.me/905302931809?text={{$post->title}}%20adlı%20ürünü%20sipariş%20vermek%20istiyorum"><i
                                        class="fa fa-whatsapp"></i> Whatsapp Hızlı Sipariş</a>

                                <a target="_blank" href="tel:905302931809"><i class="fa fa-phone"></i> Telefonla
                                    Sipariş</a>

                                <a id="order_request_form" href="javascript:void(0);"><i
                                        class="fa fa-clipboard"></i> Sipariş
                                    Formu
                                    Doldurun</a>
                                <div class="orderFormArea">
                                    <form action="{{route('ajax.email-order')}}" method="post" id="emailOrderForm" class="form">
                                        @csrf
                                        <h5 style="margin-top: 35px;" class="text-muted">Aşağıdaki formu doldurarak
                                            sipariş talebi
                                            oluşturun,
                                            biz sizi arayalım!</h5>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="order_name">Ad Soyad</label>
                                                <input type="text"name="order_name" id="order_name" class="form-control"
                                                       placeholder="Adınız Soyadınız">
                                                <input type="hidden" name="order_product" value="{{$post->title}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="order_mail">E-Posta</label>
                                                <input type="email" name="email" id="order_mail" class="form-control"
                                                       placeholder="ornek@ornek.com">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="order_phone">Telefon</label>
                                                <input type="tel" name="order_phone" id="order_phone" class="form-control"
                                                       placeholder="0555 444 33 22">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="order_notes">Sipariş Notu</label>
                                                <textarea style="width: 100%; padding: 0 15px;" name="order_note"
                                                          id="order_notes" rows="2"
                                                          placeholder="Mesajınız buraya"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <a class="applyOrderRequest btn " onclick="document.getElementById('emailOrderForm').submit()">Sipariş Talep Et</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="sicial-link">
                                <a href="#"><img src="{{asset('theme/img/icon/pro-social.png')}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 text-center">
                        <div class="review-wrapper ">
                            <ul class="review-menu ">
                                <li class="active"><a href="#pr-description" data-toggle="tab">Ürün Açıklaması</a>
                                </li>
                                <li><a href="#pr-transport" data-toggle="tab">Kargo & Teslimat</a></li>
                                <li><a href="#pr-return" data-toggle="tab">Değişim & İade</a></li>
                            </ul>
                            <div class="con tab-content">
                                <div class="tab-pane fade in active" id="pr-description">
                                    <p> {!!$post->content  !!}</p>
                                </div>

                                <div class="tab-pane fade" id="pr-transport">
                                    <figure>
                                        <img src="{{asset('theme/img/free-delivery.jpg')}}" alt="">
                                    </figure>
                                </div>

                                <div class="tab-pane fade" id="pr-return">
                                    <div style="text-align:center;">
                                        <h1>İade ve Değişim</h1>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <p><strong>Satın aldığım ürünü nasıl değiştirebilirim?</strong></p>

                                                <p>Web sitemizden yapmış olduğunuz alışverişlerin ürün değişimi
                                                    yapılabilmektedir.Bedeni olmayan ürünlerde veya başka bir ürün
                                                    ile değişim sağlanmaktadır.</p>

                                                <p><strong>Satın aldığım ürünü nasıl iade edebilirim?</strong></p>

                                                <p>www.elvanbutik.com adresinden satın aldığınız ürünlerin iadesi
                                                    için eğer üye iseniz &nbsp;öncelik
                                                    olarak&nbsp;hesabım&nbsp;sekmesinden ilgili siparişinizde hangi
                                                    ürünleri iade etmek istiyorsanız ürünün karşısında bulunan iade
                                                    butonuna tıklayarak iade talebi oluşturmanız gerekir. Sonra
                                                    &nbsp;herhangi ARAS KARGO şubesinden iade
                                                    gönderiminizi&nbsp;<span
                                                        style="background-color:#f1c40f;">1910248851615 </span>-
                                                    müşteri kodu&nbsp;&nbsp;numarasıyla&nbsp; yapabilirsiniz.
                                                    Teslimat adresi olarak " ERENKÖY İSTASYON CADDESİ PULUR
                                                    APARTMANI NO 9/A ERENKÖY/KADIKÖY/İSTANBUL” adresini
                                                    kullanabilirsiniz.</p>

                                                <p>Merkezimizden size yollanan ürünlerin iadesi için siparişlerim
                                                    kısmında ürün veya ürünlerin karşısındaki iade butonuna
                                                    tıklayarak iade talebinizi oluşturmanız gerekmektedir.&nbsp;<br>
                                                    Eğer üye değilseniz sipariş takip butonuna basıp sipariş
                                                    sorgulama numarası ile siparişi sorgulattıktan sonra iade etmek
                                                    istediğiniz ürünün karşısında bulunan iade butonuna tıklama ile
                                                    iade talebinizi oluşturmanız gerekmektedir.</p>

                                                <p><strong>Yurtdışından &nbsp;siparişlerde iade ve değişim yapabilir
                                                        miyim ?</strong></p>

                                                <p>Yurtdışı siparişlerde iade/eğişim yapılamamaktadır.</p>

                                                <p><strong>Mağazalarımızdan iade ve değişim yapabilir
                                                        miyim?</strong></p>

                                                <p>Mağazalarımızdan ürün değişimi yapılabilmektedir.</p>

                                                <p><strong>İade etme süresi kaç gündür?</strong></p>

                                                <p><br>
                                                    Tüketici Kanunu'ndaki, "Sebep Göstermeden Cayma Hakkı" maddesine
                                                    göre, ürünü teslim aldığınız tarihten itibaren ilk on dört (14)
                                                    gündür.</p>

                                                <p><strong>İade işlemlerinde kargo gönderi ücretlerini ben mi
                                                        ödeyeceğim?</strong></p>

                                                <p
                                                    style="margin-top:0cm; margin-right:0cm; margin-bottom:8.0pt; margin-left:0cm">
                                                        <span style="font-size:12pt"><span
                                                                style="font-family:&quot;Times New Roman&quot;,serif">Websitemizden
                                                                sipariş detayınızın karışındaki "iade" butonu
                                                                ile&nbsp;&nbsp;gerçekleştirdiğiniz tüm iadelerin kargo
                                                                masrafları düşüldükten sonra hesabınıza iadesi
                                                                gerçekleşir.Ürün iadenizi ARAS KARGO dışında başka bir
                                                                kargo firmasından yaptığınızda karşı ödeme ile
                                                                gönderilen ürünlerin iadesi kabul edilmemektedir. Kapıda
                                                                nakit, kapıda kredi kartı veya banka havalesi ile
                                                                yapılan alışverişlerin iade işlemlerinin sağlanabilmesi
                                                                için, fatura içinde yer alan iade formuna IBAN ve Hesap
                                                                Sahibi Adı bilgilerinizi eksiksiz doldurmanız
                                                                gerekmektedir. Kapıda ödeme tahsilat bedeli (6,90 TL)
                                                                iade edilmemektedir.</span></span>Ücret iadesi talebi
                                                    ile gönderilen kargolardan firmamıza gönderilirken
                                                    oluşabilecek&nbsp;kargo bedeli düşülerek ücret iadesi
                                                    yapılmaktadır.</p>

                                                <p><strong>Taksitli ödemelerimin iadesi nasıl yapılır?</strong></p>

                                                <p><br>
                                                    Her türlü ödemenizde, tarafımızdan bankanıza tüm tutar iade
                                                    edilir. Ödemenizi taksitli olarak yaptığınızda, iadeniz her ay
                                                    kartınıza, taksit tutarları kadar artı bakiye olarak
                                                    yansıyacaktır. Yapılan iadenin kredi kartınıza her ay taksitli
                                                    olarak yansıması tamamen bankaların süreç ve uygulamalarıyla
                                                    ilgilidir. Konu hakkında detaylı bilgiyi bankanızdan
                                                    alabilirsiniz. Ayrıca, ekstrenizde iade işlemini
                                                    görebileceksiniz. Not: Ödemesini yapmış olduğunuz taksit
                                                    tutarları, ilk ekstrenizle birlikte kredi kartınıza artı bakiye
                                                    olarak yansıyacaktır.</p>

                                                <p><strong>İade işleminden ne kadar zaman sonra geri ödeme hesabıma
                                                        yansır?</strong></p>

                                                <p>www.elvanbutik.com &nbsp;iade ettiğiniz ürünlerin iade şartlarına
                                                    uygunluğunu kontrol etmektedir. İadeniz kabul edildiğinde ve
                                                    tarafımızdan para iadeniz gerçekleştiğinde e-mail ile
                                                    bilgilendirileceksiniz. İadenin hesabınıza yansıma süresi banka
                                                    tarafından belirlenmektedir ve tarafımızdan müdahale
                                                    edilememektedir.<span style="font-size:12pt"><span
                                                            style="font-family:&quot;Times New Roman&quot;,serif">Kapıda
                                                                ödeme tahsilat bedeli (6,90TL) iade
                                                                edilmemektedir.</span></span>Ücret iadesi talebi ile
                                                    gönderilen kargolardan firmamıza gönderilirken
                                                    oluşabilecek&nbsp;kargo bedeli düşülerek ücret iadesi
                                                    yapılmaktadır.</p>

                                                <p><strong>İade koşulları nelerdir?</strong><br>
                                                    &nbsp;</p>

                                                <p>Ürün/ürünlerin (varsa) orjinal ambalajı hasar görmemiş,
                                                    kullanılmamış, kullanım hatası sonucu zarar görmemiş haliyle
                                                    tarafımıza yollanması gerekmektedir.&nbsp;<br>
                                                    İade işlemlerinizin hızlı gerçekleşmesi için, iade talebinizi
                                                    sistemden oluşturmanız gerekmektedir. İade yapmak istediğiniz
                                                    ürünün karşısındaki iade butonuna tıklayarak iade talebinizi
                                                    oluşturabilirsiniz. Faturanızı mutlaka iade yapacağınız ürün
                                                    paketi içerisine ekleyiniz. İadeniz tarafımıza ulaştıktan sonra
                                                    firmamızın İlgili birimi tarafından incelenir ve yukarıdaki
                                                    şartlara uygun ise süreç başlatılır. İade onaylandığında ürün
                                                    ücreti yasal süre olan 10 iş günü içerisinde iade edilir. Bu
                                                    süre ELVAN BUTİKin ürünü teslim alması ile başlar.<br>
                                                    Müşteri ürünü, kendisine teslim edildiği andaki durumu ile geri
                                                    vermekle ve kullanım söz konusu ise kullanma dolayısıyla malın
                                                    ticari değerindeki kaybı tazminle yükümlüdür<br>
                                                    &nbsp;</p>

                                                <p><strong>Sipariş İptali</strong></p>

                                                <p><br>
                                                    Değerli müşterilerimiz yanlış verdiğiniz veya vazgeçtiğiniz
                                                    siparişlerinizi iptal ettirebilirsiniz. Bazen yoğunluktan
                                                    mailler geç kontrol edilmektedir.Ürünün kargoya verilmiş
                                                    ihtimali ortaya çıkmaktadır.İptal işlemlerinde ürün kargoya
                                                    verilmemişse ücretin tamamı işlemi gerçekleştirdiğiniz yöntemle
                                                    iade edilir. Ürün kargoya verilmişse kargo ücreti veya ücretleri
                                                    kesilerek iadesi yapılır.</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <div class="title-with-bg style-three">
                    <span>Diğer Ürünler</span>
                </div>
                <div class="sidebar-product">
                    <!--single product-->
                    @forelse($randomProducts as $rand)
                        <div class="sin-product">
                        <div class="product-top">
                            <div class="pro-img">
                                <a href="{{route('product.find',$rand->slug)}}">
                                    <img alt="" src="{{$rand->thumbnail}}">
                                </a>
                            </div>
{{--                            @php($isnew = \App\utils\Helpers\Helper::isNewProduct($rand->id))--}}
                            @isset($rand->discounted_price) <div class="label_sale"><span>İndirim</span></div> @endisset
                            <div class="label_new"><span>Yeni</span></div>
                            <div class="name"><a href="{{route('product.find',$rand->slug)}}">{{$rand->title}}</a></div>
                            <div class="price">
                                @if(isset($rand->discounted_price))
                                    <span class="price-old">₺{{$rand->price}}</span>
                                    <span class="price-new">₺{{$rand->discounted_price}}</span>
                                @else
                                    <span class="price-new">₺{{$rand->price}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
                <!--banner-->
                <div class="sing-banner">
                    <a href="/gallery"><img alt="" src="{{asset('theme/img/banner/banner10.jpg')}}"></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--SINGLE PRODUCT AREA END-->
<!--RELATED PRODUCT AREA START-->
<div class="related-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-with-bg">
                    <span>İlginizi Çekebilir</span>
                </div>
            </div>
            <div class="related-pro-carousel">
                <!--single product-->
                @forelse($relatedProducts as $product)
                    <div class="col-md-12">
                    <div class="sin-product">
                        <div class="product-top">
                            <div class="pro-img">
                                <a href="{{route('product.find',$product->slug)}}">
                                    <img alt="" src="{{$product->thumbnail}}">
                                </a>
                            </div>
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
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>
<!--RELATED PRODUCT AREA END-->
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
