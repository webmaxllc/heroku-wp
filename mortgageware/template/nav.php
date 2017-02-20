<ul id="loan-application-nav" class="nav-steps loan-application-nav">
    <li class="<?=$step==1?'active':''?> <?=$step>1?'completed clickable':''?>">
        <a>
            <span class="title">Personal</span>
                <span class="description">
                    Name<br>
                    Address
                </span>
        </a>
    </li>
    <li class="<?=$step==2?'active':''?> <?=$step>2?'completed clickable':''?>">
        <a>
            <span class="title">Property</span>
                <span class="description">
                    Location<br>
                    Title
                </span>
        </a>
    </li>
    <li class="<?=$step==3?'active':''?> <?=$step>3?'completed clickable':''?>">
        <a>
            <span class="title">Employment</span>
                <span class="description">
                    Positions<br>
                    Dates
                </span>
        </a>
    </li>
    <li class="<?=$step==4?'active':''?> <?=$step>4?'completed clickable':''?>">
        <a>
            <span class="title">Assets</span>
                <span class="description">
                    Bank Accounts<br>
                    Real Estate
                </span>
        </a>
    </li>
    <li class="<?=$step==5?'active':''?> <?=$step>5?'completed clickable':''?>">
        <a>
            <span class="title">Housing</span>
                    <span class="description">
                        Expenses<br>
                        Income
                    </span>
        </a>
    </li>
    <li class="<?=$step==6?'active':''?> <?=$step>6?'completed clickable':''?>">
        <a>
            <span class="title">Declarations</span>
                <span class="description">
                    Government<br>
                    Financial
                </span>
        </a>
    </li>
    <li class="<?=$step==7?'active':''?>">
        <a>
            <span class="title">Submit App</span>
                <span class="description">
                    And you're done!
                </span>
        </a>
    </li>
</ul>

<div class="mobile-steps">
    <div class="progress">
        <div class="bar" style="width: <?=(100/7)*$step?>%;"></div>
    </div>
</div>