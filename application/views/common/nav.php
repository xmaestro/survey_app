<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php if(is_logged_in()===true){ ?>
      <span class="navbar-brand">Howdy!</span>
      <?php } ?>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

        <?php if(is_logged_in()===false){ ?>

          <li>
            <a href="<?php echo base_url(); ?>auth/login">Login</a>
          </li>

          <li>
            <a href="<?php echo base_url(); ?>auth/register">Register</a>
          </li>

          <?php } ?>


            <?php if(is_logged_in()===true){ ?>

              <li>
                <a href="<?php echo base_url(); ?>auth/logout">Log Out</a>
              </li>

              <?php } ?>

      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container -->
</nav>