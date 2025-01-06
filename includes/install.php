<?php

(defined('ABSPATH')) || exit;
function nasr_row_install()
{

    $config_path = ABSPATH . 'wp-config.php';

    // بررسی کن که فایل wp-config.php موجود باشه و قابل نوشتن
    if (file_exists($config_path) && is_writable($config_path)) {
        $config_content = file_get_contents($config_path);

        // بررسی کن که کد قبلاً اضافه نشده باشه
        if (strpos($config_content, "define('DISABLE_WP_CRON', true);") === false) {
            // خط جدیدی که باید اضافه بشه
            $new_code = "define('DISABLE_WP_CRON', true);";

            // اضافه کردن کد قبل از خط "That's all, stop editing! Happy publishing."
            $updated_content = str_replace(
                "/* That's all, stop editing! Happy publishing. */",
                "$new_code\n\n/* That's all, stop editing! Happy publishing. */",
                $config_content
            );

            // ذخیره فایل با تغییرات جدید
            file_put_contents($config_path, $updated_content);
        }
    }

    $timestamp = wp_next_scheduled('avin_it_cron_job');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'avin_it_cron_job');
    }

    global $wpdb;
    $tabel_nasr_row = $wpdb->prefix . 'nasr_row';
    $wpdb_collate_nasr_row = $wpdb->collate;
    $sql = "CREATE TABLE IF NOT EXISTS `$tabel_nasr_row` (
            `ID` bigint unsigned NOT NULL AUTO_INCREMENT,
            `full_name` varchar(50) CHARACTER SET utf8mb4 COLLATE $wpdb_collate_nasr_row NOT NULL DEFAULT '',
            `mobile` varchar(11) COLLATE $wpdb_collate_nasr_row NOT NULL,
            `avatar` varchar(20) CHARACTER SET utf8mb4 COLLATE $wpdb_collate_nasr_row NOT NULL DEFAULT 'no',
            `ostan` int NOT NULL DEFAULT '0',
            `description` text COLLATE $wpdb_collate_nasr_row,
            `signature` longtext CHARACTER SET utf8mb4 COLLATE $wpdb_collate_nasr_row,
            `status` varchar(20) COLLATE $wpdb_collate_nasr_row NOT NULL,
            `created_at` timestamp NOT NULL,
            PRIMARY KEY (`ID`),
            UNIQUE KEY `mobile` (`mobile`)
            ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=$wpdb_collate_nasr_row";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta($sql);

}

add_action('after_switch_theme', 'nasr_row_install');
