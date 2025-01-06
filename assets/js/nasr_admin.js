jQuery(document).ready(function ($) {

    let clickNasrUpdateRow = true;


    $('.nasr_update_row').click(function (e) {

        e.preventDefault();


        if (clickNasrUpdateRow) {

            clickNasrUpdateRow = false;

            let dataId = $(this).attr('data-id');
            let dataType = $(this).attr('data-type');

            $.ajax({
                type: "post",
                async: false,
                url: nasr_js.ajax_url,
                dataType: "json",
                data: {
                    action: 'nasr_update_row',
                    dataId: dataId,
                    dataType: dataType,

                },
                beforeSend: function () {
                    $('.nasr-loader').show();
                },
                success: function (response) {
                    location.reload(true);

                    console.log(response);
                },
                error: function (response) {
                    console.error(response);


                },
            });

        }





    });



    var background_uploader;
    $('.select_images').click(function (e) {
        e.preventDefault();


        const _this = this;

        if (background_uploader !== undefined) {
            background_uploader.open();
            return;
        }

        background_uploader = wp.media({
            title: 'انتخاب تصویر',
            button: {
                text: 'انتخاب',
            },
            library: {
                type: ['image']
            }

        })


        background_uploader.on('select', function () {
            let selected = background_uploader.state().get('selection');
            let matArtFile = selected.first().toJSON();
            $(_this).parent('.nasr-logo').find('input').val(matArtFile.id);
            $(_this).parent('.nasr-logo').find('img').attr('src', matArtFile.url);


        });


        background_uploader.open();



    });









});