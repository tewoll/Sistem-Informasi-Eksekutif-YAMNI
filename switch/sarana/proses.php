<?php 
$baca = 'index.php?page=';
$bgp = isset($_GET['page']) ? $_GET['page'] : '';
if(empty($bgp)){
	header("Location:../../login.php");	
}elseif($bgp == 'index.php?page='){
	header("Location:../../login.php");	
}else{
	if ($level != 'admin') {
		echo "<script type='text/javascript'>
		Swal.fire({
			position: 'center',
			icon: 'error',
			title: 'Halaman tidak dapat diakses, <br> login sebagai administrator untuk mengakses halaman ini!',
			type: 'error',
			showConfirmButton: false,
			timer: 3200
			});
			window.setTimeout(function(){ 
				window.location.replace('index.php');
				} ,3000); 
				</script>";
	}else{

?>
<?php
$dct = isset($_GET['data']) ? $_GET['data'] : '';
$dct = inject_checker($connection,$dct);
switch($dct) 
{
	case 'tambah':
			
			
			$jenis 			= inject_checker($connection,$_POST['jenis_sarana']);
			$nama 			= inject_checker($connection,$_POST['sarana']);
			$keperluan	 	= inject_checker($connection,$_POST['keperluan']);
			$id_tingkat 	= inject_checker($connection,$_POST['lokasi']);
			$jumlah		 	= inject_checker($connection,$_POST['jumlah']);
			$kondisi 		= inject_checker($connection,$_POST['kondisi']);
			$ket 			= inject_checker($connection,$_POST['ket']);

			$lokasi_file 	= $_FILES['foto']['tmp_name'];
			$ekstensi 		=  array('png','jpg','jpeg', 'gif');
			$nama_file   	= $_FILES['foto']['name'];
			$acak        	= rand(1,99);
			$ukuran 		= $_FILES['foto']['size'];
			$n_gambar 		= $acak.$nama_file;
			$nm_gambar 		= md5($n_gambar);
			$nama_gambar 	= $nm_gambar.'.jpg';
			$ext 			= pathinfo($nama_file, PATHINFO_EXTENSION);

			if (empty($lokasi_file)) {
				$qsapras = mysqli_query($connection, "INSERT INTO sarana(id_jenis_sarana, nama_sarana, keperluan, kondisi, id_tingkat, jumlah, ket)  VALUES('{$jenis}', '{$nama}', '{$keperluan}', '{$kondisi}', '{$id_tingkat}', '{$jumlah}', '{$ket}')")OR die('Ada kesalahan pada query '.mysqli_error($connection));
				echo "<script type='text/javascript'>
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Data berhasil disimpan',
							text:  'Mohon bersabar, halaman akan otomatis teralihkan ke index data.',
							type: 'success',
							showConfirmButton: false,
							timer: 3200
							});
							window.setTimeout(function(){ 
								window.location.replace('index.php?page=sarana');
								} ,3000); 
								</script>";
			}else{
				if (!in_array($ext,$ekstensi) ) {
					echo "<script type='text/javascript'>
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Upload Gagal!',
							text:  'Pastikan file yang di upload bertipe *.jpg/ *.jpeg/ *.png/ *.gif !!.',
							type: 'error',
							showConfirmButton: false,
							timer: 3200
							});
							window.setTimeout(function(){ 
								window.location.replace('index.php?page=sarana&act=tambah);
								} ,3000); 
								</script>";
				}else{
					$folder = 'dist/img/foto_sapras/'; // folder untuk foto 
					$qsapras = mysqli_query($connection, "INSERT INTO sarana(id_jenis_sarana, nama_sarana, keperluan, kondisi, id_tingkat, jumlah, foto, ket)  VALUES('{$jenis}', '{$nama}', '{$keperluan}', '{$kondisi}', '{$id_tingkat}', '{$jumlah}', '{$nama_gambar}', '{$ket}')")OR die('Ada kesalahan pada query '.mysqli_error($connection));
					if ($qsapras == true) {
						move_uploaded_file($lokasi_file, $folder.$nama_gambar);

						echo "<script type='text/javascript'>
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Data berhasil disimpan',
							text:  'Mohon bersabar, halaman akan otomatis teralihkan ke index data.',
							type: 'success',
							showConfirmButton: false,
							timer: 3200
							});
							window.setTimeout(function(){ 
								window.location.replace('index.php?page=sarana');
								} ,3000); 
								</script>";
					}else{
						echo "<script type='text/javascript'>
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Upload Gagal!',
							text:  'Pastikan file yang di upload bertipe *.jpg/ *.jpeg/ *.png/ *.gif !!.',
							type: 'error',
							showConfirmButton: false,
							timer: 3200
							});
							window.setTimeout(function(){ 
								window.location.replace('index.php?page=sarana&act=tambah);
								} ,3000); 
								</script>";
					}
				}
			}

	break;
	
	case 'ubah':
		if (isset($_POST['simpan'])) {
			$id 			= inject_checker($connection,$_POST['id_sarana']);

			$jenis 			= inject_checker($connection,$_POST['jenis_sarana']);
			$nama 			= inject_checker($connection,$_POST['sarana']);
			$keperluan	 	= inject_checker($connection,$_POST['keperluan']);
			$id_tingkat 	= inject_checker($connection,$_POST['lokasi']);
			$jumlah		 	= inject_checker($connection,$_POST['jumlah']);
			$kondisi 		= inject_checker($connection,$_POST['kondisi']);
			$ket 			= inject_checker($connection,$_POST['ket']);

			$lokasi_file 	= $_FILES['foto']['tmp_name'];
			$ekstensi 		=  array('png','jpg','jpeg', 'gif');
			$nama_file   	= $_FILES['foto']['name'];
			$acak        	= rand(1,99);
			$ukuran 		= $_FILES['foto']['size'];
			$n_gambar 		= $acak.$nama_file;
			$nm_gambar 		= md5($n_gambar);
			$nama_gambar 	= $nm_gambar.'.jpg';
			$ext 			= pathinfo($nama_file, PATHINFO_EXTENSION);
			
			$qdata = mysqli_query($connection, "SELECT id_sarana FROM sarana WHERE id_sarana = '{$id}'");
			$cekdata = mysqli_num_rows($qdata);

			if($cekdata > 0){
				if (empty($lokasi_file)){
					$qsapras = mysqli_query($connection,"UPDATE sarana SET id_jenis_sarana = '{$jenis}',nama_sarana = '{$nama}', keperluan = '{$keperluan}', kondisi = '{$kondisi}', id_tingkat = '{$id_tingkat}', jumlah = '{$jumlah}', ket = '{$ket}' WHERE id_sarana = '{$id}'") OR die('Ada kesalahan pada query '.mysqli_error($connection));
					if ($qsapras == true) {
						/* untuk alamat */
						echo "<script type='text/javascript'>
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Data berhasil disimpan',
							text:  'Mohon bersabar, halaman akan otomatis teralihkan ke index data.',
							type: 'success',
							showConfirmButton: false,
							timer: 3200
							});
							window.setTimeout(function(){ 
								window.location.replace('index.php?page=sarana');
								} ,3000); 
								</script>";
					}else{
						echo "<script type='text/javascript'>
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Data gagal disimpan',
							text:  'periksa kembali inputan data!!.',
							type: 'error',
							showConfirmButton: false,
							timer: 3200
							});
							window.setTimeout(function(){ 
								window.location.replace('index.php?page=sarana&act=edit&id=$id');
								} ,3000); 
								</script>";
					}
				}else { 
					$foto_lama = inject_checker($connection,$_POST['foto_lama']);
					$qsapras = mysqli_query($connection,"UPDATE sarana SET id_jenis_sarana = '{$jenis}',nama_sarana = '{$nama}', keperluan = '{$keperluan}', kondisi = '{$kondisi}', id_tingkat = '{$id_tingkat}', jumlah = '{$jumlah}', foto = '{$nama_gambar}', ket = '{$ket}' WHERE id_sarana = '{$id}'") OR die('Ada kesalahan pada query '.mysqli_error($connection));
					if ($qsapras == true) {
						$folder = 'dist/img/foto_sapras/';
						unlink("dist/img/foto_sapras/$foto_lama");
						move_uploaded_file($lokasi_file, $folder.$nama_gambar);

						echo "<script type='text/javascript'>
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Data berhasil disimpan',
							text:  'Mohon bersabar, halaman akan otomatis teralihkan ke index data.',
							type: 'success',
							showConfirmButton: false,
							timer: 3200
							});
							window.setTimeout(function(){ 
								window.location.replace('index.php?page=sarana');
								} ,3000); 
								</script>";
					}else{
						echo "<script type='text/javascript'>
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Data gagal disimpan',
							text:  'periksa kembali inputan data!!.',
							type: 'error',
							showConfirmButton: false,
							timer: 3200
							});
							window.setTimeout(function(){ 
								window.location.replace('index.php?page=sarana&act=edit&id=$id');
								} ,3000); 
								</script>";
					}
				}
			}else{
				echo "<script type='text/javascript'>
				Swal.fire({
					position: 'center',
					icon: 'error',
					title: 'Data gagal disimpan',
					text:  'periksa kembali inputan data!!.',
					type: 'error',
					showConfirmButton: false,
					timer: 3200
					});
					window.setTimeout(function(){ 
						window.location.replace('index.php?page=sarana&act=edit&id=$id');
						} ,3000); 
						</script>";
			}
		}else{
			echo "<script type='text/javascript'>
			Swal.fire({
				position: 'center',
				icon: 'error',
				title: 'Data gagal disimpan',
				text:  'periksa kembali inputan data!!.',
				type: 'error',
				showConfirmButton: false,
				timer: 3200
				});
				window.setTimeout(function(){ 
					window.location.replace('index.php?page=sarana&act=edit&id=$id');
					} ,3000); 
					</script>";
		}

	break;

	case 'hapus':
		if (isset($_GET['id'])) {
			$ids = $_GET['id'];

			$qlokasi = mysqli_query($connection, "SELECT foto FROM sarana WHERE id_sarana='$ids'");
			$clok = mysqli_num_rows($qlokasi);
			if($clok > 0){
				$lok = mysqli_fetch_assoc($qlokasi);
				$qdel = mysqli_query($connection, "DELETE FROM sarana WHERE id_sarana='$ids'") or die('Ada kesalahan pada query delete : '.mysqli_error($connection));
				// cek hasil query
				if ($qdel == true) {
					$foto_lama = $lok['foto'];
					unlink("dist/img/foto_sapras/$foto_lama");  
					echo "<script type='text/javascript'>
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Data berhasil dihapus',
						text:  'Mohon bersabar, halaman akan otomatis teralihkan ke index data.',
						type: 'success',
						showConfirmButton: false,
						timer: 3200
						});
						window.setTimeout(function(){ 
							window.location.replace('index.php?page=sarana');
							} ,3000); 
							</script>";
				}else {  
					echo "<script type='text/javascript'>
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'Data gagal dihapus',
						type: 'error',
						showConfirmButton: false,
						timer: 3200
						});
						window.setTimeout(function(){ 
							window.location.replace('index.php?page=sarana');
							} ,3000); 
						</script>";
				}
			}else {  
				echo "<script type='text/javascript'>
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'Data gagal dihapus',
						type: 'error',
						showConfirmButton: false,
						timer: 3200
						});
						window.setTimeout(function(){ 
							window.location.replace('index.php?page=sarana');
							} ,3000); 
						</script>";
			}
		}else {  
				echo "<script type='text/javascript'>
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'Data gagal dihapus',
						type: 'error',
						showConfirmButton: false,
						timer: 3200
						});
						window.setTimeout(function(){ 
							window.location.replace('index.php?page=sarana');
							} ,3000); 
						</script>";
		}
	break;
	
	default:
		echo '<meta http-equiv="refresh" content="0;url=index.php?page=sarana">';
	break;
}
?>
<?php } }?>