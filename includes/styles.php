<?php

(defined('ABSPATH')) || exit;

add_action('admin_enqueue_scripts', 'nasr_admin_script');

function nasr_admin_script()
{

    wp_enqueue_style(
        'nasr_admin',
        NASR_CSS . 'nasr_admin.css',
        [  ],
        NASR_VERSION
    );
    
    wp_enqueue_media();

    wp_enqueue_script(
        'nasr_admin',
        NASR_JS . 'nasr_admin.js',
        [ 'jquery' ],
        NASR_VERSION,
        true
    );

    wp_localize_script(
        'nasr_admin',
        'nasr_js',
        [
            'ajax_url' => admin_url('admin-ajax.php'),
         ]
    );

}
