<style>


/* Important part */
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 400px;
    overflow-y: auto;
}
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Paket Pekerjaan
		<small>Daftar Paket Pekerjaan</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url() ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Paket Pekerjaan</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green">
            	<i class="fa fa-check"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Paket Pekerjaan Aktif</span>
              <span class="info-box-number"><?php echo $total_aktif?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		<div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua">
            	<i class="fa fa-clock-o"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Jam Kerja Aman</span>
              <span class="info-box-number"><?php echo $jam_kerja_aman?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		<div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red">
            	<i class="fa fa-group"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Total Pekerja Aktif</span>
              <span class="info-box-number"><?php echo $total_pekerja_aktif?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
	</div>
	<div class="row">
        <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
    						<div class="box-title">Pencatatan Paket Pekerjaan</div>
    						<div class="box-tools pull-right">
    							<div class="dropdown pull-right">
    								<a style="cursor: pointer;" class="btn btn-primary" onclick="tambah()"><i class="fa fa-plus-circle"></i> Tambah Paket Pekerjaan</a>
    							</div>
    						</div>
                    </div><!-- /.box-header -->
					
                    <div class="box-body">
                        <?php echo form_open($url.'/hapus_pencatatan_punishment','id="form-hapus"'); ?>
                        <input type="hidden" name="check" id="check" value="0">
                        <table id="table-paket-pekerjaan" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Nama Proyek</th>
                                    <th>Divisi Lokasi</th>
                                    <th>Jumlah Mitra Perusahaan</th>
                                    <th>Total Pekerja Aktif</th>
                                    <th>Status Proyek</th>
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

    <div class="modal" id="modal-tambah" data-backdrop="static"  role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open_multipart($url.'/tambah','id="form-tambah"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Pencatatan Paket Pekerjaan</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan"></div>

                            <div class="form-group">
                                <label>Nama Proyek</label>
                                <input type="text" name="paket_pekerjaan_nama" id="paket_pekerjaan_nama" class="form-control input-sm" autocomplete="off"/><br/>
                            </div>

                            <div class="form-group">
                                <label>Lokasi Proyek</label>
                                <select name="paket_pekerjaan_alamat" id="paket_pekerjaan_alamat" class="form-control  sinput-sm ">
                                	<?php if(!empty($select_divisi)){ echo $select_divisi; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Status Aktif</label>
                              	<select name="paket_pekerjaan_aktif" id="paket_pekerjaan_aktif" class="form-control  sinput-sm ">
                                    <option value="0"> Tidak aktif</option>
                                    <option value="1"> Aktif</option>
                                </select>
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
                    <div id="trx-judul">Edit Paket Pekerjaan</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan-edit"></div>
                            <div class="form-group">
                                <label>Nama Proyek</label>
                                <input type="hidden" name="edit-pilihan" id="edit-pilihan">
                                <input type="hidden" name="edit_paket_pekerjaan_id" id="edit_paket_pekerjaan_id">
                                <input type="text" name="edit_paket_pekerjaan_nama" id="edit_paket_pekerjaan_nama" class="form-control input-sm" /><br/>
                            </div>

                            <div class="form-group">
                                <label>Lokasi Proyek</label>
                                <select name="edit_paket_pekerjaan_alamat" id="edit_paket_pekerjaan_alamat" class="form-control  sinput-sm ">
                                	<?php if(!empty($select_divisi)){ echo $select_divisi; } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Status Aktif</label>
                              	<select name="edit_paket_pekerjaan_aktif" id="edit_paket_pekerjaan_aktif" class="form-control  sinput-sm ">
                                    <option value="0"> Tidak aktif</option>
                                    <option value="1"> Aktif</option>
                                </select>
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
    function refresh_table(){
        $('#table-paket-pekerjaan').dataTable().fnReloadAjax();
    }
	
    function tambah(){
        $('#form-pesan').html('')
        $("#modal-tambah").modal("show");
        $('#form-tambah').trigger("reset");
        $('#paket_pekerjaan_nama').focus();
    }

    function edit(id){
		$('#form-pesan').html('');
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_by_id/'+id+'', function(data){
            if(data.data==1){
				$('#edit_paket_pekerjaan_id').val(data.paket_pekerjaan_id);
                $('#edit_paket_pekerjaan_nama').val(data.paket_pekerjaan_nama);
                $('#edit_paket_pekerjaan_alamat').val(data.paket_pekerjaan_alamat);
                $('#edit_paket_pekerjaan_aktif').val(data.paket_pekerjaan_aktif);
                $("#modal-edit").modal("show");
				
				$('#edit-nama-pekerja').focus();
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
                    url:"<?php echo site_url().'/'.$url; ?>/hapus",
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

        $('#table-paket-pekerjaan').DataTable({
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