<?php

/**
 * Class MortgageWareUser
 */
class MortgageWareUser
{

    /**
     * Register Ajax
     */
    public static function registerAjax()
    {
        if ($_REQUEST['password'] !== $_REQUEST['confirm_password']) {
            exit(json_encode(array("status"=>"Password Mismatch","message"=>"Passwords do not match","user"=>null)));
        }
        if (!preg_match("/^(?=.*[A-Z])(?=.*[!@#$&%^()*])(?=.*[0-9])(?=.*[a-z]).{6,}$/", $_REQUEST['password'])) {
            exit(json_encode(array("status"=>"Password Complexity","message"=>"Passwords does not meet complexity requirements","user"=>null)));
        }
        $_REQUEST['site']['id'] = $_SESSION['MW_SITE_ID'];
        $_REQUEST['plain_password'] = $_REQUEST['password'];
        $_REQUEST['role'] = MW_USER_ROLE;
        $_REQUEST['notify_user'] = MW_NOTIFY_USER;
        $result = MortgageWareAPI::register($_REQUEST);
        $registration = json_decode($result);
        if (property_exists($registration,'status')) {
            if ($registration->status == 'User Added') {
                $user = json_decode($registration->user);
                $_SESSION['MW_USER_ID'] = $user->id;
                $_SESSION['MW_USER'] = $user;
            }
        }
        exit($result);
    }

    /**
     * Login Ajax
     */
    public static function loginAjax()
    {
        $result = MortgageWareAPI::login($_POST);
        $authentication = json_decode($result);
        if (property_exists($authentication,'status')) {
            if ($authentication->status == 'Authenticated') {
                $user = json_decode($authentication->user);
                $_SESSION['MW_USER_ID'] = $user->id;
                $_SESSION['MW_USER'] = $user;
                if (isset($_POST['remember']) && $_POST['remember'] == 1) {
                    setcookie( 'MW_USERNAME', $user->username, 30 * 86400, COOKIEPATH, COOKIE_DOMAIN );
                } else {
                    setcookie( 'MW_USERNAME', null, 30 * 86400, COOKIEPATH, COOKIE_DOMAIN );
                }
            }
        }
        exit($result);
    }

    /**
     * Logged In Ajax
     */
    public static function loggedInAjax()
    {
        MortgageWare::determineDisplay();
        exit();
    }

    /**
     * Check Session Ajax
     */
    public static function checkSessionAjax()
    {
        $response = array();
        if (!isset($_SESSION['MW_USER'])) {
            $response['logout'] = true;
        }
        exit(json_encode($response));
    }

    /**
     * Determine if User is the Applicant
     *
     * @param $user
     * @param $app
     * @return bool
     */
    public static function isClientUser($user,$app)
    {
        $isClientUser = false;
        if (isset($app->client_user)) {
            if (count($app->client_user) > 0) {
                foreach ($app->client_user as $clientUser) {
                    if ($clientUser->id == $user->id) {
                        $isClientUser = true;
                        break;
                    }
                }
            }
        }

        return $isClientUser;
    }

    /**
     * Get the Role of the Primary Loan User
     *
     * @param $user
     * @param $app
     * @return string
     */
    public static function getLoanUserRoleType($user,$app)
    {
        $roleType = 'Website Admin';
        if (self::isClientUser($user,$app)) {
            $roleType = 'Additional User';
        } elseif (isset($app->user)) {
            if ($user->id == $app->user->id) {
                if (self::hasRole($user,'ROLE_LOAN_OFFICER')) {
                    $roleType = 'Loan Officer';
                } else {
                    $roleType = 'Applicant';
                }
            }
        }

        return $roleType;
    }

    /**
     * Check if a User Has a Role
     *
     * @param $user
     * @param $roleName
     * @return bool
     */
    public static function hasRole($user,$roleName)
    {
        foreach($user->roles as $userRole) {
            if($userRole->role == $roleName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Edit Account Details Ajax
     */
    public static function editAccountDetailsAjax()
    {
        $user = $_SESSION['MW_USER'];
        if (isset($user)) {
            require_once __DIR__.'/../page/modal/edit-account-details.php';
        }
        exit();
    }

    /**
     * Edit Account Details Ajax
     */
    public static function saveAccountDetailsAjax()
    {
        if (!empty($_REQUEST['password'])) {
            if ($_REQUEST['password'] !== $_REQUEST['confirm_password']) {
                exit(json_encode(array("status" => "Password Mismatch", "message" => "Passwords do not match", "user" => null)));
            }
            if (!preg_match("/^(?=.*[A-Z])(?=.*[!@#$&%^()*])(?=.*[0-9])(?=.*[a-z]).{6,}$/", $_REQUEST['password'])) {
                exit(json_encode(array("status" => "Password Complexity", "message" => "Passwords does not meet complexity requirements", "user" => null)));
            }
            $_REQUEST['plain_password'] = $_REQUEST['password'];
        }

        $result = MortgageWareAPI::editUser($_SESSION['MW_USER_ID'],$_REQUEST);
        $user = json_decode($result);

        $_SESSION['MW_USER'] = $user;

        $lastAccess = new DateTime($user->last_access);
        $response = array(
            'user' => $user,
            'html' => '
                <div><strong>Username: </strong>'.$user->username.'</div>
                <div><strong>First Name: </strong>'.$user->first_name.'</div>
                <div><strong>Last Name: </strong>'.$user->last_name.'</div>
                <div><strong>Email: </strong> '.$user->email.'</div>
                <div><strong>Last Login:</strong> '.$lastAccess->format(MW_DATETIME_FORMAT).'</div>
                <br>
                <a id="NWEditAccountDetails">edit</a>
            '
        );

        exit(json_encode($response));
    }

    public function myAccountAjax()
    {
        unset($_SESSION['MW_NEW_LOAN'],$_SESSION['MW_CURRENT_LOAN'],$_SESSION['MW_CURRENT_LOAN_STEP']);
        $_SESSION['MW_PAGE'] = 'member-portal';
        MortgageWare::determineDisplay();
        exit();
    }

    public function forgotPasswordFormAjax()
    {
        $_SESSION['MW_FORGOT_PW'] = true;
        self::loadForgotPasswordForm();
        exit();
    }

    public static function loadForgotPasswordForm()
    {
        require_once __DIR__.'/../form/forgot-password.php';
    }

    public function forgotPasswordAjax()
    {
        if (!empty($_REQUEST['username'])) {
            $request = MortgageWareAPI::forgotPassword($_REQUEST['username'],$_REQUEST['url']);
            if ('Email Sent' === $request->status) {
                $response = array(
                    'success' => true
                );
                $_SESSION['MW_FORGOT_PW'] = false;
                $_SESSION['MW_FORGOT_PW_EMAIL_SENT'] = true;
            } else {
                $response = array(
                    'message' => $request->status
                );
            }

            exit(json_encode($response));
        }
    }

    public static function loadResetPasswordForm()
    {
        unset($_SESSION['MW_FORGOT_PW']);
        require_once __DIR__.'/../form/reset-password.php';
    }

    public function resetPasswordAjax()
    {
        $request = MortgageWareAPI::resetPassword(array('token'=>$_REQUEST['_token'],'plain_password'=>$_POST['password']));
        if ('Password Reset' === $request->status) {
            $response = array(
                'success' => true
            );
        } else {
            $message = $request->status;
            switch ($request->status) {
                case 'Invalid Token':
                    $message = 'The token provided is invalid or has expired.<br>Please request a new token by clicking <a id="forgotPasswordLink">here</a>.';
                    break;
            }
            $response = array(
                'message' => $message
            );
        }

        exit(json_encode($response));
    }

    public static function loadLoginRegister()
    {
        require_once __DIR__ . '/../form/login-register.php';
    }

}