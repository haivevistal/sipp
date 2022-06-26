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
                        <h2>Manage <b>Companies</b></h2>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="<?php echo base_url()?>portal/add_company" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New Company</span></a>
                    </div>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Here you can manages companies</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($companies): ?>
                                <?php foreach($companies as $company): ?>
                                    <tr>
                                        <td><?php echo $company->id; ?></td>
                                        <td><?php echo $company->name; ?></td>
                                        <td><?php echo $company->address; ?></td>
                                        <td><?php echo $company->contact; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>portal/edit_company/<?php echo $company->id?>">
                                                <i class="fa fa-pencil" data-toggle="tooltip" title="Edit"><span class="badge badge-warning">Edit</span></i>
                                            </a>
                                            <a href="<?php echo base_url(); ?>portal/delete_company/<?php echo $company->id?>" class="delete" onClick="return confirm('Are you sure you want to delete?');" class="edit">
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
    
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

</div>
<!-- End of Content Wrapper -->