<?php
    global $mw_settings;
?>
<div class="row">
    <div class="col-md-6">
        <h1 id="mw-register-title">Reset Password <i style="float: right;" class="fa fa-arrow-circle-up hidden-md hidden-lg" aria-hidden="true"></i></h1>
        <p class="lead"><?=MW_FORGOT_PASSWORD_TEXT?></p>
        <form id="mw-reset-password-form" method="post">
            <input type="hidden" name="_token" value="<?=$_REQUEST['rp_token']?>">
<?php
            MortgageWareForm::displayInput('user','password','password',array(
                'required' => true,
                'natural' => true,
                'label' => 'Password'
            ));

            MortgageWareForm::displayInput('user','confirm_password','password',array(
                'required' => true,
                'natural' => true,
                'label' => 'Confirm Password'
            ));

?>
            <p class="hint mw-password-notice">Password must be a minimum of 6 characters and must contain at least 1 of the following...<br>
                Capital Letter, Lowercase Letter, Number, & Symbol</p>
            <div class="col-sm-8 col-md-offset-4">
                <a id="MWHomeLink">I remember my password!</a>
            </div>
            <div class="clearfix"></div>
            <div class="text-center submit-wrapper">
                <div id="mw-reset-password-message" class="form-message"></div>
                <button type="submit" id="mw-reset-pw-button" class="btn btn-primary">Submit <i class="mw-reset-pw-icon fa fa-check-square-o"></i></button>
            </div>
        </form>
    </div>
</div>
