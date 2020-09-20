<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Pengaturan MY CBT
		<small>Melakukan pengaturan Identitas MY CBT</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url() ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Pengaturan MY CBT</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <div class="col-xs-12">
			<?php echo form_open($url.'/simpan','id="form-pengaturan"'); ?>
                <div class="box">
                    <div class="box-header with-border">
    					<div class="box-title">Daftar Pengaturan MY CBT</div>
                    </div><!-- /.box-header -->

                    <div class="box-body form-horizontal">
						<div id="form-pesan"></div>
                        <div class="form-group">
							<label class="col-sm-4 control-label">Nama</label>
                            <div class="col-sm-8">
								<input type="text" class="form-control input-sm" id="MY CBT-nama" name="MY CBT-nama" >
                                <p class="help-block">
									Nama Pelaksana MY CBT.<br />
                                    Digunakan sebagai identitas pelaksanaan Tes.
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Keterangan</label>
                            <div class="col-sm-8">
								<input type="text" class="form-control input-sm" id="MY CBT-keterangan" name="MY CBT-keterangan" >
                                <p class="help-block">
									Keterangan Pelaksana bisa diisi dengan Slogan ataupun Alamat dari Organisasi.
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Link Login Operator</label>
                            <div class="col-sm-8">
								<select class="form-control input-sm" id="MY CBT-link-login" name="MY CBT-link-login">
									<option value="tidak">Tidak</option>
                                    <option value="ya">Ya</option>
								</select>
                                <p class="help-block">
									Menampilkan Link <b>Log In Operator</b> pada Halaman login user.
								</p>
							</div>
						</div>
                    </div>
					<div class="box-footer">
						<button type="submit" id="btn-simpan" class="btn btn-primary pull-right">Simpan Pengaturan</button>
					</div>
                </div>
			</form>
        </div>
    </div>
</section><!-- /.content -->



<script lang="javascript">
	function load_data(){
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_pengaturan_MY CBT', function(data){
            if(data.data==1){
                $('#MY CBT-nama').val(data.cbt_nama);
                $('#MY CBT-keterangan').val(data.cbt_keterangan);
                $('#MY CBT-link-login').val(data.link_login_operator);
            }
            $("#modal-proses").modal('hide');
        });
    }

    $(function(){
		load_data();
        $('#form-pengaturan').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/simpan",
                    type:"POST",
                    data:$('#form-pengaturan').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            $("#modal-proses").modal('hide');
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err(obj.pesan));
                        }
                    }
            });
            return false;
        });
    });
</script>
