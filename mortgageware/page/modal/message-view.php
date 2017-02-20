<?php
    $created = new DateTime($message->created);
?>
<div id="messageInfo" class="MWLoanSection">
    <div>
        <div><strong>Sender: </strong> <?=$message->user->first_name?> <?=$message->user->last_name?></div>
        <div><strong>Date: </strong> <?=$created->format(MW_DATETIME_FORMAT)?></div>
        <div><strong>Status: </strong> <?=$message->user->first_name?> <?=$message->user->last_name?></div>
        <div><strong>Message: </strong> <?=$message->message?></div>
    </div>
</div>
