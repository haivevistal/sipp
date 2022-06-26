  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

        <h1 class="logo me-auto"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>/assets/front/img/logo.png" class="" alt="">SIPP</a></h1>
      <?php if( $this->session->userdata('user_id') ) { ?>
           <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                  <ul class="navbar-nav">
                    <li class="nav-item">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                          Complaint
                        </button>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo base_url(); ?>profile/announcements">
                        <button type="button" class="btn btn-info position-relative" style="color:#fff !important;">
                          Announcements
                          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo $this->announcement_model->announcement_count(); ?>
                            <span class="visually-hidden">unread announcements</span>
                          </span>
                        </button>
                      </a>
                    </li>
                    <li class="nav-item">
                      <span>&nbsp;</span>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="userprofiledrop" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong><?php echo $this->session->userdata('firstname')." ".$this->session->userdata('lastname'); ?></strong>&nbsp;
                        <img src="<?php echo base_url(); ?>assets/uploads/profile/<?php echo $user->photo; ?>" alt="Profile" style="height: 32px;width: 32px;border: 2px solid #11111194;border-radius: 50%;" />
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="userprofiledrop">
                        <li><a class="dropdown-item <?php echo $this->uri->segment(2) == '' ? "active" : "not-active";?>" href="<?php echo base_url(); ?>profile">View My Account</a></li>
                        <li><a class="dropdown-item <?php echo $this->uri->segment(2) == 'update' ? "active" : "not-active";?>" href="<?php echo base_url(); ?>profile/update">Update Profile</a></li>
                        
                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>front/user_logout"><span class="badge bg-dark" style="font-size: 15px;">Sign Out</span></a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
       <?php } else { ?>
		<button class="btn btn-primary show-content" type="button">ABOUT SIPP</button>
	   <?php } ?>

    </div>
  </header><!-- End Header -->