$(function () {
   
    $('#settingForm').validate({
            ignore: [],
            debug: false,
            rules: {
              app_name: {
                required: true,
              },
              email: {
                required: true,
                email: true
              },
              phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 11
              },
              developed_by: {
                required: true,
              },
              timezone: {
                required: true,
              },
              address: {
                required: true,
              },
              description: {
                required: true,
              }
            },
            messages: {
                app_name: {
                required: "This app name field is required",
              },
              email: {
                required: "This email field is required",
              },
              phone: {
                required: "This phone field is required",
              },
              phone: {
                required: "This phone field is required",
              },
              developed_by: {
                required: "This developed by field is required",
              },
              timezone: {
                required: "This timezone field is required",
              },
              address: {
                required: "This address field is required",
              },
              description: {
                required: "This description field is required",
              }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
              error.addClass('invalid-feedback');
            element.closest('.form-floating').append(error);
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
            }
        });

        $('#paymentSettingForm').validate({
          ignore: [],
          debug: false,
          rules: {
            publishable_key: {
              required: true,
            },
            secret_key: {
              required: true,
            },
            currency: {
              required: true,
            }
          },
          messages: {
            publishable_key: {
              required: "This publishable key field is required",
            },
            secret_key: {
              required: "This secret key field is required",
            },
            currency: {
              required: "This currency field is required",
            }
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
          element.closest('.form-floating').append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
      });
  });