<!DOCTYPE html>
<?php
/** @var string|null $metaTitle */
/** @var string|null $metaDescription */
/** @var string|null $canonicalUrl */
/** @var string|null $ogImage */
$galleryCssVersion = @filemtime(FCPATH . 'css/gallery.css') ?: time();
$colorboxCssVersion = @filemtime(FCPATH . 'css/colorbox.css') ?: $galleryCssVersion;
$colorboxJsVersion = @filemtime(FCPATH . 'js/jquery.colorbox-min.js') ?: $galleryCssVersion;
?>
<html class="avada-html-layout-wide avada-html-header-position-top awb-scroll" lang="en-US" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($metaTitle ?? 'Galleries | Spark Awards - International Design Competition') ?></title>
    <?php if (! empty($metaDescription)): ?>
        <meta name="description" content="<?= esc($metaDescription) ?>" />
    <?php endif; ?>
    <?php if (! empty($canonicalUrl)): ?>
        <link rel="canonical" href="<?= esc($canonicalUrl) ?>" />
        <meta property="og:url" content="<?= esc($canonicalUrl) ?>" />
    <?php endif; ?>
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= esc($metaTitle ?? 'Spark Awards Gallery') ?>" />
    <?php if (! empty($metaDescription)): ?>
        <meta property="og:description" content="<?= esc($metaDescription) ?>" />
    <?php endif; ?>
    <?php if (! empty($ogImage)): ?>
        <meta property="og:image" content="<?= esc(gallery_media_url($ogImage)) ?>" />
    <?php endif; ?>

    <link rel="dns-prefetch" href="//fonts.googleapis.com" />
    <link rel='stylesheet' id='ls-google-fonts-css' href='https://fonts.googleapis.com/css?family=Lato:100,300,regular,700,900%7COpen+Sans:300%7CIndie+Flower:regular%7COswald:300,regular,700&#038;subset=latin%2Clatin-ext' type='text/css' media='all' />
    <link rel='stylesheet' id='fusion-dynamic-css-css' href='/theme/fusion-styles/0c17d3076511ca0b710d2e73ed0a84f7.min.css?ver=3.11.9' type='text/css' media='all' />
    <link rel='stylesheet' id='avada-fullwidth-md-css' href='/theme/fusion-builder/assets/css/media/fullwidth-md.min.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-fullwidth-sm-css' href='/theme/fusion-builder/assets/css/media/fullwidth-sm.min.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-icon-md-css' href='/theme/fusion-builder/assets/css/media/icon-md.min.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-icon-sm-css' href='/theme/fusion-builder/assets/css/media/icon-sm.min.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-grid-md-css' href='/theme/fusion-builder/assets/css/media/grid-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-grid-sm-css' href='/theme/fusion-builder/assets/css/media/grid-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-image-md-css' href='/theme/fusion-builder/assets/css/media/image-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-image-sm-css' href='/theme/fusion-builder/assets/css/media/image-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-person-md-css' href='/theme/fusion-builder/assets/css/media/person-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-person-sm-css' href='/theme/fusion-builder/assets/css/media/person-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-section-separator-md-css' href='/theme/fusion-builder/assets/css/media/section-separator-md.min.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-section-separator-sm-css' href='/theme/fusion-builder/assets/css/media/section-separator-sm.min.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-social-sharing-md-css' href='/theme/fusion-builder/assets/css/media/social-sharing-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-social-sharing-sm-css' href='/theme/fusion-builder/assets/css/media/social-sharing-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-social-links-md-css' href='/theme/fusion-builder/assets/css/media/social-links-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-social-links-sm-css' href='/theme/fusion-builder/assets/css/media/social-links-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-tabs-lg-min-css' href='/theme/fusion-builder/assets/css/media/tabs-lg-min.min.css?ver=7.11.9' type='text/css' media='only screen and (min-width: 640px)' />
    <link rel='stylesheet' id='avada-tabs-lg-max-css' href='/theme/fusion-builder/assets/css/media/tabs-lg-max.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-tabs-md-css' href='/theme/fusion-builder/assets/css/media/tabs-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-tabs-sm-css' href='/theme/fusion-builder/assets/css/media/tabs-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='awb-title-md-css' href='/theme/fusion-builder/assets/css/media/title-md.min.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='awb-title-sm-css' href='/theme/fusion-builder/assets/css/media/title-sm.min.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-swiper-md-css' href='/theme/fusion-builder/assets/css/media/swiper-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-swiper-sm-css' href='/theme/fusion-builder/assets/css/media/swiper-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-post-cards-md-css' href='/theme/fusion-builder/assets/css/media/post-cards-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-post-cards-sm-css' href='/theme/fusion-builder/assets/css/media/post-cards-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-facebook-page-md-css' href='/theme/fusion-builder/assets/css/media/facebook-page-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-facebook-page-sm-css' href='/theme/fusion-builder/assets/css/media/facebook-page-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-twitter-timeline-md-css' href='/theme/fusion-builder/assets/css/media/twitter-timeline-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-twitter-timeline-sm-css' href='/theme/fusion-builder/assets/css/media/twitter-timeline-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-flickr-md-css' href='/theme/fusion-builder/assets/css/media/flickr-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-flickr-sm-css' href='/theme/fusion-builder/assets/css/media/flickr-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-tagcloud-md-css' href='/theme/fusion-builder/assets/css/media/tagcloud-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-tagcloud-sm-css' href='/theme/fusion-builder/assets/css/media/tagcloud-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-instagram-md-css' href='/theme/fusion-builder/assets/css/media/instagram-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-instagram-sm-css' href='/theme/fusion-builder/assets/css/media/instagram-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='awb-meta-md-css' href='/theme/fusion-builder/assets/css/media/meta-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='awb-meta-sm-css' href='/theme/fusion-builder/assets/css/media/meta-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='awb-layout-colums-md-css' href='/theme/fusion-builder/assets/css/media/layout-columns-md.min.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='awb-layout-colums-sm-css' href='/theme/fusion-builder/assets/css/media/layout-columns-sm.min.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-max-1c-css' href='/theme/Avada/assets/css/media/max-1c.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-max-2c-css' href='/theme/Avada/assets/css/media/max-2c.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 712px)' />
    <link rel='stylesheet' id='avada-min-2c-max-3c-css' href='/theme/Avada/assets/css/media/min-2c-max-3c.min.css?ver=7.11.9' type='text/css' media='only screen and (min-width: 712px) and (max-width: 784px)' />
    <link rel='stylesheet' id='avada-min-3c-max-4c-css' href='/theme/Avada/assets/css/media/min-3c-max-4c.min.css?ver=7.11.9' type='text/css' media='only screen and (min-width: 784px) and (max-width: 856px)' />
    <link rel='stylesheet' id='avada-min-4c-max-5c-css' href='/theme/Avada/assets/css/media/min-4c-max-5c.min.css?ver=7.11.9' type='text/css' media='only screen and (min-width: 856px) and (max-width: 928px)' />
    <link rel='stylesheet' id='avada-min-5c-max-6c-css' href='/theme/Avada/assets/css/media/min-5c-max-6c.min.css?ver=7.11.9' type='text/css' media='only screen and (min-width: 928px) and (max-width: 1000px)' />
    <link rel='stylesheet' id='avada-min-shbp-css' href='/theme/Avada/assets/css/media/min-shbp.min.css?ver=7.11.9' type='text/css' media='only screen and (min-width: 801px)' />
    <link rel='stylesheet' id='avada-min-shbp-header-legacy-css' href='/theme/Avada/assets/css/media/min-shbp-header-legacy.min.css?ver=7.11.9' type='text/css' media='only screen and (min-width: 801px)' />
    <link rel='stylesheet' id='avada-max-shbp-css' href='/theme/Avada/assets/css/media/max-shbp.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 800px)' />
    <link rel='stylesheet' id='avada-max-shbp-header-legacy-css' href='/theme/Avada/assets/css/media/max-shbp-header-legacy.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 800px)' />
    <link rel='stylesheet' id='avada-max-sh-shbp-css' href='/theme/Avada/assets/css/media/max-sh-shbp.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 800px)' />
    <link rel='stylesheet' id='avada-max-sh-shbp-header-legacy-css' href='/theme/Avada/assets/css/media/max-sh-shbp-header-legacy.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 800px)' />
    <link rel='stylesheet' id='avada-min-768-max-1024-p-css' href='/theme/Avada/assets/css/media/min-768-max-1024-p.min.css?ver=7.11.9' type='text/css' media='only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait)' />
    <link rel='stylesheet' id='avada-min-768-max-1024-p-header-legacy-css' href='/theme/Avada/assets/css/media/min-768-max-1024-p-header-legacy.min.css?ver=7.11.9' type='text/css' media='only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait)' />
    <link rel='stylesheet' id='avada-min-768-max-1024-l-css' href='/theme/Avada/assets/css/media/min-768-max-1024-l.min.css?ver=7.11.9' type='text/css' media='only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape)' />
    <link rel='stylesheet' id='avada-min-768-max-1024-l-header-legacy-css' href='/theme/Avada/assets/css/media/min-768-max-1024-l-header-legacy.min.css?ver=7.11.9' type='text/css' media='only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape)' />
    <link rel='stylesheet' id='avada-max-sh-cbp-css' href='/theme/Avada/assets/css/media/max-sh-cbp.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 800px)' />
    <link rel='stylesheet' id='avada-max-sh-sbp-css' href='/theme/Avada/assets/css/media/max-sh-sbp.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 800px)' />
    <link rel='stylesheet' id='avada-max-sh-640-css' href='/theme/Avada/assets/css/media/max-sh-640.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='avada-max-shbp-18-css' href='/theme/Avada/assets/css/media/max-shbp-18.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 782px)' />
    <link rel='stylesheet' id='avada-max-shbp-32-css' href='/theme/Avada/assets/css/media/max-shbp-32.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 768px)' />
    <link rel='stylesheet' id='avada-min-sh-cbp-css' href='/theme/Avada/assets/css/media/min-sh-cbp.min.css?ver=7.11.9' type='text/css' media='only screen and (min-width: 800px)' />
    <link rel='stylesheet' id='avada-max-640-css' href='/theme/Avada/assets/css/media/max-640.min.css?ver=7.11.9' type='text/css' media='only screen and (max-device-width: 640px)' />
    <link rel='stylesheet' id='avada-max-main-css' href='/theme/Avada/assets/css/media/max-main.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1000px)' />
    <link rel='stylesheet' id='avada-max-cbp-css' href='/theme/Avada/assets/css/media/max-cbp.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 800px)' />
    <link rel='stylesheet' id='avada-max-sh-cbp-cf7-css' href='/theme/Avada/assets/css/media/max-sh-cbp-cf7.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 800px)' />
    <link rel='stylesheet' id='avada-max-640-sliders-css' href='/theme/Avada/assets/css/media/max-640-sliders.min.css?ver=7.11.9' type='text/css' media='only screen and (max-device-width: 640px)' />
    <link rel='stylesheet' id='avada-max-sh-cbp-sliders-css' href='/theme/Avada/assets/css/media/max-sh-cbp-sliders.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 800px)' />
    <link rel='stylesheet' id='avada-max-sh-cbp-social-sharing-css' href='/theme/Avada/assets/css/media/max-sh-cbp-social-sharing.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 800px)' />
    <link rel='stylesheet' id='fb-max-sh-cbp-css' href='/theme/fusion-builder/assets/css/media/max-sh-cbp.min.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 800px)' />
    <link rel='stylesheet' id='fb-min-768-max-1024-p-css' href='/theme/fusion-builder/assets/css/media/min-768-max-1024-p.min.css?ver=3.11.9' type='text/css' media='only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait)' />
    <link rel='stylesheet' id='fb-max-640-css' href='/theme/fusion-builder/assets/css/media/max-640.min.css?ver=3.11.9' type='text/css' media='only screen and (max-device-width: 640px)' />
    <link rel='stylesheet' id='fb-max-1c-css' href='/theme/fusion-builder/assets/css/media/max-1c.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 640px)' />
    <link rel='stylesheet' id='fb-max-2c-css' href='/theme/fusion-builder/assets/css/media/max-2c.css?ver=3.11.9' type='text/css' media='only screen and (max-width: 712px)' />
    <link rel='stylesheet' id='fb-min-2c-max-3c-css' href='/theme/fusion-builder/assets/css/media/min-2c-max-3c.css?ver=3.11.9' type='text/css' media='only screen and (min-width: 712px) and (max-width: 784px)' />
    <link rel='stylesheet' id='fb-min-3c-max-4c-css' href='/theme/fusion-builder/assets/css/media/min-3c-max-4c.css?ver=3.11.9' type='text/css' media='only screen and (min-width: 784px) and (max-width: 856px)' />
    <link rel='stylesheet' id='fb-min-4c-max-5c-css' href='/theme/fusion-builder/assets/css/media/min-4c-max-5c.css?ver=3.11.9' type='text/css' media='only screen and (min-width: 856px) and (max-width: 928px)' />
    <link rel='stylesheet' id='fb-min-5c-max-6c-css' href='/theme/fusion-builder/assets/css/media/min-5c-max-6c.css?ver=3.11.9' type='text/css' media='only screen and (min-width: 928px) and (max-width: 1000px)' />
    <link rel='stylesheet' id='avada-off-canvas-md-css' href='/theme/fusion-builder/assets/css/media/off-canvas-md.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 1024px)' />
    <link rel='stylesheet' id='avada-off-canvas-sm-css' href='/theme/fusion-builder/assets/css/media/off-canvas-sm.min.css?ver=7.11.9' type='text/css' media='only screen and (max-width: 640px)' />

    <script type="text/javascript" src="/js/jquery/jquery.min.js?ver=3.7.1" id="jquery-core-js"></script>
    <script type="text/javascript" src="/js/jquery/jquery-migrate.min.js?ver=3.4.1" id="jquery-migrate-js"></script>

    <link rel="stylesheet" href="/css/gallery.css?v=<?= esc((string) $galleryCssVersion) ?>">
    <link rel="stylesheet" href="/css/colorbox.css?v=<?= esc((string) $colorboxCssVersion) ?>">
    <script src="/js/jquery.colorbox-min.js?v=<?= esc((string) $colorboxJsVersion) ?>"></script>
</head>

<body class="page-template-default page page-id-18476 fusion-image-hovers fusion-body ltr fusion-sticky-header no-mobile-slidingbar no-mobile-totop fusion-disable-outline fusion-sub-menu-slide mobile-logo-pos-left layout-wide-mode fusion-top-header menu-text-align-center mobile-menu-design-modern fusion-show-pagination-text fusion-header-layout-v3 avada-responsive avada-footer-fx-sticky fusion-search-form-clean fusion-avatar-square">
<div id="wrapper" class="">
    <div id="home" style="position:relative;top:-1px;"></div>
