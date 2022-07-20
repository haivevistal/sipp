<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
   
        
        <?php $this->load->view('includes/admin/topbar'); ?>
        <!-- Begin Page Content -->
        <!-- Begin Page Content -->
        <button class="btn btn-success print_floating_btn">Print</button>
        <div class="container-fluid print_content">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h2 class="h3 mb-0 text-gray-800" style="text-align: center;width: 100%;">REPORT ON THE<br />LIST HOST TRAINING ESTABLISHMENTS (HTEs) AND STUDENT INTERNS PARTICIPATING IN THE<br />STUDENT INTERNSHIP PROGRAM IN THE PHILIPPINES(SIPP)<br/>AY <span style="text-decoration: underline;"><?php echo (date("Y")-1)."-".date("Y"); ?></span></h2>
               <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
            </div>

            <div class="row">
                <div class="col-md-12">
                <h5>HEI: <span class="txt_before"></span><input value="<?php echo $this->setting_model->get_setting('issues-concerns-hei')->value; ?>" type="text" name="hei" class="report_fields" style="width:48%;" /></h5>
                <h5>ADDRESS: <span class="txt_before"></span><input value="<?php echo $this->setting_model->get_setting('issues-concerns-address')->value; ?>" type="text" name="address" class="report_fields" style="width:62%;" /></h5>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-md-12">
                    <table width="100%" class="reports_table" data-report="lhr">
                        <tr>
                            <th width="26%" align="center">PARTNER HOST TRAINING ESTABLISHMENTS (HTEs)</th>
                            <th width="24%" align="center">NAME OF STUDENT INTERNS</th>
                            <th width="20%" align="center">PROGRAM</th>
                            <th width="10%" align="center">GENDER</th>
                            <th width="20%" align="center">DATES OF DURATION OF THE INTERNSHIP</th>
                        </tr>
                        <?php foreach( $this->user_model->get_students() as $student ) { ?>
                        <tr>
                            <td width="26%">
                            <?php
                            $comp = $this->setting_model->get_company_by_id($student->company_id);
                            echo $comp->name;
                            ?>
                            </td>
                            <td width="24%"><?php echo $student->firstname." ".$student->lastname; ?></td>
                            <td width="20%">INTERNSHIP</td>
                            <td width="10%"><?php echo $student->gender == 'm' ? 'Male' : 'Female'; ?></td>
                            <td width="20%">
                            <?php 
                            echo date('m/d/Y', strtotime($student->start_ojt) )." - ".date('m/d/Y', strtotime($student->end_ojt) );
                            ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-md-12">
                    <table width="100%" class="below_reports_table">
                        <tr>
                            <td width="34%" align="left">
                                <strong>PREPARED BY: <br /><div class="txt_before prepared_by_div" style="width:65%;text-align:center;font-size:15px;margin-bottom: -15px;border-bottom: 1px solid #111;"></div><input type="text" name="prepared_by" class="report_fields" value="<?php echo $this->setting_model->get_setting('issues-concerns-prepared-by')->value; ?>" style="width:65%;text-align:center;font-size:15px;" /></strong><br />
                                <div style="width:65%;text-align:center;">(Name and Signature)</div>
                            </td>
                            <td width="33%" align="center"></td>
                            <td width="33%" align="left">
                                <strong>CERTIFIED CORRECT: <br /><div class="txt_before corrected_by_div" style="width:65%;text-align:center;font-size:15px;margin-bottom: -15px;border-bottom: 1px solid #111;"></div><input type="text" name="corrected_by" value="<?php echo $this->setting_model->get_setting('issues-concerns-corrected-by')->value; ?>" class="report_fields" style="width:65%;text-align:center;font-size:15px;" /></strong><br />
                                <div style="width:65%;text-align:center;">(Name and Signature)</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php $this->load->view('includes/admin/copyright'); ?>
    
    

</div>
    <!-- End of Main Content -->

    <!-- Footer -->
   
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->