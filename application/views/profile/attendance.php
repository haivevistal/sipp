  <main id="main">

    <!-- ======= Activities Section ======= -->
    <section id="activities" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-12 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100" style="margin-bottom:40px;">
            
            <div class="row">
                <div class="col-md-12">
                    <h2 class="float-start">My Attendance</h2>
                </div>
            </div>
            <table id="attendance_table" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Attendance Type</th>
                        <th>Connected Company</th>
                        <th>Date</th>
                        <th >Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($attendance as $at) : ?>
                    <tr>
                        <td><?php echo $at->title; ?></td>
                        <td><?php echo $at->description; ?></td>
                        <td>
                        <?php
                            $comp = $this->setting_model->get_company_by_id($at->company);
                            echo $comp->name;
                        ?>
                        </td>
                        <td><?php echo date("F d, Y  ", strtotime($at->date_time) ); ?></td>
                       
                         <td ><?php echo date("h:i A", strtotime($at->date_time) ); ?></td>
                        <td>
                        <?php if( $at->image ) { ?>
                            <a href="javascript:;" data-image-url="<?php echo base_url(); ?>assets/uploads/attendance/<?php echo $at->image; ?>" data-bs-toggle="modal" data-bs-target="#timeoutViewModal" class="view_timeout_image_btn">View</a>
                        <?php } ?>
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