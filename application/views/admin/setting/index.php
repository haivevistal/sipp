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
                        <h2>Update Setting <?php if($msg) : ?><small><span class="badge badge-success"><?php echo $msg; ?></span></small><?php endif; ?></h2>
                    </div>
                </div>
            </div>
            
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Here you can update a setting</h6>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <form action="<?= base_url() ?>portal/setting/" method="post" enctype="multipart/form-data">
                            <div class="row">
                            <?php foreach($setting as $set) { ?>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label><?php echo strtoupper(str_replace('-',' ', $set->code)); ?></label>
                                        <?php if($set->data_type == 'textarea') { ?>
                                            <textarea name="setting[textarea_<?php echo $set->code; ?>]" class="form-control"><?php echo $set->value; ?></textarea>
                                        <?php } else if($set->data_type == 'select') { 
                                            $expl_values = explode(",", $set->options);
                                            ?>
                                            <select name="setting[select_<?php echo $set->code; ?>]" class="form-control">
                                            <?php
                                            foreach( $expl_values as $option ) {
                                                ?>
                                                <option value="<?php echo $option; ?>" <?php echo trim($option) == trim($set->value) ? 'selected' : ''; ?>><?php echo $option; ?></option>
                                                <?php
                                            }
                                            ?>
                                            </select>

                                        <?php } else if($set->data_type == 'image') { ?>
                                            <input type="hidden" name="images[<?php echo $set->code; ?>]" />
                                            <input type="file" name="<?php echo $set->code; ?>" class="form-control" value="<?php echo $set->value; ?>" />
                                            <img src="/assets/uploads/setting/<?php echo $set->value; ?>" alt="image" style="height:50px;" />
                                        <?php } else { ?>
                                            <input type="<?php echo $set->data_type; ?>" name="setting[<?php echo $set->data_type; ?>_<?php echo $set->code; ?>]" class="form-control" value="<?php echo $set->value; ?>" />
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="setting_id" value="1" />
                                <input type="submit" name="update_setting" class="btn btn-success" value="Update">
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