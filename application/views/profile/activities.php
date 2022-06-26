  <main id="main">

    <!-- ======= Activities Section ======= -->
    <section id="activities" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-12 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100" style="margin-bottom:40px;">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="float-start">My Activities</h2>
                  <!--  <a href="<?php echo base_url(); ?>profile/add_activity" class="btn btn-primary float-end" role="button">Add New Activity</a>-->
                </div>
            </div>
            <table id="activities_table" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        
                        <th>Description</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($activities as $ac) : ?>
                    <tr>
                        <td><?php echo $ac->title; ?></td>
                        <!--<td><?php echo $this->setting_model->get_activitytype_by_id($ac->activity_type_id)->name; ?></td>-->
                        <td><?php echo $ac->description; ?></td>
                        <td><?php echo date('M d, Y', strtotime($ac->activity_date) ); ?></td>
                        <td><?php echo date("h:i A", strtotime($ac->start_time) ) . " - ".date("h:i A", strtotime($ac->end_time) ); ?></td>
                        <td align="right">
                            <a href="<?php echo base_url(); ?>profile/edit_activity/<?php echo $ac->id?>"><span class="badge bg-info">Edit</span></a>
                            <a href="<?php echo base_url(); ?>profile/delete_activity/<?php echo $ac->id; ?>" class="delete" onClick="return confirm('Are you sure you want to delete?');" class="edit">
                                <span class="badge bg-danger">Delete</span>
                            </a>
                        
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    
          </div>
          
        </div>

      </div>
    </section><!-- End About Section -->

  </main><!-- End #main -->
    <style>
  #hero { height: 50vh; }
  </style>