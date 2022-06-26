  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex justify-content-center align-items-center" style="height:45vh">
    <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100">
        <div class="row">
            <div class="col-md-5 hero-h1 col-sm-12 col-xs-12">
                
                <?php if( isset($user->photo) ) { ?>
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
						
                            <img src="<?php echo base_url(); ?>assets/uploads/profile/<?php echo $user->photo; ?>" alt="Profile" style="width: 100%;" />
                        </div>
                        <div class="col-md-9 col-sm-12">
                            <h2 style="font-size:20px;"><?php echo $this->session->userdata('firstname')." ".$this->session->userdata('lastname'); ?></h2>
                            <div class="remaining_hours">
                                <span class="badge bg-primary"><?php echo $user->remaining_hours; ?> remaining hours</span>
                                <span class="badge bg-info"><?php echo $user->rendered_hours; ?> rendered hours</span>
                            </div>
                            <div class="login-logout-btns" style="margin-top: 10px;">
                                <?php
                                    $timeinsession1 = $this->session->userdata( 'timein_one_'.date("Y-m-d")."_".$this->session->userdata('user_id') );
                                    $timeoutsession1 = $this->session->userdata( 'timeout_one_'.date("Y-m-d")."_".$this->session->userdata('user_id') );
                                    $timeinsession2 = $this->session->userdata( 'timein_two_'.date("Y-m-d")."_".$this->session->userdata('user_id') );
                                    $timeoutsession2 = $this->session->userdata( 'timeout_two_'.date("Y-m-d")."_".$this->session->userdata('user_id') );
                                ?>
                                <?php
                                if( $timeinsession1 == '' ) {
                                    ?>
                                    <a href="<?php echo base_url(); ?>profile/timein/timein_one"><button class="badge bg-success" style="border: 1px solid #fff;">Time In</button></a>
                                    <?php
                                } else {
                                    if( $timeoutsession1 == '' ) {
                                        ?>
                                        <button data-link="<?php echo base_url(); ?>profile/timeout/timeout_one" class="badge bg-warning logoutbtn" style="border: 1px solid #fff;" data-bs-toggle="modal" data-bs-target="#timeoutModal">Time Out</button>
                                        <?php
                                    } else {
                                        if( $timeinsession2 == '' ) {
                                            ?>
                                            <a href="<?php echo base_url(); ?>profile/timein/timein_two"><button class="badge bg-success" style="border: 1px solid #fff;">Time In</button></a>
                                            <?php
                                        } else {
                                            ?>
                                            <button data-link="<?php echo base_url(); ?>profile/timeout/timeout_two" class="badge bg-warning logoutbtn" style="border: 1px solid #fff;" data-bs-toggle="modal" data-bs-target="#timeoutModal">Time Out</button>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <h1><?php echo $this->session->userdata('firstname')." ".$this->session->userdata('lastname'); ?></h1>
                    <div class="remaining_hours">
                        <span class="badge bg-primary"><?php echo $user->remaining_hours; ?> remaining hours</span>
                        <span class="badge bg-info"><?php echo $user->rendered_hours; ?> rendered hours</span>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-7 col-sm-12 col-xs-12">
               <div class="calendar" id="calendar" style="padding-top: 32px;">
                <ul class="nav nav-pills justify-content-end profile-nav">
                  <li class="nav-item">
                    <a class="nav-link <?php echo $this->uri->segment(2) == '' ? "active" : "not-active";?>" href="<?php echo base_url(); ?>profile">Account Home</a>
                  </li>
                  
                  <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:;" id="incoming_activities_drop" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-left: 1px;margin-top: -7px;margin-right:-5px;">
                        <button type="button" class="btn btn-info position-relative bi bi-bell" style="color:#fff !important;">
                            <?php $scount = $this->activities_model->count_incoming_activities(); ?>
                            <?php if($scount != 0) { ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo $scount;?>
                            </span>
                            <?php } ?>
                        </button>
                    </a>
                    
                    <div class="dropdown-menu" aria-labelledby="incoming_activities_drop" style="z-index: 9999;min-width: 195px;padding:10px;padding-top: 0;">
                        <?php
                        $incoming = $this->activities_model->incoming_activities();
                        foreach($incoming as $inc) {
                            ?>
                            <div class="row" style="border-bottom: 1px solid #1111;padding-bottom: 5px;padding-top: 4px;">
                                <div class="row">
                                    <div class="col-md-9">
                                        <label data-item="title"><?php echo $inc->ititle; ?></label>
                                    </div>
                                    <div class="col-md-3" style="text-align:right;">
                                        <a href="<?php echo base_url(); ?>profile/start_incoming_activity/<?php echo $inc->iid?>"><span class="badge bg-info">Start</span></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                  </li>
                  
                  <li class="nav-item">
                    <a  style="margin-right:30px;" class="nav-link <?php echo $this->uri->segment(2) == 'activities' ? "active" : "not-active";?>" href="<?php echo base_url(); ?>profile/activities">Activities</a>
                  </li>
                  
                  <!--
                  <li class="nav-item">
                    <a class="nav-link <?php echo $this->uri->segment(2) == 'activities' || $this->uri->segment(2) == 'add_activity' || $this->uri->segment(2) == 'edit_activity' ? "active" : "not-active";?>" href="<?php echo base_url(); ?>profile/activities">My Activities</a>
                  </li>
                  -->
                  <!--<li class="nav-item">
                    <a class="nav-link <?php echo $this->uri->segment(2) == 'update' ? "active" : "not-active";?>" href="<?php echo base_url(); ?>profile/update">Update Profile</a>
                  </li>-->
                   <li class="nav-item">
                   <a style="margin-left:-20px;"class="nav-link <?php echo $this->uri->segment(2) == 'attendance' || $this->uri->segment(2) == 'add_attendance' ? "active" : "not-active";?>" href="<?php echo base_url(); ?>profile/attendance">My Attendance</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php echo $this->uri->segment(2) == 'submit_portfolio' ? "active" : "not-active";?>" href="<?php echo base_url(); ?>profile/submit_portfolio">Submit Portfolio</a>
                  </li>
                  
                 
                </ul>
               </div>
            </div>
        </div>
    </div>
  </section><!-- End Hero -->