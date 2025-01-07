<?php

$ostan_row = '<option value="0">انتخاب استان</option>';

$ostan = nasr_remote('https://api.mrrashidpour.com/iran/provinces.json');

if ($ostan[ 'code' ] == 0) {

    foreach ($ostan[ 'result' ] as $row) {
        $ostan_row .= '<option value="' . $row->id . '">' . $row->name . '</option>' . PHP_EOL;
    }

} else {
    $ostan_row .= '<option>مشکلی در بارگزاری پیش آمده</option>';
}

?>





<?php get_header();?>



<div class="row">
    <!-- Sidebar with image -->
    <nav class="w3-sidebar w3-hide-medium w3-hide-small" style="width:50%; top:0">
        <!-- w3-grayscale-min-->
        <div class="bgimg "></div>
    </nav>


    <!-- Page Content -->
    <div class="w3-main w3-padding-large" style="margin-left:50%">

        <!-- Menu icon to open sidebar -->

        <!-- Header -->
        <header class="w3-container w3-center" style="padding:30px 16px" id="home">

            <div style="text-align: justify;direction: rtl;"><?=$nasr_option[ 'form' ][ 'text' ]?> </div>

            <div class="counter-box">
                <div class="d-flex justify-content-between align-items-center nasr_count">
                    <span id="WCOUNT" class="persian-digit w3-text-gray counter-number">0</span>

                    <span class="counter-text">: تعداد کل شرکت‌کنندگان</span>
                </div>
                <img src="<?=nasr_panel_image('hezb.png')?>" alt="Background" class="counter-bg-image nasr-dn ">
            </div>
            <?=nasr_transient()?>

            <?php if (isset($_GET[ 'mytest' ])) {echo current_time('mysql');}?>
            <br>
            لطفا در فرم زیر بیانیه این درخواست را امضا نمایید
        </header>

        <img src="<?=wp_get_attachment_url($nasr_option[ 'images_logo' ])?>"
            class="  w3-image w3-hide-large w3-hide-small w3-round" style="display:block;width:60%;margin:auto;">
        <img src="<?=wp_get_attachment_url($nasr_option[ 'images_logo' ])?>" style="  border-radius: 20px;"
            class="  w3-image w3-hide-large w3-hide-medium w3-round" width="1000" height="1333">

        <!-- Comment Section -->
        <div class="w3-padding-32 w3-content" id="Comment" style="direction: rtl;">
            <p class="w3-right-align w3-text-gray">افزودن درخواست</p>
            <form action="/" method="POST" class="contact-form" dir="rtl" style="direction:rtl;">
                <?php wp_nonce_field('nasr_login_page' . nasr_cookie());?>

                <div class="w3-row-padding w3-margin-bottom" tabindex="0">
                    <div class="w3-col l6 s12 m6">
                        <input tabindex="2" style="direction:rtl"
                            class="w3-input w3-border w3-right-align w3-margin-bottom w3-round-small" type="text"
                            name="name" placeholder="*نام و نام خانوادگی" required>
                    </div>
                    <div class="w3-col l6 s12 m6">
                        <input tabindex="1" maxlength="11" style="direction:rtl"
                            class="w3-input w3-border w3-right-align w3-margin-bottom w3-round-small" type="text"
                            name="mob" placeholder="*شماره همراه" required>
                    </div>


                    <div class="w3-col l12 s12 m12 <?=(!$nasr_option[ 'form' ][ 'ostan' ]) ? ' nasr-dn' : ''?>">

                        <select name="user_ostan" id="user_ostan"
                            class="form-select w3-input w3-border w3-right-align w3-margin-bottom w3-round-small "
                            <?=($nasr_option[ 'form' ][ 'ostan_required' ] && $nasr_option[ 'form' ][ 'ostan' ]) ? 'required' : ''?>
                            tabindex="4" style="direction:rtl">
                            <?php echo $ostan_row; ?>
                        </select>
                    </div>

                    <div id="nasr-form-avatar"
                        class="w3-col l12 s12 m12 <?=(!$nasr_option[ 'form' ][ 'avatar' ]) ? ' nasr-dn' : ''?>">
                        <p style="color: #000;">
                            ابتدا جنسیت و سپس یک عکس برای خود انتخاب کنید:
                        </p>
                        <div class="avatar-tabs">
                            <div class="tabs">
                                <div class="tab-btn active" data-tab="male">آقا</div>
                                <div class="tab-btn" data-tab="female">خانم</div>
                            </div>
                            <div class="tab-content active" id="male">
                                <fieldset>

                                    <div class="avatars">
                                        <input type="radio" name="avatar" class="sr-only" id="ma" value="ma">
                                        <label for="ma">
                                            <img src="<?=nasr_panel_image('avatar/ma.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="mb" value="mb">
                                        <label for="mb">
                                            <img src="<?=nasr_panel_image('avatar/mb.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="mc" value="mc">
                                        <label for="mc">
                                            <img src="<?=nasr_panel_image('avatar/mc.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="md" value="md">
                                        <label for="md">
                                            <img src="<?=nasr_panel_image('avatar/md.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="me" value="me">
                                        <label for="me">
                                            <img src="<?=nasr_panel_image('avatar/me.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="mf" value="mf">
                                        <label for="mf">
                                            <img src="<?=nasr_panel_image('avatar/mf.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="mg" value="mg">
                                        <label for="mg">
                                            <img src="<?=nasr_panel_image('avatar/mg.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="mh" value="mh">
                                        <label for="mh">
                                            <img src="<?=nasr_panel_image('avatar/mh.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="mi" value="mi">
                                        <label for="mi">
                                            <img src="<?=nasr_panel_image('avatar/mi.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="mj" value="mj">
                                        <label for="mj">
                                            <img src="<?=nasr_panel_image('avatar/mj.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="mk" value="mk">
                                        <label for="mk">
                                            <img src="<?=nasr_panel_image('avatar/mk.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="ml" value="ml">
                                        <label for="ml">
                                            <img src="<?=nasr_panel_image('avatar/ml.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="mm" value="mm">
                                        <label for="mm">
                                            <img src="<?=nasr_panel_image('avatar/mm.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="mn" value="mn">
                                        <label for="mn">
                                            <img src="<?=nasr_panel_image('avatar/mn.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="mo" value="mo">
                                        <label for="mo">
                                            <img src="<?=nasr_panel_image('avatar/mo.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <!-- اضافه کردن آواتارهای دیگر -->
                                    </div>
                                </fieldset>
                            </div>
                            <div class="tab-content" id="female">
                                <fieldset>

                                    <div class="avatars">
                                        <input type="radio" name="avatar" class="sr-only" id="wa" value="wa">
                                        <label for="wa">
                                            <img src="<?=nasr_panel_image('avatar/wa.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wb" value="wb">
                                        <label for="wb">
                                            <img src="<?=nasr_panel_image('avatar/wb.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wc" value="wc">
                                        <label for="wc">
                                            <img src="<?=nasr_panel_image('avatar/wc.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wd" value="wd">
                                        <label for="wd">
                                            <img src="<?=nasr_panel_image('avatar/wd.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="we" value="we">
                                        <label for="we">
                                            <img src="<?=nasr_panel_image('avatar/we.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wf" value="wf">
                                        <label for="wf">
                                            <img src="<?=nasr_panel_image('avatar/wf.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wg" value="wg">
                                        <label for="wg">
                                            <img src="<?=nasr_panel_image('avatar/wg.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wh" value="wh">
                                        <label for="wh">
                                            <img src="<?=nasr_panel_image('avatar/wh.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wi" value="wi">
                                        <label for="wi">
                                            <img src="<?=nasr_panel_image('avatar/wi.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wj" value="wj">
                                        <label for="wj">
                                            <img src="<?=nasr_panel_image('avatar/wj.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wk" value="wk">
                                        <label for="wk">
                                            <img src="<?=nasr_panel_image('avatar/wk.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wl" value="wl">
                                        <label for="wl">
                                            <img src="<?=nasr_panel_image('avatar/wl.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wm" value="wm">
                                        <label for="wm">
                                            <img src="<?=nasr_panel_image('avatar/wm.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wn" value="wn">
                                        <label for="wn">
                                            <img src="<?=nasr_panel_image('avatar/wn.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                        <input type="radio" name="avatar" class="sr-only" id="wo" value="wo">
                                        <label for="wo">
                                            <img src="<?=nasr_panel_image('avatar/wo.jpg')?>" width="50" height="63"
                                                alt="male">
                                        </label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div id="nasr-form-description"
                        class="mb-3 <?=(!$nasr_option[ 'form' ][ 'description' ]) ? ' nasr-dn' : ''?>"
                        style="margin-bottom: 15px;">
                        <label for="textarea" class="form-label">پیام شما</label>
                        <textarea maxlength="150" name="description" class="form-control  nasr_textarea" id="textarea"
                            rows="5"></textarea>
                    </div>

                    <div id="nasr-form-signature"
                        class="w3-col l12 s12 m12 <?=(!$nasr_option[ 'form' ][ 'signature' ]) ? ' nasr-dn' : ''?>">
                        <label class="form-label">محل امضاء</label>


                        <div class="signatureBx row">
                            <canvas id="signatureCanvas" class="signature-pad"></canvas>
                            <button class="clear btn" id="clear" style="margin-bottom: 10px;" type="button"
                                onclick="clearCanvas()"><img style="width: 20px;"
                                    src="<?=nasr_panel_image('eraser.svg')?>"></button>
                        </div>
                        <input type="hidden" name="Comment" id="signature-data">

                        <button tabindex="5" class="w3-button w3-green w3-round-large w3-block margin-bottom "
                            type="submin" name="act" value="form___submin"> ثبت و ارسال امضا <img
                                style=" width: 26px; margin: 0;" src="<?=nasr_panel_image('arrow.svg')?>"></button>
                    </div>
                </div>
            </form>

            <div id="otpModal" class="w3-modal">
                <div class="w3-modal-content w3-animate-opacity w3-padding">
                    <h3>کد تایید را وارد کنید</h3>
                    <input id="otpInput" class="w3-input w3-border w3-margin-bottom" type="text" placeholder="کد تایید">
                    <button id="verifyOtpBtn" class="w3-button w3-green w3-round-large">تایید</button>
                    <button id="closeOtpModal" class="w3-button w3-red w3-round-large">بستن</button>
                    <br>

                </div>
            </div>
            <div id="alert_danger_in_allert" class="alert alert-danger nasr-dn" role="alert"></div>


        </div>


        <div class="w3-col l12 m12 s12 w3-margin-bottom">


            <div class="w3-display-container w3-padding w3-right-align  w3-xxlarge w3-block w3-round-small "
                style="height: 60px; border-radius: 15px;">

                <h5 class=" w3-right-align nasr_user_list">
                    <img src="<?=nasr_panel_image('refresh.svg')?>" class="nasr_refresh" id="rotatingImage">
                    شرکت کنندگان در پویش

                </h5>

            </div>
        </div>


        <!-- About Section -->
        <div class="w3-content w3-justify w3-text-grey w3-padding-32 w3-right-align w3-col l12 m12 s12 w3-margin-bottom"
            id="about">
        </div>
        <div class="text-center col col-ms-12  mb-3 ">
            <button id="loadmore" data-page="0" class="btn btn-success">نمایش بیشتر</button>
        </div>
    </div>
</div>

<?php get_footer();?>