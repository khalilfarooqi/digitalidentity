<!DOCTYPE html>
<html lang="en">
<?php 
  $assets_link=base_url('assets/backend'); 
?>
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Digitalidentity - Authentication</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?=$assets_link;?>/css/app.min.css">
  <link rel="stylesheet" href="<?=$assets_link;?>/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?=$assets_link;?>/css/style.css">
  <link rel="stylesheet" href="<?=$assets_link;?>/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?=$assets_link;?>/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">

                <?php if($msg=$this->session->flashdata('msg')){ ?>
                <div class="alert alert-danger">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">X</span> </button> <?=$msg;?>
                </div>
                <?php } ?>

                <?php 

                $username = (ENVIRONMENT == 'development') ? 'sysadmin' : '';

                if( $this->session->flashdata('postdata') ) {
                    $username = $this->session->flashdata('postdata')['username'] ?? 0;
                }

                $attributes=array(
                  'class'=>'form-horizontal form-material',
                  'id'=>'loginform',
                  'autocomplete'=>'off'
                );
                echo form_open('Authentication/authorize',$attributes);
                ?>
                  <div class="form-group">
                    <label for="email">Username or Email</label>
                    <input id="email" type="text" class="form-control" name="username" value="<?php echo set_value('username')?:$username?:''; ?>" placeholder="Please enter your username or email" tabindex="1" required autofocus>
                    <?=form_error('username','<p class="invalid-feedback">');?>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" placeholder="Please enter your password" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="<?=$assets_link;?>/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="<?=$assets_link;?>/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="<?=$assets_link;?>/js/custom.js"></script>
</body>

</html>