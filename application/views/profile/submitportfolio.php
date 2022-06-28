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
                <h2>Submit a Portfolio</h2>
            </div>
            
            <form  method="POST" action="<?php echo base_url(); ?>profile/submit_portfolio" enctype="multipart/form-data">
              <div class="mb-3">
              
                <div class="accordion" id="submitportfoliopage">
                
                  <?php
                  $fields = array(
                    "one" => array("table_of_contents" , "Table Of Contents"), 
                    "two" => array("acknowledgement" , "Acknowledgement"), 
                    "three" => array("introduction" , "Introduction"), 
                    "four" => array( "vmg"  , "HTE/Company Profile - VMG"), 
                    "five" => array( "history" , "HTE/Company Profile - History"), 
                    "six" => array( "org_chart" , "HTE/Company Profile - Org. Chart"), 
                    "seven" => array( "weekly_narrative_report" , "Weekly Narrative Report"), 
                    "eight" => array( "learnings" , "Narrative Report - Learnings"),
                    "nine" => array( "conclusion","Narrative Report - Conclusion"),
                    "ten" => array( "parent_consent","Appendices - Parent Consent"),
                    "eleven" => array( "application_letter","Appendices - Application Letter"),
                    "twelve" => array( "cor","Appendices - Certificate of Registration"),
                    "thirteen" => array( "endorsement_letter","Appendices - Endorsement Letter"),
                    "fourteen" => array( "pictures","Appendices - Pictures"),
                    "fifthteen" => array( "dtr","Appendices - Daily Time Record"),
                    "sixteen" => array( "copy_moa","Appendices - Copy Moa"),
                    "seventeen" => array( "cert_ojt_completion","Appendices - Certificate Of OJT Completion"),
                    "eighteen" => array( "evaluation_sheet","Appendices - Evaluation Sheet"),
                    "nineteen" => array( "resume","Appendices - Resume"),
                  );
                  $exclude = array();
                  $c = 0; 
                  $portfolio = $portfolio ? (array)$portfolio[0] : array();
                  foreach( $fields as $key => $val ) {
                      ?>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?php echo $key; ?>">
                          <button class="accordion-button <?php echo $key == 'one' ? '': 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $key; ?>" aria-expanded="<?php echo $key == 'one' ? 'true': 'false'; ?>" aria-controls="collapse<?php echo $key; ?>">
                            <?php echo $val[1]; ?>
                          </button>
                        </h2>
                        <div id="collapse<?php echo $key; ?>" class="accordion-collapse collapse <?php echo $key == 'one' ? 'show': ''; ?>" aria-labelledby="heading<?php echo $key; ?>" data-bs-parent="#submitportfoliopage">
                          <div class="accordion-body">
                            <?php if( in_array($key, $exclude) ) { ?>
                                <button class="btn btn-primary">Generate</button>
                            <?php } else if( $key == 'seven') { ?>
                                <div class="row">
                                    <table id="" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Activity Name</th>
                                               <!-- <th>Type</th>-->
                                                <th>Description</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($activities as $ac) : ?>
                                            <tr>
                                                <td><?php echo $ac->title; ?></td>
                                               <!-- <td><?php echo $this->setting_model->get_activitytype_by_id($ac->activity_type_id)->name; ?></td>-->
                                                <td><?php echo $ac->description; ?></td>
                                                <td><?php echo date('M d, Y', strtotime($ac->activity_date) ); ?></td>
                                                <td><?php echo date('M d, Y', strtotime($ac->activity_date) ); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="display:none">
                                    <textarea name="pictures"><?php echo $images; ?></textarea>
                                </div>
                            <?php } else if( $key == 'fourteen') { ?>
                                <div class="row">
                                    <?php 
                                    $images = '';
                                    foreach( $attendance as $atd ) { ?>
                                        <?php 
                                        if( $atd->image != '' ) { 
                                        $images .= '<img width="100" height="100" style="width:100px;" src="'.base_url().'assets/uploads/attendance/'.$atd->image.'" alt="" />';
                                        ?>
                                            <div class="col-md-2">
                                                <img style="width:100%" src="<?php echo base_url();?>assets/uploads/attendance/<?php echo $atd->image; ?>" alt="" />
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div style="display:none">
                                    <textarea name="pictures"><?php echo $images; ?></textarea>
                                </div>
                            <?php } else if( $key == 'fifthteen') { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table width="100%" class="table table-striped dataTable no-footer">
                                            <tr><td>Type</td><td>Date</td><td>Time</td><td>Status</td></tr>
                                            <?php foreach( $myattendance as $atd ) { ?>
                                                <tr><td><?php echo $atd[0]; ?></td><td><?php echo $atd[1]; ?></td><td><?php echo $atd[2]; ?></td><td><?php echo $atd[3]; ?></td></tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
                                <div style="display:none">
                                    <textarea name="dtr"><?php echo $tables; ?></textarea>
                                </div>
                            <?php } else { ?>
                                <textarea class="form-control" id="editor<?php echo $c; ?>" name="<?php echo $val[0]; ?>" style="padding:20px;height:200px;">
                                    <?php echo isset($portfolio[$val[0]]) ? $portfolio[$val[0]] : ''; ?>
                                </textarea>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                      <?php
                      $c++;
                  }
                  ?>
                  
                </div>

              </div>
              
              <button type="submit" name="submit_portfolio" class="btn btn-primary" value="save">Submit Portfolio and Generate PDF</button>
              <?php if( isset($portfolio["pdf_link"]) ) { ?>
              <a type="submit" href="<?php echo base_url();?>assets/uploads/portfolio/<?php echo $portfolio["pdf_link"];?>" target="_blank" class="btn btn-success" value="pdf">View PDF</a>
              <?php } ?>
            </form>
      
          </div>
          
        </div>

      </div>
    </section><!-- End About Section -->

  </main><!-- End #main -->
    <style>
  #hero { height: 50vh; }
  </style>