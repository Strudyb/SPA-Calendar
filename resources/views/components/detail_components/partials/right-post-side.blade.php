@php
    $recentPosts = Helper::recentPosts(3)
@endphp

<aside class="cell-3 right-sidebar">
    <ul class="sidebar_widgets">
        <li class="widget search-w fx" data-animate="fadeInRight">
            <h3 class="widget-head">Arama</h3>
            <div class="widget-content">
                <form action="#" method="get">
                    <input type="text" name="t" onkeydown="live_post_search()" id="search_input_post"
                           class="txt-box"
                           placeholder="Anahtar Kelime Girin..."/>
                    <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                </form>

            </div>
            <div id="search_result_post" class="bg-info">

            </div>
        </li>

        <li class="widget r-posts-w fx" data-animate="fadeInRight">
            <h3 class="widget-head">Yeni Gönderiler</h3>
            <div class="widget-content">
                <ul>
                    @isset($recentPosts)
                        @forelse($recentPosts as $recentPost)
                            @php
                                $recentDate = Helper::getDateForHuman($recentPost->created_at);
                            @endphp
                            <li>
                                <div class="post-img">
                                    <img src="{{$recentPost->thumbnail}}" alt="">
                                </div>
                                <div class="widget-post-info">
                                    <h4>
                                        <a href="blog-single.blade.php">
                                            {{$recentPost->title}}
                                        </a>
                                    </h4>
                                    <div class="meta">
                                        <span><i class="fa fa-clock-o"></i>{{$recentDate}}</span>
                                    </div>
                                </div>
                            </li>

                        @empty
                        @endforelse
                    @endisset
                </ul>
            </div>
        </li>

        <li class="widget blog-cat-w fx" data-animate="fadeInLeft">
            <h3 class="widget-head">Bizimle İletişime Geçebilirsiniz</h3>
            <div class="widget-content">
                <ul class="sidebarCallLocation">
                    <li><a title="Whatsapp Destek Hattı" href="https://wa.me/908503469956"><i
                                class="fa fa-whatsapp fa-2x"></i></a></li>
                    <li><a title="Telefonla Ulaşın" href="tel:+908503469956"><i
                                class="fa fa-phone fa-2x"></i></a>
                    <li><a title="E-Posta İletişim" href="mailto:info@eihracatturkiye.com"><i
                                class="fa fa-envelope fa-2x"></i></a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</aside>
