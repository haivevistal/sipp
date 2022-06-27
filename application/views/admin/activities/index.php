<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Activities</b></h2>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="<?php echo base_url()?>portal/add_activity" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New Activity</span></a>
                    </div>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Here you can manages activities</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Start_Time</th>
                                    <th>End_Time</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($activities): ?>
                                    <?php foreach($activities as $activity): ?>
                                        <tr>
                                            <td><?php echo $activity->firstname." ".$activity->lastname;?></td>
                                            <td><?php echo $activity->title; ?></td>
                                            <td><?php echo $activity->description; ?></td>
                                            <td><?php echo $activity->start_time; ?></td>
                                            <td><?php echo $activity->end_time; ?></td>
                                            <td>
                                            <select name="rating" class="form-control rating" data-user="<?php echo $activity->user_id; ?>" id="rating<?php echo $activity->id; ?>" data-id="<?php echo $activity->id; ?>">
                                            <?php
                                                foreach( $rating_options as $rate) {
                                                    ?>
                                                    <option value="<?php echo $rate->id; ?>" <?php echo $rate->id == $activity->rating ? "selected" : ''; ?>><?php echo $rate->title; ?></option>
                                                    <?php
                                                }
                                            ?>
                                            </select>
                                            </td>
                                            <td><?php 
                                            $stat = $activity->activity_status; 
                                            echo '<span class="badge bg-info" style="color: #fff !important;">'.($stat == 1 ? "" : ( $stat == 2 ? "Started" : ( $stat == 3 ? "Done" : ($stat == 4 ?  "Reject" : "") ) ) ).'</span>';
                                            ?></td>
                                            <td>
                                                <a href="<?php echo base_url(); ?>portal/edit_activity/<?php echo $activity->id;?>">
                                                    <i class="fa fa-pencil" data-toggle="tooltip" title="Edit"><span class="badge badge-warning">Edit</span></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>portal/delete_activity/<?php echo $activity->id;?>" class="delete" onClick="return confirm('Are you sure you want to delete?');" class="edit">
                                                    <span class="badge badge-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></span>
                                                </a>
                                                <?php if($activity->attachment) { ?>
                                                <a href="<?php echo base_url(); ?>assets/uploads/activities/<?php echo $activity->attachment;?>" target="_blank">
                                                    <span class="badge badge-info">View Attachment</span>
                                                </a>
                                                <?php } ?>
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