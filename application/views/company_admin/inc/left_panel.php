<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
      <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="">
                <a href="<?php echo base_url(); ?>company_admins/index"><i class="menu-icon fas fa-home"></i>Home </a>
            </li>
			<li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-users"></i>Citizens </a>
                <ul class="sub-menu children dropdown-menu">                            
                    <li>
                        <a href="<?php echo base_url(); ?>company_admins/citizens">
                            View Citizens
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>company_admins/add_citizen">
                            Add Citizen
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-user"></i>Your Account </a>
                <ul class="sub-menu children dropdown-menu">                            
                    <li>
                        <a href="<?php echo base_url(); ?>company_admins/account">
                            View Your Account
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>company_admins/edit_account">
                            Edit Your Account
                        </a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="<?php echo base_url(); ?>company_admins/logout"><i class="menu-icon fas fa-sign-out-alt"></i>Logout </a>
            </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </nav>
</aside>
