<?php

/**
 * Class MortgageWareMessage
 */
class MortgageWareMessage
{

    /**
     * Statuses
     * @var array
     */
    public static $statuses = array(
        'New',
        'Read',
        'Ignored'
    );

    /**
     * Add Loan Message Ajax
     */
    public static function addLoanMessageAjax() {
        $message = MortgageWareAPI::addLoanMessage($_REQUEST);

        $sent = new DateTime($message->created);
        $message->message = strip_tags($message->message);
        if (strlen($message->message) > 30) {
            // truncate string
            $stringCut = substr($message->message, 0, 30);
            // make sure it ends in a word so assassinate doesn't become ass...
            $message->message = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
        }
        if ($_POST['table']) {
            $message->row = '
                <tr data-message_id="'.$message->id.'">' .
                    '<td>'.$_SESSION['MW_USER']->first_name.' '.$_SESSION['MW_USER']->last_name.'</td>' .
                    '<td>'.$message->message.'</td>' .
                    '<td>'.self::$statuses[$message->status].'</td>' .
                    '<td>'.$sent->format(MW_DATETIME_FORMAT).'</td>' .
                    '<td><button class="btn btn-primary MWViewMessage">View</button></td>' .
                '</tr>';
        }
        exit(json_encode($message));
    }

    /**
     * View Message Ajax
     */
    public static function viewMessageAjax() {
        $message = MortgageWareAPI::getMessage($_REQUEST['message_id']);
        require_once __DIR__.'/../page/modal/message-view.php';
        exit();
    }


}