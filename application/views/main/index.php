<!-- Page Content -->
<div class="container">

  <div class="row">
    <div class="col-lg-12 text-center">
      <?php if(is_logged_in()===true){ ?>

        <h1>Hi, <?php echo user_info()->user_fname; ?></h1>

        <?php
        if($this->session->flashdata('survey_success')) {
        
        ?>
          <div class="alert alert-success">
            <?php echo $this->session->flashdata('survey_success'); ?>
          </div>
          <?php
        
        }?>

            <?php if(!empty($surveys)){ ?>

              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Survey Name</th>
                    <th>Survey Description</th>
                    <th>Creation Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php foreach($surveys as $survey){ ?>
                    <tr>
                      <td>
                        <?php echo $survey->name; ?>
                      </td>
                      <td>
                        <?php echo $survey->description; ?>
                      </td>
                      <td>
                        <?php echo $survey->created_on; ?>
                      </td>
                      <td>
                        <?php echo $survey->status; ?>
                      </td>
                      <td>
                        <?php if($survey->status=="COMPLETED"){ ?>
                          <a href="<?php echo base_url(); ?>main/survey/<?php echo $survey->survey_id; ?>">View</a>
                          <?php }else{ ?>
                            <a href="<?php echo base_url(); ?>main/survey/<?php echo $survey->survey_id; ?>">Fill</a>
                            <?php } ?>
                      </td>
                    </tr>
                    <?php } ?>

                </tbody>
              </table>

              <?php }else{ ?>

                <div class="alert alert-warning">No results found!</div>

                <?php } ?>

                  <?php } ?>

    </div>
  </div>
  <!-- /.row -->

</div>