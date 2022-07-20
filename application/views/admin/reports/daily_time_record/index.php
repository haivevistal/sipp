<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
   
        
        <?php $this->load->view('includes/admin/topbar'); ?>
        <!-- Begin Page Content -->
        <!-- Begin Page Content -->
        <button class="btn btn-success print_floating_btn">Print</button>
        <div class="container-fluid">
            <div class="table-responsive">
                <form name="search_dtr" action="#" method="POST" style="margin-top: 45px;">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Search Student Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-wrapper">
                            
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Select Student</label>
                                            <select name="student" class="form-control">
                                                <option value="">Select==</option>
                                                <?php
                                                foreach( $this->user_model->get_students() as $student ) {
                                                    ?>
                                                    <option <?php echo isset($_POST["student"]) && $student->id == $_POST["student"] ? "selected" : ""; ?> value="<?php echo $student->id; ?>"><?php echo $student->firstname." ".$student->lastname; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <input type="submit" name="search_user" class="btn btn-success" value="Search Student DTR" style="margin-top: 32px;" />
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </form>
                <?php if( isset($_POST["student"]) ) { ?>
                
                <?php
                $new_attendances = array();
                $student_data = array();
                foreach($attendance as $atd) {
                    $comp = $this->setting_model->get_company_by_id($atd->company_id);
                    $new_attendances[date("Y_m_d", strtotime($atd->date_time) )."_".$atd->user_id][] = array(
                        'date' => date("F d, Y", strtotime($atd->date_time) ),
                        'info' => "<strong>Name:</strong> ".$atd->firstname." ".$atd->lastname."<br /><strong>Course:</strong> ".$atd->course,
                        'company' => $comp->name,
                        'time' => date("h:i A", strtotime($atd->date_time) ),
                        'duration' => strtotime($atd->date_time)
                    );
                    $student_data = array('firstname' => $atd->firstname, 'lastname' => $atd->lastname, 'company' => $comp->name);
                }
                ?>
                <div class="print_content">
                <div class="row">
                    <div class="col-md-12">
                    <h5>Name: <span class="txt_before"></span><span style="text-decoration: underline;"><?php echo $student_data['firstname']." ".$student_data['lastname']; ?></span></h5>
                    <h5>Office Assign To: <span class="txt_before"></span><span style="text-decoration: underline;"><?php echo $student_data['company']; ?></span></h5>
                    </div>
                </div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="margin-top: 45px;" data-report="dtr">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($attendance) { ?>
                            <?php 
                            foreach($new_attendances as $atr) {
                                $total = 0;
                                $time1 = isset($atr[0]["time"]) ? $atr[0]["time"] : '';
                                $time2 = isset($atr[1]["time"]) ? $atr[1]["time"] : '';
                                $time3 = isset($atr[2]["time"]) ? $atr[2]["time"] : '';
                                $time4 = isset($atr[3]["time"]) ? $atr[3]["time"] : '';
                                if( isset($atr[0]["duration"]) && isset($atr[1]["duration"]) ) {
                                    $duration1 = isset($atr[0]["duration"]) ? $atr[0]["duration"] : 0;
                                    $duration2 = isset($atr[1]["duration"]) ? $atr[1]["duration"] : 0;
                                    $total = $total + ( $duration2 - $duration1 );
                                }
                                
                                if( isset($atr[2]["duration"]) && isset($atr[3]["duration"]) ) {
                                    $duration3 = isset($atr[2]["duration"]) ? $atr[2]["duration"] : 0;
                                    $duration4 = isset($atr[3]["duration"]) ? $atr[3]["duration"] : 0;
                                    $total = $total + ( $duration4 - $duration3 );
                                }
                                ?>
                                <tr>
                                    <td><?php echo $atr[0]["date"]; ?></td>
                                    <td><?php echo $time1." - ".$time2; ?></td>
                                    <td><?php echo number_format( ( ($total) / 60 ) / 60, 2); ?> hours</td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
                <?php } ?>
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