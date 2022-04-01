
<?php foreach($company_admin as $comp_admin): ?>
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- Widgets  -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="fas fa-users fa-fw"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text">
                                        <span class="count"><?php echo count($citizens); ?></span>
                                    </div>
                                    <div class="stat-heading">No of Citizens</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
        <!-- /Widgets -->
        
        <!--  Traffic  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Welcome to NPC Users </h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div style="color: black;">You can use it to:</div>
                                        <div style="margin-left: 20px;">
                                            <ul>
                                                <li>Get NPC Data</li>
                                                <li>Add Citizens</li>
                                            </ul>
                                        </div>
                                        <!--<div>
                                            Link to the site: <a href="<?php echo base_url(); ?>company_admins/index"><?php echo base_url(); ?>company_admins/index</a>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
            </div><!-- /# column -->
        </div>
        <!--  /Traffic -->
        <div class="clearfix"></div>
        
    <!-- /#add-category -->
    </div>
    <!-- .animated -->
</div>
<!-- /.content -->
<?php endforeach; ?>
