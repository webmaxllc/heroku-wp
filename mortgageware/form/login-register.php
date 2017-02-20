<?php
    global $mw_settings;
?>
<div class="row">
    <?php
    if (isset($_GET['timeout'])) {
        ?>
        <div class="timeout alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <?=MW_INACTIVITY_LOG_OUT_TEXT?></div>
        <?php
    }
    if (isset($_GET['reset'])) {
        ?>
        <div class="timeout alert alert-success"><i class="fa fa-check"></i> <?=MW_PASSWORD_RESET_TEXT?></div>
        <?php
    }
    if (isset($_SESSION['MW_FORGOT_PW_EMAIL_SENT'])) {
        unset ($_SESSION['MW_FORGOT_PW_EMAIL_SENT']);
        ?>
        <div class="alert alert-success"><i class="fa fa-envelope-o"></i> <?=MW_FORGOT_PASSWORD_EMAIL_SENT_TEXT?></div>
        <?php
    }
    ?>
    <p class="lead"><?=MW_LOGIN_REGISTER_TEXT?></p>
    <div class="col-md-6">
        <h1 id="mw-register-title">Register<i style="float: right;" class="fa fa-arrow-circle-up hidden-md hidden-lg" aria-hidden="true"></i></h1>
        <form id="mw-register-form" method="post">
<?php
            MortgageWareForm::displayInput('user','username','text',array(
                'required' => true,
                'natural' => true
            ));

            MortgageWareForm::displayInput('user','email','text',array(
                'required' => true,
                'natural' => true
            ));

            MortgageWareForm::displayInput('user','first_name','text',array(
                'required' => false,
                'natural' => true
            ));

            MortgageWareForm::displayInput('user','last_name','text',array(
                'required' => false,
                'natural' => true
            ));

            MortgageWareForm::displayInput('user','cell_phone','text',array(
                'required' => false,
                'natural' => true,
                'class' => 'phone'
            ));

            MortgageWareForm::displayInput('user','timezone','select',array(
                'required' => true,
                'natural' => true,
                'options' => MortgageWare::$timezones,
                'value' => $mw_settings->timezone,
                'nullOption' => 'Select a Timezone'
            ));
            ?>
            <div class="col-md-7 col-md-offset-4"><p class="mw-pw-notice">Password must be a minimum of 6 characters and must contain at least 1 of the following...<br>Capital Letter, Lowercase Letter, Number, & Symbol</p></div>
            <?php
            MortgageWareForm::displayInput('user','password','password',array(
                'required' => true,
                'natural' => true
            ));

            MortgageWareForm::displayInput('user','confirm_password','password',array(
                'required' => true,
                'natural' => true
            ));

            MortgageWareForm::displayInput('user','alert','checkbox',array(
                'required' => false,
                'checked' => true,
                'value' => 1,
                'label_size' => 8,
                'label_offset' => 4,
                'label' => 'Receive Notifications',
                'natural' => true
            ));
?>
            <div class="text-center submit-wrapper">
                <div id="mw-register-message" class="form-message"></div>
                <button type="submit" id="mw-register-button" class="btn btn-primary">Register <i class="mw-register-icon fa fa-user-plus"></i></button>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <h1 id="mw-login-title">Login <i style="float: right;" class="fa fa-arrow-circle-down hidden-md hidden-lg" aria-hidden="true"></i></h1>
        <form id="mw-login-form" method="post">
<?php
            MortgageWareForm::displayInput(null,'_username','text',array(
                'required' => true,
                'natural' => true,
                'label' => 'Username',
                'value' => array_key_exists('MW_USERNAME',$_COOKIE)?$_COOKIE['MW_USERNAME']:''
            ));

            MortgageWareForm::displayInput(null,'_password','password',array(
                'required' => true,
                'natural' => true,
                'label' => 'Password'
            ));
?>
            <div class="form-group">
<?php       /*
            MortgageWareForm::displayInput(null,'remember','checkbox',array(
                'natural' => true,
                'value' => 1,
                'label_size' => 8,
                'label_offset' => 4,
                'label' => 'Remember Username?',
                'checked' => array_key_exists('MW_USERNAME',$_COOKIE)
            ));
            */
?>
                <div class="col-sm-8 col-md-offset-4">
                    <a id="forgotPasswordLink">Forgot password?</a>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="text-center submit-wrapper">
                <div id="mw-login-message" class="form-message"></div>
                <button type="submit" id="mw-login-button" class="btn btn-primary">Login <i class="mw-login-icon fa fa-sign-in"></i></button>
            </div>
        </form>
    </div>
</div>
