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
		Absensi
		<small>Daftar Paket Pekerjaan</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url() ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Absensi</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <div class="col-md-6">
        	<div class="box">
                <div class="box-header with-border">
						<div class="box-title">Tambah Mitra Perusahaan</div>
                </div><!-- /.box-header -->
				
                <div class="box-body">
                	<div id="form-pesan"></div>
                    <div class="form-group">
                        <label>Proyek</label>
                        <select name="pekerjaan_id" id="pekerjaan_id" class="form-control sinput-sm ">
                            <?php if(!empty($select_divisi)){ echo $select_divisi; } ?>
                        </select>
                    </div>
                </div>
                
                <div class="box-body">
                	<div id="form-pesan"></div>
                    <div class="form-group">
                        <label>Pekerja</label>
                        <select name="pekerja_id" id="pekerja_id" class="form-control sinput-sm ">
                            <?php if(!empty($select_perkerja)){ echo $select_perkerja; } ?>
                        </select>
                    </div>
                </div>
                <div class="box-footer with-border text-right">
					 <button type="button" id="tambah-simpan" class="btn btn-primary" onclick="absen_masuk()">Login</button>
                </div><!-- /.box-header -->
             </div>       
        </div>
        <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
    						<div class="box-title">Data Absen</div>
                    </div><!-- /.box-header -->
					
                    <div class="box-body">
                        <input type="hidden" name="check" id="check" value="0">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Nama Proyek</th>
                                    <th class="all">Nama Pekerja</th>
                                    <th class="all">Jam Masuk</th>
                                    <th class="all"></th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php if($absensi != null){
                            	    foreach ($absensi as $key=>$data){
                            	?>
                                <tr>
                                    <td><?php echo $key+1?></td>
                                    <td><?php echo $data->nama_proyek?></td>
                                    <td><?php echo $data->nama_pekerja?></td>
									<td><?php echo $data->jam_masuk?></td>
									<td><a href="<?php echo site_url()."/manager/paket_pekerjaan/absen_pekerja_keluar/".$data->user_id."/".$data->id_pekerjaan."/".$data->id?>">Absen Keluar</a></td>
                                </tr>
                                <?php 
                            	    }
                                }
                                ?>
                            </tbody>
                        </table> 
                    </div>
                </div>
        </div>
    </div>

</section><!-- /.content -->



<script lang="javascript">
	function absen_masuk(){
		var pekerjaan_id = $("#pekerjaan_id").val();
		var pekerja_id = $("#pekerja_id").val();
		window.location = '<?php echo site_url()."/manager/paket_pekerjaan/absen_pekerja_masuk/"?>'+pekerja_id+'/'+pekerjaan_id;
	}
</script>