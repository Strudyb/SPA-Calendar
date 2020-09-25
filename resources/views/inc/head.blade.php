
<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7 ltie8 ltie9" lang="en-US"><![endif]-->
<!--[if IE 8]><html class="ie ie8 ltie9" lang="en-US"><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html lang="{{ app()->getLocale() }}">
<!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <input type="hidden" id="meta_csrf"  value="{{csrf_token()}}">
    @if ($page)
        <title>{{ $page->seo_title }}</title>
        <meta name="description" content="{{ $page->seo_description }}"/>
    @else
        <title>test</title>
        <meta name="description" content="test"/>
@endif

    <link rel='stylesheet' href='/theme/css/admin_icon.min.css' type='text/css' media='all' />
    <link rel='stylesheet'
        href='https://fonts.googleapis.com/css?family=Droid+Serif:400,400i,700,700i|Montserrat:400,700|Mr+De+Haviland|Open+Sans:300,400,600,700,800|Raleway:100,200,300,300i,400,400i,500,600,700,700i,800,900&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese'
        type='text/css' media='all' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css'
        type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/fontello/css/fontello.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/main.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/style.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/core.animation.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/shortcodes.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/instagram-widget.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/skin.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/custom-style.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/responsive.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/skin.responsive.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/custom.responsive.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/js/vendor/grid.layout/grid.layout.min.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/core.messages.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/js/vendor/swiper/swiper.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/plugins.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/theme/css/custom.css' type='text/css' media='all' />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>