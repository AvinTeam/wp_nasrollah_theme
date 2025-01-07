<?php
(defined('ABSPATH')) || exit;
global $title;

?>

<div id="wpbody-content">
    <div class="wrap">
        <h1><?php echo esc_html($title) ?></h1>


        <hr class="wp-header-end">

        <?php if ($error = get_transient('error_mat')) {?>
        <div class="notice notice-error settings-error is-dismissible">
            <p><?php echo esc_html($error); ?></p>
        </div>
        <?php set_transient('error_mat', '');}?>

        <?php if ($success = get_transient('success_mat')) {?>
        <div class="notice notice-success settings-error is-dismissible">
            <p><?php echo esc_html($success); ?></p>
        </div>
        <?php set_transient('success_mat', '');}?>

        <form method="post" action="" novalidate="novalidate" class="ag_form">
            <?php wp_nonce_field('nasr_nonce' . get_current_user_id());?>
            <table class="form-table" role="presentation">
                <tbody>

                    <tr>
                        <th scope="row"><label for="ostan">نمایش استان </label></th>
                        <td>
                            <fieldset>
                                <label for="ostan">
                                    <input name="form[ostan]" type="checkbox" id="ostan" value="1"
                                        <?php if ($nasr_option[ 'form' ][ 'ostan' ]) {echo 'checked="checked"';}?>>استان
                                    نمایش داده شود</label>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">استان ضروری</th>
                        <td>
                            <fieldset>
                                <input name="form[ostan_required]" type="checkbox" id="ostan_required" value="1"
                                    <?php if ($nasr_option[ 'form' ][ 'ostan_required' ]) {echo 'checked="checked"';}?>>ارسال استان ضروری باشد</label>

                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="avatar">نمایش جنسیت </label></th>
                        <td>
                            <fieldset>
                                <label for="avatar">
                                    <input name="form[avatar]" type="checkbox" id="avatar" value="1"
                                        <?php if ($nasr_option[ 'form' ][ 'avatar' ]) {echo 'checked="checked"';}?>>جنسیت
                                    نمایش داده شود</label>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="description">نمایش توضیحات </label></th>
                        <td>
                            <fieldset>
                                <label for="description">
                                    <input name="form[description]" type="checkbox" id="description" value="1"
                                        <?php if ($nasr_option[ 'form' ][ 'description' ]) {echo 'checked="checked"';}?>>توضیحات
                                    نمایش داده شود</label>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="signature">نمایش توضیحات </label></th>
                        <td>
                            <fieldset>
                                <label for="signature">
                                    <input name="form[signature]" type="checkbox" id="signature" value="1"
                                        <?php if ($nasr_option[ 'form' ][ 'signature' ]) {echo 'checked="checked"';}?>>امضا
                                    نمایش داده شود</label>
                            </fieldset>
                        </td>
                    </tr>


                    <tr>
                        <th scope="row"><label for="sms_text_otp">متن </label></th>
                        <td>
                            <?php

$editor_array = [
    'media_buttons' => false,
    'textarea_name' => 'form[text]',
    'tinymce' => [
        'wpautop' => true,
        'force_p_newlines' => true,
        'br_in_pre' => true,
        'valid_elements' => '*[*]',
        'extended_valid_elements' => 'p[*],br[*],span[*]',
        'remove_linebreaks' => false,

     ],
 ];

wp_editor($nasr_option[ 'form' ][ 'text' ], 'form_text', $editor_array)?>
                        </td>
                    </tr>



















                </tbody>
            </table>


            <p class="submit">
                <button type="submit" name="nasr_act" value="nasr__submit" id="submit"
                    class="button button-primary">ذخیرهٔ
                    تغییرات</button>
            </p>
        </form>

    </div>


    <div class="clear"></div>
</div>