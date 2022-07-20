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
                    <h6 class="m-0 font-weight-bold text-primary">Intern attendances</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <!--<th>Title</th>-->
                                    <th>Attendance type</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Attach</th>
                                    <?php if( trim(strtolower($this->setting_model->get_setting('hide-approval')->value)) == 'no' ) { ?>
                                    <th>Status</th>
                                    <?php }?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($attendances): ?>
                                    <?php foreach($attendances as $attendance): ?>
                                        <tr>
                                            <td><?php echo $attendance->firstname." ".$attendance->lastname;?></td>
                                            <!-- <td><?php echo $attendance->title; ?></td>-->
                                            <td><?php echo $attendance->description; ?></td> 
                                          
                                            <td><?php echo date("F d, Y", strtotime($attendance->date_time) ); ?></td>
                                            <td><?php echo date("h:i A", strtotime($attendance->date_time) ); ?></td>
                                            <td>
                                              <?php 
                                              if( $attendance->image ) {
                                                  ?>
                                                  <a target="_blank" href="<?php echo base_url(); ?>assets/uploads/attendance/<?php echo $attendance->image; ?>" class="btn btn-info">View Image</a>
                                                  <?php
                                              } else {
                                                  echo 'N/A';
                                              }
                                              ?>
                                            </td>
                                            <?php if( trim(strtolower($this->setting_model->get_setting('hide-approval')->value)) == 'no' ) { ?>
                                            <td>
                                                <?php 
                                                    if( $this->session->userdata('admin_usertype') == 2 ) {
                                                        if( $attendance->status == 0 ) {
                                                            ?>
                                                                <a href="<?php echo base_url(); ?>portal/approve_attendance/<?php echo $attendance->id?>" class="btn btn-primary" onClick="return confirm('Are you sure you want to approve this attendance?');">Approve</a>
                                                            <?php
                                                        } else {
                                                            echo 'Approved';
                                                        }
                                                    } else {
                                                        echo $attendance->status == 0 ? "Pending" : "Approved";
                                                    }
                                                ?>
                                            </td>
                                            <?php } ?>
                                            <!-- <td>
                                                <a href="<?php echo base_url(); ?>portal/edit_attendance/<?php echo $attendance->id?>">
                                                    <i class="fa fa-pencil" data-toggle="tooltip" title="Edit"><span class="badge badge-warning">Edit</span></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>portal/delete_attendance/<?php echo $attendance->id?>" class="delete" onClick="return confirm('Are you sure you want to delete?');" class="edit">
                                                    <span class="badge badge-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></span>
                                                </a>
                                            </td>-->
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