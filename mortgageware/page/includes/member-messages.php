<div class="mw-loan-view temp-hide" id="mw-loan-messages-view">
    <div id="loanMessages" class="MWLoanSection">
        <div class="col-md-12">
            <h2>Messages</h2>
            <div class="table-responsive" id="MWLoanMessages">
                <?php
                if (!empty($loan->message_thread->message)) {
                    ?>
                    <table class="table table-striped data-table" style="width: 100%">
                        <thead>
                        <tr>
                            <th>Sender</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Date Sent</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($loan->message_thread->message as $message) {
                            $sent = new DateTime($message->created);
                            $message->message = strip_tags($message->message);
                            if (strlen($message->message) > 30) {
                                // truncate string
                                $stringCut = substr($message->message, 0, 30);
                                // make sure it ends in a word so assassinate doesn't become ass...
                                $message->message = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
                            }
                            //var_dump($loan->message_thread);
                            ?>
                            <tr data-message_id="<?=$message->id?>">
                                <td><?=$message->user->first_name.' '.$message->user->last_name?></td>
                                <td><?=$message->message?></td>
                                <td><?=MortgageWareMessage::$statuses[$message->status]?></td>
                                <td><?=$sent->format(MW_DATETIME_FORMAT)?></td>
                                <td><button class="btn btn-primary MWViewMessage">View</button></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo "There are no messages to display";
                }
                ?>
            </div>
        </div>
        <form id="mw-message-form">
            <input type="hidden" name="thread[id]" value="<?=$loan->message_thread->id?>">
            <input type="hidden" name="user[id]" value="<?=$_SESSION['MW_USER_ID']?>">
            <div class="form-group">
                <div class="col-md-4">
                    <textarea class="form-control" placeholder="Add Message" name="message" required></textarea>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary" id="sendMessage">Send Message</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <div class="form-message"></div>
            </div>
        </form>
    </div>
</div>