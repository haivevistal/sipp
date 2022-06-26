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
                <div class="print_content">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="margin-top: 45px;" data-report="dtr">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Student Info</th>
                            <!--<th>Title</th>-->
                            <th>Company</th>
                            <th>Time</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($attendances): ?>
                            <?php 
                            $new_attendances = array();
                            foreach($attendances as $attendance) {
                                $comp = $this->setting_model->get_company_by_id($attendance->company_id);
                                $new_attendances[date("Y_m_d", strtotime($attendance->date_time) )."_".$attendance->user_id][] = array(
                                    'date' => date("F d, Y", strtotime($attendance->date_time) ),
                                    'info' => "<strong>Name:</strong> ".$attendance->firstname." ".$attendance->lastname."<br /><strong>Course:</strong> ".$attendance->course,
                                    'company' => $comp->name,
                                    'time' => date("h:i A", strtotime($attendance->date_time) ),
                                    'duration' => strtotime($attendance->date_time)
                                );
                            }
                            
                            foreach($new_attendances as $atd): 
                            $time1 = $atd[0]["time"];
                            $time2 = $atd[1]["time"];
                            $duration1 = $atd[0]["duration"];
                            $duration2 = $atd[1]["duration"];
                            ?>
                                <tr>
                                    <td><?php echo $atd[0]["date"]; ?></td>
                                    <td><?php echo $atd[0]["info"]; ?></td>
                                    <td><?php echo $atd[0]["company"]; ?></td>
                                    <td><?php echo $time1." - ".$time2; ?></td>
                                    <td><?php echo number_format( ( ($duration2 - $duration1) / 60 ) / 60, 2); ?> hours</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
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