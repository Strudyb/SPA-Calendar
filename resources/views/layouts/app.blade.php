@include('inc/head')
@include('inc/header')
<div id="front-end">
<body
    class="aboutus page body_filled theme_skin_less article_style_stretch scheme_original top_panel_show top_panel_above sidebar_hide sidebar_outer_hide preloader wpb-js-composer sc_responsive">
    <div id="page_preloader"></div>
    <div class="body_wrap">
        <div class="page_wrap">
            <div class="top_panel_fixed_wrap" style="height: 114px;"></div>
    @switch($type)
    @case($type)
    @if($type === 'page')
        @include('components/page')
        @break
    @else
        @include('components/detail_components/'.$category)
        @break
    @endif
    @default
    @include('components/page')
@endswitch
</div>
<a href="#" class="scroll_to_top icon-up" title="Scroll to top"></a>
</div>
</div>
@include('inc/footer')
@include('inc/scripts')
