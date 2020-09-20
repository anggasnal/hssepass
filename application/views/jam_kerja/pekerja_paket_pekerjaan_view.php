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
                </div>
                <?php echo form_close();?>
             </div>       
        </div>
        <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
    						<div class="box-title">Pekerja Aktif</div>
                    </div><!-- /.box-header -->
					
                    <div class="box-body">
                        <table id="table-paket-pekerjaan-pekerja" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Nama</th>
                                    <th class="all">Jam Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table> 
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
        $('#table-paket-pekerjaan-pekerja').dataTable().fnReloadAjax();
    }
	
    $(function(){
        
        $('#table-paket-pekerjaan-pekerja').DataTable({
                "paging": true,
                "iDisplayLength":10,
                "bProcessing": false,
                "bServerSide": true, 
                "searching": true,
                  "aoColumns": [
    					{"bSearchable": false, "bSortable": false, "sWidth":"20px"},
    					{"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false, "sWidth":"30px"}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable_pekerja_aktif/<?php echo $paket_pekerjaan_id?>",
                  "autoWidth": false,
                  "responsive": true,
                  "fnServerParams": function ( aoData ) {
                    //aoData.push( { "name": "modul", "value": $('#modul').val()} );
                  }
         });          
    });
</script>