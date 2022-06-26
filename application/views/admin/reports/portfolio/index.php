<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        
        <?php $this->load->view('includes/admin/topbar'); ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
          <!--  <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Attendances</b></h2>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="<?php echo base_url()?>portal/add_attendance" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New Attendance</span></a>
                    </div>
                </div>
            </div>
            -->
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Student Portfolio's</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($portfolio): ?>
                                    <?php foreach($portfolio as $pf): ?>
                                        <tr>
                                  
                                            <td>
                                            <?php 
                                            $user = $this->user_model->get_user_by_id($pf->user_id);
                                            echo $user->firstname." ".$user->lastname;
                                            ?>
                                            </td>
                                            <td>
                                                <a target="_blank" href="<?php echo base_url(); ?>assets/uploads/portfolio/<?php echo $pf->user_id; ?>_portfolio.pdf">
                                                    <span class="badge badge-primary">View PDF</span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
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