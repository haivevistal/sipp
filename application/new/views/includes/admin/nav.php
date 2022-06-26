<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url(); ?>portal/">
       <!-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-database"></i>
        </div>-->
     <div class="col-lg-6">
        <img src="<?php echo base_url(); ?>/assets/front/img/logo.png" style="width:40px;">SIPP</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url(); ?>portal/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    
    <?php
        $attendancespages = array("attendances", "add_attendance", "edit_attendance");
    ?>
    <!-- Nav Item - Users Collapse Menu -->
    <li class="nav-item <?php if( in_array($this->uri->segment(2), $attendancespages ) ) { ?>active<?php } ?>">
        <a class="nav-link <?php if( in_array($this->uri->segment(2), $attendancespages ) ) { ?>active<?php } else { ?><?php } ?>" href="<?php echo base_url(); ?>portal/attendances/">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Attendance</span>
        </a>
    </li>
    
    
    
    <?php
        $activitiespages = array("activities", "add_activity", "edit_activity");
    ?>
    
    <li class="nav-item <?php if( in_array($this->uri->segment(2), $activitiespages ) ) { ?>active<?php } ?>">
        <a class="nav-link <?php if( in_array($this->uri->segment(2), $activitiespages ) ) { ?><?php } else { ?>collapsed<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseActivities"
            aria-expanded="true" aria-controls="collapseActivities">
            <i class="fas fa-fw fa-folder"></i>
            <span>Activities</span>
        </a>
        <div id="collapseActivities" class="collapse <?php if( in_array($this->uri->segment(2), $activitiespages ) ) { ?>show<?php } ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item <?php if( $this->uri->segment(2) == 'add_activity' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/add_activity/">Add New Activity</a>
                <a class="collapse-item <?php if( $this->uri->segment(2) == 'activities' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/activities/">All Activities</a>
          
            </div>
        </div>
    </li>
    
    <?php
        $announcementspages = array("announcements", "add_announcement", "edit_announcement");
    ?>
    
    <li class="nav-item <?php if( in_array($this->uri->segment(2), $announcementspages ) ) { ?>active<?php } ?>">
        <a class="nav-link <?php if( in_array($this->uri->segment(2), $announcementspages ) ) { ?><?php } else { ?>collapsed<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseAnnouncements"
            aria-expanded="true" aria-controls="collapseAnnouncements">
            <i class="fas fa-fw fa-folder"></i>
            <span>Announcements</span>
        </a>
        <div id="collapseAnnouncements" class="collapse <?php if( in_array($this->uri->segment(2), $announcementspages ) ) { ?>show<?php } ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if( $this->uri->segment(2) == 'announcements' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/announcements/">All Announcements</a>
                <a class="collapse-item <?php if( $this->uri->segment(2) == 'add_announcement' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/add_announcement/">Add New Announcement</a>
            </div>
        </div>
    </li>
    
    <?php if( $this->session->userdata('admin_usertype') == 1 ) { ?>
        <?php
            $userspages = array("users", "add_user", "edit_user");
        ?>
        <li class="nav-item <?php if( in_array($this->uri->segment(2), $userspages ) ) { ?>active<?php } ?>">
            <a class="nav-link <?php if( in_array($this->uri->segment(2), $userspages ) ) { ?><?php } else { ?>collapsed<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseUsers"
                aria-expanded="true" aria-controls="collapseUsers">
                <i class="fas fa-fw fa-user"></i>
                <span>Users</span>
            </a>
            <div id="collapseUsers" class="collapse <?php if( in_array($this->uri->segment(2), $userspages ) ) { ?>show<?php } ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?php if( $this->uri->segment(2) == 'users' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/users/">All Users</a>
                    <a class="collapse-item <?php if( $this->uri->segment(2) == 'add_user' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/add_user/">Add New User</a>
                </div>
            </div>
        </li>
        
        <?php
            $companiespages = array("companies", "add_company", "edit_company");
        ?>
        <li class="nav-item <?php if( in_array($this->uri->segment(2), $companiespages ) ) { ?>active<?php } ?>">
            <a class="nav-link <?php if( in_array($this->uri->segment(2), $companiespages ) ) { ?><?php } else { ?>collapsed<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseCompanies"
                aria-expanded="true" aria-controls="collapseCompanies">
                <i class="fas fa-fw fa-id-card"></i>
                <span>Companies</span>
            </a>
            <div id="collapseCompanies" class="collapse <?php if( in_array($this->uri->segment(2), $companiespages ) ) { ?>show<?php } ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?php if( $this->uri->segment(2) == 'companies' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/companies/">All Companies</a>
                    <a class="collapse-item <?php if( $this->uri->segment(2) == 'add_company' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/add_company/">Add New Company</a>
                </div>
            </div>
        </li>
        
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Reports
        </div>
        <?php
            $reportpages = array("reports", "annual_reports", "host_reports");
        ?>
        <li class="nav-item <?php if( in_array($this->uri->segment(2), $reportpages ) ) { ?>active<?php } ?>">
            <a class="nav-link <?php if( in_array($this->uri->segment(2), $reportpages ) ) { ?><?php } else { ?>collapsed<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseReports"
                aria-expanded="true" aria-controls="collapseReports">
                <i class="fas fa-fw fa-id-card"></i>
                <span>Report</span>
            </a>
            <div id="collapseReports" class="collapse <?php if( in_array($this->uri->segment(2), $reportpages ) ) { ?>show<?php } ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?php if( $this->uri->segment(2) == 'annual_reports' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/annual_reports/">Annual Report</a>
                    <a class="collapse-item <?php if( $this->uri->segment(2) == 'host_reports' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/host_reports/">List Host Report</a>
                </div>
            </div>
        </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>portal/Internshipplan">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Internship plan</span></a>
        </li>
        
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Utilities
        </div>

        <?php
            $coursespages = array("courses", "add_course", "edit_course");
        ?>
        <li class="nav-item <?php if( in_array($this->uri->segment(2), $coursespages ) ) { ?>active<?php } ?>">
            <a class="nav-link <?php if( in_array($this->uri->segment(2), $coursespages ) ) { ?><?php } else { ?>collapsed<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseCourses"
                aria-expanded="true" aria-controls="collapseCourses">
                <i class="fas fa-fw fa-id-card"></i>
                <span>Courses</span>
            </a>
            <div id="collapseCourses" class="collapse <?php if( in_array($this->uri->segment(2), $coursespages ) ) { ?>show<?php } ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?php if( $this->uri->segment(2) == 'courses' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/courses/">All Courses</a>
                    <a class="collapse-item <?php if( $this->uri->segment(2) == 'add_course' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/add_course/">Add New Course</a>
                </div>
            </div>
        </li>
      
     
        
        <!-- Nav Item - Utilities Collapse Menu -->
        <?php
            $utilitiespages = array("setting", "user_types", "activity_types");
        ?>
        <li class="nav-item <?php if( in_array($this->uri->segment(2), $utilitiespages ) ) { ?>active<?php } ?>">
            <a class="nav-link <?php if( in_array($this->uri->segment(2), $utilitiespages ) ) { ?><?php } else { ?>collapsed<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Config</span>
            </a>
            <div id="collapseUtilities" class="collapse <?php if( in_array($this->uri->segment(2), $utilitiespages ) ) { ?>show<?php } ?>" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                   <h6 class="collapse-header">Utilities:</h6>
                    <a class="collapse-item <?php if( $this->uri->segment(2) == 'setting' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/setting/">Settings</a>
                    <a class="collapse-item <?php if( $this->uri->segment(2) == 'user_types' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/user_types/">User Types</a>
                   <a class="collapse-item <?php if( $this->uri->segment(2) == 'activity_types' ) { ?>active<?php } ?>" href="<?php echo base_url(); ?>portal/activity_types/">Activity Types</a>
            </div>
        </li>
    
    <?php } ?>
   
</ul>
<!-- End of Sidebar -->