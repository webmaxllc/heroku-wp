<?php
        $lastAccess = new DateTime($user->last_access);
?>
<div id="MWAccountDetails">
        <div><strong>Username: </strong><?=$user->username?></div>
        <div><strong>First Name: </strong><?=$user->first_name?></div>
        <div><strong>Last Name: </strong><?=$user->last_name?></div>
        <div><strong>Email: </strong> <?=$user->email?></div>
        <div><strong>Last Login:</strong> <?=$lastAccess->format(MW_DATETIME_FORMAT)?></div>
        <br>
        <a id="NWEditAccountDetails">edit</a>
</div>