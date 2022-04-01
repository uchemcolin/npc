<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="main-navigation">
  <div class="container d-flex justify-content-between">
    <strong>
        <a class="navbar-brand" href="#">
            <h2><?php echo $title; ?></h2>
        </a>
    </strong>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <?php if($this->session->tempdata("npc_company_admin_id")): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>company_admins/index">YOUR ACCOUNT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>company_admins/logout">LOGOUT</a>
                </li>
            <?php else: ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo base_url() ?>users/login">LOGIN</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
  </div>
</nav>

  