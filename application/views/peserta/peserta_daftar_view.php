<!-- Content Header (Page header) -->
<style>


/* Important part */
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 400px;
    overflow-y: auto;
}
.img-circle {
    border-radius: 50%;
}
</style>
<script>

function on_change_is_internal_group(el){
		  var selectedOption = el.target.value;
		  
		  if (selectedOption == 1) {
			document.getElementById('admin_settings_div').style.display = '';
			document.getElementById('divisi_div').style.display = '';
		  } else {
			document.getElementById('admin_settings_div').style.display = 'none';
			document.getElementById('divisi_div').style.display = 'none';
		  }
			
		}

function edit_on_change_is_internal_group(el){
		  var selectedOption = el.target.value;
		  
		  if (selectedOption == 1) {
			document.getElementById('edit-admin_settings_div').style.display = '';
			document.getElementById('edit-divisi_div').style.display = '';
		  } else {
			document.getElementById('edit-admin_settings_div').style.display = 'none';
			document.getElementById('edit-divisi_div').style.display = 'none';
		  }
			
		}
$(document).ready( function() {
		$('#tambah-group').change(function(){
            var id=$(this).val();
            $.ajax({
                url : "<?php echo base_url();?>index.php/manager/peserta_daftar/get_jabatan",
                method : "POST",
                data : {id: id},
                async : false,
                dataType : 'json',
                success: function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value = "'+data[i].jabatan_id+'">'+data[i].user_jabatan+'</option>';
                    }
                    $('.jabatan').html(html);
                     
                }
            });
        });
		$('#edit-group').change(function(){
            var id=$(this).val();
            $.ajax({
                url : "<?php echo base_url();?>index.php/manager/peserta_daftar/get_jabatan",
                method : "POST",
                data : {id: id},
                async : false,
                dataType : 'json',
                success: function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value = "'+data[i].jabatan_id+'">'+data[i].user_jabatan+'</option>';
                    }
                    $('.edit-jabatan').html(html);
                     
                }
            });
        });
    	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {
		    
		    var input = $(this).parents('.input-group').find(':text'),
		        log = label;
		    
		    if( input.length ) {
		        input.val(log);
		    } else {
		        if( log ) alert(log);
		    }
	    
		});
		
		
		
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        
		        reader.onload = function (e) {
		            $('#img-upload').attr('src', e.target.result);
		        }
		        
		        reader.readAsDataURL(input.files[0]);
		    }
		}
		function readURLEdit(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        
		        reader.onload = function (e) {
		            $('#edit-img-upload').attr('src', e.target.result);
		        }
		        
		        reader.readAsDataURL(input.files[0]);
		    }
		}

        // function readURLRapid(input) {
        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader();
                
        //         reader.onload = function (e) {
        //             $('#img-upload-rapid').attr('src', e.target.result);
        //         }
                
        //         reader.readAsDataURL(input.files[0]);
        //     }
        // }

		$("#imgInp").change(function(){
		    readURL(this);
		}); 
		$("#edit-imgInp").change(function(){
		    readURLEdit(this);
		});
// tambahan foto hasil rapid test
        // $("#imghasilrapidtest").change(function(){
        //     readURLRapid(this);
        // });  	
	});
</script>
<style>
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

#img-upload{
    width: 100%;
}
#edit-img-upload{
    width: 100%;
}
/*tambahan*/
#img-upload-rapid{
    width: 100%;
}
</style>
<section class="content-header">
	<h1>
		Peserta
		<small>Daftar peserta, penambahan peserta, pengubahan data peserta, dan penghapusan data peserta</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url() ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Peserta</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
       <!-- <div class="col-md-3">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="box-title">Pilih Group</div>
                    </div><!-- /.box-header -->

                    <!--<div class="box-body">
                        <div class="form-group">
                            <label>Group</label>
                            <div id="data-kelas">-->
                                <select name="group" id="group" class="form-control input-sm" style="display: none;">
                                    <option value="semua">Semua Group</option>
                                    <?php if(!empty($select_group)){ echo $select_group; } ?>
                                </select>
                           <!--</div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <p>Pilih group terlebih dahulu untuk menampilkan dan menambah data Peserta</p>
                    </div>
                </div>
        </div>-->

        <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
    						<div class="box-title">Daftar Peserta</div>
    						<div class="box-tools pull-right">
    							<div class="dropdown pull-right">
    								<a style="cursor: pointer;" onclick="tambah()">Tambah Peserta</a>
    							</div>
    						</div>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <?php echo form_open($url.'/hapus_daftar_siswa','id="form-hapus"'); ?>
                        <input type="hidden" name="check" id="check" value="0">
                        <table id="table-peserta" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Username</th>
                                    <th class="all">Nama</th>
                                    <th>Perusahaan</th>
                                    <th>Kelompok</th>
                                    <th>Jabatan</th>
                                    <th class="all">Action</th>
                                    <th class="all"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
									<td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>  
                        </form>                      
                    </div>
                    <div class="box-footer">
                        <button type="button" id="btn-edit-hapus" class="btn btn-primary" title="Hapus Siswa yang dipilih">Hapus</button>
                        <button type="button" id="btn-edit-pilih" class="btn btn-default pull-right">Pilih Semua</button>
                    </div>
                </div>
        </div>
    </div>

    <div class="modal" id="modal-hapus" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Hapus Peserta</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <strong>Peringatan</strong>
                            Data Siswa yang sudah dipilih akan dihapus, Data Hasil Tes juga akan terhapus.
                            <br /><br />
                            Apakah anda yakin untuk menghapus data Siswa ?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-hapus" class="btn btn-default pull-left">Hapus</button>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-tambah" data-backdrop="static" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open_multipart($url.'/tambah','id="form-tambah"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Tambah Peserta</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div class="row register-form">
                                    <div class="col-md-6">
										<div id="form-pesan"></div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="tambah-username" name="tambah-username" placeholder="Username Pengguna">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="tambah-password" name="tambah-password" placeholder="Password Pengguna">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="tambah-nama" name="tambah-nama" placeholder="Nama Lengkap Pengguna">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="tambah-email" name="tambah-email" placeholder="Email Pengguna (Boleh dikosongkan)">
                                        </div>
										<div class="form-group">
                                            <select name="tambah-mitra" id="tambah-mitra" class="form-control input-sm" onchange='on_change_is_internal_group(event)'>
                                    <?php if(!empty($select_mitra)){ echo $select_mitra; } ?>
                                </select>
                                        </div>
										<div class="form-group" id = "divisi_div" style="display: none;">
                                            <select name="tambah-divisi" id="tambah-divisi" class="form-control input-sm">
												<?php if(!empty($select_divisi)){ echo $select_divisi; } ?>
											</select>
                                        </div>
										<div class="form-group">
                                            <select name="tambah-group" id="tambah-group" class="form-control input-sm">
                                    <?php if(!empty($select_group)){ echo $select_group; } ?>
                                </select>
                                        </div>
										<div class="form-group">
                                            <select name="jabatan" id="jabatan" class="jabatan form-control">
												<option value="0">-PILIH-</option>
											</select>
                                        </div>
                                        
										<div class="form-group">
                                            <div class="input-group">
												<span class="input-group-btn">
													<span class="btn btn-default btn-file">
														Browse <input type="file" id="imgInp" name="imgInp">
													</span>
												</span>
												<input type="text" class="form-control" readonly>
											</div>
											<img id='img-upload'/>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <input type="radio" name="gender" id="gender" value="male" checked>
                                                <span> Male </span> 	
                                                <input type="radio" name="gender" id="gender" value="female">
                                                <span>Female </span> 
                                        </div>
										
                                        <div class="form-group">
                                            <input type="text" name="notlp" id="notlp" class="form-control" placeholder="Nomor Tlp/HP *" value="" />
                                        </div>
										
                                        <div class="form-group">
                                            <input type="text" name="emergency-phone" id="emergency-phone" class="form-control" placeholder="Emergency Phone" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="noktp" id="noktp" class="form-control" placeholder="Nomor KTP *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <textarea name="alamat" id="alamat"class="form-control" placeholder="Alamat *" value="" /></textarea>
                                        </div>
										<div class="form-group" id = "admin_settings_div">
                                            <input type="radio" name="is_admin" id="is_admin" value="user" checked>
                                                <span> Common User</span> 	
                                            <input type="radio" name="is_admin" id="is_admin" value="operator">
                                                <span>Admin Divisi</span> 
											<?php if($userlevel=='admin'){?>
                                            <input type="radio" name="is_admin" id="is_admin" value="admin">
                                                <span>Super Admin</span> 
											<?php } ?>
                                        </div>
<!-- tambahan -->
                                        <div class="form-group">
                                            <input type="date" name="tglrapidtest" id="tglrapidtest" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <select name="hasilrapidtest" id="hasilrapidtest" class="form-control">
                                                <option value="nonreactive">Non Reactive</option>
                                                <option value="reactive">Reactive</option>
                                            </select>
                                        </div>
                                         <div class="form-group">
                                            <textarea name="lokasirapidtest" id="lokasirapidtest"class="form-control" placeholder="Lokasi Rapid Test *" value="" /></textarea>
                                        </div>
<!-- tambahan foto hasil rapid test -->
                                       <!--  <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <span class="btn btn-default btn-file">
                                                        Browse <input type="file" id="imghasilrapidtest" name="imghasilrapidtest">
                                                    </span>
                                                </span>
                                                <input type="text" class="form-control" readonly>
                                            </div>
                                            <img id='img-upload-rapid'/>
                                        </div> -->

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="tambah-simpan" class="btn btn-primary">Tambah</button>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>

    </form>
    </div>

    <div class="modal" id="modal-edit" data-backdrop="static" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open_multipart($url.'/edit','id="form-edit"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Edit Peserta</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div class="row register-form">
                                    <div class="col-md-6">
                            <div id="form-pesan-edit"></div>
                            <div class="form-group">
                                <input type="hidden" name="edit-id" id="edit-id">
                                <input type="hidden" name="edit-pilihan" id="edit-pilihan">
                                <input type="text" class="form-control" id="edit-username" name="edit-username" readonly >
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" id="edit-password" name="edit-password" placeholder="Kosongkan Jika tidak ingin diubah">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="edit-nama" name="edit-nama" placeholder="Nama Lengkap Pengguna">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="edit-email" name="edit-email" placeholder="Email Peserta (Boleh dikosongkan)">
                            </div>

                            <div class="form-group">
                                            <select name="edit-mitra" id="edit-mitra" class="form-control input-sm" onchange='edit_on_change_is_internal_group(event)'>
                                    <?php if(!empty($select_mitra)){ echo $select_mitra; } ?>
                                </select>
                                        </div>
										<div class="form-group" id = "edit-divisi_div" style="display: none;">
                                            <select name="edit-divisi" id="edit-divisi" class="form-control input-sm">
												<?php if(!empty($select_divisi)){ echo $select_divisi; } ?>
											</select>
                                        </div>
										<div class="form-group">
                                            <select name="edit-group" id="edit-group" class="form-control input-sm">
                                    <?php if(!empty($select_group)){ echo $select_group; } ?>
                                </select>
                                        </div>
										<div class="form-group">
                                            <select name="edit-jabatan" id="edit-jabatan" class="edit-jabatan form-control">
												<option value="0">-PILIH-</option>
											</select>
                                        </div>
                                        
										<div class="form-group">
                                            <div class="input-group">
												<span class="input-group-btn">
													<span class="btn btn-default btn-file">
														Browse <input type="file" id="edit-imgInp" name="edit-imgInp">
													</span>
												</span>
												<input type="text" class="form-control" readonly>
											</div>
											<img id='edit-img-upload'/>
                                        </div>
                                        
                                    </div>
									<div class="col-md-6">
                                        <div class="form-group">
                                                <input type="radio" name="edit-gender" id="edit-gender" value="male" checked>
                                                <span> Male </span> 	
                                                <input type="radio" name="edit-gender" id="edit-gender" value="female">
                                                <span>Female </span> 
                                        </div>
										
                                        <div class="form-group">
                                            <input type="text" name="edit-notlp" id="edit-notlp" class="form-control" placeholder="Nomor Tlp/HP *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="edit-emergency-phone" id="edit-emergency-phone" class="form-control" placeholder="Emergency Phone" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="edit-noktp" id="edit-noktp" class="form-control" placeholder="Nomor KTP *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <textarea name="edit-alamat" id="edit-alamat"class="form-control" placeholder="Alamat *" value="" /></textarea>
                                        </div>
										<div class="form-group" id = "edit-admin_settings_div">
                                            <input type="radio" name="edit-is_admin" id="edit-is_admin" value="user" checked>
                                                <span> Common User</span> 	
                                            <input type="radio" name="edit-is_admin" id="edit-is_admin" value="operator">
                                                <span>Admin Divisi</span> 
											<?php if($userlevel=='admin'){?>	
                                            <input type="radio" name="edit-is_admin" id="edit-is_admin" value="admin">
                                                <span>Super Admin</span> 
												<?php } ?>
                                        </div>
<!-- tambahan -->
                                        <div class="form-group">
                                            <input type="date" name="edit-tglrapidtest" id="edit-tglrapidtest" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <select name="edit-hasilrapidtest" id="edit-hasilrapidtest" class="form-control">
                                                <option value="nonreactive">Non Reactive</option>
                                                <option value="reactive">Reactive</option>
                                            </select>
                                        </div>
                                         <div class="form-group">
                                            <textarea name="edit-lokasirapidtest" id="edit-lokasirapidtest"class="form-control" placeholder="Lokasi Rapid Test *" value="" /></textarea>
                                        </div>

									</div>
                                    </div>
									</div>
                            <p>NB : Peserta yang dihapus, maka semua hasil tes akan ikut terhapus !</p>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" id="edit-hapus" class="btn btn-default pull-left">Hapus</button>
                    <button type="button" id="edit-simpan" class="btn btn-primary">Simpan</button>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>

    </form>
    </div>
</section><!-- /.content -->



<script lang="javascript">
    function refresh_table(){
        $('#table-peserta').dataTable().fnReloadAjax();
    }

    function tambah(){
        $('#form-pesan').html('');
        $('#tambah-username').val('');
        $('#tambah-password').val('');
        $('#tambah-nama').val('');
        $('#tambah-email').val('');
        $('#tambah-mitra').val('');
        $('#notlp').val('');
        $('#noktp').val('');
        $('#alamat').val('');
        $('#imgInp').val('');
// tambahan
        $('#tglrapidtest').val('');
        $('#hasilrapidtest').select2({ width: '100%' });
        $('#lokasirapidtest').val('');
// tambahan foto hasil rapid test
        // $('#imghasilrapidtest').val('');


		$('#tambah-mitra').select2({ width: '100%' });
		$('#tambah-group').select2({ width: '100%' });
		$('#jabatan').select2({ width: '100%' });
		$('#tambah-divisi').select2({ width: '100%' });
		 
        $("#modal-tambah").modal("show");
        $('#tambah-username').focus();
    }

    function edit(id){
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_by_id/'+id+'', function(data){
            if(data.data==1){
                $('#edit-id').val(data.id);
                $('#edit-username').val(data.username);
                //$('#edit-password').val(data.password);
                $('#edit-nama').val(data.nama);
                $('#edit-email').val(data.email);
                $('#edit-group').val(data.group);
                $('#edit-mitra').val(data.mitra_id);
                $('#edit-divisi').val(data.divisi_id);
                $('#edit-divisi_div').val(data.divisi_id);
				//alert(data.mitra_id);
				if(data.mitra_id==1){
					document.getElementById('edit-divisi_div').style.display = '';
					document.getElementById('edit-admin_settings_div').style.display = '';
				}else{
					document.getElementById('edit-divisi_div').style.display = 'none';
					document.getElementById('edit-admin_settings_div').style.display = 'none';
				}
                //$('#edit-gender').val(data.gender);
				var $radiogender = $('input:radio[name=edit-gender]');
				$radiogender.filter('[value='+data.gender+']').prop('checked', true);
                $('#edit-alamat').val(data.alamat);
                $('#edit-noktp').val(data.no_ktp);
                $('#edit-notlp').val(data.no_tlp);
                $('#edit-emergency-phone').val(data.emergency_phone);
// tambahan
                $('#edit-tglrapidtest').val(data.tglrapidtest);
                $('#edit-hasilrapidtest').select2({ width: '100%' });               
                $('#edit-lokasirapidtest').val(data.lokasirapidtest);

				var def = 0;
				if(data.user_level==9) def = 'operator';
				if(data.user_level==1) def = 'admin';
				if(data.user_level==10) def = 'user';
				//alert(def);
				var $radioadmin = $('input:radio[name=edit-is_admin]');
				$("#edit-img-upload").attr("src","<?php echo base_url();?>uploads/photos/"+data.foto);
				$radioadmin.filter('[value='+def+']').prop('checked', true);
				$.ajax({
					url : "<?php echo base_url();?>index.php/manager/peserta_daftar/get_jabatan",
					method : "POST",
					dt : {id: data.group},
					async : false,
					dataType : 'json',
					success: function(dt){
						var html = '';
						var i;
						for(i=0; i<dt.length; i++){
							html += '<option value = "'+dt[i].jabatan_id+'">'+dt[i].user_jabatan+'</option>';
						}
						$('.edit-jabatan').html(html);
						setTimeout(function() {
						  $('#edit-jabatan').val(data.jabatan_id)
						}, 1500);
						
						 
					}
				});
                
				$('#edit-mitra').select2({ width: '100%' });
				$('#edit-group').select2({ width: '100%' });
				$('#edit-jabatan').select2({ width: '100%' });
				$('#edit-divisi').select2({ width: '100%' });
                $("#modal-edit").modal("show");
            }
            $("#modal-proses").modal('hide');
        });
    }

    $(function(){
        $("#group").change(function(){
            refresh_table();
        });

        $('#edit-simpan').click(function(){
            $('#edit-pilihan').val('simpan');
            $('#form-edit').submit();
        });
        $('#edit-hapus').click(function(){
            $('#edit-pilihan').val('hapus');
            $('#form-edit').submit();
        });
        $('#btn-edit-pilih').click(function(event) {
            if($('#check').val()==0) {
                $(':checkbox').each(function() {
                    this.checked = true;
                });
                $('#check').val('1');
            }else{
                $(':checkbox').each(function() {
                    this.checked = false;
                });
                $('#check').val('0');
            }
        });
        $('#btn-edit-hapus').click(function(){
            $("#modal-hapus").modal('show');
        });
        $('#btn-hapus').click(function(){
            $("#form-hapus").submit();
        });

        $('#form-hapus').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/hapus_daftar_siswa",
                    type:"POST",
                    data:$('#form-hapus').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            refresh_table();
                            $("#modal-proses").modal('hide');
                            $("#modal-hapus").modal('hide');
                            notify_success(obj.pesan);
                            $('#check').val('0');
                        }else{
                            $("#modal-proses").modal('hide');
                            notify_error(obj.pesan);
                        }
                    }
            });
            return false;
        });

        $('#form-edit').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/edit",
                    type:"POST",
					data:new FormData(this),
                    mimeType: "multipart/form-data",
                    contentType:false,
                    cache: false,
                    processData: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            refresh_table();
                            $("#modal-proses").modal('hide');
                            $("#modal-edit").modal('hide');
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan-edit').html(pesan_err(obj.pesan));
                        }
                    }
            });
            return false;
        });

        $('#form-tambah').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/tambah",
                    type:"POST",
					data:new FormData(this),
                    mimeType: "multipart/form-data",
					contentType:false,
                    cache: false,
                    processData: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            refresh_table();
                            $("#modal-proses").modal('hide');
                            $("#modal-tambah").modal('hide');
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err(obj.pesan));
                        }
                    }
            });
            return false;
        });

        $('#table-peserta').DataTable({
                  "paging": true,
                  "iDisplayLength":10,
                  "bProcessing": false,
                  "bServerSide": true, 
                  "searching": true,
                  "aoColumns": [
    					{"bSearchable": false, "bSortable": false, "sWidth":"20px"},
    					{"bSearchable": true, "bSortable": false, "sWidth":"80px"},
                        {"bSearchable": true, "bSortable": false, "sWidth":"80px"},
    					{"bSearchable": true, "bSortable": false, "sWidth":"50px"},
                        {"bSearchable": true, "bSortable": false, "sWidth":"50px"},
                        {"bSearchable": true, "bSortable": false, "sWidth":"50px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"20px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"20px"}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/",
                  "autoWidth": false,
                  "responsive": true,
                  "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "group", "value": $('#group').val()} );
                  }
         });          
    });
</script>