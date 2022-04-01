<div class="container">
    <section>
        <div class="row" style="margin-top: 40px;">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
                    <!--<form class="login100-form validate-form">-->
                    <?php
                        $attributes = array('id' => 'login-form', 'class' => 'login100-form validate-form');
                        echo form_open('users/login_company_admin/', $attributes);
                    ?>
                        <?php if($this->session->flashdata("info")): ?> 
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo "<div class='alert alert-danger'>".$this->session->flashdata("info")."</div>";?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata("spam")): ?>              
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo "<div class='alert alert-danger'>".$this->session->flashdata("spam")."</div>";?>
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
                        <?php if(validation_errors()): ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo "<div class='alert alert-danger'>".validation_errors()."</div>"; ?>
                                </div>
                            </div>
                        <?php endif ?>
                        <div style="display: none !important;">
                            <input type="text" name="check_spam" id="check_spam" placeholder="" value="">
                        </div>

                        <span class="login100-form-title p-b-33">
                            Account Login
                        </span>

                        <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                            <input class="input100" type="text" name="email" placeholder="Email">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>

                        <div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
                            <input class="input100" type="password" name="password" placeholder="Password">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>

                        <div class="container-login100-form-btn m-t-20">
                            <button class="login100-form-btn">
                                Sign in
                            </button>
                        </div>

                        <div class="text-center p-t-45 p-b-4">
                            <span class="txt1">
                                Forgot
                            </span>

                            <a href="<?php echo base_url(); ?>users/forgot_password" class="txt2 hov1">
                                Password?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>

    </section>
</div>
