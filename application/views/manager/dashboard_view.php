<?php 
$div = "";
$val1Div = "";
$val2Div = "";
$val3Div = "";
$val4Div = "";
if($divisi != null){
    $arr = array();
    $val1 = array();
    $val2 = array();
    foreach ($divisi as $d){
        $g = strpos($d->nama, '(');
        $kode = substr($d->nama, $g);
        $arr[] = "'".$kode."'";
        $val1[] = rand(0,100);
        $val2[] = rand(0,100);
        $val3[] = rand(0,100);
        $val4[] = rand(300,1000);
    }
    $div = implode(",", $arr);
    $val1Div = implode(",", $val1);
    $val2Div = implode(",", $val2);
    $val3Div = implode(",", $val3);
    $val4Div = implode(",", $val4);
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Dashboard
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/manager"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Dashboard</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
    
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-orange">
            	<i class="fa fa-id-badge"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Pemegang HSSE Pass</span>
              <span class="info-box-number"><?php echo $total_hsse_pass?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green">
            	<i class="fa fa-check"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Paket Pekerjaan Aktif</span>
              <span class="info-box-text">Sampai dengan saat ini</span>
              <span class="info-box-number"><?php echo $total_aktif?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua">
            	<i class="fa fa-clock-o"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Jam Kerja Aman</span>
              <span class="info-box-text">Sampai dengan saat ini</span>
              <span class="info-box-number"><?php echo $jam_kerja_aman?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red">
            	<i class="fa fa-group"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Total Pekerja Aktif</span>
              <span class="info-box-text">Sampai dengan saat ini</span>
              <span class="info-box-number"><?php echo $total_pekerja_aktif?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
	</div>
	
    <div class="callout callout-info">
    	<h4>Informasi</h4>
        <p>Jam kerja aman di akumulasi dari presensi pekerja dilapangan setelah jam keluar pekerja.</p>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Hasil Ujian Peserta</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>Rata-rata Nilai per Divisi per Level</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChart" style="height: 450px; width: 100%;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Rata-rata Divisi</strong>
                  </p>
				<?php 
				foreach ($divisi as $key=>$d){
				    $rata = ceil(($val1[$key] + $val2[$key] + $val3[$key]) / 3);
				    $warnas = array('aqua','green','red','orange','yellow');
				    switch ($rata){
				        case ($rata > 80 && $rata <= 100):
				            $w = $warnas[1];
				            break;
				        case ($rata > 60 && $rata <= 80 ):
				            $w = $warnas[0];
				            break;
				        case ($rata > 40 && $rata <= 60 ):
				            $w = $warnas[4];
				            break;
				        case ($rata > 20 && $rata <= 40 ):
				            $w = $warnas[3];
				            break;
				        case ($rata <= 20 ):
				            $w = $warnas[2];
				            break;
				    }
				?>
                  <div class="progress-group">
                    <span class="progress-text"><?php echo $d->nama?></span>
                    <span class="progress-number"><b><?php echo $rata?></b>/100</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-<?php echo $w?>" style="width: 80%"></div>
                    </div>
                  </div>
                <?php 
				}
                ?> 
                  <!-- /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      
      <div class="row">
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Total Pekerja Aktif</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center">
                    <strong>Total Pekerja Aktif per Divisi</strong>
                  </p>
                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="pekerjaChart" style="height: 400px; width: 100%;"></canvas>
                  </div>
                 </div>
               </div>
             </div>     
          </div>
        </div>
        
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Paket Pekerjaan Aktif</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
					<table id="table-paket-pekerjaan" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Nama Proyek</th>
                                    <th>Divisi Lokasi</th>
                                    <th>Jumlah Mitra Perusahaan</th>
                                    <th>Total Pekerja Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> </td>
                                    <td> </td>
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
        </div>
      </div>     
      
</section><!-- /.content -->
<script>
$(function () {

	  'use strict';

	  // -----------------------
	  // - MONTHLY SALES CHART -
	  // -----------------------

	  // Get context with jQuery - using jQuery's .get() method.
	  var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
	  // This will get the first returned node in the jQuery collection.
	  var salesChart       = new Chart(salesChartCanvas);

	  var salesChartData = {
	    labels  : [<?php echo $div?>],
	    datasets: [
	      {
	        label               : 'Top Management',
	        fillColor           : 'rgb(255, 133, 27)',
	        strokeColor         : 'rgb(255, 133, 27)',
	        pointColor          : 'rgb(255, 133, 27)',
	        pointStrokeColor    : '#ff851b',
	        pointHighlightFill  : 'black',
	        pointHighlightStroke: 'rgb(255, 133, 27)',
	        data                : [<?php echo $val1Div?>]
	      },
	      {
	        label               : 'Line Management',
	        fillColor           : 'rgba(0,192,239,0.9)',
	        strokeColor         : 'rgba(0,192,239,0.8)',
	        pointColor          : '#00c0ef',
	        pointStrokeColor    : 'rgba(0,192,239,1)',
	        pointHighlightFill  : 'black',
	        pointHighlightStroke: 'rgba(0,192,239,1)',
	        data                : [<?php echo $val2Div?>]
	      },
	      {
	        label               : 'Worker',
	        fillColor           : 'rgba(0,166,90,0.9)',
	        strokeColor         : 'rgba(0,166,90,0.8)',
	        pointColor          : '#00a65a',
	        pointStrokeColor    : 'rgba(0,166,90,1)',
	        pointHighlightFill  : 'black',
	        pointHighlightStroke: 'rgba(0,166,90,1)',
	        data                : [<?php echo $val3Div?>]
	      }
	    ]
	  };

	  var salesChartOptions = {
	    // Boolean - If we should show the scale at all
	    showScale               : true,
	    // Boolean - Whether grid lines are shown across the chart
	    scaleShowGridLines      : false,
	    // String - Colour of the grid lines
	    scaleGridLineColor      : 'rgba(0,0,0,.05)',
	    // Number - Width of the grid lines
	    scaleGridLineWidth      : 1,
	    // Boolean - Whether to show horizontal lines (except X axis)
	    scaleShowHorizontalLines: true,
	    // Boolean - Whether to show vertical lines (except Y axis)
	    scaleShowVerticalLines  : true,
	    // Boolean - Whether the line is curved between points
	    bezierCurve             : true,
	    // Number - Tension of the bezier curve between points
	    bezierCurveTension      : 0.3,
	    // Boolean - Whether to show a dot for each point
	    pointDot                : false,
	    // Number - Radius of each point dot in pixels
	    pointDotRadius          : 4,
	    // Number - Pixel width of point dot stroke
	    pointDotStrokeWidth     : 1,
	    // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
	    pointHitDetectionRadius : 10,
	    // Boolean - Whether to show a stroke for datasets
	    datasetStroke           : true,
	    // Number - Pixel width of dataset stroke
	    datasetStrokeWidth      : 2,
	    // Boolean - Whether to fill the dataset with a color
	    datasetFill             : true,
	    // String - A legend template
	    legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
	    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
	    maintainAspectRatio     : true,
	    // Boolean - whether to make the chart responsive to window resizing
	    responsive              : true
	  };

	  // Create the line chart
	  salesChart.Line(salesChartData, salesChartOptions);



	  // Get context with jQuery - using jQuery's .get() method.
	  var pekerjaChartCanvas = $('#pekerjaChart').get(0).getContext('2d');
	  // This will get the first returned node in the jQuery collection.
	  var pekerjaChart       = new Chart(pekerjaChartCanvas);

	  var pekerjaChartData = {
	    labels  : [<?php echo $div?>],
	    datasets: [
	      {
	        label               : 'Pekerja Aktif',
	        fillColor           : 'rgba(0,192,239,0.9)',
	        strokeColor         : 'rgba(0,192,239,0.8)',
	        pointColor          : '#00c0ef',
	        pointStrokeColor    : 'rgba(0,192,239,1)',
	        pointHighlightFill  : 'black',
	        pointHighlightStroke: 'rgba(0,192,239,1)',
	        data                : [<?php echo $val4Div?>]
	      }
	    ]
	  };

	  var pekerjaChartOptions = {
	    // Boolean - If we should show the scale at all
	    showScale               : true,
	    // Boolean - Whether grid lines are shown across the chart
	    scaleShowGridLines      : false,
	    // String - Colour of the grid lines
	    scaleGridLineColor      : 'rgba(0,0,0,.05)',
	    // Number - Width of the grid lines
	    scaleGridLineWidth      : 1,
	    // Boolean - Whether to show horizontal lines (except X axis)
	    scaleShowHorizontalLines: true,
	    // Boolean - Whether to show vertical lines (except Y axis)
	    scaleShowVerticalLines  : true,
	    // Boolean - Whether the line is curved between points
	    bezierCurve             : true,
	    // Number - Tension of the bezier curve between points
	    bezierCurveTension      : 0.3,
	    // Boolean - Whether to show a dot for each point
	    pointDot                : false,
	    // Number - Radius of each point dot in pixels
	    pointDotRadius          : 4,
	    // Number - Pixel width of point dot stroke
	    pointDotStrokeWidth     : 1,
	    // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
	    pointHitDetectionRadius : 10,
	    // Boolean - Whether to show a stroke for datasets
	    datasetStroke           : true,
	    // Number - Pixel width of dataset stroke
	    datasetStrokeWidth      : 2,
	    // Boolean - Whether to fill the dataset with a color
	    datasetFill             : true,
	    // String - A legend template
	    legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
	    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
	    maintainAspectRatio     : true,
	    // Boolean - whether to make the chart responsive to window resizing
	    responsive              : true
	  };

	  // Create the line chart
	  pekerjaChart.Bar(pekerjaChartData, pekerjaChartOptions);


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
                      {"bSearchable": false, "bSortable": false}],
                "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/",
                "autoWidth": false,
                "responsive": true,
                "fnServerParams": function ( aoData ) {
                  //aoData.push( { "name": "modul", "value": $('#modul').val()} );
                }
       });     	
});	  
</script>