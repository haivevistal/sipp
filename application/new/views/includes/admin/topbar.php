<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form
        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="display:none !important;">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                            placeholder="Search for..." aria-label="Search"
                            aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        
        <?php if( $this->session->userdata('admin_usertype') == 1 ) { ?>
        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
               <span class="badge badge-danger badge-counter feedback-counter"><?php echo $this->setting_model->count_feedbacks(); ?></span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Complaints
                </h6>
                <?php
                $complaints = $this->setting_model->get_all_feedbacks();
                foreach( $complaints as $com) {
                    ?>
                    <a class="dropdown-item d-flex align-items-center viewfeedback viewfeedback<?php echo $com->id; ?>" data-id="<?php echo $com->id; ?>" href="#" data-toggle="modal" data-target="#viewFeedbackModal" data-attach="<?php echo $com->attachement; ?>">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500 date"><?php echo date('F d, Y', strtotime($com->date_save) ); ?></div>
                            <div class="small text-gray-500 title"><?php echo $com->title; ?></div>
                            <span class="font-weight-bold desc"><?php echo $com->description; ?></span>
                        </div>
                    </a>
                    <?php
                }
                ?>
            </div>
        </li>
        <?php } ?>
        
       <?php if( $this->session->userdata('admin_usertype') == 2 ) { ?>
       <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="modal" data-target="#sendMessageModal">
                <span class="btn btn-primary">
                    <i class="fas fa-envelope fa-fw"></i>Send Message
                </span>
            </a>
        </li>
       <?php } ?>
        
        <?php if( $this->session->userdata('admin_usertype') == 1 ) { ?>
        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter message-counter"><?php echo $this->setting_model->count_messages(); ?></span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Message Center
                </h6>
                <?php
                $messages = $this->setting_model->get_all_messages();
                foreach( $messages as $msg) {
                    $supervisor_user = $this->user_model->get_user_by_id($msg->supervisor_id);
                ?>
                    <a class="dropdown-item d-flex align-items-center viewmsg viewmsg<?php echo $msg->id; ?>" data-supervisor="<?php echo $msg->supervisor_id; ?>" data-id="<?php echo $msg->id; ?>" href="#" data-toggle="modal" data-target="#viewMsgModal">
                        <div class="dropdown-list-image mr-3">
                            <i class="fas fa-envelope fa-user"></i>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate msg_content_field<?php echo $msg->id; ?>"><?php echo $msg->content; ?></div>
                            <div class="small text-gray-500 msg_from_field<?php echo $msg->id; ?>"><?php echo $supervisor_user->firstname." ".$supervisor_user->lastname; ?></div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </li>
        <?php } ?>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $this->session->userdata('admin_firstname')." ".$this->session->userdata('admin_lastname'); ?></span>
                <i class="fa fa-user-circle"></i>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <!--<a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>-->
                <?php if( $this->session->userdata('admin_usertype') == 1 ) { ?>
                <a class="dropdown-item" href="/portal/setting/">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <?php } ?>
                <!--<a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>-->
                <?php if( $this->session->userdata('admin_usertype') == 1 ) { ?>
                <div class="dropdown-divider"></div>
                <?php } ?>
                
                <a class="dropdown-item" href="<?php echo base_url(); ?>portal/admin_logout" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->