<form id="MWAccountDetailsForm" method="post">
    <?php
    MortgageWareForm::displayInput('user','username','text',array(
        'value'=>$user->username,
        'required'=>true,
        'natural'=>true
    ));

    MortgageWareForm::displayInput('user','first_name','text',array(
        'value'=>$user->first_name,
        'required'=>true,
        'natural'=>true
    ));

    MortgageWareForm::displayInput('user','last_name','text',array(
        'value'=>$user->last_name,
        'required'=>true,
        'natural'=>true
    ));

    MortgageWareForm::displayInput('user','email','text',array(
        'value'=>$user->email,
        'required'=>true,
        'natural'=>true
    ));

    MortgageWareForm::displayInput('user','password','password',array(
        'label'=>'New Password',
        'natural'=>true
    ));

    MortgageWareForm::displayInput('user','confirm_password','password',array(
        'natural'=>true
    ));
    ?>
    <div id="MWProfileMessage"></div>
</form>