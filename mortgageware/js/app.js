String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

window.getSearch = function get(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split('&');
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        if (decodeURIComponent(pair[0]) == variable) {
            return decodeURIComponent(pair[1]);
        }
    }
    return null;
};

$(window).on("popstate", function (e) {

    data = {
        action: 'mw_logged_in_ajax'
    };

    if (window.getSearch('loan')) {
        data.loan = window.getSearch('loan');
    }

    $('#currentDisplay').html(mw_spinner);
    $.ajax({
        url: mw_app.ajax_url,
        dataType: 'html',
        method: 'post',
        data: data
    }).done(function(html) {
        $('#currentDisplay').fadeOut('fast',function() {
            $(this).html(html).fadeIn('fast');
        });
    }).fail(function() {
        $.alert({
            title: 'Oops!',
            content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
        });
    });
});

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function removeLogoutHistory(){
    if (window.location.search.indexOf('logout') != -1) {
        history.pushState({ 'page_id': 1, 'user_id': 1 },'MortgageWare',window.location.pathname);
    }
}

var sessionTimer = 300000,
    ajaxTimeout = 60000,
    MWBankAccountIndex = 0,
    MWAssetPropertyIndex = 0,
    MWPropertyIndex = 0,
    MWIncomeIndex = 0,
    mw_spinner = '<i class="fa fa-spinner fa-spin loading-page"></i>',
    validExtensions = ['txt','pdf','doc','tif','jpg','jpeg','jpe'];

/**
 * Ready
 */
$(function () {

    $('#mw-login-title').click( function() {
        if ($(window).width() > 768) return false;

        $('#mw-login-form').slideToggle('fast', 'swing',function() {
            if ($(this).is(':visible')) {
                $(this).prev('h1').find('i').removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-up');
            } else {
                $(this).prev('h1').find('i').removeClass('fa-arrow-circle-up').addClass('fa-arrow-circle-down');
            }
        });
        $('#mw-register-form').slideToggle('fast', 'swing',function() {
            if ($(this).is(':visible')) {
                $(this).prev('h1').find('i').removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-up');
            } else {
                $(this).prev('h1').find('i').removeClass('fa-arrow-circle-up').addClass('fa-arrow-circle-down');
            }
        });
    });

    $('#mw-register-title').click( function() {

        if ($(window).width() > 768) return false;

        $('#mw-register-form').slideToggle('fast', 'swing',function() {
            if ($(this).is(':visible')) {
                $(this).prev('h1').find('i').removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-up');
            } else {
                $(this).prev('h1').find('i').removeClass('fa-arrow-circle-up').addClass('fa-arrow-circle-down');
            }
        });
        $('#mw-login-form').slideToggle('fast', 'swing',function() {
            if ($(this).is(':visible')) {
                $(this).prev('h1').find('i').removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-up');
            } else {
                $(this).prev('h1').find('i').removeClass('fa-arrow-circle-up').addClass('fa-arrow-circle-down');
            }
        });
    });

    /*var $mw_timezone = $('#mw_timezone');
    if ($mw_timezone.is(':visible')) {

        var mw_timezones = {
            'GMT -5': 'America/New_York',
            'GMT -6': 'America/Chicago',
            'GMT -7': 'America/Denver',
            'GMT -8': 'America/Los_Angeles',
            'GMT -9': 'America/Anchorage',
            'GMT -10': 'Pacific/Honolulu'
        };

        var mw_visitortime = new Date();
        var mw_visitortimezone = "GMT " + (-mw_visitortime.getTimezoneOffset()/60 - 1);
        if (typeof(mw_timezones[mw_visitortimezone]) != 'undefined') {
            $('#mw_timezone').val(mw_timezones[mw_visitortimezone]);
        }
    }
    */


    /**
     * Session Check
     */
    var idleTimeOut = 600; // seconds
    var idleSecondsCounter = 0;
    var theTimer;

    $(document)
        .on("click", function () {
            idleSecondsCounter = 0;
        })
        .on("mousemove", function () {
            idleSecondsCounter = 0;
        })
        .on("keypress", function () {
            idleSecondsCounter = 0;
        })
        .on("scroll", function () {
            idleSecondsCounter = 0;
        })
    ;

    function CheckIdleTime() {
        idleSecondsCounter++;
        var remainSeconds = idleTimeOut - idleSecondsCounter;
        //console.log($.cookie("dont_hack_this"));
        //console.log("Seconds to expire: " +  remainSeconds)
        if (idleSecondsCounter >= idleTimeOut) {
            //console.log("Time expired!");
            //$.removeCookie('dont_hack_this', { path: '/' });
            //clearInterval(theTimer);
            $.confirm({
                title: 'Session Expired',
                content: 'Your session is about to expire.<br><br>To stay logged in, click the button below...',
                //confirmButtonClass: 'btn label-default',
                theme: 'supervan',
                backgroundDismiss: false,
                autoClose: 'cancel|30000',
                confirmButton: 'Keep Me Logged In',
                cancelButton: 'Log Out',
                cancel: function () {
                    clearTimeout(theTimer);
                    $current = window.location.pathname;
                    window.location = $current+'?mw_logout=1&timeout=1';
                }
            });

        }
    }
    if (!$('#mw-register-form').is(':visible') && !$('#mw-forgot-password-form').is(':visible') && !$('#mw-reset-password-form').is(':visible')) {
        theTimer = window.setInterval(CheckIdleTime, 1000);
    }

    /*
    interval = setInterval(function () {
        $.ajax({
            url: mw_app.ajax_url,
            method: 'post',
            data: {
                action: 'mw_session_check_ajax'
            },
            dataType: 'json',
            success: function (res) {
                if (res.logout) {
                    $.alert({
                        title: 'Session Expired',
                        content: 'Your session has expired! You will now be logged out.',
                        theme: 'supervan',
                        backgroundDismiss: false,
                        autoClose: 'confirm|30000',
                        confirmTimeout: 10,
                        confirm: function () {
                            window.location.reload();
                        }
                    });
                    clearInterval(interval);
                }
            }
        });
    }, sessionTimer);
    */


    /**
     * Signature
     */
    $('.sigPad').livequery(function() {
        if ($(this).hasClass('signed')) {
            var signatureData = $(this).data('signature');
            $(this).signaturePad({displayOnly: true}).regenerate(signatureData);
        } else {
            $(this).signaturePad();
        }

    });

    /**
     * DataTables
     */
    $('table.data-table').livequery(function(){
        $(this).DataTable();
    });

    /**
     * Masking
     */
    $('input.phone').livequery(function() {
        $(this).mask('(000) 000-0000');
    });

    $('input.date').livequery(function() {
        $(this).mask('00/00/0000');
    });

    /**
     * Define Asset Indexes
     */
    if ($('#mw-assets').is(':visible')) {
        MWBankAccountIndex = $('tr.mw-asset-account').length - 2;
        if (MWBankAccountIndex < 0) MWBankAccountIndex = 0;
        MWPropertyIndex = $('.mw-asset-real-estate').length;
    }


    $('body')
        .on('click',function() {
            $userNav = $('.mw-user-nav');
            if ($userNav.is(':visible')) {
                $userNav.slideUp();
            }
        })

        .on('keydown','input.integer',function(e) {
            if ($.inArray(e.which, [46, 8, 9, 27, 13]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                (e.which == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                    // Allow: home, end, left, right, down, up
                (e.which >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.which < 48 || e.which > 57)) && (e.which < 96 || e.which > 105)) {
                e.preventDefault();
            }
        })
    ;

    $('#mw-container') // MAIN DIV


    /**
     * Back to Home
     */
      .on('click','#MWHomeLink',function() {

        data = { action: 'mw_home_ajax' };

        $.ajax({
          url: mw_app.ajax_url,
          method: 'POST',
          dataType: 'html',
          data: data,
          timeout: ajaxTimeout,
          success: function(html) {
            history.pushState({},'',window.location.pathname);
            $('#currentDisplay').fadeOut('fast', function () {
              $(this).html(html).fadeIn('fast');
            })
          },
          error: function (res,status,error) {
            if (getUrlParam('mw_debug')) {
              console.log(status);
              console.log(error);
            }

            $.alert({
              title: 'Oops!',
              content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
            })
          }
        });
      })
    /**
     * Register
     */
        .on('submit','form#mw-register-form',function(e) {
            e.preventDefault();
            $registerIcon = $('.mw-register-icon');
            $registerMessage = $('#mw-register-message');

            $registerIcon.removeClass('glyphicon glyphicon-user').addClass('fa fa-spinner fa-spin');
            $registerMessage.html('').removeClass('alert alert-danger');

            error = false;

            $(this).find('[required]').each(function() {
                if (!$(this).val()) {
                    error = true;
                    $(this).addClass('error').closest('.form-group').find('label.control-label').addClass('error')
                }
            });

            if (error) {
                $registerMessage.html("Please fill in all required fields").addClass('alert alert-danger');
                $registerIcon.removeClass('fa fa-spinner fa-spin').addClass('glyphicon glyphicon-user');
                return false;
            }

            var pw = $('#mw_password').val();

            if (pw != $('#mw_confirm_password').val()) {
                $registerMessage.html("Passwords do not match").addClass('alert alert-danger');
                $('#mw_password, #mw_confirm_password').addClass('error').closest('.form-group').find('label.control-label').addClass('error');
                $registerIcon.removeClass('fa fa-spinner fa-spin').addClass('glyphicon glyphicon-user');
                return false;
            }

            if (pw.length < 6) {
                $registerMessage.html("Password must be at least 6 characters").addClass('alert alert-danger');
                $('#mw_password, #mw_confirm_password').addClass('error').closest('.form-group').find('label.control-label').addClass('error');
                $registerIcon.removeClass('fa fa-spinner fa-spin').addClass('glyphicon glyphicon-user');
                return false;
            }

            /*if(!/^(?=.*[A-Z])(?=.*[!@#$&%^()*])(?=.*[0-9])(?=.*[a-z]).{6,}$/.test(pw)) {
                $('.mw-pw-notice').addClass('error');
                $('#mw-register-message').html("Password does not match complexity requirements").addClass('alert alert-danger');
                $('#mw_password, #mw_confirm_password').addClass('error').closest('.form-group').find('label.control-label').addClass('error');
                $('.mw-register-icon').removeClass('fa fa-spinner fa-spin').addClass('glyphicon glyphicon-user');
                return false;
            }
            */

            var data = $(this).serializeObject();

            data.action = 'mw_register_ajax';
            $.ajax({
                url: mw_app.ajax_url,
                method: 'POST',
                dataType: 'json',
                data: data,
                timeout: ajaxTimeout,
                success: function (res) {
                    if (res.status == 'User Added') {
                        $registerMessage.html('Registration was successful! Loading application... <i class="fa fa-spinner fa-spin"></i>').addClass('alert alert-success');
                        $('#mw-register-button').fadeOut();
                        setTimeout(function() {
                            $.ajax({
                                url: mw_app.ajax_url,
                                method: 'POST',
                                data: {
                                    action: 'mw_logged_in_ajax',
                                    loan: null
                                },
                                success: function (html) {
                                    removeLogoutHistory();
                                    $('#currentDisplay').fadeOut('fast',function() {
                                        var user = JSON.parse(res.user);
                                        $('#mw-user').html(
                                            '<div class="mw-welcome">Welcome <span class="mw-username">'+user.username+'</span> <i class="fa fa-caret-down" aria-hidden="true"></i></div>' +
                                            '<ul class="mw-user-nav">' +
                                            '<li><a class="mw-my-account">My Account <i class="fa fa-user"></i></a></li>' +
                                            '<li><a class="mw-new-loan-app">New Loan Application <i class="fa fa-file-text-o" aria-hidden="true"></i></a></li>' +
                                            '<li class="divider"></li>' +
                                            '<li><a class="mw-logout" href="?mw_logout=1">Logout <i class="fa fa-sign-out"></i></a></li>' +
                                            '</ul>' +
                                            '</div>'
                                        );
                                        $(this).html(html).fadeIn('fast');
                                        theTimer = window.setInterval(CheckIdleTime, 1000);
                                    });
                                }
                            });
                        },1000);
                    } else {
                        $registerMessage.html(res.message).addClass('alert alert-danger');
                        $registerIcon.removeClass('fa-spinner fa-spin').addClass('fa-user');
                    }
                },
                error: function (res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $registerIcon.removeClass('fa-spinner fa-spin').addClass('fa-user');
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    })
                }
            });

        })

    /**
     * Login
     */

        .on('click','#forgotPasswordLink', function(e) {
          e.preventDefault();

          $('#currentDisplay').html(mw_spinner);
          var data = { action: 'mw_forgot_password_form_ajax' };
          $.ajax({
            url: mw_app.ajax_url,
            method: 'POST',
            dataType: 'html',
            data: data,
            timeout: ajaxTimeout,
            success: function(html) {
              history.pushState({},'',window.location.pathname);
              $('#currentDisplay').fadeOut('fast', function () {
                $(this).html(html).fadeIn('fast');
              })
            },
            error: function (res,status,error) {
              if (getUrlParam('mw_debug')) {
                console.log(status);
                console.log(error);
              }

              $.alert({
                title: 'Oops!',
                content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
              })
            }
          });
        })

        .on('submit','form#mw-forgot-password-form',function(e) {
          e.preventDefault();

          $forgotPasswordIcon = $('.mw-forgot-pw-icon');
          $forgotPasswordIcon.removeClass('fa-paper-plane').addClass('fa-spinner fa-spin');

          var error = false;
          $(this).find('[required]').each(function() {
            if (!$(this).val()) {
              error = true;
              $(this).addClass('error').closest('.form-group').find('label.control-label').addClass('error')
            }
          });

          if (error) {
            $('#mw-forgot-password-message').html("Please fill in all required fields").addClass('alert alert-danger');
            $forgotPasswordIcon.removeClass('fa-spinner fa-spin').addClass('fa-paper-plane');
            return false;
          }

          var data = $(this).serializeObject();
          data.action = 'mw_forgot_password_ajax';
          data.url = window.location.href;

          $.ajax({
            url: mw_app.ajax_url,
            method: 'POST',
            dataType: 'json',
            data: data,
            timeout: ajaxTimeout,
            success: function (res) {
              if (res.success) {
                window.location.reload();
              } else {
                $('#mw-forgot-password-message').html(res.message).addClass('alert alert-danger');
                $('.mw-forgot-pw-icon').removeClass('fa fa-spinner fa-spin').addClass('fa fa-paper-plane');
              }
            },
            error: function (res,status,error) {
              if (getUrlParam('mw_debug')) {
                console.log(status);
                console.log(error);
              }
              $('.mw-forgot-pw-icon').removeClass('fa fa-spinner fa-spin').addClass('fa fa-sign-in');
              $.alert({
                title: 'Oops!',
                content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
              })
            }
          });
        })

        .on('submit','form#mw-login-form',function(e) {
            e.preventDefault();
            $loginIcon = $('.mw-login-icon');
            $('#mw-login-message').html('').removeClass('alert alert-danger');
            $loginIcon.removeClass('fa-sign-in').addClass('fa-spinner fa-spin');

            var error = false;
            $(this).find('[required]').each(function() {
                if (!$(this).val()) {
                    error = true;
                    $(this).addClass('error').closest('.form-group').find('label.control-label').addClass('error')
                }
            });

            if (error) {
                $('#mw-register-message').html("Please fill in all required fields").addClass('alert alert-danger');
                $loginIcon.removeClass('fa-spinner fa-spin').addClass('fa-sign-in');
                return false;
            }

            var data = $(this).serializeObject();

            data.action = 'mw_login_ajax';
            loan = window.getSearch('loan');
            $.ajax({
                url: mw_app.ajax_url,
                method: 'POST',
                dataType: 'json',
                data: data,
                timeout: ajaxTimeout,
                success: function (res) {
                    if (res.status == 'Authenticated') {
                        $('#mw-login-message').html('Login successful! Loading... <i class="fa fa-spinner fa-spin"></i>').addClass('alert alert-success');
                        $('#mw-login-button').fadeOut();
                        setTimeout(function () {
                            $.ajax({
                                url: mw_app.ajax_url,
                                method: 'POST',
                                data: {
                                    action: 'mw_logged_in_ajax',
                                    loan: loan,
                                    displayUserNav: true
                                },
                                success: function (html) {
                                    removeLogoutHistory();
                                    $('#currentDisplay').fadeOut('fast', function () {
                                        var user = JSON.parse(res.user);
                                        $('#mw-user').html(
                                            '<div class="mw-welcome">Welcome <span class="mw-username">' + user.username + '</span> <i class="fa fa-caret-down" aria-hidden="true"></i></div>' +
                                            '<ul class="mw-user-nav">' +
                                            '<li><a class="mw-my-account">My Account <i class="fa fa-user"></i></a></li>' +
                                            '<li><a class="mw-new-loan-app">New Loan Application <i class="fa fa-file-text-o" aria-hidden="true"></i></a></li>' +
                                            '<li class="divider"></li>' +
                                            '<li><a class="mw-logout" href="?mw_logout=1">Logout <i class="fa fa-sign-out"></i></a></li>' +
                                            '</ul>' +
                                            '</div>'
                                        );
                                        $(this).html(html).fadeIn('fast');
                                        theTimer = window.setInterval(CheckIdleTime, 1000);
                                    });
                                }
                            });
                        }, 1000);
                    } else {
                        var message = res.error || res.message;

                        $('#mw-login-message').html(message).addClass('alert alert-danger');
                        $('.mw-login-icon').removeClass('fa fa-spinner fa-spin').addClass('fa fa-sign-in');
                    }
                },
                error: function (res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $('.mw-login-icon').removeClass('fa fa-spinner fa-spin').addClass('fa fa-sign-in');
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    })
                }
            });

        })

        .on('click','.mw-user-nav',function(e) {
            e.stopPropagation();
        })

        .on('click','.mw-welcome',function(e) {
            e.stopPropagation();
            $('.mw-user-nav').slideToggle();
        })

    /**
     * Start New Application
     */
        .on('click','.mw-new-loan-app',function() {
            $('.mw-user-nav').slideUp();
            $('#currentDisplay').html(mw_spinner);
            $.ajax({
                url: mw_app.ajax_url,
                method: 'POST',
                data: {
                    action: 'mw_new_loan_application_ajax'
                },
                success: function(html) {
                    $('#currentDisplay').fadeOut('fast',function() {
                        $(this).html(html).fadeIn('fast');
                    })
                },
                error: function(res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    });
                }
            });
        })

    /**
     * My Account
     */

        .on('click','.mw-my-account',function() {
            $('.mw-user-nav').slideUp();
            $('#currentDisplay').html(mw_spinner);
            $.ajax({
                url: mw_app.ajax_url,
                method: 'POST',
                data: {
                    action: 'mw_my_account_ajax'
                },
                success: function(html) {
                    $('#currentDisplay').fadeOut('fast',function() {
                        $(this).html(html).fadeIn('fast');
                    })
                },
                error: function(res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    });
                }
            });
        })

    /**
     * Complete Loan Application
     */
        .on('click','.MWCompleteApp',function() {
            var $tr = $(this).closest('tr');
            guid = $tr.data('guid');

            $('#currentDisplay').html(mw_spinner);
            $.ajax({
                url: mw_app.ajax_url,
                method: 'POST',
                data: {
                    action: 'mw_complete_loan_app_ajax',
                    guid: guid
                },
                timeout: ajaxTimeout,
                success: function (html) {
                    $('#currentDisplay').html(html);
                    history.pushState({ guid: guid },'',window.location.pathname + '?app=' + guid);
                },
                error: function (res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    })
                }
            });
        })

    /**
     * Loan Application Navigation
     */
        .on('click','ul#loan-application-nav li.clickable',function() {
            var $li = $(this),
                step = $li.index() + 1,
                guid = $('#mw-loan-guid').val();

            $('#currentLoanStep').html(mw_spinner);
            $.ajax({
                url: mw_app.ajax_url,
                method: 'POST',
                data: {
                    action: 'mw_load_step_ajax',
                    step: step,
                    loan_guid: guid
                },
                timeout: ajaxTimeout,
                success: function (html) {
                    $('#currentLoanStep').fadeOut('fast',function() {
                        $(this).html(html).fadeIn('fast');
                        $('ul#loan-application-nav li.active').addClass('clickable');
                        $('ul#loan-application-nav li').each(function(index,element) {
                            if (index == step - 1) {
                                $(this).removeClass('completed clickable').addClass('active');
                            }
                            else if (index < step) {
                                $(this).removeClass('active').addClass('completed');
                            } else {
                                $(this).removeClass('completed active');
                            }
                        });
                    })
                },
                error: function(res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    });
                }
            });

        })

    /**
     * Required Remove Error Class
     */

        .on('focus change','input[required].error,select[required].error,textarea[required].error',function() {
            $(this).removeClass('error').closest('.form-group').find('label.error').removeClass('error');
        })

    /**
     * Step 1 - Personal
     */

        .on('blur','input.ssn',function() {
            var val = $(this).val();
            $(this).next('input.ssn-val').val(val);
            $(this).unmask();
            if (val && val.indexOf('_') == -1) {
                $(this).val('***-**-****');
            } else {
                $(this).val('');
            }
        })

        .on('focus','input.ssn',function() {
            var val = $(this).next('input.ssn-val').val();
            $(this).val(val).mask('999-99-9999');
        })


        .on('focus','.dob',function() {
            var end = parseInt((new Date).getFullYear()) - 18;
            $(this).datepicker({
                changeMonth: true,
                defaultDate: new Date(1980, 00, 01),
                changeYear: true,
                yearRange: '1900:'+end
            });
        })

        .on('focus','.date',function() {
            $(this).datepicker({
                changeMonth: true,
                changeYear: true
            });
        })

        .on('change','input[class=dependents]',function () {
            if ($(this).val() == "1") {
                $(this).closest('.form-group').parent().find('.dependents_extra').slideDown().children().each(function() {
                    $(this).find('input').attr('required',true);
                });
            } else {
                $(this).closest('.form-group').parent().find('.dependents_extra').slideUp().children().each(function() {
                    $(this).find('input').removeAttr('required');
                });
            }
        })

        .on('click','#mw-add-co-borrower',function () {
            $(this).fadeOut('fast');
            $personal = $('#mw-personal');
            $coborrower = $personal.data('prototype');
            $personal.append($coborrower);
        })

        .on('click','#mw-remove-co-borrower',function() {
            $('#co_borrower').slideUp(function() {
                $('#mw-add-co-borrower').fadeIn('fast');
                $(this).remove();
            });
        })

    /**
     * Step 3 - Employment
     */
        .on('change','.employment-radio',function() {
            var borrower = $(this).data('borrower');
            var $employment =  $('#' + borrower + '-employment');
            if (parseInt($(this).val()) === 1) {
                $employment.slideDown('fast').find('input, select, textarea').removeAttr('disabled');
                $employment.find('.mw-employment-record').each(function(index) {
                    if (parseInt($(this).find('.current-employment-radio:checked').val()) == 1) {
                        $(this).find('input.date.end').attr('disabled','disabled');
                    }
                });
            }
            else {
                $('#' + borrower + '-employment').slideUp('fast').find('input, select, textarea').attr('disabled','disabled');
            }
        })

        .on('change','.current-employment-radio',function() {
            var $end_date = $(this).closest('.mw-employment-record').find('input.date.end');
            if (parseInt($(this).val()) === 1) {
                var now = moment();
                $end_date.val(now.format('MM/DD/YYYY')).attr('disabled','disabled');
            } else {
                $end_date.val('').removeAttr('disabled');
            }
        })

    /**
     * Step 4 - Assets
     */
        .on('click','#mw-add-bank-account',function() {
            $table = $('#mw-assets').find('table');
            MWBankAccountIndex++;
            $tr = $table.data('prototype').replaceAll('prototype',MWBankAccountIndex);
            $table.append($tr);
        })

        .on('click','.mw-delete-bank-account',function() {
            $(this).closest('tr').remove();
        })

        .on('click','#mw-add-asset-real-estate',function() {
            $properties = $('#mw-property-list');
            $property = $properties.data('prototype').replaceAll('prototype',MWPropertyIndex);
            $properties.append($property);
            MWPropertyIndex++;
        })

        .on('click','.mw-delete-asset-real-estate',function() {
            $(this).closest('.mw-asset-real-estate').slideUp(function() {
                $(this).remove();
            })
        })

    /**
     * Step 5 - Assets
     */
        .on('click','#mw-add-income',function() {
            $table = $('#mw-income').find('table');
            MWIncomeIndex++;
            $tr = $table.data('prototype').replaceAll('prototype',MWIncomeIndex);
            $table.append($tr);
        })

        .on('click','.mw-delete-income',function() {
            $(this).closest('tr').remove();
        })

    /**
     * Step 6 - Declarations
     */
        .on('change','.declaration',function() {
            var name = $(this).attr('name').replaceAll('\\[','-').replaceAll('\\]','').replace('declaration_','')+'-details';
            var $details = $('#'+name);
            if ($(this).closest('.boolean-group').data('correct') == $(this).val()) {
                $details.slideUp('fast',function() {
                    $(this).find('input, textarea, select').attr('disabled','disabled');
                });
            } else {
                $details.slideDown('fast').find('[disabled]').removeAttr('disabled');
            }
        })

        .on('change','.opt-out',function() {
            var $info = $(this).closest('.mw-government-monitoring').find('.mw-government-monitoring-info');
            if ($(this).is(':checked')) {
                $info.slideUp('fast',function() {
                    $(this).find('select,input').attr('disabled','disabled');
                })
            } else {
                $info.slideDown('fast').find('[disabled]').removeAttr('disabled');
            }
        })

    /**
     * Form Back
     */
        .on('click','.mw-back-button',function () {
            step = parseInt($('form.mw-loan-application-form').data('step')) - 1;
            guid = $('#mw-loan-guid').val();
            $.ajax({
                url: mw_app.ajax_url,
                method: 'POST',
                data: {
                    action: 'mw_load_step_ajax',
                    step: step,
                    loan_guid: guid,
                    save_loan: false
                },
                timeout: ajaxTimeout,
                success: function (html) {
                    $('#currentLoanStep').fadeOut('fast',function() {
                        $(this).html(html).fadeIn('fast');
                        $('ul#loan-application-nav li').each(function(index,element) {
                            if (index == step - 1) {
                                $(this).removeClass('completed').addClass('active');
                            } else if (index < step - 1) {
                                $(this).removeClass('active').addClass('completed');
                            } else {
                                $(this).removeClass('completed active');
                            }
                        });
                    })
                },
                error: function(res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    });
                }
            });
        })

    /**
     * Loan Application Submit Step
     */
        .on('submit','form.mw-loan-application-form',function(e) {

            e.preventDefault();

            error = false;

            $('input[required]:visible, select[required]:visible, textarea[required]:visible').each(function() {
                if (!$(this).val()) {
                    error = true;
                    $(this).addClass('error').closest('.form-group').find('label.control-label').addClass('error');
                }
            });

            $('input[type=radio][required]:visible').each(function() {
                var name = $(this).attr('name');
                if (typeof($('input[name="'+name+'"]:checked').val()) == 'undefined') {
                    error = true;
                    $(this).addClass('error').closest('.form-group').find('label.control-label').addClass('error');
                }
            });

            step = parseInt($(this).data('step'));

            if (step == 3) {
                $('.employment-form').each(function() {
                    var days = 0;
                    $(this).find('.mw-employment-record').each(function() {
                        var start_date = moment($(this).find('input.date.start').val(),"MM-DD-YYYY");
                        var end_date = moment($(this).find('input.date.end').val(),"MM-DD-YYYY");
                        days += end_date.diff(start_date,'days');
                    });

                    if (days < 730) {
                        var $message = $(this).find('.mw-employment-message');
                        $message.html('At least 2 years of employment history is required. Please add another employment record.').addClass('alert alert-danger');
                        var newIndex = $(this).find('.mw-employment-record').length;
                        var $prototype = $(this).data('prototype').replaceAll('prototype',newIndex);
                        $($prototype).insertBefore($message);
                        error = true;
                    }
                });
            } else if (step == 5) {
                $('.mw-income-monthly').each(function() {
                    var hasValue = false;
                    $(this).find('input').each(function() {
                        if ($(this).val()) {
                            hasValue = true;
                            return false;
                        }
                    });
                    if (!hasValue) {
                        if (!error) {
                            var $message = $('.mw-income-message');
                            $message.html('At least 1 value is required for each income row.').addClass('alert alert-danger');
                            error = true;
                        }
                        $(this).find('input').addClass('error');

                    } else {
                        $(this).find('input').removeClass('error');
                    }
                });
            } else if (step == 7) {
                $('.mw-agreement').each(function() {
                    if (!$(this).is(':checked')) {
                        $(this).parent().addClass('error');
                        error = true;
                    } else {
                        $(this).parent().removeClass('error');
                    }
                });
            }

            if (error) return false;

            var data = $(this).serializeObject();
            data.action = 'mw_load_step_ajax';
            data.step = step + 1;
            data.save_loan = true;

            $('.mw-submit-application').find('i').removeClass('fa-check').addClass('fa-spinner fa-spin');
            $.ajax({
                url: mw_app.ajax_url,
                method: 'POST',
                data: data,
                timeout: ajaxTimeout,
                success: function (html) {
                    if (html.indexOf('Loan Application Complete!') != -1) {
                        $('#currentDisplay').fadeOut('fast',function() {
                            $(this).html(html).fadeIn('fast');
                        });
                    } else {
                        $('#currentLoanStep').fadeOut('fast', function () {
                            $(this).html(html).fadeIn('fast');
                            $('ul#loan-application-nav li').each(function (index, element) {
                                if (index == step) {
                                    $(this).addClass('active').removeClass('clickable');
                                } else if (index <= step) {
                                    $(this).removeClass('active').addClass('completed clickable');
                                } else {
                                    $(this).removeClass('completed active');
                                }
                            });
                        });
                    }
                },
                error: function(res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    });
                }
            });
        })

    /**
     * Edit Loan Step From Summary
     */
        .on('click','.mw-edit-link',function() {
            step = $(this).data('step');
            guid = $('#mw-loan-guid').val();

            $('#currentLoanStep').html(mw_spinner);
            $.ajax({
                url: mw_app.ajax_url,
                method: 'POST',
                data: {
                    action: 'mw_load_step_ajax',
                    step: step,
                    loan_guid: guid
                },
                timeout: ajaxTimeout,
                success: function (html) {
                    $('#currentLoanStep').fadeOut('fast',function() {
                        $(this).html(html).fadeIn('fast');
                        $('ul#loan-application-nav li.active').addClass('clickable');
                        $('ul#loan-application-nav li').each(function(index,element) {
                            if (index == step - 1) {
                                $(this).removeClass('completed clickable').addClass('active');
                            }
                            else if (index < step) {
                                $(this).removeClass('active').addClass('completed');
                            } else {
                                $(this).removeClass('completed active');
                            }
                        });
                    })
                },
                error: function(res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    });
                }
            });

        })

    /**
     * View Application
     */
        .on('click','.MWViewApp',function() {
            guid = $(this).closest('tr').data('guid');

            $('#currentDisplay').html(mw_spinner);
            $.ajax({
                url: mw_app.ajax_url,
                dataType: 'html',
                method: 'post',
                data: {
                    action: 'mw_view_loan_app_ajax',
                    guid: guid
                },
                timeout: ajaxTimeout,
                success: function (html) {
                    $('#currentDisplay').fadeOut('fast', function () {
                        history.pushState({guid: guid}, '', window.location.pathname + '?loan=' + guid);
                        $(this).html(html).fadeIn('fast');
                    });
                },
                error: function(res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    });
                }
            });

        })

    /**
     * View Borrower Modal
     */
        .on('click','.MWViewBorrower',function() {
            var $tr = $(this).closest('tr');
            var borrowerID = $tr.data('borrower_id');
            var title = $tr.data('title');
            $.dialog({
                title: title,
                content: function () {
                    var self = this;
                    return $.ajax({
                        url: mw_app.ajax_url,
                        dataType: 'html',
                        method: 'post',
                        data: {
                            action: 'mw_view_borrower_ajax',
                            borrower_id: borrowerID
                        }
                    }).done(function (html) {
                        self.setContent(html);
                    }).fail(function(){
                        self.setContent('Something went wrong.');
                    });
                },
                columnClass: 'col-md-6 col-md-offset-3',
                closeIconClass: 'glyphicon glyphicon-remove',
                backgroundDismiss: true
            });
        })

    /**
     * View Message Modal
     */
        .on('click','.MWViewMessage',function() {
            var $tr = $(this).closest('tr');
            var messageID = $tr.data('message_id');
            $.dialog({
                title: 'View Message',
                content: function () {
                    var self = this;
                    return $.ajax({
                        url: mw_app.ajax_url,
                        dataType: 'html',
                        method: 'post',
                        data: {
                            action: 'mw_view_message_ajax',
                            message_id: messageID
                        }
                    }).done(function (html) {
                        self.setContent(html);
                    }).fail(function(){
                        self.setContent('Something went wrong.');
                    });
                },
                columnClass: 'col-md-6 col-md-offset-3',
                closeIconClass: 'glyphicon glyphicon-remove',
                backgroundDismiss: true
            });
        })

    /**
     * Add Loan Messsage
     */
        .on('submit','#mw-message-form',function(e) {
            e.preventDefault();
            $button = $('#sendMessage');
            if ($button.hasClass('sending')) return false;
            var data = $(this).serializeObject();
            data.action = 'mw_add_loan_message_ajax';
            data.table = 'true';
            $button.html('<i class="fa fa-spinner fa-spin"></i> Sending').addClass('sending');
            $.ajax({
                url: mw_app.ajax_url,
                dataType: 'json',
                method: 'post',
                data: data,
                timeout: ajaxTimeout,
                success: function(message) {
                    if (message.id) {
                        $('#MWLoanMessages').find('table').find('tbody').prepend(message.row);
                        $('.form-message').html('Message has been sent').addClass('alert alert-success').delay(5000).fadeOut(1000,function() {
                            $(this).html('').removeClass('alert alert-success').show();
                        });
                        $button.removeClass('sending').html('Send Message');
                    } else {
                        $('.form-message').html('Message has not been sent. Support has been notified.').addClass('alert alert-danger');
                    }
                },
                error: function(res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    });
                }
            });
        })


    /**
     * Export to MISMO 2.3.1
     */
        .on('click','.mw-export-loan',function() {
            var format = $(this).data('format');
            var guid = $(this).closest('tr').data('guid');
            window.location = window.location.href + '?download=true&guid='+guid+'&format='+format;

        })


    /**
     * Delete Application
     */
        .on('click','.MWDeleteApp',function() {
            $this = $(this);
            $.confirm({
                title: 'Delete Application?',
                content: 'Are you sure you want to delete this application?',
                confirmButton: 'Yes',
                cancelButton: "No",
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-success',
                confirm: function() {
                    var guid = $this.closest('tr').data('guid');
                    $.ajax({
                        url: mw_app.ajax_url,
                        dataType: 'json',
                        method: 'post',
                        data: {
                            action: 'mw_delete_loan_ajax',
                            guid: guid
                        },
                        success: function(res) {
                            if (res.success) {
                                $this.removeClass('MWDeleteApp').addClass('MWUnDeleteApp').html('<i class="fa fa-repeat"></i> Reinstate').closest('tr').find('.mw-status').html('Deleted');
                            }
                        },
                        error: function(res,status,error) {
                            if (getUrlParam('mw_debug')) {
                                console.log(status);
                                console.log(error);
                            }
                            $.alert({
                                title: 'Oops!',
                                content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                            });
                        }
                    });
                }
            });
        })

    /**
     * Undelete Application
     */
        .on('click','.MWUnDeleteApp',function() {
            $this = $(this);
            $.confirm({
                title: 'Reinstate Application?',
                content: 'Are you sure you want to undelete this application?',
                confirmButton: 'Yes',
                cancelButton: "No",
                confirmButtonClass: 'btn-success',
                cancelButtonClass: 'btn-danger',
                confirm: function() {
                    var guid = $this.closest('tr').data('guid');
                    $.ajax({
                        url: mw_app.ajax_url,
                        dataType: 'json',
                        method: 'post',
                        data: {
                            action: 'mw_delete_loan_ajax',
                            guid: guid,
                            reverse: true
                        },
                        success: function(res) {
                            if (res.success) {
                                $this.removeClass('MWUnDeleteApp').addClass('MWDeleteApp').html('<i class="fa fa-trash"></i> Delete').closest('tr').find('.mw-status').html(res.status);
                            }
                        },
                        error: function(res,status,error) {
                            if (getUrlParam('mw_debug')) {
                                console.log(status);
                                console.log(error);
                            }
                            $.alert({
                                title: 'Oops!',
                                content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                            });
                        }
                    });
                }
            });
        })

    /**
     * Loan View Back Button
     */
        .on('click','a.back',function() {
            $('#currentDisplay').html(mw_spinner);
            $.ajax({
                url: mw_app.ajax_url,
                dataType: 'html',
                method: 'post',
                data: {
                    action: 'mw_view_loans_ajax'
                },
                timeout: ajaxTimeout,
                success: function(html) {
                    $('#currentDisplay').fadeOut('fast',function() {
                        history.pushState({ guid: null },'',window.location.pathname );
                        $(this).html(html).fadeIn('fast');
                    });
                },
                error: function(res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    });
                }
            });
        })

    /**
    * Start New Application
    */
        .on('click','#startNewApplication',function() {
            // TODO: Start New Application
        })


        /**
         * Toggle Loan View
     */
        .on('click','a.mw-loan-tab',function() {
            $this = $(this);
            $parent = $this.parent();
            if ($parent.hasClass('active')) return false;
            var section = $this.data('section');
            var $nav = $this.closest('ul.nav-tabs');

            $nav.find('li.active').removeClass('active');
            $('.mw-loan-view:visible').fadeOut('fast',function() {
                $('#mw-loan-' + section + '-view').fadeIn('fast');
                $parent.addClass('active');
            });
        })

    /**
     * Trigger File Chooser
     */
        .on('click','input#documentSelect',function() {
            $('#documentUploader').trigger('click');
        })

    /**
     * Choose File
     */
        .on('change','#documentUploader',function() {

            var file = this.files[0];
            var val = $(this).val().replace("C:\\fakepath\\",'');
            var split = val.split('.');
            ext = split[split.length-1];

            var invalidFormat = true;
            var fileSize = 0;

            for (var i in validExtensions) {
                if (ext.toLowerCase() == validExtensions[i]) invalidFormat = false;
            }

            /*
             if (file.size > maxFileSize) {
                // TODO: DO SOMETHING FOR MAX SIZE
             }
             */

            if (!invalidFormat) {

                $('#fileName').val(file.name);

                $('#documentSelect').val(val).removeClass('redBG');
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#fileData').val(e.target.result);
                    checkUploadButton();
                };

                reader.readAsDataURL(this.files[0]);

            } else {
                $.alert({
                    title: 'Invalid Document Format',
                    content: 'Only the following formats are valid...<br><br><strong>.'+ validExtensions.join(', .') + '</strong>',
                    confirm: function () {
                        $('#documentSelect, #documentUploader, #fileData').val('');
                        checkUploadButton();
                    }
                });
                $('#fileData').val('');
            }

        })

    /**
     * Change of Document Name
     */
        .on('keyup change','#documentName',function() {
            checkUploadButton();
        })

    /**
     * Change of Document Category
     */
        .on('change','#documentCategory',function() {
            checkUploadButton();
        })

    /**
     * Stop Document Text Entry
     */
        .on('keydown','#documentSelect',function(e) {
            if (e.which == 13) {
                $('#documentUploader').trigger('click');
            }
            return false;
        })

    /**
     * Upload Document
     */
        .on('submit','#mw-document-form',function(e) {
            e.preventDefault();
            if ($('#uploadButton').hasClass('btn-disabled')) return false;

            $formMessage = $('.mw-form-message');
            $formMessage.removeClass('alert-success alert-danger')

            var xhr = new XMLHttpRequest();

            var data = $(this).serializeObject();
            data.action = 'mw_add_loan_document_ajax';
            data.table = true;

            $formMessage.html('Uploading... <i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                url: mw_app.ajax_url,
                dataType: 'json',
                method: 'post',
                data: data,
                timeout: ajaxTimeout,
                success: function(document) {
                    if (document.id) {
                        $('#documentSelect, #documentUploader, #fileData, #documentName, #documentCategory').val('');
                        checkUploadButton();
                        $table = $('#loanDocuments').find('table');
                        $table.find('tr.empty').fadeOut('fast');
                        $table.find('tbody').prepend(document.row);
                        $formMessage.html('Upload Successful').addClass('alert alert-success').delay(5000).fadeOut('fast', function () {
                            $(this).html('').removeClass('alert alert-success').show();
                        });
                    } else {
                        $.alert({
                            title: 'Oops',
                            content: 'There was a problem uploading your document. Please contact webmax support at support@webmaxco.com'
                        });
                    }
                },
                error: function(res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    });
                }
            });

        })

    /**
     * Download Document
     */
        .on('click','.MWDownloadDocument',function(e) {

            var document_id = $(this).closest('tr').data('document_id');

            window.location.href = window.location.pathname+'?download=true&document='+document_id;

        })

    /**
     * Approve Document
     */
        .on('click','.MWApproveDocument',function(e) {

            $tr = $(this).closest('tr');

            var document_id = $tr.data('document_id');

            $.ajax({
                url: mw_app.ajax_url,
                dataType: 'json',
                method: 'post',
                data: {
                    action: 'mw_approve_loan_document_ajax',
                    document: document_id
                },
                timeout: ajaxTimeout,
                success:function(res) {
                    $tr.css({backgroundColor: '#aaffaa'}).animate({
                        backgroundColor: 'transparent'
                    },3000).find('.mw-document-status').html('Accepted');
                },
                error: function(res,status,error) {
                    if (getUrlParam('mw_debug')) {
                        console.log(status);
                        console.log(error);
                    }
                    $.alert({
                        title: 'Oops!',
                        content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                    });
                }
            });

        })

    /**
     * Edit User Profile
     */

        .on('click','#NWEditAccountDetails',function() {
            $.confirm({
                title: 'Edit Account Profile',
                content: function () {
                    var self = this;
                    return $.ajax({
                        url: mw_app.ajax_url,
                        dataType: 'html',
                        method: 'post',
                        data: {
                            action: 'mw_edit_account_details_ajax'
                        }
                    }).done(function (html) {
                        self.setContent(html);
                    }).fail(function(){
                        self.setContent('Something went wrong.');
                    });
                },
                columnClass: 'col-md-6 col-md-offset-3',
                closeIconClass: 'glyphicon glyphicon-remove',
                backgroundDismiss: false,
                confirmButton: 'Save Profile',
                cancelButton: 'Discard Changes',
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger',
                confirm: function() {

                  var $profileMessage = $('#MWProfileMessage');
                  var pw = $('#mw_password').val();
                  var cpw = $('#mw_confirm_password').val();

                  $profileMessage.html('Saving... <i class="fa fa-spinner fa-spin"></i>');

                  if (pw || cpw) {
                      if (pw !== cpw) {
                        $profileMessage.html("Passwords do not match").addClass('alert alert-danger');
                        $('#mw_password, #mw_confirm_password').addClass('error').closest('.form-group').find('label.control-label').addClass('error');
                        $registerIcon.removeClass('fa fa-spinner fa-spin').addClass('glyphicon glyphicon-user');
                        return false;
                      }

                      if (pw.length < 6) {
                        $profileMessage.html("Password must be at least 6 characters").addClass('alert alert-danger');
                        $('#mw_password, #mw_confirm_password').addClass('error').closest('.form-group').find('label.control-label').addClass('error');
                        $registerIcon.removeClass('fa fa-spinner fa-spin').addClass('glyphicon glyphicon-user');
                        return false;
                      }

                      if(!/^(?=.*[A-Z])(?=.*[!@#$&%^()*])(?=.*[0-9])(?=.*[a-z]).{6,}$/.test(pw)) {
                        $('.mw-pw-notice').addClass('error');
                        $('#mw-register-message').html("Password does not match complexity requirements").addClass('alert alert-danger');
                        $('#mw_password, #mw_confirm_password').addClass('error').closest('.form-group').find('label.control-label').addClass('error');
                        $('.mw-register-icon').removeClass('fa fa-spinner fa-spin').addClass('glyphicon glyphicon-user');
                        return false;
                      }

                  }

                  var data = $('#MWAccountDetailsForm').serializeObject();
                  data.action = 'mw_save_account_details_ajax';

                  $.ajax({
                    url: mw_app.ajax_url,
                    dataType: 'json',
                    method: 'post',
                    data: data,
                    success:function(res) {
                      $('#MWAccountDetails').html(res.html).css({backgroundColor: '#aaffaa'}).animate({
                          backgroundColor: 'transparent'
                      },3000);
                      $('.mw-username').html(res.user.username);
                    },
                    error: function(res,status,error) {
                      if (getUrlParam('mw_debug')) {
                          console.log(status);
                          console.log(error);
                      }
                      $.alert({
                          title: 'Oops!',
                          content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>'+ error
                      });
                    }
                  });

                }
            });
        })

        .on('click','#mw-reset-pw-button',function(e) {

          e.preventDefault();

          $resetForm = $('form#mw-reset-password-form');
          $resetMessage = $('#mw-reset-password-message');
          $resetIcon = $('.mw-reset-pw-icon');
          $inputs = $('#mw_password, #mw_confirm_password');

          var pw = $('#mw_password').val();
          var cpw = $('#mw_confirm_password').val();

          $(this).find('i').removeClass('fa-check-square-o').addClass('fa-spinner fa-spin');

          if (pw || cpw) {
            if (pw !== cpw) {
              $resetMessage.html("Passwords do not match").addClass('alert alert-danger');
              $('#mw_confirm_password').addClass('error').closest('.form-group').find('label.control-label').addClass('error');
              $resetIcon.removeClass('fa-spinner fa-spin').addClass('fa-check-square-o');
              return false;
            }

            if (pw.length < 6) {
              $resetMessage.html("Password must be at least 6 characters").addClass('alert alert-danger');
              $inputs.addClass('error').closest('.form-group').find('label.control-label').addClass('error');
              $resetIcon.removeClass('fa-spinner fa-spin').addClass('fa-check-square-o');
              return false;
            }

            if (!/^(?=.*[A-Z])(?=.*[!@#$&%^()*])(?=.*[0-9])(?=.*[a-z]).{6,}$/.test(pw)) {
              $('.mw-pw-notice').addClass('error');
              $resetMessage.html("Password does not match complexity requirements").addClass('alert alert-danger');
              $inputs.addClass('error').closest('.form-group').find('label.control-label').addClass('error');
              $resetIcon.removeClass('fa-spinner fa-spin').addClass('fa-check-square-o');
              return false;
            }

          } else {
            $resetMessage.html('Please fill in required information').addClass('alert alert-danger');
            $resetIcon.removeClass('fa-spinner fa-spin').addClass('fa-check-square-o');
            $('#mw_password, #mw_confirm_password').addClass('error').closest('.form-group').find('label.control-label').addClass('error');
          }

          var data = $resetForm.serializeObject();
          data.action = 'mw_reset_password_ajax';

          $.ajax({
            url: mw_app.ajax_url,
            dataType: 'json',
            method: 'post',
            data: data,
            success: function (res) {
              if (res.success) {
                window.location.href = window.location.pathname + '?reset=true';
              } else {
                $resetMessage.html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> '+ res.message + '</div>');
                $resetIcon.removeClass('fa-spinner fa-spin').addClass('fa-check-square-o');
              }
            },
            error: function (res, status, error) {
              if (getUrlParam('mw_debug')) {
                console.log(status);
                console.log(error);
              }
              $resetIcon.removeClass('fa-spinner fa-spin').addClass('fa-check-square-o');
              $.alert({
                title: 'Oops!',
                content: "We're having trouble processing your request. Please try again.<br><br>Code: " + status + '<br>Message:<br>' + error
              });
            }
          });

      })

});

function checkUploadButton() {
    $docCategory = $('#documentCategory');
    if ($docCategory.is(':visible')) {
        if ($('#documentName').val() && $docCategory.val() && $('#fileData').val()) {
            $('#uploadButton').removeClass('btn-disabled').addClass('btn-primary');
        } else {
            $('#uploadButton').removeClass('btn-primary').addClass('btn-disabled');
        }
    } else {
        if ($('#documentName').val() && $('#fileData').val()) {
            $('#uploadButton').removeClass('btn-disabled').addClass('btn-primary');
        } else {
            $('#uploadButton').removeClass('btn-primary').addClass('btn-disabled');
        }
    }

}


function getUrlParam(param) {
    var s = window.location.search.replace('?','');
    var l = s.split('&');
    obj = {}
    var o = l.map(function(p) {
        kp = p.split('=');
        obj[kp[0]]=kp[1];
    });
    return obj[param];
}
