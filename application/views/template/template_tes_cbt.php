<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.urbanui.com/victory/pages/samples/landing-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 23 Oct 2019 07:01:51 GMT -->
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php if(!empty($site_name)){ echo $site_name; } ?> | <?php echo $title; ?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/newtemplate/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/newtemplate/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/newtemplate/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/newtemplate/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
	<!-- plugin css for this page -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/newtemplate/vendors/ti-icons/css/themify-icons.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/newtemplate/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>public/newtemplate/images/icon.png" />
   <!-- Theme style -->
    <link href="<?php echo base_url(); ?>public/plugins/adminlte/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>public/plugins/adminlte/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
  
    <link href="<?php echo base_url(); ?>public/plugins/pnotify/pnotify.custom.min.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="<?php echo base_url(); ?>public/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>public/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
  	
  	<script src="<?php echo base_url(); ?>public/newtemplate/vendors/js/vendor.bundle.base.js"></script>
    
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>public/app.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>public/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/plugins/datatables/dataTables.reload.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>public/plugins/pnotify/pnotify.custom.min.js" type="text/javascript"></script>
    
    <!-- membuat gambar responsive pada soal -->
    <style type="text/css">
      #isi-tes-soal img {
        display: block;
        max-width: 100%;
        height: auto;
      }
    </style>

    <script type="text/javascript">
    function notify_success(pesan){
      new PNotify({
        title: 'Berhasil',
        text: pesan,
        type: 'success',
        history: false,
        delay:2000
      });
    }
        
    function notify_info(pesan){
      new PNotify({
        title: 'Informasi',
        text: pesan,
        type: 'info',
        history: false,
        delay:2000
      });
    }
    
    function notify_error(pesan){
      new PNotify({
        title: 'Error',
        text: pesan,
        type: 'error',
        history: false,
        delay:2000
      });
    } 
  </script>
</head>

<body>
  <div class="container-scroller landing-page">
			<div class="container-fluid top-banner">
				<nav class="navbar navbar-expand-lg bg-transparent">
					<div class="row flex-grow">
						<div class="col-md-8 d-lg-flex flex-row mx-auto">
							<a class="navbar-brand" href="#">
								<img src="<?php echo base_url(); ?>public/newtemplate/images/icon-landscape.png" alt="logo"/>
							</a>
							<button class="navbar-toggler collapsed float-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
								<span class="navbar-toggler-icon ti ti-menu text-white"></span>
							</button>
							<div class="collapse navbar-collapse" id="navbarSupportedContent">
								<ul class="navbar-nav ml-auto navbar-nav-right">
                                  	<li class="nav-item d-none d-lg-flex">
                                        <a class="nav-link nav-btn" href="#" >
                                          <span class="btn btn-primary" id="timestamp"><?php echo date("h:i:s A")?></span>
                                        </a>
                                    </li>
									<li class="nav-item dropdown">
										<a class="nav-link count-indicator dropdown-toggle" href="#" id="userDropdown" class="dropdown-toggle" data-toggle="dropdown">
											Hi, <?php if(!empty($nama)){ echo $nama; }else{ echo 'User Tes'; } ?>
										</a>
                                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="userDropdown">
                                          <a class="dropdown-item preview-item" href="#">
                                            <p class="mb-0 font-weight-normal float-left"> 
                                               <?php if(!empty($nama)){ echo $nama; }else{ echo 'User Tes'; } ?>
                                               <?php if(!empty($group)){ echo ' - '.$group; } ?>
                                            </p>
                                          </a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item preview-item" data-toggle="modal" href="#modal-password">
                                            <div class="preview-thumbnail">
                                              <div class="preview-icon bg-success">
                                                <i class="icon-key mx-0"></i>
                                              </div>
                                            </div>
                                            <div class="preview-item-content">
                                              <h6 class="preview-subject font-weight-medium">Ubah Password</h6>
                                              <p class="font-weight-light small-text">
                                                Klik untuk mengubah password Anda
                                              </p>
                                            </div>
                                          </a>
                                          <div class="dropdown-divider"></div>
                                          <a href="<?php echo site_url(); ?>/welcome/logout" class="dropdown-item preview-item">
                                            <div class="preview-thumbnail">
                                              <div class="preview-icon bg-warning">
                                                <i class="icon-logout mx-0"></i>
                                              </div>
                                            </div>
                                            <div class="preview-item-content">
                                              <h6 class="preview-subject font-weight-medium">Logout</h6>
                                              <p class="font-weight-light small-text">
                                                Klik untuk keluar dari Akun anda
                                              </p>
                                            </div>
                                          </a>
                                        </div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</nav>
				<div class="row container-fluid">
					<?php echo $content;?>
					
				</div>
			</div>
			
    		<!-- page-body-wrapper ends -->
  </div>
  
    <div class="modal" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <?php echo form_open('tes_dashboard/password','id="form-password"')?>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
          	<h5 class="modal-title">Ubah Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
                <span id="form-pesan-password"></span>
                <div class="box-body">
                  <div class="form-group">
                    <label>Old Password</label>
                    <input type="password" class="form-control" id="password-old" name="password-old" placeholder="Old Password">
                  </div>
                  <div class="form-group">
                    <label>New Password</label>
                    <input type="password" class="form-control" id="password-new" name="password-new" placeholder="New Password">
                  </div>
                  <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="password-confirm" name="password-confirm" placeholder="Confirm Password">
                  </div>
                </div>  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="password-submit">Ubah Password</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      <?php echo form_close(); ?> 
    </div><!-- /.modal -->
  
  <script type="text/javascript">
    $(function () {
        var serverTime = <?php if(!empty($timestamp)){ echo $timestamp; } ?>;
        var counterTime=0;
        var date;

        setInterval(function() {
          date = new Date();

          serverTime = serverTime+1;

          date.setTime(serverTime*1000);
          time = date.toLocaleTimeString();
          $("#timestamp").html(time);
        }, 1000);

        $('#modal-password').on('shown.bs.modal', function (e) {
          $('#form-pesan-password').html('');
          $('#password-old').val('');
          $('#password-new').val('');
          $('#password-confirm').val('');
          $('#password-old').focus();
        });
        
        $('#form-password').submit(function(){        
          $.ajax({
            url:"<?php echo site_url()?>/tes_dashboard/password",
            type:"POST",
            data:$('#form-password').serialize(),
            cache: false,
            success:function(respon){
              var obj = $.parseJSON(respon);
              if(obj.status==1){
                $('#form-pesan-password').html('');
                $('#modal-password').modal('hide');
                notify_success('Password berhasil diubah');
              }else{
                $('#form-pesan-password').html(pesan_err(obj.error));
              }
            }
          });
          return false;
        });
    });
  </script>

</body>


<!-- Mirrored from www.urbanui.com/victory/pages/samples/landing-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 23 Oct 2019 07:02:22 GMT -->
</html>
