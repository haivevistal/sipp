  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex justify-content-center align-items-center">
    <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100">
        <div class="row">
            <div class="col-md-6">
                <h1>Attendance</h1>
                <h2>The attendance for the day.</h2>
            </div>
            <div class="col-md-6">
                <div class="calendar" id="calendar"></div>
            </div>
        </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Attendance Section ======= -->
    <section id="attendance" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-12 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
            
            <table id="attendance_table" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Attendance Type</th>
                        <th>Connected Company</th>
                        <th>Date/Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($attendance as $at) : ?>
                    <tr>
                        <td><?php echo $at->title; ?></td>
                        <td><?php echo $at->description; ?></td>
                        <td><?php echo $at->company; ?></td>
                        <td><?php echo date("F d, Y  h:i A", strtotime($at->start_date_time) ); ?></td>
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