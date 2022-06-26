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
                        <h2>
                        Add New User 
                        <?php if($msg) : ?><small><span class="badge badge-success"><?php echo $msg; ?></span></small><?php endif; ?>
                        <?php if($errormsg) : ?><small><span class="badge badge-danger"><?php echo $errormsg; ?></span></small><?php endif; ?>
                        </h2>
                    </div>
                    <div class="col-sm-3 text-right">
                        <a href="<?php echo base_url()?>portal/users" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Go Back To Users</span></a>
                    </div>
                </div>
            </div>
            
            <form action="<?= base_url() ?>portal/add_user" method="POST">
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
                                        <input type="text" name="firstname" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="lastname" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input type="text" name="username" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control">
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Bio</label>
                                        <textarea name="bio" class="form-control" required></textarea>
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
                                                <option value="<?php echo $usertype->id; ?>"><?php echo $usertype->type_desc; ?></option>
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
                                                <option value="<?php echo $course->id; ?>"><?php echo $course->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required>
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
                                        <input type="date" name="start_ojt" class="form-control"  />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" name="end_ojt" class="form-control"  />
                                    </div>
                                </div>
                            </div>
                            <div class="row studentshow hidediv">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Total Hours</label>
                                        <input type="text" name="total_hours" class="form-control"  />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Company</label>
                                        <select name="company_id" class="form-control">
                                            <option value="">Select Company</option>
                                            <?php foreach( $companies as $company ) { ?>
                                            <option value="<?php echo $company->id; ?>"><?php echo $company->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <input type="hidden" name="id">
                                <input type="submit" name="save_user" class="btn btn-success" value="Save">
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