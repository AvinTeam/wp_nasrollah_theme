</div>


<script>
let nasr_ajax_url = '<?=admin_url('admin-ajax.php', 'https')?>';
let mat_ajaxnonce = '<?=wp_create_nonce('nasr-nonce-ajax' . nasr_cookie())?>';
</script>


<script src="<?=nasr_panel_js('dayjs.min.js')?>" charset="utf-8"></script>
<script src="<?=nasr_panel_js('nasr.js')?>" charset="utf-8"></script>

</body>


</html>