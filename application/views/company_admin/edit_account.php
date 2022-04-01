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
                            <li class=""><a href="#">Account</a></li>
                            <li class="active"><a href="<?php echo base_url(); ?>company_admins/edit_account">Edit Account</a></li>
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
                        <strong class="card-title">Edit your Account </strong>
                    </div>
                    <div class="card-body">
                        <?php if(validation_errors()): ?>  
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo "<div class='alert alert-danger'>".validation_errors()."</div>";?>     
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata("error")): ?>  
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo "<div class='alert alert-danger'>".$this->session->flashdata("error")."</div>";?>     
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
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <?php foreach($company_admin as $comp_admin): ?>
                                        <?php
                                            $attributes = array('id' => 'edit-email-form');
                                            echo form_open('company_admins/update_account_email', $attributes);
                                        ?>
                                            <div style="display: none !important;">
                                                <input type="text" name="check_spam" id="check_spam" placeholder="" value="">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email Address</label>
                                                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter your email address" value="<?php echo $comp_admin["email"]; ?>">
                                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block" id="update-supervisor-email-btn">UPDATE</button>
                                        </form>
                                        <hr>
                                        <?php
                                            $attributes = array('id' => 'edit-password-form');
                                            echo form_open('company_admins/update_account_password', $attributes);
                                        ?>
                                            <div style="display: none !important;">
                                                <input type="text" name="check_spam" id="check_spam" placeholder="" value="">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Old Password</label>
                                                <input type="password" class="form-control" name="old_password" id="old-password" placeholder="Enter your old password">
                                                <small id="passwordHelp" class="form-text text-muted">At least 6 characters in length.</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">New Password</label>
                                                <input type="password" class="form-control" name="new_password" id="new-password" placeholder="Enter your new password">
                                                <small id="passwordHelp" class="form-text text-muted">At least 6 characters in length.</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Confirm Password</label>
                                                <input type="password" class="form-control" name="confirm_new_password" id="confirm-password" placeholder="Retype your password">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block" id="update-password-btn">UPDATE</button>
                                        </form>
                                    <?php endforeach; ?>
                                </div>
                                <div class="col-md-3"></div>
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
