<?php

(defined('ABSPATH')) || exit;

if (!class_exists('WP_List_Table')) {

    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';

}

class List_Table extends WP_List_Table
{

    private $all_results;
    private $par_page;
    private $numsql;
    private $m;

    public function get_columns()
    {
        return [
            'cb' => '<input type="checkbox" >',
            'nasr_row' => '#',
            'full_name' => 'نام و نام خانوادگی',
            'avatar' => 'تصویر',
            'mobile' => 'شماره موبایل',
            'ostan' => 'استان',
            'signature' => 'امضا',
            'description' => 'توضیحات',
            'created_at' => 'تاریخ ثبت',
            'status' => 'وضعیت',
            'nasr_update' => '',

         ];
    }

    public function column_default($item, $column_name)
    {

        if (isset($item[ $column_name ])) {
            return wp_kses($item[ $column_name ], [
                'span' => [  ],
             ]);
        }
        return '-';
    }
    public function column_cb($item)
    {

        return '<input type="checkbox" name="nasr_row[]" value = "' . $item[ 'ID' ] . '" >';
    }

    public function column_ostan($item)
    {

        $provinces = nasr_remote('https://api.mrrashidpour.com/iran/provinces.json');

        return ($provinces[ 'code' ] == 0 && absint($item[ 'ostan' ])) ? get_name_by_id($provinces[ 'result' ], absint($item[ 'ostan' ])) : 'نامعلوم';
    }

    public function column_avatar($item)
    {
        return sprintf('<img src="%s" style="height:50px;">', nasr_panel_image('avatar/' . $item[ 'avatar' ] . '.jpg'));
    }

    public function column_signature($item)
    {
        return sprintf('<img src="%s" style="border-radius: 10px;height: 50px;object-fit: cover;">', $item[ 'signature' ]);
    }

    public function column_status($item)
    {

        switch ($item[ 'status' ]) {
            case 'successful':
                $type = '<span class = "successful dashicons-before dashicons-yes-alt">تایید شده</span>';
                break;
            case 'waiting':
                $type = '<span class = "progress dashicons-before dashicons-warning">نا معلوم</span>';
                break;
            case 'failed':
                $type = '<span class="failed dashicons-before dashicons-dismiss">رد شده</span>';
                break;
            default:
                $type = '-';
                break;
        }

        return $type;
    }

    public function column_created_at($item)
    {
        return tarikh($item[ 'created_at' ]);
    }

    public function get_bulk_actions()
    {

        if (current_user_can('manage_options')) {
            $action[ 'successful' ] = 'تایید امضا';
            $action[ 'failed' ] = 'رد امضا';
            $action[ 'delete' ] = 'حذف امضا';
        }
        return $action;
    }

    public function column_nasr_row($item)
    {
        $this->m++;
        return $this->m;
    }
    public function column_nasr_update($item)
    {

        $nasr_update = '
            <button data-id="' . $item[ 'ID' ] . '" data-type="successful" class="button button-primary nasr_update_row">تایید امضا</button>
            <button data-id="' . $item[ 'ID' ] . '" data-type="failed" class="button action nasr_update_row">رد امضا</button>
            <button data-id="' . $item[ 'ID' ] . '" data-type="delete" class="button button-primary button-error nasr_update_row">حذف امضا</button>
        ';

        return $nasr_update;
    }

    public function no_items()
    {

        echo 'چیزی یافت نشد';

    }

    public function get_sortabele_colums()
    {

        // return [
        //     'amount' => [ 'amount', true ],
        //     'created_at' => [ 'created', true ],
        //  ];

    }

    public function process_table_data()
    {

        $nasrdb = new NasrDB();

        $par_page = 25;

        $offset = (isset($_GET[ 'paged' ])) ? ($par_page * absint($_GET[ 'paged' ])) - 1 : 0;

        $status = (isset($_GET[ 'status' ]) && $_GET[ 'status' ] != "all") ? sanitize_text_field($_GET[ 'status' ]) : "";

        $all_results = $nasrdb->select($par_page, $offset, $status);

        $this->all_results = $all_results;
        $this->par_page = $par_page;
        $this->numsql = $nasrdb->num();
        $this->m = $offset;

    }

    public function prepare_items()
    {

        $this->process_table_data();
        $this->process_bulk_action();

        $this->set_pagination_args([
            'total_items' => intval($this->numsql),
            'per_page' => $this->par_page,
         ]);
        $this->_column_headers = [
            $this->get_columns(),
            [  ],
            $this->get_sortabele_colums(),
            'full_name',
         ];
        $this->items = $this->all_results;

    }

    private function create_view($key, $label, $url, $count = 0)
    {
        $current_status = isset($_GET[ 'status' ]) ? $_GET[ 'status' ] : 'all';

        $view_tag = sprintf('<a href="%s" %s>%s</a>', $url, $current_status == $key ? 'class="current"' : '', $label);

        $view_tag .= sprintf('<span class="count">(%d)</span>', $count);

        return $view_tag;
    }

    protected function get_views()
    {

        $nasrdb = new NasrDB();

        return [
            'all' => $this->create_view('all', 'همه', admin_url('admin.php?page=nasr'), $nasrdb->num()),
            'successful' => $this->create_view('successful', 'تایید شده', admin_url('admin.php?page=nasr&status=successful'), $nasrdb->num('', 'successful')),
            'waiting' => $this->create_view('waiting', 'نامعلوم', admin_url('admin.php?page=nasr&status=waiting'), $nasrdb->num('', 'waiting')),
            'failed' => $this->create_view('failed', 'رد شده', admin_url('admin.php?page=nasr&status=failed'), $nasrdb->num('', 'failed')),
         ];
    }

    protected function extra_tablenav($which)
    {
        if ('top' === $which) {
            ?>
<!-- <div class="alignleft actions">
    <a href="<?php echo esc_url(add_query_arg('action', 'download_csv', get_current_relative_url())); ?>"
        class="button button-primary">دانلود CSV</a>
    <a href="<?php echo esc_url(add_query_arg('action', 'download_exel', get_current_relative_url())); ?>"
        class="button button-primary">دانلود exel</a>
</div> -->
<?php
}
    }

}