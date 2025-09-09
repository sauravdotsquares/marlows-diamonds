var stagingVar = environmentPhpVariable;
if (stagingVar == 'production') {
    grecaptcha.ready(function () {
        grecaptcha.execute('6Lc9hhUgAAAAAJzmHHLuY__2pxT9bHMlIPzgGbwN', {
            action: 'contact'
        }).then(function (token) {
            if (token) {
                document.getElementById('recaptcha').value = token;
            }
        });
    });
}

$(document).ready(function () {
    if (stagingVar == 'production') {
        $('#showPromotionPopup').modal('show');
    }
    $.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z," "]+$/i.test(value);
    }, "Letters and spaces only please");


    $.validator.addMethod(
        "noSpacesOnly",
        function (value, element) {
            return $.trim(value).length > 3;
        },
        "This field cannot be empty or contain only spaces."
    );

    $('form#contactForm').validate({
        rules: {
            title: {
                required: true,
                lettersonly: true,
                noSpacesOnly: true
            },
            email: {
                required: true,
                email: true
            },
            description: {
                required: true,
                noSpacesOnly: true
            }
        },
        messages: {
            title: {
                required: 'Name is required',
                noSpacesOnly: "Name cannot be empty and must not contain spaces."
            },
            email: {
                required: 'Email is required',
                email: 'Valid email is required',
            },
            description: {
                required: 'Message is required',
                noSpacesOnly: "Description cannot be empty and must not contain spaces."
            }
        },
        submitHandler: function (form) {
            if (stagingVar == 'production') {
                if (grecaptcha.getResponse()) {
                    var form_data = new FormData(form);
                    $(form).find("button[type='submit']").prop('disabled', true);
                    $("button[type='submit']").text("Please Wait...");
                    $.ajax({
                        url: mailListRoute,
                        method: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        success: function (response) {
                            blankForm();
                            $("button[type='submit']").text("Subscribe");
                            if (response.status == 200) {
                                toastr.success(response.success);
                            } else {
                                toastr.info(response.error);
                            }
                        }
                    });
                } else {
                    alert('Please confirm captcha to proceed')
                }
            } else {
                var form_data = new FormData(form);
                $(form).find("button[type='submit']").prop('disabled', true);
                $("button[type='submit']").text("Please Wait...");
                $.ajax({
                    url: mailListRoute,
                    method: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (response) {
                        blankForm();
                        $("button[type='submit']").text("Subscribe");
                        if (response.status == 200) {
                            toastr.success(response.success);
                        } else {
                            toastr.info(response.error);
                        }
                    }
                });
            }
        }
    });
});


function blankForm() {
    $('input[name="title"]').val('');
    $('input[name="email"]').val('');
    $('textarea[name="description"]').val('');
    $("button[type='submit']").prop('disabled', false);
    if (stagingVar == 'production') {
        grecaptcha.reset();
    }
}


