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
                    <?php echo $msg; ?>+
                </div>
                <?php
            }
            if( $msg ) {
                ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $msg; ?>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="float-start">Update Activity</h2>
                    <a href="<?php echo base_url(); ?>profile/activities" class="btn btn-primary float-end" role="button">Go Back To My Activities</a>
                </div>
            </div>
            <form  method="POST" action="<?php echo base_url(); ?>profile/edit_activity/<?php echo $ac->id; ?>" enctype="multipart/form-data">
              <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>" />
              <input type="hidden" name="id" value="<?php echo $ac->id; ?>" />
              <div class="mb-3">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $ac->title; ?>" />
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="activity_type_id" class="form-label">Activity Type</label>
                        <select class="form-select" id="activity_type_id" name="activity_type_id">
                            <option selected>Select</option>
                            <?php 
                            foreach($activity_types as $activity_type) {
                                ?>
                                <option value="<?php echo $activity_type->id; ?>" <?php echo $ac->activity_type_id == $activity_type->id ? 'selected' : ''; ?>><?php echo $activity_type->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
              </div>
              
              <div class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="3" name="description"><?php echo $ac->description; ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label">Attachment</label>
                        <input class="form-control" type="file" id="activity_attach" name="activity_attach" size="33" />
                    </div>
                </div>
              </div>
              
              <div class="mb-3">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="activity_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="activity_date" name="activity_date" value="<?php echo $ac->activity_date; ?>" />
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" value="<?php echo $ac->start_time; ?>" />
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" value="<?php echo $ac->end_time; ?>" />
                    </div>
                </div>
              </div>
             
              <button type="submit" name="update_activity" class="btn btn-primary">Update Activity</button>
            </form>
    
          </div>
          
        </div>

      </div>
    </section><!-- End About Section -->

  </main><!-- End #main -->
    <style>
  #hero { height: 50vh; }
  </style>