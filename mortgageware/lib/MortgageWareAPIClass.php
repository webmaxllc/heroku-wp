<?php

/**
 * Class MortgageWareAPI
 */
class MortgageWareAPI
{

    const debug=MW_API_DEBUGGING;
    const oauthURI='/oauth/v2/token';
    const getSettingsURI='/api/v1/settings';
    const getLocationStatesURI='/api/v1/location/states';
    const getAllStatesURI='/api/v1/location/state';
    const loginURI='/api/v1/users/login';
    const usersURI='/api/v1/users';
    const loansURI='/api/v1/loans';
    const getBorrowerURI='/api/v1/borrowers';
    const getUserLoansURI='/api/v1/users/loans/active';
    const loanOfficersURI='/api/v1/loanofficers';
    const messagesURI='/api/v1/messages';
    const documentsURI='/api/v1/documents';
    const forgotPasswordURI = '/api/v1/users/forgotpw';


    /**
     * Authenticate User
     *
     * @param $data
     * @return array|mixed|object
     */
    public static function login($data)
    {
        self::checkAPIToken();
        return self::postCurl(MW_URL.self::loginURI.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],$data);
    }

    /**
     * Register User
     *
     * @param $data
     * @return array|mixed|object
     */
    public static function register($data)
    {
        self::checkAPIToken();
        return self::postCurl(MW_URL.self::usersURI.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],$data);
    }

    /**
     * Edit User
     *
     * @param $userId
     * @param $data
     * @return array|mixed|object
     */
    public static function editUser($userId,$data)
    {
        self::checkAPIToken();
        return self::putCurl(MW_URL.self::usersURI.'/'.$userId.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],$data);
    }

    /**
     * Edit User
     *
     * @param $userId
     * @param $data
     * @return array|mixed|object
     */
    public static function resetPassword($data)
    {
        self::checkAPIToken();
        return self::putCurl(MW_URL.self::usersURI.'/resetpw?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],$data,true,true);
    }

    /**
     * Get Settings
     *
     * @return array|mixed|object
     */
    public static function getSettings() {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::getSettingsURI.'/'.$_SESSION['MW_SITE_ID'].'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Get Location States
     *
     * @return array|mixed|object
     */
    public static function getLocationStates() {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::getLocationStatesURI.'/'.$_SESSION['MW_SITE_ID'].'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Get All States
     *
     * @return array|mixed|object
     */
    public static function getAllStates() {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::getAllStatesURI.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Get Loan by ID
     *
     * @param $loanID
     * @return array|mixed|object
     */
    public static function getLoan($loanID)
    {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::loansURI.'/'.$loanID.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Get Loan by GUID
     *
     * @param $guid
     * @return array|mixed|object
     */
    public static function getLoanByGuid($guid)
    {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::loansURI.'/guid/'.$guid.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Delete Loan by ID
     *
     * @param $loanID
     * @return array|mixed|object
     */
    public static function deleteLoan($loanID)
    {
        self::checkAPIToken();
        return self::deleteCurl(MW_URL.self::loansURI.'/'.$loanID.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Delete Loan by GUID
     *
     * @param $guid
     * @return array|mixed|object
     */
    public static function deleteLoanByGuid($guid)
    {
        self::checkAPIToken();
        return self::deleteCurl(MW_URL.self::loansURI.'/guid/'.$guid.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Undelete Loan by ID
     *
     * @param $loanID
     * @return array|mixed|object
     */
    public static function undeleteLoan($loanID)
    {
        self::checkAPIToken();
        $data = new stdClass;
        $data->id = $loanID;
        $data->deleted = false;
        return self::putCurl(MW_URL.self::loansURI.'/'.$loanID.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],$data,true,true);
    }

	/**
	 * UnDelete Loan by GUID
	 *
	 * @param $guid
	 * @return array|mixed|object
	 */
	public static function unDeleteLoanByGuid($guid)
	{
		self::checkAPIToken();
		$data = new stdClass;
		$data->deleted = false;
		self::checkAPIToken();
		return self::putCurl(MW_URL.self::loansURI.'/guid/'.$guid.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
	}

    /**
     * Add Loan
     *
     * @param $data
     * @return array|mixed|object
     */
    public static function addLoan($data)
    {
        self::checkAPIToken();
        return self::postCurl(MW_URL.self::loansURI.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],$data,true,true);
    }

    /**
     * Edit Loan
     *
     * @param $loanID
     * @param $data
     * @return array|mixed|object
     */
    public static function editLoan($loanID,$data)
    {
        self::checkAPIToken();
        return self::putCurl(MW_URL.self::loansURI.'/'.$loanID.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],$data,true,true);
    }

    /**
     * Export Loan
     *
     * @param $loanID
     * @param $format
     * @return array|mixed|object
     */
    public static function exportLoan($loanID,$format='mismo231')
    {
        self::checkAPIToken();
        if ($format == 'mismo231') {
            $uri = self::loansURI.'/export/mismo231';
        } else if ($format == 'fanniemae32') {
            $uri = self::loansURI.'/export/fanniemae32';
        } else {
            return 'Invalid Format';
        }
        return self::getCurl(MW_URL.$uri.'/'.$loanID.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Get User Loans
     *
     * @param $userID
     * @return array|mixed|object
     */
    public static function getUserLoans($userID)
    {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::getUserLoansURI.'/'.$_SESSION['MW_SITE_ID'].'/'.$userID.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Get Loan Officer
     *
     * @param $loanOfficerID
     * @return array|mixed|object
     */
    public static function getLoanOfficer($loanOfficerID)
    {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::loanOfficersURI.'/'.$loanOfficerID.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Get Loan Officer Loans
     *
     * @param $loanOfficerID
     * @return array|mixed|object
     */
    public static function getLoanOfficerLoans($loanOfficerID)
    {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::loanOfficersURI.'/loans/'.$_SESSION['MW_SITE_ID'].'/'.$loanOfficerID.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Get Borrower
     *
     * @param $borrowerId
     * @return array|mixed|object
     */
    public static function getBorrower($borrowerId)
    {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::getBorrowerURI.'/'.$borrowerId.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Add Loan Message
     *
     * @param $data
     * @return array|mixed|object
     */
    public static function addLoanMessage($data)
    {
        self::checkAPIToken();
        return self::postCurl(MW_URL.self::messagesURI.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],$data,true,true);
    }

    /**
     * Get Message
     *
     * @param $messageId
     * @return array|mixed|object
     */
    public static function getMessage($messageId)
    {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::messagesURI.'/'.$messageId.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Get Loan Document Categories
     *
     * @return array|mixed|object
     */
    public static function getLoanDocumentCategories()
    {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::documentsURI.'/categories/'.$_SESSION['MW_SITE_ID'].'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Add Loan Document
     *
     * @param $data
     * @return array|mixed|object
     */
    public static function addLoanDocument($data)
    {
        self::checkAPIToken();
        return self::postCurl(MW_URL.self::documentsURI.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],$data,true,true);
    }

    /**
     * Get Loan Document Categories
     * @param $documentId
     * @return array|mixed|object
     */
    public static function getLoanDocument($documentId)
    {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::documentsURI.'/'.$documentId.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],true);
    }

    /**
     * Get Loan Document Categories
     * @param $documentId
     * @return array|mixed|object
     */
    public static function getLoanDocumentContent($documentId)
    {
        self::checkAPIToken();
        return self::getCurl(MW_URL.self::documentsURI.'/content/'.$documentId.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],false);
    }

    /**
     * Approve Loan Document
     * @param $documentId
     * @return mixed
     */
    public static function approveLoanDocument($documentId)
    {
        self::checkAPIToken();
        $data = new stdClass;
        $data->id = $documentId;
        $data->status = 3;
        return self::putCurl(MW_URL.self::documentsURI.'/'.$documentId.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],$data,true,true);
    }

    /**
     * Forgot Password
     * @param $username
     * @param $url
     * @return mixed
     */
    public static function forgotPassword($username, $url=null) {
        self::checkAPIToken();
        $data = new stdClass();
        $data->email = $username;
        $data->url = $url;
        return self::postCurl(MW_URL.self::forgotPasswordURI.'?access_token='.$_SESSION['MW_API_ACCESS_TOKEN'],$data,true,true);
    }

    /**
     * Check API Token
     */
    public static function checkAPIToken()
    {
        if (!isset($_SESSION['MW_API_ACCESS_TOKEN'])) {
            self::getToken();
        } else if ($_SESSION['MW_API_TOKEN_EXPIRATION'] < time()) {
            self::refreshToken();
        }
    }

    /**
     * Oauth Authentication
     */
    public static function getToken()
    {
        $oauth = self::getCurl(MW_URL.self::oauthURI.'?api_key='.MW_API_KEY.'&client_id='.MW_CLIENT_ID.'&client_secret='.MW_CLIENT_SECRET.'&grant_type='.MW_GRANT_TYPE,true);
        if (is_object($oauth) && property_exists($oauth,'access_token')) {
            $_SESSION['MW_API_ACCESS_TOKEN'] = $oauth->access_token;
            $_SESSION['MW_API_REFRESH_TOKEN'] = $oauth->refresh_token;
            $_SESSION['MW_API_TOKEN_EXPIRATION'] = time() + $oauth->expires_in;
        }
    }

    /**
     * Oauth Refresh
     */
    public static function refreshToken()
    {
        $oauth = self::getCurl(MW_URL.self::oauthURI.'?api_key='.MW_API_KEY.'&client_id='.MW_CLIENT_ID.'&client_secret='.MW_CLIENT_SECRET.'&grant_type=refresh_token&refresh_token='.$_SESSION['MW_API_REFRESH_TOKEN']);
        if (is_object($oauth) && property_exists($oauth,'access_token')) {
            $_SESSION['MW_API_ACCESS_TOKEN'] = $oauth->access_token;
            $_SESSION['MW_API_REFRESH_TOKEN'] = $oauth->refresh_token;
            $_SESSION['MW_API_TOKEN_EXPIRATION'] = time() + $oauth->expires_in;
        } else {
            self::getToken();
        }

    }


    /**
     * GET cURL Request
     *
     * @param $url
     * @param bool $decode
     * @return array|mixed|object
     */
    public static function getCurl($url,$decode=false)
    {
        $response = self::execCurl(self::initCurl($url),$decode);
        if (self::debug) {
            echo "GET";
            var_dump($url);
            var_dump($response);
        }
        return $response;
    }

    /**
     * POST cURL Request
     *
     * @param $url
     * @param $data
     * @param bool $encode
     * @param bool $decode
     * @return array|mixed|object
     */
    public static function postCurl($url,$data,$encode=true,$decode=false)
    {
        if ($encode === true) $data = json_encode($data);
        if (self::debug == true) {
            print_r($data);
        }
        $response = self::execCurl(self::initCurl($url,$data),$decode);

        if (self::debug || property_exists($response,'error')) {
            echo "POST";
            var_dump($url);
            var_dump($data);
            var_dump($response);
        }
        return $response;
    }

    /**
     * PUT cURL Request
     *
     * @param $url
     * @param $data
     * @param bool $encode
     * @param bool $decode
     * @return array|mixed|object
     */
    public static function putCurl($url,$data,$encode=true,$decode=false)
    {
        if ($encode === true) $data = json_encode($data);
        if (self::debug) {
            print_r($data);
        }
        $response = self::execCurl(self::initCurl($url,$data,'PUT'),$decode);
        if (self::debug || property_exists($response,'error')) {
            echo "PUT";
            var_dump($url);
            var_dump($response);
        }
        return $response;
    }

    /**
     * DELETE cURL Request
     *
     * @param $url
     * @param bool $decode
     * @return array|mixed|object
     */
    public static function deleteCurl($url,$decode=false)
    {
        $response = self::execCurl(self::initCurl($url),$decode);
        if (self::debug) {
            echo "DELETE";
            var_dump($url);
            var_dump($response);
        }
        return $response;
    }


    /**
     * Initialize cURL Request
     *
     * @param $url
     * @param null $post
     * @param null $method
     * @return resource
     */
    public static function initCurl($url,$post=null,$method=null)
    {
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        if (isset($post)) {
            if (isset($method)) {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
            } else {
                curl_setopt($ch,CURLOPT_POST,true);
            }
            curl_setopt($ch,CURLOPT_POSTFIELDS, $post);
        } else if (isset($method)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        }
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_VERBOSE,true);

        return $ch;
    }

    /**
     * Execute cURL Request
     *
     * @param $ch
     * @param bool $decode
     * @return array|mixed|object
     */
    public static function execCurl($ch,$decode=false) {
        $result = curl_exec($ch);

        curl_close($ch);

        if ($decode === true) {
            $result = json_decode($result);
        }

        return $result;
    }

}