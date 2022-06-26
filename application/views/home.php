  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex justify-content-center align-items-center">
    <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100">
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-12 text-content">
					<h2>SIPP COORDINATOR INTERNSHIP MONITORING AND INTERN E-PORTFOLIO</h2>
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
	<h3 style=" font-style:bold;">The SIPP COORDINATOR INTERNSHIP MONITORING AND INTERN E-PORTFOLIO</h3>
    <p class="fst-italic " style="font-family:Times New Roman;">
    	<br>
•	Provide automated recording of trainees’ attendance.
<br>
•	Provide trainees with electronic portfolio.
<br>
•	Provide trainees complaint message section that will direct to SIPP coordinator
<br>
•	Provide trainees Activity or task section.
<br>

This system helps the OJT trainee to easily login his or her attendance, view announcements, edit their profile, report the circumstances and request help from the admin or the SIPP coordinator, and easily create and process their portfolio. This system also provides an activity menu section where the Interns can view and modify their activities, and also provide a notification bell for them to be notified of the incoming activities given by the SIPP coordinator.

</p>

</p>
 </div>