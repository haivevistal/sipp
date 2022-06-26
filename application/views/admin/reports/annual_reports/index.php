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
                <h2 class="h3 mb-0 text-gray-800" style="text-align: center;width: 100%;">ANNUAL REPORT IN THE IMPLEMENTATION OF <br/>STUDENT INTERNSHIP PROGRAM IN THE PHILIPPINES(SIPP)<br/>AY <span style="text-decoration: underline;"><?php echo (date("Y")-1)."-".date("Y"); ?></span></h2>
               <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
            </div>

            <div class="row">
                <div class="col-md-12">
                <h5>HEI: <span class="txt_before"></span><input type="text" name="hei" class="report_fields" style="width:48%;" /></h5>
                <h5>ADDRESS: <span class="txt_before"></span><input type="text" name="address" class="report_fields" style="width:62%;" /></h5>
                <h5>DEGREE PROGRAM: <span class="txt_before"></span><input type="text" name="degree_program" class="report_fields" style="width:54%;" /></h5>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-md-12">
                    <table width="100%" class="reports_table">
                        <tr>
                            <th width="34%" align="center">Issues and Concerns Encountered</th>
                            <th width="33%" align="center">Solutions</th>
                            <th width="33%" align="center">Recommendations</th>
                        </tr>
                        <?php foreach( $this->setting_model->get_all_seen_feedbacks() as $feedback ) { ?>
                        <tr>
                            <td width="34%"><?php echo $feedback->description; ?></td>
                            <td width="33%"><span class="txt_before"></span><textarea name="hei" class="report_fields" style="width:100%;border:none !important;"></textarea></td>
                            <td width="33%"><span class="txt_before"></span><textarea name="hei" class="report_fields" style="width:100%;border:none !important;"></textarea></td>
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
                                <strong>PREPARED BY: <br /><div class="txt_before prepared_by_div" style="width:65%;text-align:center;font-size:15px;margin-bottom: -15px;border-bottom: 1px solid #111;"></div><input type="text" name="prepared_by" class="report_fields" style="width:65%;text-align:center;font-size:15px;" /></strong><br />
                                <div style="width:65%;text-align:center;">(Name and Signature)</div>
                            </td>
                            <td width="33%" align="center"></td>
                            <td width="33%" align="left">
                                <strong>CERTIFIED CORRECT: <br /><div class="txt_before corrected_by_div" style="width:65%;text-align:center;font-size:15px;margin-bottom: -15px;border-bottom: 1px solid #111;"></div><input type="text" name="corrected_by" class="report_fields" style="width:65%;text-align:center;font-size:15px;" /></strong><br />
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