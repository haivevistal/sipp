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
                        <h2>Update Internship Plan <?php if($msg) : ?><small><span class="badge badge-success"><?php echo $msg; ?></span></small><?php endif; ?></h2>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn btn-success print_plan">Print</button>
                        <a href="<?php echo base_url()?>portal/internship_plan" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Go Back To Internship Plans</span></a>
                    </div>
                </div>
            </div>
            
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Here you can update a internship plan</h6>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <form action="<?= base_url() ?>portal/edit_internship_plan/<?php echo $internship_plan->id; ?>" method="post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control" required value="<?php echo $internship_plan->title; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea id="intership_plan_description" name="description" class="form-control" required><?php echo $internship_plan->description; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $internship_plan->id; ?>" />
                                <input type="submit" name="update_internship_plan" class="btn btn-success" value="Update">
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