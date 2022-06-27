<div class="row">
    <div class="col-md-12" style="margin-top:45px;">
        <h2 class="float-start">My Activities</h2>
        <!--<a href="<?php echo base_url(); ?>profile/add_activity" class="btn btn-primary float-end" role="button">Add New Activity</a>
    </div>-->
    </div>

    <table id="activities_table" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Title</th>
               <!-- <th>Type</th>-->
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
             
                <th></th>
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
              <!--  <td><?php echo date("h:i A", strtotime($ac->start_time) );  ?></td>-->
                <td><?php echo $ac->end_time == '00:00:00' ? "" : date("h:i A", strtotime($ac->end_time) ); ?></td>
                <td align="right">
                    <?php if($ac->activity_status == 3) { ?>
                    <span>Done</span>
                    <?php } else if($ac->activity_status == 4) { ?>
                    <span>Rejected</span>
                    <?php } else { ?>
                    <button data-id="<?php echo $ac->id; ?>" data-bs-toggle="modal" data-bs-target="#doneActivityModal" class="doneactivitybtn"><span class="badge bg-info">Done</span></button>
                    <a href="<?php echo base_url(); ?>profile/reject_activity/<?php echo $ac->id; ?>" class="delete" onClick="return confirm('Are you sure you want to reject?');" class="cancel">
                        <span class="badge bg-danger">Reject</span>
                    </a>
                    <?php } ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>