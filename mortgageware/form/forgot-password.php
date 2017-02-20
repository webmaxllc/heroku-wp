<?php
    global $mw_settings;
?>
<div class="row">
    <div class="col-md-6">
        <h1 id="mw-register-title">Forgot Password <i style="float: right;" class="fa fa-arrow-circle-up hidden-md hidden-lg" aria-hidden="true"></i></h1>
        <p class="lead"><?=MW_FORGOT_PASSWORD_TEXT?></p>
        <form id="mw-forgot-password-form" method="post">
<?php
            MortgageWareForm::displayInput('user','username','text',array(
                'required' => true,
                'natural' => true,
                'label' => 'Email or Username'
            ));

?>
            <div class="col-sm-8 col-md-offset-4">
                <a id="MWHomeLink">I remember my password!</a>
            </div>
            <div class="clearfix"></div>
            <div class="text-center submit-wrapper">
                <div id="mw-forgot-password-message" class="form-message"></div>
                <button type="submit" id="mw-forgot-pw-button" class="btn btn-primary">Submit <i class="mw-forgot-pw-icon fa fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>
