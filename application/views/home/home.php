<div class="col-md-8 mx-auto">
	<div class="row">
		<div class="col-md-4">
			<div class="m-3">
				<div class="card card-item-preview">
					<a href="<?php echo base_url(); ?>../filemanager/index.php?token=<?php echo $token;?>" style="display:block;">
					<img class="card-img-top"
						src="<?php echo base_url(); ?>public/newtemplate/images/home/filemanagement.jpg"
						alt="image">
					<div class="card-body py-3 border-top">
						<!-- <label class="badge badge-warning">New</label> -->
						<h6 class="font-weight-normal mb-0"><b>E-Module</b></h6>
						<small>Materi training - HSSE Pass</small>
					</div>
					</a>
				</div>
			</div>
		</div>
		<div class="col-md-4 grid-margin">
			<div class="m-3">
				<div class="card card-item-preview">
					<a href="<?php echo base_url(); ?>index.php/tes_dashboard" style="display:block;">
					<img class="card-img-top"
						src="<?php echo base_url(); ?>public/newtemplate/images/home/ujian.jpg"
						alt="image">
					<div class="card-body py-3 border-top">
						<h6 class="font-weight-normal mb-0"><b>Ujian Training</b></h6>
						<small>Mulai Ujian - HSSE Pass</small>
					</div>
					</a>
				</div>
			</div>
		</div>
		<?php if($userlevel=='admin' || $userlevel=='operator'){?>
		<div class="col-md-4 grid-margin">
			<div class="m-3">
				<div class="card card-item-preview">
					<a href="<?php echo base_url(); ?>index.php/manager/peserta_daftar" style="display:block;">
					<img class="card-img-top"
						src="<?php echo base_url(); ?>public/newtemplate/images/home/usermanagement.jpg"
						alt="image">
					<div class="card-body py-3 border-top">
						<h6 class="font-weight-normal mb-0"><b>User management</b></h6>
						<small>Daftar User & Peserta</small>
					</div>
					</a>
				</div>
			</div>
		</div>
		<div class="col-md-4 grid-margin">
			<div class="m-3">
				<div class="card card-item-preview">
					<a href="<?php echo base_url(); ?>index.php/manager/paket_pekerjaan" style="display:block;">
					<img class="card-img-top"
						src="<?php echo base_url(); ?>public/newtemplate/images/home/jamkerja.jpg"
						alt="image">
					<div class="card-body py-3 border-top">
						<h6 class="font-weight-normal mb-0"><b>Jam kerja aman</b></h6>
						<small>Satuan Kerja & Paket Pekerjaan</small>
					</div>
					</a>
				</div>
			</div>
		</div> 
		<div class="col-md-4 grid-margin">
			<div class="m-3">
				<div class="card card-item-preview">
					<a href="<?php echo base_url(); ?>index.php/manager/reward_punishment" style="display:block;">
					<img class="card-img-top"
						src="<?php echo base_url(); ?>public/newtemplate/images/home/rewardnpunish.jpg"
						alt="image">
					<div class="card-body py-3 border-top">
						<h6 class="font-weight-normal mb-0"><b>Reward & Punishment</b></h6>
						<small>Setup Reward & Punishment</small>
					</div>
					</a>
				</div>
			</div>
		</div> 
		<div class="col-md-4 grid-margin">
			<div class="m-3">
				<div class="card card-item-preview">
					<a href="<?php echo base_url(); ?>index.php/manager/dashboard" style="display:block;">
					<img class="card-img-top"
						src="<?php echo base_url(); ?>public/newtemplate/images/home/dashboard.jpg"
						alt="image">
					<div class="card-body py-3 border-top">
						<h6 class="font-weight-normal mb-0"><b>Dashboard</b></h6>
						<small>Dashboard & Report</small>
					</div>
					</a>
				</div>
			</div>
		</div> 
		<?php }?>
	</div>
</div>
