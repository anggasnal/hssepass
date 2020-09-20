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

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Reward
		<small>Daftar reward, penambahan reward, pengubahan reward, dan penghapusan reward</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url() ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Reward</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
    						<div class="box-title">Pencatatan Reward</div>
    						<div class="box-tools pull-right">
    							<div class="dropdown pull-right">
    								<a style="cursor: pointer;" onclick="tambah()">Tambah Reward</a>
    							</div>
    						</div>
                    </div><!-- /.box-header -->
					
					<div class="box">
                    
                    <div class="box-body">
                        <div class="form-group">
                            <label>Modul</label>
                            <div id="data-kelas">
                                <select name="modul" id="modul" class="form-control input-sm">
                                    <?php if(!empty($select_modul)){ echo $select_modul; } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
					
                    <div class="box-body">
                        <?php echo form_open($url.'/hapus_pencatatan_reward','id="form-hapus"'); ?>
                        <input type="hidden" name="check" id="check" value="0">
                        <table id="table-prestasi" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Nama Pekerja</th>
                                    <th>Perusahaan</th>
                                    <th>Posisi</th>
                                    <th>Prestasi</th>
                                    <th>Tgl. Validasi</th>
                                    <th>Validator</th>
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

    <div class="modal" id="modal-tambah" data-backdrop="static"  role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open_multipart($url.'/tambah','id="form-tambah"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Pencatatan Reward</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan"></div>
                            <div class="form-group">
                                <label>Nama Pekerja</label>
                                <input type="hidden" name="tambah-modul-id" id="tambah-modul-id">
								<select name="nama-pekerja" id="nama-pekerja" class="form-control  sinput-sm ">
                                    <?php if(!empty($select_cbt_user)){ echo $select_cbt_user; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Valdasi</label>
                                    <input type="text" name="tanggal-validasi" id="tanggal-validasi" class="form-control input-sm"  readonly />
                            </div>
                            <div class="form-group">
                                <label>Nama Perusahaan</label>
                                <select name="nama-perusahaan" id="nama-perusahaan" class="form-control  sinput-sm ">
                                    <?php if(!empty($select_perusahaan)){ echo $select_perusahaan; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Posisi/ Jabatan</label>
                                <select name="nama-posisi" id="nama-posisi" class="form-control  sinput-sm ">
                                    <?php if(!empty($select_posisi)){ echo $select_posisi; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Prestasi</label>
                              <select name="nama-prestasi[]" id="nama-prestasi" class="mdb-select colorful-select dropdown-primary md-form" multiple="multiple" searchable="--Pilih--">
                                    <?php if(!empty($select_prestasi)){ echo $select_prestasi; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>FIle</label>
                                        <input type="file" id="upload-file" name="upload-file" >
                                        <p class="help-block">File yang didukung adalah Image, doc dan pdf</p>
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
                    <div id="trx-judul">Edit Data Reward</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan-edit"></div>
							<figure class="text-center">
								<img id = "edit-my-image" name = "my-image" class="img-circle rounded mx-auto d-block" alt="100x100" width = "200px" height = "200px" src="#" data-holder-rendered="true">
							</figure>
                            <div class="form-group">
                                <label>Nama Pekerja</label>
                                <input type="hidden" name="edit-id" id="edit-id">
                                <input type="hidden" name="edit-pilihan" id="edit-pilihan">
                                <select name="edit-nama-pekerja" id="edit-nama-pekerja" class="form-control  sinput-sm ">
                                    <?php if(!empty($select_cbt_user)){ echo $select_cbt_user; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Valdasi</label>
                                    <input type="text" name="edit-tanggal-validasi" id="edit-tanggal-validasi" class="form-control input-sm"  readonly />
                            </div>
                            <div class="form-group">
                                <label>Nama Perusahaan</label>
                                <select name="edit-nama-perusahaan" id="edit-nama-perusahaan" class="form-control  sinput-sm ">
                                    <?php if(!empty($select_perusahaan)){ echo $select_perusahaan; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Posisi/ Jabatan</label>
                                <select name="edit-nama-posisi" id="edit-nama-posisi" class="form-control  sinput-sm ">
                                    <?php if(!empty($select_posisi)){ echo $select_posisi; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Prestasi</label>
                              <select name="edit-nama-prestasi[]" id="edit-nama-prestasi" class="mdb-select colorful-select dropdown-primary md-form" multiple="multiple" searchable="--Pilih--">
                                    <?php if(!empty($select_prestasi)){ echo $select_prestasi; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Dokumen</label>
										<a href="#" id = "edit-download"><i class="fa fa-download" aria-hidden="true"><label>Dokumen</label></i></a><br/>
                                        <input type="file" id="edit-upload-file" name="edit-upload-file" >
                                        <p class="help-block">File yang didukung adalah Image, doc dan pdf</p>
                            </div>
                        </div>
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

    <div class="modal" id="modal-view" data-backdrop="static" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">View Reward Data</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
							<figure class="text-center">
								<img id = "my-image" name = "my-image" class="img-circle rounded mx-auto d-block" alt="100x100" width = "200px" height = "200px" src="#" data-holder-rendered="true">
							</figure>
                            <div class="form-group">
                                <label>Nama Pekerja</label>
                                <input type="hidden" name="view-pilihan" id="view-pilihan">
                                <select name="view-nama-pekerja" id="view-nama-pekerja" class="form-control  sinput-sm " disabled>
                                    <?php if(!empty($select_cbt_user)){ echo $select_cbt_user; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Valdasi</label>
                                    <input type="text" name="view-tanggal-validasi" id="view-tanggal-validasi" class="form-control input-sm"  disabled />
                            </div>
                            <div class="form-group">
                                <label>Nama Perusahaan</label>
                                <select name="view-nama-perusahaan" id="view-nama-perusahaan" class="form-control  sinput-sm "disabled>
                                    <?php if(!empty($select_perusahaan)){ echo $select_perusahaan; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Posisi/ Jabatan</label>
                                <select name="view-nama-posisi" id="view-nama-posisi" class="form-control  sinput-sm " disabled>
                                    <?php if(!empty($select_posisi)){ echo $select_posisi; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Prestasi</label>
                              <select name="view-nama-prestasi[]" id="view-nama-prestasi" class="mdb-select colorful-select dropdown-primary md-form" multiple="multiple" searchable="--Pilih--" disabled>
                                    <?php if(!empty($select_prestasi)){ echo $select_prestasi; } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <a href="#" id = "view-download"><i class="fa fa-download" aria-hidden="true"><label>Dokumen</label></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>

    </div>

    <div class="modal" id="modal-hapus" data-backdrop="static" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Hapus Data Terpilih</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <strong>Peringatan</strong>
                            Data yang sudah dipilih akan dihapus beserta detail didalamnya.
                            <br /><br />
                            Apakah anda yakin untuk menghapus data ini ?
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
</section><!-- /.content -->



<script lang="javascript">
	$("#nama-pekerja").change(function(){
            var jabatan = $('option:selected', this).attr('data-jabatan-id');
            var mitra = $('option:selected', this).attr('data-mitra-id');
			$('#nama-posisi').val(jabatan).trigger('change'); 
			$('#nama-perusahaan').val(mitra).trigger('change'); 
			
        });
    function refresh_table(){
        $('#table-prestasi').dataTable().fnReloadAjax();
    }
	
    function viewdata(id){
		$('#form-pesan').html('');
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_by_id/'+id+'', function(data){
            if(data.data==1){
				$('#view-id').val(data.id);
                $('#view-nama-pekerja').val(data.user_id);
                $('#view-nama-perusahaan').val(data.mitra_id);
                $('#view-nama-posisi').val(data.jabatan_id);
                $('#view-tanggal-validasi').val(data.tgl_validasi);
				var str = data.reward;
				var str_array = str.split(',');

				for(var i = 0; i < str_array.length; i++) {
				   str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
				   $("#view-nama-prestasi").find("option[value="+str_array[i]+"]").prop("selected", "selected");
				}
				
                
                $("#modal-view").modal("show");
				$('#view-tanggal-validasi').datepicker({format: 'dd/mm/yyyy',autoclose: true});
				$('#view-nama-perusahaan').select2();
				$('#view-nama-posisi').select2();
				$('#view-nama-prestasi').select2();
				$('#view-nama-pekerja').focus();
				$("#my-image").attr("src","<?php echo base_url();?>uploads/photos/"+data.foto);
				$("#view-download").attr("href","<?php echo base_url();?>uploads/documents/"+data.file);
            }
            $("#modal-proses").modal('hide');
        });
	}
	
    function tambah(){
        $('#form-pesan').html('');
        $('#upload-file').val('');

        $("#modal-tambah").modal("show");
		$('#tanggal-validasi').datepicker({format: 'dd/mm/yyyy',autoclose: true}); 
		$('#nama-pekerja').select2();
		$('#nama-perusahaan').select2();
		$('#nama-posisi').select2();
		$('#nama-prestasi').select2();
        $('#nama-pekerja').focus();
    }

    function edit(id){
		$('#form-pesan').html('');
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_by_id/'+id+'', function(data){
            if(data.data==1){
				$('#edit-id').val(data.id);
                $('#edit-nama-pekerja').val(data.user_id);
                $('#edit-nama-perusahaan').val(data.mitra_id);
                $('#edit-nama-posisi').val(data.jabatan_id);
                $('#edit-tanggal-validasi').val(data.tgl_validasi);
				var str = data.reward;
				var str_array = str.split(',');

				for(var i = 0; i < str_array.length; i++) {
				   str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
				   $("#edit-nama-prestasi").find("option[value="+str_array[i]+"]").prop("selected", "selected");
				}
				
                
                $("#modal-edit").modal("show");
				$('#edit-tanggal-validasi').datepicker({format: 'dd/mm/yyyy',autoclose: true});
				$('#edit-nama-perusahaan').select2();
				$('#edit-nama-posisi').select2();
				$('#edit-nama-prestasi').select2();
				$('#edit-nama-pekerja').focus();
				$("#edit-my-image").attr("src","<?php echo base_url();?>uploads/photos/"+data.foto);
				$("#edit-download").attr("href","<?php echo base_url();?>uploads/documents/"+data.file);
            }
            $("#modal-proses").modal('hide');
        });
    }

    $(function(){
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

        $("#modul").change(function(){
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
        $('#btn-edit-hapus').click(function(){
            $("#modal-hapus").modal('show');
        });
        $('#btn-hapus').click(function(){
            $("#form-hapus").submit();
        });

        $('#form-hapus').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/hapus_daftar_topik",
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
            $('#tambah-modul-id').val($('#modul').val());
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

        $('#table-prestasi').DataTable({
                  "paging": true,
                  "iDisplayLength":10,
                  "bProcessing": false,
                  "bServerSide": true, 
                  "searching": true,
                  "aoColumns": [
    					{"bSearchable": false, "bSortable": false, "sWidth":"20px"},
    					{"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false},
    					{"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false},
    					{"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false, "sWidth":"30px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"30px"}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/",
                  "autoWidth": false,
                  "responsive": true,
                  "fnServerParams": function ( aoData ) {
                    //aoData.push( { "name": "modul", "value": $('#modul').val()} );
                  }
         });          
    });
</script>