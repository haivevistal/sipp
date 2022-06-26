  <main id="main">

    <!-- ======= Activities Section ======= -->
    <section id="activities" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-12 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100" style="margin-bottom:40px;">
            
            <?php
            $msg = $this->session->flashdata('msg');
            if( $msg ) {
                ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $msg; ?>
                </div>
                <?php
            }
            $upload_msg = $this->session->flashdata('upload_msg');
            if( $upload_msg ) {
                ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $upload_msg; ?>
                </div>
                <?php
            }
            $error = $this->session->flashdata('error');
            if( $error ) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
                <?php
            }
            ?>
            <div class="mb-3">
                <h2>Update My Account Information</h2>
            </div>
            
            <form  method="POST" action="<?php echo base_url(); ?>profile/update" enctype="multipart/form-data">
              <div class="mb-3">
                <div class="row">
                    <?php if( isset($user->photo) ) { ?>
                        <div class="col-md-6 col-sm-12">
                            <img src="<?php base_url(); ?>/assets/uploads/profile/<?php echo $user->photo; ?>" alt="profile" style="width:120px;" />
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="photo" class="form-label">Update Profile Picture</label>
                            <input type="file" class="form-control" id="photo" name="photo" value="<?php echo isset($user->photo) ? $user->photo : ''; ?>" />
                        </div>
                    <?php } else { ?>
                        <div class="col-md-12 col-sm-12">
                            <label for="photo" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="photo" name="photo" />
                        </div>
                    <?php } ?>
                </div>
              </div>
              <div class="mb-3">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $user->firstname; ?>" />
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $user->lastname; ?>" />
                    </div>
                </div>
              </div>
              <div class="mb-3">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user->phone; ?>" />
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender">
                          <option selected>Select Gender</option>
                          <option value="m" <?php echo $user->gender == 'm' ? "selected" : ""; ?>>Male</option>
                          <option value="f" <?php echo $user->gender == 'f' ? "selected" : ""; ?>>Female</option>
                        </select>
                    </div>
                </div>
              </div>
              
              <div class="mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" rows="3" name="bio"><?php echo $user->bio; ?></textarea>
                    </div>
                </div>
              </div>
              
              
              <div class="mb-3" style="margin-top:4em;">
                <h2>Update Password and Email <span class="badge bg-secondary">Keep the password empty if you don't want to update</span></h2>
              </div>
              <div class="mb-3">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user->email; ?>" />
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password"  name="password" />
                    </div>
                </div>
              </div>
              
              <button type="submit" name="updateprofile" class="btn btn-primary">Update</button>
            </form>
          </div>
          
          
        </div>

      </div>
    </section><!-- End About Section -->

  </main><!-- End #main -->
    <style>
  #hero { height: 50vh; }
  </style>