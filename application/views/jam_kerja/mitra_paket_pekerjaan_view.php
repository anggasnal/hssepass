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
		<li><a href="<?php echo site_url() ?>/manager/paket_pekerjaan">Paket Pekerjaan</a></li>
		<li class="active"><?php echo $paket_pekerjaan_nama?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <div class="col-md-6">
        	<div class="box">
        		<?php echo form_open_multipart($url.'/tambahmitra/'.$paket_pekerjaan_id,'id="form-tambah"'); ?>
                <div class="box-header with-border">
						<div class="box-title">Tambah Mitra Perusahaan</div>
                </div><!-- /.box-header -->
				
                <div class="box-body">
                	<div id="form-pesan"></div>

                    <div class="form-group">
                        <label>Nama proyek</label>
                        <p><?php echo $paket_pekerjaan_nama?></p>
					</div>
                    <div class="form-group">
                        <label>Alamat proyek</label>
                        <p><?php echo $paket_pekerjaan_alamat?></p>
					</div>
                    <div class="form-group">
                        <label>Status Proyek</label>
                        <p><?php echo ($paket_pekerjaan_aktif > 0)?"<span class='btn btn-primary btn-xs'>Aktif</span>" : "<span class='btn btn-danger btn-xs'>Tidak Aktif</span>"?></p>
					</div>
                    <div class="form-group">
                        <label>Mitra Perusahaan</label>
                        <input type="hidden" name="paket_pekerjaan_id" id="paket_pekerjaan_id" value="<?php echo $paket_pekerjaan_id?>">
                        <select name="mitra_id" id="mitra_id" class="form-control sinput-sm ">
                            <?php if(!empty($select_perusahaan)){ echo $select_perusahaan; } ?>
                        </select>
                    </div>
                </div>
                <div class="box-footer with-border text-right">
					 <button type="submit" id="tambah-simpan" class="btn btn-primary">Tambah</button>
                </div><!-- /.box-header -->
                <?php echo form_close();?>
             </div>       
        </div>
        <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
    						<div class="box-title">Mitra Perusahaan Yang Berpartisipasi</div>
                    </div><!-- /.box-header -->
					
                    <div class="box-body">
                        <input type="hidden" name="check" id="check" value="0">
                        <table id="table-paket-pekerjaan" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Nama Perusahaan</th>
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
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                    <div class="box-footer">
                        <button type="button" id="btn-edit-hapus" class="btn btn-primary" title="Hapus Siswa yang dipilih">Hapus</button>
                        <button type="button" id="btn-edit-pilih" class="btn btn-default pull-right">Pilih Semua</button>
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
	$("#mitra_id").select2();
    function refresh_table(){
        $('#table-paket-pekerjaan').dataTable().fnReloadAjax();
    }
	
	function hapus(id){
		var retVal = confirm("Hapus data ini?");
        if( retVal == true ) {
            $("#modal-proses").modal('show');
    		$.ajax({
                url:"<?php echo site_url().'/'.$url; ?>/hapusmitra",
                type:"POST",
                data:{
                	id_pekerjaan_mitra: id
                },
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
        } else {
            
        }
    return false;
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


        $('#form-tambah').submit(function(){
            $('#tambah-modul-id').val($('#modul').val());
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/tambahperusahaan",
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
                  "paging": false,
                  //"iDisplayLength":10,
                  "bProcessing": false,
                  "bServerSide": true, 
                  "searching": false,
                  "aoColumns": [
    					{"bSearchable": false, "bSortable": false, "sWidth":"20px"},
    					{"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false, "sWidth":"30px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"30px"}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable_mitra/<?php echo $paket_pekerjaan_id?>",
                  "autoWidth": false,
                  "responsive": true,
                  "fnServerParams": function ( aoData ) {
                    //aoData.push( { "name": "modul", "value": $('#modul').val()} );
                  }
         });          
    });
</script>