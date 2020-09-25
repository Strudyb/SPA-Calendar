@php
    $dateArray = Helper::getDateForHuman($post->created_at,1);
    $recentPosts = Helper::recentPosts(3);
    $comments = Helper::getComments($post->id,false);
      $canVote = Helper::canVotePost($post->id);

      $tags = Helper::jsonToArray($post->options);

@endphp


<!-- Content Start -->
<div id="contentWrapper">
    <div class="page-title title-1">
        <div class="container">
            <div class="row">
                <div class="cell-12">
                    <h1 class="fx" data-animate="fadeInLeft">Blog <span>Başlığı</span></h1>
                    <div class="breadcrumbs main-bg fx" data-animate="fadeInUp">
                        <span class="bold">Buradasınız:</span><a href="#">Anasayfa</a><span
                            class="line-separate">/</span><a href="#">Blog</a><span
                            class="line-separate">/</span><span>Blog Detayı</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sectionWrapper">
        <div class="container">
            <div class="row">
                <div class="cell-9">
                    <div class="blog-posts">
                        <div class="post-item fx" data-animate="fadeInLeft">
                            <div class="details-img">
                                <div class="post-lft-info">
                                    <div class="main-bg">{{$dateArray[0]}}<br>{{$dateArray[1]}}<br>{{$dateArray[2]}}
                                        <span class="tri-col"></span>
                                    </div>
                                </div>
                                <img src="{{$post->thumbnail}}" alt="Our Blog post image goes here">
                            </div>
                            <article class="post-content">
                                <div class="post-info-container">
                                    <h1 class="main-color">{!! $post->title  !!}
                                    </h1>
                                </div>
                                {!! $post->content !!}

                                <div class="post-tags">
                                    <i class="fa fa-tags"></i><span>Etiketler: </span>
                                    @isset($tags)
                                        @foreach ($tags as $key1 => $tag)
                                            @isset($tag)
                                            @foreach ($tag as $key2 => $item)
                                                <a>{{$item}}</a>
                                            @endforeach
                                            @endisset
                                        @endforeach
                                    @endisset


                                    <div class="share-post">
                                        <span class="sh">Gönderiyi Paylaş:</span>
                                        <div id="shareme" data-text="Share this post"></div>
                                    </div>
                            </article>
                        </div>
                        <div class="comments">
                            <h3 class="block-head">Yorumlar</h3>
                            <ul class="comment-list">
                                <li>
                                    @isset($comments)
                                        @forelse($comments as $comment)
                                            @php
                                                $childComment = Helper::getChildComments($comment->id);
                                            @endphp
                                            <article class="comment">
                                                <img src="{{$comment->user->avatar}}" alt="avatar"
                                                     class="comment-avatar">
                                                <div class="comment-content">
                                                    <h5 class="comment-author skew-25">
                                                        <span class="author-name skew25">{{$comment->user->name}}</span>
                                                        <a href="#commentForm"
                                                           onclick="setToWhomComment({{$comment->id}})"
                                                           class="comment-reply main-bg"><span
                                                                class="skew25"><i
                                                                    class="fa fa-comment"></i>cevapla</span></a>
                                                        <span
                                                            class="comment-date skew25">{{Helper::getDateForHuman($comment->created_at)}}</span>
                                                    </h5>
                                                    <p>
                                                        {{$comment->content}}
                                                    </p>
                                                </div>
                                            </article><!-- End .comment -->
                                            @isset($childComment)
                                                @forelse($childComment as $key=> $child)
                                                    <ul class="child-comment">
                                                        <li>
                                                            <article class="comment">
                                                                <img src="{{$child->user->avatar}}"
                                                                     alt="avatar"
                                                                     class="comment-avatar">
                                                                <div class="comment-content">
                                                                    <h5 class="comment-author skew-25">
                                                                        <span
                                                                            class="author-name skew25">{{$child->user->name}}</span>
                                                                        <a href="#commentForm"
                                                                           onclick="setToWhomComment({{$comment->id}})"
                                                                           class="comment-reply main-bg"><span
                                                                                class="skew25"><i
                                                                                    class="fa fa-comment"></i>cevapla</span></a>
                                                                        <span
                                                                            class="comment-date skew25">{{Helper::getDateForHuman($child->created_at)}}</span>
                                                                    </h5>
                                                                    <p>{{$child->content}}</p>
                                                                </div>
                                                            </article><!-- End .comment -->
                                                        </li>
                                                    </ul><!-- End .child-comment -->
                                                @empty
                                                @endforelse
                                            @endisset
                                </li>
                                @empty
                                @endforelse
                                @endisset
                            </ul><!-- End .comment-list -->
                        </div>
                        @guest
                            Yorum yapmak için
                            <a href="/panel/login" class="btn btn-danger"> Giriş Yapınız</a>
                        @endguest
                        @auth
                            <form action="{{route('add_comment_to_post',$post->id)}}" method="post"
                                  class="leave-comment contact-form" id="commentForm">
                                @csrf
                                <h3 class="block-head">Yorum Yap</h3>
                                <p>Aşağıdaki gerekli alanları doldurarak sizde bu haber hakkındaki fikirlerinizi
                                    paylaşabilirsiniz.</p>
                                <div class="row">

                                    {{--<div class="cell-6">
                                        <div class="form-input">
                                            <input type="text" placeholder="Ad Soyad" required>
                                        </div>
                                    </div>
                                    <div class="cell-6">
                                        <div class="form-input">
                                            <input type="email" placeholder="E-Posta Adresi" required>
                                        </div>
                                    </div>--}}
                                    @if($canVote)
                                        <div class="cell-12">
                                            <div class="form-input rating">
                                                <span class="bold">Derecelendirmeniz: </span>
                                                <span>1<input value="1" class="divideThis" type="radio"
                                                              name="point"></span>
                                                <span>2<input value="2" class="divideThis" type="radio"
                                                              name="point"></span>
                                                <span>3<input value="3" class="divideThis" type="radio"
                                                              name="point"></span>
                                                <span>4<input value="4" class="divideThis" type="radio"
                                                              name="point"></span>
                                                <span>5<input value="5" class="divideThis" type="radio"
                                                              name="point"></span>

                                            </div>
                                        </div>
                                    @endif
                                    <div class="cell-12">
                                        <div class="form-input">
											<textarea class="txt-box textArea" name="content" cols="40" rows="7"
                                                      id="messageTxt" placeholder="Yorumunuz" spellcheck="true"
                                                      required></textarea>
                                            <input type="hidden" name="isFromPartnerPage" value="0">
                                            <input type="hidden" name="reply_to" id="formCommentHidden">
                                        </div>
                                    </div>
                                    <div class="cell-12">
                                        <input type="submit" class="btn btn-large main-bg" value="Yorum Yap">
                                    </div>
                                </div>
                            </form>
                        @endauth
                    </div>
                </div>

                @include('pages.partials.blog-sidebar')
            </div>
        </div>
    </div>

</div>
<!-- Content End -->
