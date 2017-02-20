<div id="mw-container" class="container-fluid <?=MW_HAS_SIDEBAR?'has-sidebar':'no-sidebar'?>">
    <section class="loan-app">
        <div id="mw-user">
            <?php
                if (isset($_SESSION['MW_USER'])) {
                    ?>
                    <div class="mw-welcome">Welcome <span class="mw-username"><?=$_SESSION['MW_USER']->username?></span> <i class="fa fa-caret-down" aria-hidden="true"></i></div>
                    <ul class="mw-user-nav">
                        <li><a class="mw-my-account">My Account <i class="fa fa-user"></i></a></li>
                        <li><a class="mw-new-loan-app">New Loan Application <i class="fa fa-file-text-o" aria-hidden="true"></i></a></li>
                        <li class="divider"></li>
                        <li><a class="mw-logout" href="?mw_logout=1">Logout <i class="fa fa-sign-out"></i></a></li>
                    </ul>
                    <?php
                }
            ?>
        </div>
        <div id="currentDisplay">