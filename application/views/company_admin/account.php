<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Account</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="<?php echo base_url(); ?>company_admins/index">Admin</a></li>
                            <li class=""><a href="#">account</a></li>
                            <li class="active"><a href="<?php echo base_url(); ?>company_admins/account">View Account</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Your Account </strong> <a class="btn btn-primary" href="<?php echo base_url(); ?>company_admins/edit_account">Edit Account <i class="fas fa-user"></i></a>
                    </div>
                    <div class="card-body">
                    <?php if($this->session->flashdata("error")): ?>  
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo "<div class='alert alert-error'>".$this->session->flashdata("errror")."</div>";?>     
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata("success")): ?>  
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo "<div class='alert alert-success'>".$this->session->flashdata("success")."</div>";?>     
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata("info")): ?>  
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo "<div class='alert alert-info'>".$this->session->flashdata("info")."</div>";?>     
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata("check_spam")): ?>              
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo "<div class='alert alert-danger'>".$this->session->flashdata("check_spam")."</div>";?>
                            </div>
                        </div>
                    <?php endif; ?>
                        <?php if(!empty($company_admin)): ?>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <?php $serial_no = 1; ?>
                                    <table id="" class="table table-striped table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Data</th>
                                                <th>Info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($company_admin as $comp_admin): ?>
                                                <tr>
                                                    <td>Email:</td>
                                                    <td><?php echo $comp_admin["email"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Role:</td>
                                                    <td>
                                                        <?php echo ucwords($comp_admin["role"]); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="alert alert-danger text-center">
                                        <p><strong>We can't find your account!</strong></p>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div><!-- .content -->