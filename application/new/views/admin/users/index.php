<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        
        <?php $this->load->view('includes/admin/topbar'); ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Users</b></h2>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="<?php echo base_url()?>portal/add_user" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>
                    </div>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Here you can manages users</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                               
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>User Type</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($users): ?>
                                <?php foreach($users as $user): ?>
                                    <tr>
                                    
                                        <td><?php echo $user->firstname; ?></td>
                                        <td><?php echo $user->lastname; ?></td>
                                        <td><?php echo $user->gender; ?></td>
                                        <td><?php echo $user->phone; ?></td>
                                        <td><?php echo $user->email; ?></td>
                                        <td><?php echo $user->username; ?></td>
                                        <td>
                                        <?php 
                                        if( $user->usertype ) {
                                            $comp = $this->setting_model->get_usertype_by_id( $user->usertype );
                                            if( $comp ) {
                                                echo $comp->usertype; 
                                            } else {
                                                echo '-';
                                            }
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>portal/edit_user/<?php echo $user->id?>">
                                                <i class="fa fa-pencil" data-toggle="tooltip" title="Edit"><span class="badge badge-warning">Edit</span></i>
                                            </a>
                                            <a href="<?php echo base_url(); ?>portal/delete_user/<?php echo $user->id?>" class="delete" onClick="return confirm('Are you sure you want to delete?');" class="edit">
                                                <span class="badge badge-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></span>
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

</div>
<!-- End of Content Wrapper -->