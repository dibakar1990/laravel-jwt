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

    $('#mailSettingForm').validate({
        ignore: [],
        debug: false,
        rules: {
          mail_driver: {
            required: true,
          },
          mail_host: {
            required: true,
          },
          mail_port: {
            required: true,
            digits: true,
          },
          mail_address: {
            required: true,
            email: true,
          },
          username: {
            required: true,
            email: true,
          },
          password: {
            required: true,
          },
          from_name: {
            required: true,
          },
          encryption: {
            required: true,
          }
        },
        messages: {
          mail_driver: {
            required: "This mail driver field is required",
          },
          mail_host: {
            required: "This mail host field is required",
          },
          mail_port: {
            required: "This mail port field is required",
          },
          mail_address: {
            required: "This mail address field is required",
          },
          username: {
            required: "This username field is required",
          },
          password: {
            required: "This password field is required",
          },
          from_name: {
            required: "This from name field is required",
          },
          encryption: {
            required: "This encryption field is required",
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