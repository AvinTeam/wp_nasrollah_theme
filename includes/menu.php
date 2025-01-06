<?php
(defined('ABSPATH')) || exit;

add_action('admin_menu', 'mph_admin_menu');

/**
 * Fires before the administration menu loads in the admin.
 *
 * @param string $context Empty context.
 */
function mph_admin_menu(string $context): void
{

    $menu_suffix = add_menu_page(
        'نصرالله',
        'نصرالله',
        'manage_options',
        'nasr',
        'nasr_menu_callback',
        'dashicons-hammer',
        55
    );

    add_submenu_page(
        'nasr',
        'لیست',
        'لیست',
        'manage_options',
        'nasr',
        'nasr_menu_callback',
    );

    function nasr_menu_callback()
    {
        $nasr_option = nasr_start_working();

        $nasrListTable = new List_Table;

        require_once NASR_VIEWS . 'list.php';

    }

    $setting_suffix = add_submenu_page(
        'nasr',
        'تنظیمات',
        'تنظیمات',
        'manage_options',
        'setting_panels',
        'setting_panels',
    );

    function setting_panels()
    {
        $nasr_option = nasr_start_working();

        require_once NASR_VIEWS . 'setting.php';

    }

    $sms_panels_suffix = add_submenu_page(
        'nasr',
        'تنظیمات پنل پیامک',
        'تنظیمات پنل پیامک',
        'manage_options',
        'sms_panels',
        'nasr_sms_panels',
    );

    function nasr_sms_panels()
    {
        $nasr_option = nasr_start_working();

        require_once NASR_VIEWS . 'setting_sms_panels.php';

    }

    add_action('load-' . $menu_suffix, 'nasr__list');
    add_action('load-' . $setting_suffix, 'nasr__submit');
    add_action('load-' . $sms_panels_suffix, 'nasr__submit');

    function nasr__list()
    {

        if (isset($_POST[ 'action2' ]) && in_array($_POST[ 'action2' ], [ 'successful', 'failed', 'delete' ])) {

            $nasrdb = new NasrDB();

            if (sanitize_text_field($_POST[ 'action2' ]) == 'delete') {

                foreach ($_POST[ 'nasr_row' ] as $row) {
                    $delete_row = $nasrdb->delete(intval($row));

                }

            } else {

                foreach ($_POST[ 'nasr_row' ] as $row) {
                    $data = [ 'status' => sanitize_text_field($_POST[ 'action2' ]) ];
                    $where = [ 'ID' => intval($row) ];
                    $format = [ '%s' ];
                    $where_format = [ '%d' ];

                    $nasrdb->update($data, $where, $format, $where_format);
                }

            }

        }

    }

    function nasr__submit()
    {

        if (isset($_POST[ 'nasr_act' ]) && $_POST[ 'nasr_act' ] == 'nasr__submit') {

            if (wp_verify_nonce($_POST[ '_wpnonce' ], 'nasr_nonce' . get_current_user_id())) {
                if (isset($_POST[ 'tsms' ])) {
                    $_POST[ 'tsms' ] = array_map('sanitize_text_field', $_POST[ 'tsms' ]);
                }
                if (isset($_POST[ 'ghasedaksms' ])) {
                    $_POST[ 'ghasedaksms' ] = array_map('sanitize_text_field', $_POST[ 'ghasedaksms' ]);
                }

                nasr_update_option($_POST);

                set_transient('success_mat', 'تغییر با موفقیت ثبت شد');

            } else {
                set_transient('error_mat', 'ذخیره سازی به مشکل خورده دوباره تلاش کنید');

            }

        }

    }

}