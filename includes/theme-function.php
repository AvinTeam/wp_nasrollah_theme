<?php

(defined('ABSPATH')) || exit;

function nasr_panel_js($path)
{
    return NASR_JS . $path;
}

function nasr_panel_css($path)
{
    return NASR_CSS . $path;
}

function nasr_panel_image($path)
{
    return NASR_IMAGE . $path;
}

function nasr_panel_php($path)
{
    return NASR_PHP . $path;
}

function nasr_remote(string $url)
{
    $res = wp_remote_get(
        $url,
        [
            'timeout' => 1000,
         ]);

    if (is_wp_error($res)) {
        $result = [
            'code' => 1,
            'result' => $res->get_error_message(),
         ];
    } else {
        $result = [
            'code' => 0,
            'result' => json_decode($res[ 'body' ]),
         ];
    }

    return $result;
}

function nasr_start_working(): array
{

    if (!isset($_GET[ 'avin_cron' ])) {
        nasr_cookie();
    }
    $nasr_option = get_option('nasr_option');

    if (!isset($nasr_option[ 'version' ]) || version_compare(NASR_VERSION, $nasr_option[ 'version' ], '>')) {

        update_option(
            'nasr_option',
            [
                'version' => NASR_VERSION,
                'tsms' => (isset($nasr_option[ 'tsms' ])) ? $nasr_option[ 'tsms' ] : [ 'username' => '', 'password' => '', 'number' => '' ],
                'ghasedaksms' => (isset($nasr_option[ 'ghasedaksms' ])) ? $nasr_option[ 'ghasedaksms' ] : [ 'ApiKey' => '', 'number' => '' ],
                'sms_text_otp' => (isset($nasr_option[ 'sms_text_otp' ])) ? $nasr_option[ 'sms_text_otp' ] : 'کد تأیید شما: %otp%',
                'set_timer' => (isset($nasr_option[ 'set_timer' ])) ? $nasr_option[ 'set_timer' ] : 1,
                'set_code_count' => (isset($nasr_option[ 'set_code_count' ])) ? $nasr_option[ 'set_code_count' ] : 4,
                'show_signature' => (isset($nasr_option[ 'show_signature' ])) ? $nasr_option[ 'show_signature' ] : 12,
                'start_signature' => (isset($nasr_option[ 'start_signature' ])) ? $nasr_option[ 'start_signature' ] : 0,
                'sms_type' => (isset($nasr_option[ 'sms_type' ])) ? $nasr_option[ 'sms_type' ] : 'tsms',
                'images_logo' => (isset($nasr_option[ 'images_logo' ])) ? intval($nasr_option[ 'images_logo' ]) : '/wp-content/themes/nasrollah/assets/image/wemen.jpg',
                'notificator_token' => (isset($nasr_option[ 'notificator_token' ])) ? $nasr_option[ 'notificator_token' ] : '',
                'target_word' => (isset($nasr_option[ 'target_word' ])) ? $nasr_option[ 'target_word' ] : 1,

             ]

        );

        // global $wpdb;
        // $tabel_nasr_row = $wpdb->prefix . 'nasr_row';

        // $sql = "ALTER TABLE `$tabel_nasr_row` ADD `type` VARCHAR(20) NOT NULL AFTER `status`;";

        // require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        // dbDelta($sql);

    }

    return get_option('nasr_option');

}

function nasr_update_option($data)
{

    $nasr_option = get_option('nasr_option');

    $nasr_option = [
        'version' => NASR_VERSION,
        'tsms' => (isset($data[ 'tsms' ])) ? $data[ 'tsms' ] : $nasr_option[ 'tsms' ],
        'ghasedaksms' => (isset($data[ 'ghasedaksms' ])) ? $data[ 'ghasedaksms' ] : $nasr_option[ 'ghasedaksms' ],
        'set_timer' => (isset($data[ 'set_timer' ])) ? absint($data[ 'set_timer' ]) : $nasr_option[ 'set_timer' ],
        'set_code_count' => (isset($data[ 'set_code_count' ])) ? absint($data[ 'set_code_count' ]) : $nasr_option[ 'set_code_count' ],
        'show_signature' => (isset($data[ 'show_signature' ])) ? $data[ 'show_signature' ] : $nasr_option[ 'show_signature' ],
        'start_signature' => (isset($data[ 'start_signature' ])) ? $data[ 'start_signature' ] : $nasr_option[ 'start_signature' ],
        'sms_text_otp' => (isset($data[ 'sms_text_otp' ])) ? sanitize_textarea_field($data[ 'sms_text_otp' ]) : $nasr_option[ 'sms_text_otp' ],
        'sms_type' => (isset($data[ 'sms_type' ])) ? sanitize_text_field($data[ 'sms_type' ]) : $nasr_option[ 'sms_type' ],
        'images_logo' => (isset($data[ 'images_logo' ])) ? intval($data[ 'images_logo' ]) : $nasr_option[ 'images_logo' ],
        'notificator_token' => (isset($data[ 'notificator_token' ])) ? sanitize_text_field($data[ 'notificator_token' ]) : $nasr_option[ 'notificator_token' ],
        'target_word' => (isset($data[ 'target_word' ])) ? $data[ 'target_word' ] : $nasr_option[ 'target_word' ],

     ];

    update_option('nasr_option', $nasr_option);

}

function nasr_massage_otp($otp)
{
    global $nasr_option;

    $server_name = $_SERVER[ 'SERVER_NAME' ];

    $finalMessage = str_replace('%otp%', $otp, $nasr_option[ 'sms_text_otp' ]);

    //$massage = $finalMessage . PHP_EOL . "@" . $server_name . " #" . $otp;
    $massage = $finalMessage;

    return $massage;

}

function nasr_massage_format($data)
{
    global $nasr_option;
    $server_name = $_SERVER[ 'SERVER_NAME' ];

    $finalMessage = str_replace([ '%username%', '%password%', '%url%' ], $data, $nasr_option[ 'sms_text_format' ]);
    $massage = $finalMessage . PHP_EOL . $server_name;

    return $massage;

}

function notificator($mobile, $massage)
{
    global $nasr_option;

    $data = [
        'to' => $nasr_option[ 'notificator_token' ],
        'text' => $mobile . PHP_EOL . $massage,
     ];

    // درخواست POST با wp_remote_post
    $response = wp_remote_post('https://notificator.ir/api/v1/send', [
        'body' => $data,
     ]);

    $result = json_decode(wp_remote_retrieve_body($response));

    $result = [
        'code' => $result->success,
        'massage' => ($result->success) ? 'پیام با موفقیت ارسال شد' : 'پیام به خطا خورده است ',
     ];

    return $result;

}

function tsms($mobile, $massage)
{

    global $nasr_option;

    $msg_array = [ $massage ];

    $data = [
        'method' => 'sendSms',
        'username' => $nasr_option[ 'tsms' ][ 'username' ],
        'password' => $nasr_option[ 'tsms' ][ 'password' ],
        'sms_number' => array($nasr_option[ 'tsms' ][ 'number' ]),
        'mobile' => [ $mobile ],
        'msg' => $msg_array,
        'mclass' => array(''),
        'messagid' => rand(),
     ];

    $response = wp_remote_post('https://www.tsms.ir/json/json.php', [
        'body' => http_build_query($data),
     ]);

    $response = json_decode(wp_remote_retrieve_body($response));

    $result = [
        'code' => ($response->code == 200) ? 1 : $response->code,
        'massage' => ($response->code == 200) ? 'پیام با موفقیت ارسال شد' : 'پیام به خطا خورده است',
     ];
    return $result;

}

function ghasedaksms($mobile, $massage)
{

    global $nasr_option;
    $data = [
        'message' => $massage,
        'sender' => $nasr_option[ 'ghasedaksms' ][ 'number' ],
        'receptor' => $mobile,
     ];
    $header = [
        'ApiKey' => $nasr_option[ 'ghasedaksms' ][ 'ApiKey' ],
     ];

    $response = wp_remote_post('http://api.ghasedaksms.com/v2/sms/send/bulk2', [
        'headers' => $header,
        'body' => http_build_query($data),
     ]);

    $response = json_decode(wp_remote_retrieve_body($response));

    $result = [
        'code' => ($response->result == 'success' && strlen($response->messageids) > 5) ? 1 : $response->messageids,
        'massage' => ($response->result == 'success' && strlen($response->messageids) > 5) ? 'پیام با موفقیت ارسال شد' : 'پیام به خطا خورده است',
     ];
    return $result;

}

function nasr_send_sms($mobile, $type, $data = [  ])
{

    global $nasr_option;
    $massage = '';

    $result = [
        'code' => 0,
        'massage' => $mobile,
     ];

    // بررسی فرمت شماره موبایل
    if (!preg_match('/^09[0-9]{9}$/', $mobile)) {
        $result = [
            'code' => -1,
            'massage' => 'شماره موبایل معتبر نیست.',
         ];
    }

    if ($type == 'otp') {
        if (get_transient('otp_' . $mobile)) {
            $result = [
                'code' => -2,
                'massage' => 'لطفا چند دقیقه دیگر تلاش کنید.',
             ];
        }

        $otp = '';

        for ($i = 0; $i < $nasr_option[ 'set_code_count' ]; $i++) {
            $otp .= rand(0, 9);
        }
        set_transient('otp_' . $mobile, $otp, $nasr_option[ 'set_timer' ] * MINUTE_IN_SECONDS);

        if ($result[ 'code' ] == 0) {
            $result = $nasr_option[ 'sms_type' ]($mobile, nasr_massage_otp($otp));
            if ($result[ 'code' ] != 1) {
                delete_transient('otp_' . $mobile);

            }

        }
    }

    if ($type == 'fornasr_art') {
        $result = $nasr_option[ 'sms_type' ]($mobile, nasr_massage_format($data));

    }

    return $result;
}
function sanitize_phone($phone)
{

    /**
     * Convert all chars to en digits
     */
    $western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $persian = [ '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' ];
    $arabic = [ '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' ];
    $phone = str_replace($persian, $western, $phone);
    $phone = str_replace($arabic, $western, $phone);

    //.9158636712   => 09158636712
    if (strpos($phone, '.') === 0) {
        $phone = '0' . substr($phone, 1);
    }

    //00989185223232 => 9185223232
    if (strpos($phone, '0098') === 0) {
        $phone = substr($phone, 4);
    }
    //0989108210911 => 9108210911
    if (strlen($phone) == 13 && strpos($phone, '098') === 0) {
        $phone = substr($phone, 3);
    }
    //+989156040160 => 9156040160
    if (strlen($phone) == 13 && strpos($phone, '+98') === 0) {
        $phone = substr($phone, 3);
    }
    //+98 9156040160 => 9156040160
    if (strlen($phone) == 14 && strpos($phone, '+98 ') === 0) {
        $phone = substr($phone, 4);
    }
    //989152532120 => 9152532120
    if (strlen($phone) == 12 && strpos($phone, '98') === 0) {
        $phone = substr($phone, 2);
    }
    //Prepend 0
    if (strpos($phone, '0') !== 0) {
        $phone = '0' . $phone;
    }
    /**
     * check for all character was digit
     */
    if (!ctype_digit($phone)) {
        return '';
    }

    if (strlen($phone) != 11) {
        return '';
    }

    return $phone;

}

function nasr_cookie(): string
{

    if (!isset($_COOKIE[ "setcookie_nasr_nonce" ])) {

        $is_key_cookie = nasr_rand_string(15);
        ob_start();

        setcookie("setcookie_nasr_nonce", $is_key_cookie, time() + 1800, "/");

        ob_end_flush();

        header("Refresh:0");
        exit;

    } else {
        $is_key_cookie = $_COOKIE[ "setcookie_nasr_nonce" ];
    }

    return $is_key_cookie;
}

function nasr_rand_string($length = 20)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // اعداد و حروف
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[ rand(0, $charactersLength - 1) ];
    }
    return $randomString;
}

function nasr_mask_mobile($mobile)
{
    // بررسی طول شماره موبایل
    if (strlen($mobile) === 11) {
        $lastFour = substr($mobile, -4); // گرفتن 4 رقم آخر

        $masked = $lastFour . "*****" . substr($mobile, 0, 4);

        return $masked;
    }
    return "شماره موبایل نامعتبر است.";
}

function tarikh($data, $time = "")
{
    $data1 = "";
    if (!empty($data)) {
        $arr = explode(" ", $data);
        $data = $arr[ 0 ];

        $arrayData = [ '/', '-' ];

        foreach ($arrayData as $arrayData) {
            $x = explode($arrayData, $data);
            if (sizeof($x) == 3) {

                list($gy, $gm, $gd) = explode($arrayData, $data);

                if ($arrayData == '/') {
                    $tagir = '-';
                    $chen = 'jalali_to_gregorian';
                }
                if ($arrayData == '-') {
                    $tagir = '/';
                    $chen = 'gregorian_to_jalali';
                }

                $data1 = $chen($gy, $gm, $gd, $tagir);

                break;
            }

        }

        if ($time == "d") {
            $data1 = $data1;
        } elseif ($time == "t") {
            $data1 = $arr[ 1 ];
        } else {
            $data1 = $data1 . " " . $arr[ 1 ];
        }
    }
    return $data1;
}

function get_current_relative_url()
{
    // گرفتن مسیر فعلی بدون دامنه
    $path = esc_url_raw(wp_unslash($_SERVER[ 'REQUEST_URI' ]));

    // حذف دامنه و فقط نگه داشتن مسیر نسبی + پارامترها
    $relative_url = strtok($path, '?'); // مسیر قبل از پارامترها
    $query_string = $_SERVER[ 'QUERY_STRING' ]; // پارامترهای GET

    // اگر پارامتر وجود داره، به مسیر اضافه کن
    if ($query_string) {
        $relative_url .= '?' . $query_string;
    }

    return $relative_url;
}

function get_name_by_id($data, $id)
{
    $filtered = array_filter($data, function ($item) use ($id) {
        return $item->id == $id;
    });

    // برگرداندن اولین مقدار پیدا شده
    if (!empty($filtered)) {
        return array_values($filtered)[ 0 ]->name;
    }
    return null;
}

function nasr_transient()
{
    $nasr_transient = get_transient('nasr_transient');

    if ($nasr_transient) {
        delete_transient('nasr_transient');
        return $nasr_transient;
    }

}

function nasr_to_enghlish($text)
{

    $western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $persian = [ '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' ];
    $arabic = [ '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' ];
    $text = str_replace($persian, $western, $text);
    $text = str_replace($arabic, $western, $text);
    return $text;

}
