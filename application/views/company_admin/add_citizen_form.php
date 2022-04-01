<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Company Admin</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="<?php echo base_url(); ?>company_admins/index">Admin</a></li>
                            <li class=""><a href="<?php echo base_url(); ?>company_admins/citizens">Citizens</a></li>
                            <li class="active"><a href="#">Add Citizen</a></li>
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
                        <strong class="card-title">Add citizen</strong> <a class="btn btn-primary" href="<?php echo base_url(); ?>company_admins/citizens">View Citizens <i class="fas fa-eye fa-fw"></i></a>
                    </div>
                    <div class="card-body">
						<?php
							$attributes = array('id' => 'add-citizen-form');
							echo form_open_multipart('company_admins/create_citizen', $attributes);
						?>
							<?php if($this->session->flashdata("error")): ?>  
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo "<div class='alert alert-danger'>".$this->session->flashdata("error")."</div>";?>     
									</div>
								</div>
							<?php endif; ?>
							<?php if($this->session->flashdata("upload_error")): ?>  
								<div class="form-group">
									<div class="col-sm-12">
										<div class='alert alert-danger'>
											<?php $errors = $this->session->flashdata("upload_error"); ?>
											<?php foreach($errors as $error): ?>
												<?php echo $error; ?>
											<?php endforeach; ?>
										</div>
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
							<div class="form-group">
								<label for="name">Name <span class="must-fill-field">*</span></label>
								<input type="text" name="name" class="form-control" id="name" placeholder="E.g John Doe." maxlength="100" required/>
							</div>
							<div class="form-group">
								<label for="gender">Gender <span class="must-fill-field">*</span></label>
								<select name="gender" class="form-control" required>
									<option name="" value="">Please choose...</option>
									<option name="1">Male</option>
									<option name="2">Female</option>
								</select>
							</div>
							<div class="form-group">
								<label for="address">Address <span class="must-fill-field">*</span></label>
								<input type="text" name="address" class="form-control" id="address" placeholder="Your Address" maxlength="255" required/>
							</div>
							<div class="form-group">
								<label for="phone">Phone Number <span class="must-fill-field">*</span></label>
								<input type="text" name="phone" class="form-control" id="phone" placeholder="E.g 08091234567" maxlength="11" required/>
							</div>
							
							<div class="form-group">
								<label for="ward_id">Ward <span class="must-fill-field">*</span></label>
								<select name="ward_id" class="form-control" required>
									<option name="" value="">Please choose...</option>
									<?php $loop_no = 1; ?>
									<?php foreach($wards as $ward): ?>
										<?php
											$ward_id = $ward["id"];
											$ward_name = $ward["name"];
											$lga_id = $ward["lga_id"];

											$lga = $this->lga_model->findLgaById($lga_id);

											foreach($lga as $l) {
												$state_id = $l["state_id"];
												$lga_name = $l["name"];
											}

											$state = $this->state_model->findStateById($state_id);

											foreach($state as $s) {
												$state_name = $s["name"];
											}

											$ward_name_to_display = $ward_name.", ".$lga_name.", ".$state_name;
										?>
										<option name="<?php echo $loop_no; ?>" value="<?php echo $ward_id; ?>"><?php echo $ward_name_to_display; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<button type="submit" class="btn btn-primary" id="add-citizen-form-btn">Submit</button>
						</form>
					</div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div><!-- .content -->
