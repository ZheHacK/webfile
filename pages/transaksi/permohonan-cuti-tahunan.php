<section class="content-header">
    <h1>Permohonan<small>Cuti</small></h1>
    <ol class="breadcrumb">
        <li><a href="home-pegawai.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Permohonan Cuti</li>
    </ol>
</section>
<div class="register-box">
<?php
	include "dist/koneksi.php";
	function kdauto($tabel, $inisial){
		$struktur   = mysql_query("SELECT * FROM $tabel");
		$field      = mysql_field_name($struktur,0);
		$panjang    = mysql_field_len($struktur,0);
		$qry  = mysql_query("SELECT max(".$field.") FROM ".$tabel);
		$row  = mysql_fetch_array($qry);
		if ($row[0]=="") {
		$angka=0;
		}
		else {
		$angka= substr($row[0], strlen($inisial));
		}
		$angka++;
		$angka      =strval($angka);
		$tmp  ="";
		for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";
		}
		return $inisial.$tmp.$angka;
	}
	$no_cuti	=kdauto("tb_mohoncuti","");
	$nip		=$_SESSION['id_user'];
	$tgl		=date('H:m:s');
	
		
	if ($_POST['save'] == "save") {
	$dari	=$_POST['dari'];
	$sampai	=$_POST['sampai'];
	//menghitung jumlah hari
	$selisih = strtotime($sampai) - strtotime($dari);
	$selisih = $selisih/86400;
	$jml_hari = 1 + $selisih;
	
	$cekhak= "SELECT hak_cuti_tahunan FROM tb_pegawai WHERE nip='$nip'";
	$query=mysql_query($cekhak);
		$data=mysql_fetch_array($query);
		$hak=$data['hak_cuti_tahunan'];
	
	if (empty($_POST['dari']) || empty($_POST['sampai'])) {
		echo "<div class='register-logo'><b>Oops!</b> Data Tidak Lengkap.</div>
			<div class='box box-primary'>
				<div class='register-box-body'>
					<p>Harap periksa kembali dan pastikan data yang Anda masukan lengkap dan benar</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-pegawai.php?page=form-permohonan-cuti-tahunan' class='btn btn-block btn-warning'>Back</button>
						</div>
					</div>
				</div>
			</div>";
	}
		
	else if ($hak < $jml_hari) {
	echo "<div class='register-logo'><b>Oops!</b> Hak Cuti Deficit</div>
			<div class='box box-primary'>
				<div class='register-box-body'>
					<p>Periksa kembali tanggal cuti. Hak cuti yang tersedia <b>$hak</b>, jumlah pengajuan <b>$jml_hari</b>.</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-pegawai.php?page=form-permohonan-cuti-tahunan' class='btn btn-block btn-warning'>Back</button>
						</div>
					</div>
				</div>
			</div>";
	}
		
	else{
		echo "<div class='register-logo'><b>Transaction</b> Successful!</div>	
				<div class='register-box-body'>
					<p>MAAF, PROSES INI HANYA DAPAT BERJALAN DI APLIKASI VERSI PRO, SILAHKAN HUBUNGI ADMIN RajaPutraMedia.Com</p>
					<div class='row'>
						<div class='col-xs-8'></div>
						<div class='col-xs-4'>
							<button type='button' onclick=location.href='home-pegawai.php' class='btn btn-danger btn-block btn-flat'>Next >></button>
						</div>
					</div>
				</div>";
	}
	}
?>
</div>