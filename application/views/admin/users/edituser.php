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
                    <div class="col-sm-9">
                        <h2>Update [<?php echo $user->firstname; ?> <?php echo $user->lastname; ?>] User <?php if($msg) : ?><small><span class="badge badge-success"><?php echo $msg; ?></span></small><?php endif; ?></h2>
                    </div>
                    <div class="col-sm-3 text-right">
                        <a href="<?php echo base_url()?>portal/users" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Go Back To Users</span></a>
                    </div>
                </div>
            </div>
            
            <!-- DataTales Example -->
            <form action="<?= base_url() ?>portal/edit_user/<?php echo $user->id; ?>" method="post">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="firstname" class="form-control" required value="<?php echo $user->firstname; ?>" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="lastname" class="form-control" required value="<?php echo $user->lastname; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input type="text" name="username" class="form-control" required value="<?php echo $user->username; ?>" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" class="form-control" required value="<?php echo $user->email; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control" required value="<?php echo $user->phone; ?>" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Emergency Phone</label>
                                        <input type="text" name="emergency_phone" class="form-control" required value="<?php echo $user->emergency_phone; ?>" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control">
                                            <option value="m" <?php echo $user->gender == 'm' ? 'selected' : ''; ?>>Male</option>
                                            <option value="f" <?php echo $user->gender == 'f' ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Bio</label>
                                        <textarea name="bio" class="form-control" required><?php echo $user->bio; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>User Type</label>
                                        <select name="usertype" class="form-control" required>
                                            <option value="">Select User Type</option>
                                            <?php foreach($user_types as $usertype) { ?>
                                                <?php if( trim(strtolower($this->setting_model->get_setting('hide-supervisor')->value)) == 'yes' ) { ?>
                                                    <?php if( $usertype->id != 2 ) { ?>
                                                        <option value="<?php echo $usertype->id; ?>" <?php echo $user->usertype == $usertype->id ? 'selected' : ''; ?>><?php echo $usertype->type_desc; ?></option>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <option value="<?php echo $usertype->id; ?>" <?php echo $user->usertype == $usertype->id ? 'selected' : ''; ?>><?php echo $usertype->type_desc; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 studentshow hidediv">
                                    <div class="form-group">
                                        <label>Course</label>
                                        <select name="course" class="form-control">
                                            <option value="">Select Course</option>
                                            <?php foreach($courses as $course) { ?>
                                                <option value="<?php echo $course->id; ?>" <?php echo $user->course == $course->id ? 'selected' : ''; ?>><?php echo $course->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-header py-3 studentshow hidediv">
                        <h6 class="m-0 font-weight-bold text-primary">OJT Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper">
                            <div class="row studentshow hidediv">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" name="start_ojt" class="form-control" value="<?php echo date('Y-m-d', strtotime($user->start_ojt) ); ?>" min="<?php echo date("Y-m-d"); ?>" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" name="end_ojt" class="form-control" value="<?php echo date('Y-m-d', strtotime($user->end_ojt) ); ?>" min="<?php echo date("Y-m-d"); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 studentshow hidediv">
                                    <div class="form-group">
                                        <label>Total Hours</label>
                                        <input type="text" name="total_hours" class="form-control" value="<?php echo $user->total_hours; ?>" />
                                    </div>
                                </div>
                                <div class="col-lg-6 studentshow supervisorshow hidediv">
                                    <div class="form-group">
                                        <label>Company</label>
                                        <select name="company_id" class="form-control">
                                            <option value="">Select Company</option>
                                            <?php foreach( $companies as $company ) { ?>
                                            <option value="<?php echo $company->id; ?>" <?php echo $user->company_id == $company->id ? 'selected' : ''; ?>><?php echo $company->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row studentshow hidediv">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Rendered Hours</label>
                                        <span><?php echo $user->rendered_hours; ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Remaining Hours</label>
                                        <span><?php echo $user->remaining_hours; ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $user->id; ?>" />
                                <input type="submit" name="update_user" class="btn btn-success" value="Update">
                                <a href="<?php echo base_url('portal/users')?>" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php $this->load->view('includes/admin/copyright'); ?>

</div>
<!-- End of Content Wrapper -->