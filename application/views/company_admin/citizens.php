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
                            <li class=""><a href="#">Company Admin</a></li>
                            <li class="active"><a href="<?php echo base_url(); ?>company_admins/citizens">View Citizens</a></li>
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
                        <strong class="card-title">Citizens</strong>
                    </div>
                    <div class="card-body">
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
                        <?php if(count($citizens) > 0): ?>
							<div class="row">
								<div class="col-md-1"></div>
								<div class="col-md-10">
									<div class="text-center alert alert-info">
										<i class="fas fa-info-circle"></i> 
										<strong><?php echo count($citizens)?></strong> citizen(s) 
									</div>
								</div>
								<div class="col-md-1"></div>
							</div>
						<?php endif; ?>
                        <?php if(!empty($citizens)): ?>
                            <?php $serial_no = 1; ?>
                            <table id="citizens-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>S/NO</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Ward</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($citizens as $citizen): ?>
                                        <tr>
                                            <td><?php echo $serial_no; ?></td>
                                            <td>
                                                <?php
                                                    $citizen_id = $citizen["id"];
                                                    $citizen_name = ucwords($citizen["name"]);
                                                    $citizen_gender = $citizen["gender"];

													$citizen_address = ucwords($citizen["address"]);
													$citizen_phone = ucfirst($citizen["phone"]);
                                                    $citizen_ward_id = strtolower($citizen["ward_id"]);
                                                ?>

                                                <div class="my-tooltip text-left">
                                                    <?php echo $citizen_name." "; ?>

                                                </div>
                                            </td>
                                            <td>
												<?php echo $citizen_gender; ?>
											</td>
                                            <td>
												<?php echo $citizen_address; ?>
                                            </td>
                                            <td>
												<a href="tel:<?php echo $citizen_phone; ?>"><?php echo $citizen_phone; ?></a>
											</td>
                                            <td>
                                                <?php
                                                    $ward_id = $citizen["ward_id"];

                                                    $ward = $this->ward_model->findWardById($ward_id);

                                                    foreach($ward as $w) {
                                                        $ward_name = $w["name"];
                                                        $lga_id = $w["lga_id"];
                                                    }
        
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
                                                <?php echo $ward_name_to_display; ?>
                                            </td>
                                        </tr>
                                        <?php $serial_no++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 text-center">
                                    <div class="alert alert-info"><strong>No citizens for now!</strong></div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div><!-- .content -->
