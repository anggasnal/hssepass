<form class="pt-2" id="form-login" class="form-horizontal">
  <div class="form-group">
    <input type="text" class="form-control text-center input-login" autocomplete="off" id="username" name="username" placeholder="Username">
  </div>
  <div class="form-group">
    <input type="password" class="form-control text-center input-login" autocomplete="off" id="password" name="password" placeholder="Password">
  </div>
  <!-- <div class="form-group">
   <input type="checkbox" id="show-password"> Show Password
  </div> -->

   <div id="form-pesan"></div>
   
   
   
  <div class="mt-5">
    <button type="submit"  class="btn btn-block btn-primary btn-rounded btn-lg font-weight-medium" id="btn-login">Login</button>
  </div>
</form>

<div class="modal" id="modal-proses" data-backdrop="static"
	tabindex="-1" role="dialog" aria-labelledby="basicModal"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" style="color:black">Data Sedang diproses...</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div> 
<!-- /.modal -->

<script type="text/javascript">
    function showpassword(){
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
    $(function () {
        $('#username').focus(); 

        $('#show-password').on('ifChanged', function(event){
          showpassword();
        });
        
        $('#form-login').submit(function(){
          $("#modal-proses").modal('show');
            $.ajax({
              url:"<?php echo site_url()?>/welcome/login",
     			    type:"POST",
					data: "username=" + btoa(btoa($('#username').val())) + "&password=" + btoa(btoa($('#password').val())),
     			    //data:$('#form-login').serialize(),
     			    cache: false,
      		        success:function(respon){
         		    	var obj = $.parseJSON(respon);
      		            if(obj.status==1){
      		                window.open("<?php echo site_url()?>/","_self");
          		        }else{
                            $('#form-pesan').html(obj.error);
                            $("#modal-proses").modal('hide');
                            $('#username').focus();   
          		        }
         			}
      		});
            
      		return false;
        });    
    });
</script>
