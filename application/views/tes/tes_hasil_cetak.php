<div id="style-div">
<style>
/* vietnamese */
@font-face {
  font-family: 'Josefin Sans';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: local('Josefin Sans Regular'), local('JosefinSans-Regular'), url(<?php echo base_url(); ?>public/fonts/Qw3aZQNVED7rKGKxtqIqX5EUAnx4RHw.woff2) format('woff2');
  unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
  font-family: 'Josefin Sans';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: local('Josefin Sans Regular'), local('JosefinSans-Regular'), url(<?php echo base_url(); ?>public/fonts/Qw3aZQNVED7rKGKxtqIqX5EUA3x4RHw.woff2) format('woff2');
  unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Josefin Sans';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: local('Josefin Sans Regular'), local('JosefinSans-Regular'), url(<?php echo base_url(); ?>public/fonts/Qw3aZQNVED7rKGKxtqIqX5EUDXx4.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}


body{
/*   background: #b696d7; */
}

.card{
  width: 210px;
  height: 330px;
  padding: 20px 20px 0;
  position: relative;
  border-radius: 10px;
  border:0px solid #ccc;
  overflow: hidden;
  float:left;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Aria, Helvetica, sans-serif;
  font-weight: bold;
}

/* .card img{ */
/*     width: 100%;  */
/*     margin-bottom: 80px;  */
/* } */

.card .bg{
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0px;
    left: 0px;
/*     z-index:-9; */
}
.card .foto{
    width: 80px;
    position: absolute;
    top: 65px;
    left: calc(50% - 40px);
    z-index:9;
}
.card .desc{
    width: 100%;
    position: absolute;
    top: 190px;
    left: 0px;
    text-align: center;
    z-index:9;
    font-weight: bold;
}
.card .desc .name{
    font-weight:bold;
    padding: 5px 0 5px 0;
    z-index:9;
}
.card .desc .no{
    font-size:9px;
}
.card .qr{
    width: 56px;
    position: absolute;
    bottom: 20px;
    left: calc(50% - 31px);
    z-index:9;
}

.card .info{
  position: absolute;
  bottom: 0;
  width: 100%;
  left: 0;
  padding: 20px;
  background: #353535;
  border-bottom-left-radius: 5px;
  border-bottom-right-radius: 5px;
}

.card p{
  text-transform: uppercase;
  letter-spacing: 5px;
  font-weight: bold;
  color: #fff;
  text-align: center;
  font-size: 12px;
}
.sandk{
  padding:20px 10px 20px 20px;
}
.sandk li{
  font-size: 10px;
  margin-bottom: 10px;
}
</style>
</div>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Hasil Tes
		<small>Hasil tes, menghapus hasil tes, mengunci tes, membuka kunci, dan menambah waktu tes</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url() ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo site_url()."/".$url ?>">Daftar Peserta</a></li>
		<li class="active">Cetak HSSE PASS</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<input type ="hidden"  name="pilih-tes" id="pilih-tes"	value="semua">
	<input type ="hidden"  name="pilih-group" id="pilih-group"	value="semua">
	<input type ="hidden"  name="pilih-rentang-waktu" id="pilih-rentang-waktu" value="<?php if(!empty($rentang_waktu)){ echo $rentang_waktu; } ?>">
	<input type ="hidden"  name="pilih-urutkan" id="pilih-urutkan"   value="tertinggi">
	<div class="row">
        <div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<div class="box-title">Daftar Hasil Tes - <?php echo $data_user->user_firstname?></div>
				</div><!-- /.box-header -->
				
                <?php echo form_open($url.'/save_pass','id="form-save-pass"'); ?>
                <input type="hidden" name="user_id" value="<?php echo $data_user->id?>">
                <div class="box-body">
					<table id="table-hasil" class="table table-bordered table-hover">
						<thead>
                            <tr>
                                <th class="all">No.</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu</th>
                                <th>Nama Tes</th>
                                <th>Group</th>
                                <th class="all">Nama User</th>
                                <th>Poin</th>
                                <th>Status</th>
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
				</div>
                <div class="box-footer">
                    <a href="<?php echo site_url()."/".$url?>" class="btn btn-default"><i class="fa fa-chevron-left"></i> Kembali </a>
                    <?php 
                    if($hsse_pass == null){
                    ?>
                    <button type="submit" id="buat-hsse-pass" class="btn btn-primary pull-right"><i class="fa fa-print"></i> Cetak HSSE PASS</button>
                    <?php 
                    }
                    ?>
                </div>
                <?php echo form_close()?>
			</div>
        </div>
	
    </div>
    <?php 
        if($hsse_pass != null){
    ?>
    <div class="row">
        <div class="col-xs-6">
			<div class="box">
				<div class="box-header with-border">
					<div class="box-title">HSSE PASSPORT : <?php echo $data_user->user_firstname?> (Depan)</div>
				</div><!-- /.box-header -->
                <div class="box-body" id="depan-print">
                      <div class="card" id="cardId-depan">
                      	<img class="bg" alt="background" src="<?php echo base_url(); ?>public/images/backgroundkartu.jpg">
                        <img class="foto" src="<?php echo base_url(); ?>uploads/photos/<?php echo $data_user->foto?>" alt="Employee_ID">
                        <img class="qr" src="<?php echo base_url(); ?>uploads/qrcode/<?php echo $data_user->qr_code?>" alt="Employee_ID">
                        <div class="desc">
                        	<div class="name"><?php echo $data_user->user_firstname?></div>
                        	<div class="no">No Pass : <?php echo $data_user->nomor_pass ?></div>
                        	<div class="no">  </div>
                        </div>
                      </div>
                </div>
                
                <div class="box-footer">
                	<button type="button" onclick="printDiv('depan-print')" id="buat-hsse-pass" class="btn btn-primary pull-right"><i class="fa fa-print"></i> Cetak</button>
                </div>
            </div>    
        </div>     
        <div class="col-xs-6">
			<div class="box">
				<div class="box-header with-border">
					<div class="box-title">HSSE PASSPORT : <?php echo $data_user->user_firstname?> (Belakang)</div>
				</div><!-- /.box-header -->
                <div class="box-body" id="belakang-print">
                      <div class="card" id="cardId-belakang">
                      	<ul class="sandk">
                      		<li style="text-align: justify;">Pemegang Kartu HSSE PASS wajib menaati ketentuan & peraturan HSSE yang berlaku di lingkungan PMO-PGN.</li>
                            <li style="text-align: justify;">Kartu ini agar selalu dibawa dalam setiap aktifitas keproyekan di lingkungan PMO-PGN.</li>
                            <li style="text-align: justify;">Apabila terjadi keadaan darurat agar segera menghubungi no tlp keadaan darurat pada ERP masing-masing proyek.</li>
                            <li style="text-align: justify;">Apabila menemukan kartu ini mohon dikembalikan segera kepada PT Perusahaan Gas Negara Tbk.</li>
                      	</ul>
                      </div>
                </div>
                
                <div class="box-footer">
                	<button type="button" onclick="printDiv('belakang-print')" id="buat-hsse-pass" class="btn btn-primary pull-right"><i class="fa fa-print"></i> Cetak</button>
                </div>
            </div>    
        </div>     
    </div>
    <?php 
        }
    ?>
</section><!-- /.content -->



<script lang="javascript">
    function refresh_table(){
        $('#table-hasil').dataTable().fnReloadAjax();
    }

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var styleContents = document.getElementById('style-div').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = styleContents+printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
    	

    $(function(){
        $("#form-save-pass").submit(function(){
        	$("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/save_pass",
                    type:"POST",
                    data:$('#form-save-pass').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            refresh_table();
                            $("#modal-proses").modal('hide');
                            $("#modal-hapus").modal('hide');
                            notify_success(obj.pesan);
                            window.location.reload(false); 
                        }else{
                            $("#modal-proses").modal('hide');
                            notify_error(obj.pesan);
                        }
                    }
            });
			return false;
        });
        
        $('#table-hasil').DataTable({
                  "paging": true,
                  "iDisplayLength":50,
                  "bProcessing": false,
                  "bServerSide": true, 
                  "searching": false,
                  "aoColumns": [
    					{"bSearchable": false, "bSortable": false, "sWidth":"20px"},
    					{"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false},
    					{"bSearchable": false, "bSortable": false, "sWidth":"150px"}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/<?php echo $data_user->id?>",
                  "autoWidth": false,
                  "responsive": true,
                  "aLengthMenu": [[10, 25, 50, 100, 200, 500], [10, 25, 50, 100, 200, 500]],
                  "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "tes", "value": $('#pilih-tes').val()} );
                    aoData.push( { "name": "group", "value": $('#pilih-group').val()} );
                    aoData.push( { "name": "waktu", "value": $('#pilih-rentang-waktu').val()} );
                    aoData.push( { "name": "urutkan", "value": $('#pilih-urutkan').val()} );
                  }
         });          
    });
</script>
