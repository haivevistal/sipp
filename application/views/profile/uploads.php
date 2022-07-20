  <main id="main">

    <!-- ======= Activities Section ======= -->
    <section id="activities" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-12 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100" style="margin-bottom:40px;">
            
            <h2>Uploads</h2>
            
            <table id="activities_table" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $map = directory_map($_SERVER["DOCUMENT_ROOT"].'/assets/uploads/admin/files');
                    ?>
                    <?php foreach($map as $m) : ?>
                    <tr>
                        <td><?php echo $m; ?></td>
                        <td><a href="<?php echo base_url(); ?>assets/plugins/tinyfilemanager/tinyfilemanager.php?p=&dl=<?php echo $m; ?>">Download</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    
          </div>
          
      </div>
    </section><!-- End About Section -->

  </main><!-- End #main -->
    <style>
  #hero { height: 50vh; }
  </style>