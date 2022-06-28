  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex justify-content-center align-items-center">
    <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100">
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-12 text-content">
					<h2 style="padding-top: 75px;font-size:32px;text-align: center;"><?php echo $this->setting_model->get_setting('homepagetitle')->value; ?></h2>
				</div>
            </div>
            <div class="col-md-6">
                <div class="loginform">
                    <?php
                    if( !$this->session->userdata('user_id') ) {
                        $error_msg = $this->session->flashdata('error_msg');
                        if( $error_msg ) {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_msg; ?>
                            </div>
                            <?php
                        }
                        ?>
                        <h3>Signin</h3>
                        <form method="POST" action="<?php echo base_url(); ?>front/login">
                          <div class="mb-3">
                            <label for="youremail" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="youremail" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                          </div>
                          <div class="mb-3">
                            <label for="yourpassword" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="yourpassword">
                          </div>
                          <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    <?php } else { ?>
                        <p>You're already logged in. You can view your attendance and activities by clicking the My Account button at the top.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
  </section><!-- End Hero -->
 <div class="fixed-content">
	<button class="close-content float-end" style="color: red;">x</button>
	<h3 style=" font-style:bold;"><?php echo $this->setting_model->get_setting('homepagepopuptitle')->value; ?></h3>
    <p class="fst-italic " style="font-family:Times New Roman;"><?php echo $this->setting_model->get_setting('homepagepopupcontent')->value; ?></p>
 </div>
 <style>
 .fixed-content {
    position: fixed;
    top: 0px;
    background: rgb(255, 255, 255);
    width: 50%;
    height: 100%;
    z-index: 999;
    padding: 50px;
    display:none;
 }
 </style>