  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo base_url(); ?>/assets/vendor/aos/aos.js"></script>
  <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/vendor/php-email-form/validate.js"></script>
  <script src="<?php echo base_url(); ?>/assets/vendor/datatables/datatables.min.bootstrap5.js"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo base_url(); ?>/assets/front/js/main.js"></script>
  
  <script src="<?php echo base_url(); ?>/assets/ckeditor4/ckeditor.js"></script>
   <script>
    $(document).ready(function() {
        $(".doneactivitybtn").on("click", function() {
            let a_ic = $(this).attr("data-id");
            $("#doneActivityModal").find("#activity_id").val(a_ic);
        });
        $('#attendance_table,#activities_table').DataTable({
            "paging":   true,
            "ordering": false,
            "info":     false
        });
		$(".show-content").on("click", function() {
			$(".fixed-content").show();
		});
		$(".close-content").on("click", function() {
			$(".fixed-content").hide();
		});
        $(".view_timeout_image_btn").on( "click", function() {
            let urlimage = $(this).attr("data-image-url");
            $(".container_image_timeout").html('<img src="'+urlimage+'" alt="Timeout Image" style="width:100%" />');
        });
        $('#myTab a').on('click', function (e) {
          e.preventDefault()
          $(this).tab('show')
        });
        
    } );
    <?php if($this->uri->segment(2) == 'submit_portfolio') { ?>
    for( var n = 0 ; n <=20; n++ ) {
        CKEDITOR.replace('editor'+n, {
          height: 260,
          removeButtons: 'PasteFromWord'
        });
    }
    <?php } ?>
   </script>

</body>

</html>