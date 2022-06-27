<!-- Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="feedbackModal">Submit Complaint</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" action="<?php echo base_url(); ?>profile/submit_feedback" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <label for="title" class="form-label">Complaint Subject</label>
                    <input type="text" class="form-control" id="title" name="title" />
                </div>
                <div class="col-md-12 col-sm-12">
                    <label for="description" class="form-label">Complaint Message</label>
                    <textarea name="description" id="description" class="form-control" ></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <label for="attachement" class="form-label">Attach A File</label>
                    <input type="file" class="form-control" id="attachement" name="attachement" />
                </div>
            </div>
            <input type="hidden" name="redirect_url" value="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="submit_feeback" class="btn btn-primary">Submit</button>
          </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="timeoutModal" tabindex="-1" aria-labelledby="timeoutModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="timeoutModal">Submit an Attachment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" action="<?php echo base_url(); ?>profile/timeout" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <label for="attachement" class="form-label">Attach A File</label>
                    <input type="file" class="form-control" id="attachement" name="attachement" />
                    <input type="hidden" name="timeout_url" value="<?php echo base_url(); ?>profile/timeout" />
                </div>
            </div>
            <input type="hidden" name="redirect_url" value="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="submit_timeout_attachment" class="btn btn-primary">Submit</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="doneActivityModal" tabindex="-1" aria-labelledby="doneActivityModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="doneActivityModal">Submit an Attachment As a proof that you're done with the activity.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" action="<?php echo base_url(); ?>profile/finish_activity" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <label for="attachment" class="form-label">Attach A File</label> 
                    <input type="file" class="form-control" id="attachment" name="attachment" required />
                    <input type="hidden" name="activity_id" value="" id="activity_id" />
                </div>
            </div>
            <input type="hidden" name="redirect_url" value="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="done_activity_attachment" class="btn btn-primary">Done Activity and Submit Attachment</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="timeoutViewModal" tabindex="-1" aria-labelledby="timeoutViewModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="timeoutViewModal">View Attachment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-md-12 col-sm-12">
                  <div class="container_image_timeout"></div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ======= Footer ======= -->
<footer id="footer">
  <div class="container d-md-flex py-4">

    <div class="me-md-auto text-center text-md-start">
      <div class="copyright">
        &copy; Copyright <strong><span>SIPP</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        
      </div>
    </div>
    <div class="social-links text-center text-md-right pt-3 pt-md-0" style="display:none;">
      <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
      <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
      <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
      <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
    </div>
  </div>
</footer><!-- End Footer -->