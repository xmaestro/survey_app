<!-- Page Content -->
<div class="container">

  <div class="row">
    <div class="col-lg-12">
      <?php if(is_logged_in()===true){ ?>

        <?php if(!empty($survey)){ ?>

          <h1><?php echo $survey[0]->name; ?></h1>

          <?php
        if(isset($survey_error)) {
            
            ?>
            <div class="alert alert-danger">
              <?php echo $survey_error; ?>
            </div>
            <?php
            
        }?>

              <?php echo form_open('main/survey/'.$survey[0]->survey_id); ?>

                <?php foreach($survey as $field){ ?>

                  <?php echo render_field($field,$status); ?>

                    <?php } ?>

                      <?php if($status!='COMPLETED'){ ?>

                        <input class="btn btn-default" type="submit" name="submit" value="Submit">

                        <input class="btn btn-default" type="submit" name="save" value="Save Work">

                        <?php }else{ ?>

                        <?php echo '<br/><strong>Completed on: </strong>: '. $completed; ?>  

                        <?php } ?>

                          </form>

                          <?php }else{ ?>

                            <div class="alert alert-warning">Survey not found!</div>

                            <?php } ?>

                              <?php } ?>

    </div>
  </div>
  <!-- /.row -->

</div>