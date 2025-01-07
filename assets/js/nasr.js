const copyButton = document.getElementById('copyButton');

const textToCopy = window.location.href;

copyButton.addEventListener('click', () => {


    navigator.clipboard.writeText(textToCopy).then(() => {

        const originalText = copyButton.textContent;
        copyButton.innerHTML = "<span>کپی شد</span>";

        setTimeout(() => {
            copyButton.textContent = originalText;
        }, 1000);


    }).catch(err => {

        console.error('خطا:', err);
    });

});


const canvas = document.getElementById("signatureCanvas");
const ctx = canvas.getContext("2d");
let isDrawing = false;
let lastX = 0;
let lastY = 0;

canvas.addEventListener("mousedown", startDrawing);
canvas.addEventListener("mouseup", stopDrawing);
canvas.addEventListener("mousemove", draw);

canvas.addEventListener("touchstart", startDrawing, { passive: true });
canvas.addEventListener("touchend", stopDrawing, { passive: true });
canvas.addEventListener("touchmove", draw, { passive: true });

// function startDrawing(e) {
//     isDrawing = true;
//     ctx.beginPath();
//     const { x, y } = getCursorPosition(e);
//     ctx.moveTo(x, y);
// }

// function stopDrawing() {
//     isDrawing = false;
// }

// function draw(e) {
//     if (!isDrawing) return;
//     const { x, y } = getCursorPosition(e);
//     ctx.lineWidth = 1;
//     ctx.lineCap = "round";
//     ctx.strokeStyle = "#000";
//     ctx.lineTo(x, y);
//     ctx.stroke();
// }

// function getCursorPosition(e) {
//     const rect = canvas.getBoundingClientRect(); // اندازه ظاهری canvas
//     const scaleX = canvas.width / rect.width; // نسبت عرض
//     const scaleY = canvas.height / rect.height; // نسبت ارتفاع

//     if (e.touches) {
//         return {
//             x: (e.touches[0].clientX - rect.left) * scaleX,
//             y: (e.touches[0].clientY - rect.top) * scaleY,
//         };
//     } else {
//         return {
//             x: (e.clientX - rect.left) * scaleX,
//             y: (e.clientY - rect.top) * scaleY,
//         };
//     }
// }

// function getCursorPosition(e) {
//     const rect = e.target.getBoundingClientRect();
//     return {
//         x: e.clientX - rect.left,
//         y: e.clientY - rect.top
//     };
// }
// 
// 
function getCursorPosition(e) {
    const rect = canvas.getBoundingClientRect(); // اندازه ظاهری canvas
    const scaleX = canvas.width / rect.width; // نسبت عرض
    const scaleY = canvas.height / rect.height; // نسبت ارتفاع

    if (e.touches) {
        return {
            x: (e.touches[0].clientX - rect.left) * scaleX,
            y: (e.touches[0].clientY - rect.top) * scaleY,
        };
    } else {
        return {
            x: (e.clientX - rect.left) * scaleX,
            y: (e.clientY - rect.top) * scaleY,
        };
    }
}

function startDrawing(e) {
    isDrawing = true;
    const { x, y } = getCursorPosition(e);
    lastX = x;
    lastY = y;
    ctx.beginPath(); // Start a new path
    ctx.moveTo(lastX, lastY); // Move to the starting point
}

function interpolateLine(x1, y1, x2, y2) {
    const distance = Math.hypot(x2 - x1, y2 - y1);
    const steps = Math.ceil(distance / 2); // Define the number of steps for interpolation
    const points = [];
    for (let i = 1; i <= steps; i++) {
        const t = i / steps;
        const interpolatedX = x1 + t * (x2 - x1);
        const interpolatedY = y1 + t * (y2 - y1);
        points.push({ x: interpolatedX, y: interpolatedY });
    }
    return points;
}

function draw(e) {
    if (!isDrawing) return;

    const { x, y } = getCursorPosition(e);

    // Interpolate points to fill gaps
    const interpolatedPoints = interpolateLine(lastX, lastY, x, y);

    interpolatedPoints.forEach(({ x, y }) => {
        ctx.lineTo(x, y);
        ctx.strokeStyle = "#000"; // Black color
        ctx.lineWidth = 3; // Line thickness
        ctx.lineCap = "round"; // Smooth line ends
        ctx.stroke();
        ctx.beginPath(); // Prevent sharp edges
        ctx.moveTo(x, y);
    });

    // Update last position
    lastX = x;
    lastY = y;
}

function stopDrawing() {
    isDrawing = false;
}


function clearCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

document.querySelectorAll('.tab-btn').forEach(button => {
    button.addEventListener('click', (event) => {
        event.preventDefault(); // جلوگیری از رفتار پیش‌فرض
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');
        const target = button.getAttribute('data-tab');

        tabs.forEach(tab => tab.classList.remove('active'));
        contents.forEach(content => content.classList.remove('active'));

        button.classList.add('active');
        document.getElementById(target).classList.add('active');
    });
});

document.querySelector('input[name="mob"]').addEventListener('input', function (e) {
    // فقط اعداد مجاز هستند
    this.value = this.value.replace(/[^0-9]/g, '');
});

document.querySelector('input[name="name"]').addEventListener('input', function (e) {
    // فقط حروف فارسی، انگلیسی و فاصله مجاز هستند
    this.value = this.value.replace(/[^آ-یA-Za-z\s]/g, '');
});

$(document).ready(function () {

    if (navigator.onLine) {

    } else {
        $('#WCOUNT').html("<small>اتصال خود را بررسی کنید ...</small>")
    }

});

document.querySelector('form.contact-form').addEventListener('submit', function (e) {
    let error = 0;
    let error_massage = '';

    const dataURL = canvas.toDataURL("image/png");

    const input = document.querySelector("#signature-data");
    input.value = dataURL;

    e.preventDefault();

    let mobile = document.querySelector('input[name="mob"]').value.trim();
    let name = document.querySelector('input[name="name"]').value.trim();
    let avatar = document.querySelector('input[name="avatar"]').value.trim();
    let Comment = document.querySelector('input[name="Comment"]').value.trim();




    const userOstan = document.getElementById("user_ostan");

    if (userOstan.hasAttribute("required")) {
        if (userOstan.value == 0) {
            error_massage = "لطفاً یک استان انتخاب کنید!";
            error = 1;
        }
    }





    let wpnonce = $('#_wpnonce').val();


    if (!name) {
        error_massage = 'لطفاً نام و نام خانوادگی را وارد کنید.';
        error = 1;

    }


    // if (!avatar) {
    //     error_massage = 'لطفاً عکس خود را انخاب کنید.';
    //     error = 1;

    // }



    // if (empty(Comment)) {
    //     error_massage = 'لطفاً امضای کنید.';
    //     error = 1;

    // }


    // const regex_mobile = /^09(1[0-9]|2[0-9]|3[0-9]|9[0-9]|0[1-9])-?[0-9]{7}$/;

    mobile = mobile.replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d));
    mobile = mobile.replace(/\s+/g, '');

    if (mobile === '') {
        error_massage += '<br> لطفاً شماره موبایل خود را وارد کنید.';
        error = 1;
    }


    // else if (!regex_mobile.test(mobile)) {
    //     error_massage += 'لطفاً شماره موبایل خود را به درستی وارد کنید.';
    //     error = 1;
    // }

    if (window.isOtpSent) {
        return;
    }



    if (error == 0) {

        window.isOtpSent = true;
        const formData = {
            action: 'nasr_sent_sms',
            mobileNumber: mobile,
            wpnonce: wpnonce,
        };

        $.ajax({
            url: nasr_ajax_url,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                document.getElementById('otpModal').style.display = 'block';
            },
            error: function (response) {
                window.isOtpSent = false;
                $('#alert_danger_in_allert').removeClass('nasr-dn');
                $('#alert_danger_in_allert').text(response.responseJSON.data || 'خطا در ارسال کد تایید');
            },
        });

    } else {
        $('#alert_danger_in_allert').removeClass('nasr-dn');
        $('#alert_danger_in_allert').html(error_massage);
    }

});

isOtpVerified = false;
document.getElementById('verifyOtpBtn').addEventListener('click', function () {

    const otpNumber = document.getElementById('otpInput').value.trim();
    const mobile = document.querySelector('input[name="mob"]').value.trim();

    let wpnonce = $('#_wpnonce').val();

    if (otpNumber != "") {

        $('#alert_success').addClass('nasr-dn');
        $('#alert_success').text('');

        const formData = {
            action: 'nasr_sent_verify',
            mobileNumber: mobile,
            otpNumber: otpNumber,
            wpnonce: wpnonce,
        };

        $.ajax({
            url: nasr_ajax_url,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                document.getElementById('otpModal').style.display = 'none';
                document.querySelector('form.contact-form').submit();
            },
            error: function (response) {

                $('#alert_danger_in_allert').removeClass('nasr-dn');
                $('#alert_danger_in_allert').text(response.responseJSON.data);
            }
        });
    } else {


        $('#alert_danger_in_allert').removeClass('nasr-dn');
        $('#alert_danger_in_allert').text(' رمز یکبار مصرف را وارد کنید');
    }


});

// بستن مودال
document.getElementById('closeOtpModal').addEventListener('click', function () {
    document.getElementById('otpModal').style.display = 'none';
    window.isOtpSent = false; // بعد از بستن مودال، ارسال دوباره مجاز است
});

if (self === top) {
    var antiClickjack = document.getElementById("antiClickjack");
    antiClickjack.parentNode.removeChild(antiClickjack);
} else {
    top.location = self.location;
}


let isSentAjax = true;

function my_test_new() {

    isSentAjax = false;


    let WCOUNT = document.getElementById("WCOUNT");
    let numberTrim = WCOUNT.textContent.replace(/،/g, '');

    $.ajax({
        type: "post",
        async: false,
        url: nasr_ajax_url.trim(),
        dataType: "json",
        data: {
            action: 'nasr_get_count',
            nowCount: numberTrim,

        },
        success: function (response) {

            if (response.success) {

                numberTrim = Number(numberTrim);

                let formattedValue = response.data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '،');

                WCOUNT.innerHTML = formattedValue.toString();

                setTimeout(function () {
                    my_test_new()
                }, 10000);

            } else {
                isSentAjax = true;

            }



        },
        error: function (response) {
            isSentAjax = true;

        },
    });
}
my_test_new();

interval = setInterval(() => {

    if (isSentAjax) {
        my_test_new();
    }

}, 30000);



function maskMobileNumber(mobile) {
    if (mobile.length === 11) {
        const lastFour = mobile.slice(-4);
        const firstFour = mobile.slice(0, 4);
        const masked = `${lastFour}*****${firstFour}`;
        return masked;
    }
    return "شماره موبایل نامعتبر است.";
}




let thisDate = dayjs().format('YYYY-MM-DD HH:mm:ss');
let thisPage = 1;

console.log(thisDate);

function loadSignature(type = "") {
    const div = $('#about');


    if (type == 'refresh') {
        thisDate = dayjs().format('YYYY-MM-DD HH:mm:ss');
        thisPage = 1;
        div.empty();
    }

    const formData = {
        action: 'nast_loadSignature',
        thisPage: thisPage,
        date: thisDate,
    };

    $.ajax({
        url: nasr_ajax_url,
        method: 'POST',
        data: formData,
        dataType: 'json',
        beforeSend: function () {
            if (type == 'refresh') {
                $('.nasr_refresh').addClass('nasr_refresh_click');
            }
        },
        success: function (response) {
            response = response.data;
            if (response.end === 'end') {
                $('#loadmore').addClass('nasr-dn');
            } else {
                $('#loadmore').removeClass('nasr-dn');
            }

            if (response.results && Array.isArray(response.results)) {
                response.results.forEach(item => {

                    let description = '';
                    let signature = '';  
                    let avatar = '';  
                    


    
                    if (item.description != null && !$('#nasr-form-description').hasClass("nasr-dn")) {
                        description = `<p class="" style="direction:rtl; word-wrap: break-word;overflow: hidden; text-align: justify; font-size: 12px;">
                                            ${item.description != null ? item.description : ''}
                                        </p>`;

                    }
    
                    if (!$('#nasr-form-signature').hasClass("nasr-dn")) {
                        signature = `<p class="" style="direction:rtl; word-wrap: break-word;overflow: hidden; text-align: center;">
                                            <img src="${item.signature}" style="border-radius: 10px;height: 100px;object-fit: cover;">
                                        </p>`;

                    }
                    
    
                    if (!$('#nasr-form-avatar').hasClass("nasr-dn")) {
                        avatar = `<img src="/wp-content/themes/nasrollah/assets/image/avatar/${item.avatar}.jpg"
                                                class="w3-circle" style="height:50px;margin: 10px;">`;

                    }
                    

                    const label = $(`
                                <div style="direction:rtl; float: right; height: auto;" class="w3-col l4 m6 s12 w3-padding fixed-height">
                                    <div class="w3-card w3-round-large w3-border w3-border-gray w3-padding">
                                        <h4 class=" nasr_users " >
                                        ${avatar}
                                            <div class="nasr_username">
                                                <p>${item.full_name}</p>
                                                <span>${maskMobileNumber(item.mobile)}</span>
                                            </div>
                                        </h4>
                                        ${description}
                                        ${signature}
 
                                    </div>
                                </div>
                        `);
                    div.append(label);

                });
            }

            thisPage++;

            $('#loadmore').attr('data-page', thisPage);

        },
        error: function (response) {

            console.error(response.responseJSON);

        },
        complete: function () {
            if (type == 'refresh') {
                $('.nasr_refresh').removeClass('nasr_refresh_click');

            }
        },
    });



}


loadSignature();




$('#loadmore').click(function (e) {
    e.preventDefault();

    loadSignature('loadmore')

});


$('.nasr_refresh').click(function (e) {
    e.preventDefault();

    loadSignature('refresh')

});




