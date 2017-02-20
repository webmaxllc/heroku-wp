<?php

/**
 * Class MortgageWareDocument
 */
class MortgageWareDocument
{

    /**
     * Statuses
     * @var array
     */
    public static $statuses = array(
        0 => 'New',
        1 => 'Not Submitted',
        2 => 'Awaiting Review',
        3 => 'Accepted',
        4 => 'Rejected'
    );

    /**
     * LOS Statuses
     * @var array
     */
    public static $losStatuses = array(
        0 => 'Not Sent',
        1 => 'Sent',
        2 => 'Pending Download',
        3 => 'Pending Upload',
        4 => 'Received',
        5 => 'Failed',
        6 => 'Queued',
    );

    /**
     * Add Loan Document Ajax
     */
    public static function addLoanDocumentAjax()
    {;
        $content = substr($_REQUEST['file']['content'],strpos($_REQUEST['file']['content'],','));
        $mime_type = substr($_REQUEST['file']['content'],0,strpos($_REQUEST['file']['content'],';'));
        $mime_type = substr($mime_type,strpos($mime_type,':')+1);
        $_REQUEST['file']['content'] = $content;
        $_REQUEST['file']['site']['id'] = $_SESSION['MW_SITE_ID'];
        $_REQUEST['file']['name'] = $_REQUEST['name'];
        $_REQUEST['file']['user']['id'] = $_SESSION['MW_USER_ID'];
        $_REQUEST['file']['public'] = false;
        $_REQUEST['file']['mime_type'] = $mime_type;
        $loan = MortgageWareAPI::getLoanByGuid($_REQUEST['guid']);
        $document = MortgageWareAPI::addLoanDocument($_REQUEST);
        $sent = new DateTime($document->created);
        if (isset($document->type)) {
            $category = $document->type->term;
        } else {
            $category = 'none';
        }
        if ($_POST['table']) {
            $document->row = '
                <tr data-document_id="'.$document->id.'">' .
                '<td>'.$document->name.'</td>' .
                '<td>'.$category.'</td>' .
                '<td>'.$sent->format(MW_DATETIME_FORMAT).'</td>' .
                '<td>'.$document->file->user->username.'</td>' .
                '<td>'.self::$statuses[$document->status].'</td>' .
                '<td><button class="btn btn-primary MWDownloadDocument">Download <i class="fa fa-download" aria-hidden="true"></i> </button></td>' .
                '</tr>';
        }
        exit(json_encode($document));
    }

    /**
     * Download Loan Document
     */
    public static function downloadLoanDocument()
    {
        $document = MortgageWareAPI::getLoanDocument($_REQUEST['document']);

        $content = base64_decode(MortgageWareAPI::getLoanDocumentContent($document->id));

        header('Content-Type: '.$document->file->mime_type);
        header('Content-disposition: attachment; filename='.basename($document->file->path));
        header("Pragma: no-cache");
        header("Expires: 0");

        exit($content);
    }

    /**
     * Approve Loan Document Ajax
     */
    public static function approveLoanDocumentAjax() {

        $document = MortgageWareAPI::approveLoanDocument($_REQUEST['document']);
        exit(json_encode($document));
    }

}