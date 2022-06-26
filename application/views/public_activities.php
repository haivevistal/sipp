  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex justify-content-center align-items-center">
    <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100">
        <div class="row">
            <div class="col-md-6">
                <h1>Activities</h1>
                <h2>The activities for the day.</h2>
            </div>
            <div class="col-md-6">
               <div class="calendar" id="calendar"></div>
            </div>
        </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Activities Section ======= -->
    <section id="activities" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-12 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
            
            <table id="activities_table" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Start Date/Time</th>
                        <th>End Date/Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($activities as $ac) : ?>
                    <tr>
                        <td><?php echo $ac->title; ?></td>
                        <td><?php echo $ac->description; ?></td>
                        <td><?php echo $ac->start_date_time; ?></td>
                        <td><?php echo $ac->start_date_time; ?></td>
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