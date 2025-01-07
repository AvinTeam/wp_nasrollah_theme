<?php
global $nasr_option;


?><!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta http-equiv="refresh" content="360" />
    <title><?php wp_title('|', true, 'right');?></title>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=nasr_panel_css('w3schools.css')?>">
    <link rel="stylesheet" href="<?=nasr_panel_css('bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=nasr_panel_css('nasr.css')?>">

    <script src="<?=nasr_panel_js('jquery.min.js')?>"></script>
    <script src="<?=nasr_panel_js('animationCounter.js')?>" charset="utf-8"></script>
    <script src="<?=nasr_panel_js('persianumber.js')?>" charset="utf-8"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="<?=esc_url(get_site_icon_url())?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=esc_url(get_site_icon_url(32))?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=esc_url(get_site_icon_url(16))?>">
    <link rel="manifest" href="<?=esc_url(get_site_icon_url())?>">
    <link rel="mask-icon" href="<?=esc_url(get_site_icon_url())?>" color="#c5a049">
    <link rel="shortcut icon" href="<?=esc_url(get_site_icon_url())?>">
    <meta name="msapplication-TileColor" content="#141414">
    <meta name="theme-color" content="#c5a049">


    <style>
    .bgimg {
        background-image: url('<?=wp_get_attachment_url($nasr_option[ 'images_logo' ])?>');
    }
    </style>
    <style id="antiClickjack">
    body {
        display: none !important;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <header class="headertop d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <!-- دکمه‌ای که فقط در دسکتاپ نمایش داده می‌شود -->
                <button id="copyButton" class="share-buttonh me-3 d-none d-md-block">
                    <span>کپی کردن لینک این صفحه</span>
                </button>
                <div class="logo"><?= bloginfo('name') ?> </div>
            </div>
        </header>
