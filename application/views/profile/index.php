  <main id="main">

    <!-- ======= Activities Section ======= -->
    <section id="activities" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-12 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100" style="margin-bottom:40px;">
            
            <h2>Announcements</h2>
            
            <table id="activities_table" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($announcements as $announcement) : ?>
                    <tr>
                        <td><?php echo $announcement->title; ?></td>
                        <td><?php echo $announcement->description; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    
          </div>
          
          <div class="col-lg-12 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
            
            <?php $this->load->view('profile/activity_list', $activities); ?>
          
          </div>

      </div>
    </section><!-- End About Section -->

  </main><!-- End #main -->
    <style>
  #hero { height: 50vh; }
  </style>