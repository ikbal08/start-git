<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title;?></title>
  <link rel="icon" href="<?= base_url();?>uploads/logo/amano.png" width="32" height="32">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/lte/');?>plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('assets/lte/');?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/lte/');?>dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link href="<?= base_url('assets/lte/');?>plugins/toastr/toastr.min.css" rel="stylesheet" />
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= base_url('dashboard');?>" class="h1"><b><?= $nameApp;?></b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

       <?php if(form_error('username')){?>
        <div class="alert alert-info alert-dismissible" id="pesan-flash">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-info"></i> Info!</h4>
          <?php echo form_error('username');?>
        </div>
      <?php };?>

      <?php if($this->session->flashdata('password_check')){?>
        <div class="alert alert-warning alert-dismissible" id="pesan-flash">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-warning"></i> Warning!</h4>
          <?php echo $this->session->flashdata('password_check');?>
        </div>
      <?php };?>

      <form name="post-form" id="post-form" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email/NIK" name="username" id="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" id="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="submit" id="submit" onclick="loginProcess();" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="https://61.8.76.43:447/Account/forgotPassword">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="https://61.8.76.43:447/account/newregister" class="text-center">Register</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url('assets/lte/');?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/lte/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/lte/');?>dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url('assets/lte/');?>plugins/toastr/toastr.min.js"></script>

<script type="text/javascript">
  // $(function(){
  //   $('#pesan-flash').delay(4000).fadeOut();
  //   $('#pesan-error-flash').delay(5000).fadeOut();
  // });
  $(function () {
      $('#pesan-flash').delay(4000).fadeOut();
      $('#pesan-error-flash').delay(5000).fadeOut();

      var postForm = $( '#post-form' );
 
      var jsonData = function( form ) {
      var arrData = form.serializeArray(),
        objData = {};
     
      $.each( arrData, function( index, elem ) {
          objData[elem.name] = elem.value;
      });
       
      return JSON.stringify( objData );
    };
 
    postForm.on( 'submit', function( e ) {
        e.preventDefault();
          $('#submit').text('Sign In...');
		  
		// $.ajaxSetup({
			// headers: {  'Access-Control-Allow-Origin': '<?php echo $urlApi;?>api/authentication/login/' }
		// });

        $.ajax({
            url: '<?php echo $urlApi;?>api/authentication/login/',
			//url: '',
			headers: {  'Access-Control-Allow-Origin': '<?php echo $urlApi;?>api/authentication/login/' },
            url2: '<?php echo base_url() ?>login/set_session',
            method: 'POST',
            data: jsonData( postForm ),
            crossDomain: true,
            contentType: 'application/json',
            beforeSend: function ( xhr ) {
              xhr.setRequestHeader( 'Authorization', 'Basic username:password' );
            },
            success: function( data ) {
              
              $.post("<?php echo base_url() ?>login/set_session", data, function(results) {
               //alert(results); // alerts 'Updated'
             window.location.href = "<?php echo base_url() ?>attandance";
              });
              //console.log( data );
       
            },
            error: function( error ) {
              $('#submit').text('Sign In');
              alert_toastr('gagal','Invalid login attempt!');
              //console.log( error );
            }
        });
    });
  });

  //*******************alert toastr.js*********************//
function alert_toastr(pesan,text)
{
  if(pesan=='berhasil')
  {
      toastr.success(text, "Status");
  }
  else
  {
      toastr.error(text, "Status");
  }
}

toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "100",
  "hideDuration": "100",
  "extendedTimeOut": "1000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
//*******************alert toastr.js*********************//
</script>
</body>
</html>
