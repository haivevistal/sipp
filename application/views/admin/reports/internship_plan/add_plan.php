<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        
        <?php $this->load->view('includes/admin/topbar'); ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"></h1>
            
            <!-- Page Heading -->
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>
                        Add New Internship Plan 
                        <?php if($msg) : ?><small><span class="badge badge-success"><?php echo $msg; ?></span></small><?php endif; ?>
                        <?php if($errormsg) : ?><small><span class="badge badge-danger"><?php echo $errormsg; ?></span></small><?php endif; ?>
                        </h2>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn btn-success print_plan">Print</button>
                        <a href="<?php echo base_url()?>portal/internship_plan" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Go Back To Internship Plan</span></a>
                    </div>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Here you can add new internship plan</h6>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <form action="<?= base_url() ?>portal/add_internship_plan" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea id="intership_plan_description" name="description" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="id">
                                <input type="submit" name="save_plan" class="btn btn-success" value="Save">
                                <a href="<?php echo base_url('portal/internship_plan')?>" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php $this->load->view('includes/admin/copyright'); ?>
    
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

</div>
<!-- End of Content Wrapper -->