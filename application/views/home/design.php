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

*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Josefin Sans', sans-serif;
}

body{
/*   background: #b696d7; */
}

.wrapper{
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  background: #d0bbe5;
  padding: 35px 15px 15px;
  border-radius: 5px;
}

.wrapper:before{
  content: "";
  position: absolute;
  top: 11px;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 13px;
  background: #b696d7;
  border-radius: 50px;
}

.wrapper:after{
  content: "";
  position: absolute;
  top: -181px;
  left: 50%;
  transform: translateX(-50%);
  width: 60px;
  height: 200px;
  background: #353535;
  box-shadow: 0 5px 5px rgba(0,0,0,0.125);
}

.card{
  width: 200px;
  height: 320px;
  padding: 20px 20px 0;
  position: relative;
  border-radius: 10px;
  border:1px solid #ccc;
  overflow: hidden;
  float:left;
  margin-right:20px;
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
    z-index:-9;
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
    width: 62px;
    position: absolute;
    bottom: 20px;
    left: calc(50% - 31px);
    z-index:9;
}

/* .card:before{ */
/*   content: ""; */
/*   position: absolute; */
/*   top: 20px; */
/*   left: 20px; */
/*   width: 30%; */
/*   height: 225px; */
/*   background: #353535; */
/*   opacity: 0.8; */
/* } */

/* .card:after{ */
/*   content: "HSSE PASS"; */
/*   position: absolute; */
/*   top: 125px; */
/*   left: -50px; */
/*   transform: rotate(-90deg); */
/*   text-transform: uppercase; */
/*   letter-spacing: 5px; */
/*   color: #fff; */
/*   font-weight: bold; */
/* } */

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
  font-weight: 400;
  color: black;
  text-align: center;
  font-size: 12px;
}
.sandk{
  padding:10px;
}
.sandk li{
  font-size: 10px;
  margin-bottom: 10px;
}
</style>
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
</script>
  <div class="card" id="cardId">
  	<img class="bg" alt="background" src="<?php echo base_url(); ?>public/images/backgroundkartu.jpg">
    <img class="foto" src="<?php echo base_url(); ?>public/images/pasfoto.jpg" alt="Employee_ID">
    <img class="qr" src="<?php echo base_url(); ?>public/images/qr.png" alt="Employee_ID">
    <div class="desc">
    	<div class="name">Indra Lesmana</div>
    	<div class="no">No Passport : 20171000001</div>
    	<div class="no">Valid s.d <b>31 Oktober 2022</b></div>
    </div>
  </div>
  <div class="card" id="cardId">
  	<ul class="sandk">
  		<li>Pemegang Kartu HSSE PASS wajib manaati ketentuan & peraturan HSSE yang berlaku di lingkungan PMO-PGN.</li>
        <li>Kartu ini agar selalu dibawa dalam setiap aktifitas keproyekan di lingkungan PMO-PGN.</li>
        <li>Apabila terjadi keadaan darurat agar segera menghubungi no tlp keadaan darurat pada ERP masing-masing proyek.</li>
        <li>Apabila menemukan kartu ini mohon dikembalikan segera kepada PT Perusahaan Gas Negara Tbk.</li>
  	</ul>
  </div>
