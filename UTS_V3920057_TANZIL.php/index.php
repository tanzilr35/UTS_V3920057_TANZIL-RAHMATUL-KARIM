<?php
// CAESAR CIPHER
// Memanggil fungsi isset untuk mengetahui apakah variabel yang di POST pada form input terisi atau kosong
if(isset($_POST['submit1'])) {
	// Membuat fungsi sandi/chiper
	function Cipher($ch, $key) {
			if (!ctype_alpha($ch))
			return $ch;
			
			// offset = pergeseran
			// ord berfungsi mengambil karakter sebagai argumen dan mengembalikan kode ASCII yang sesuai dengan karakter itu
			$offset = ord(ctype_upper($ch) ? 'A' : 'a');
			// fmod digunakan untuk mengembalikan sisa (modulo)
			// menggunakan rumus (x-n) % 26
			return chr(fmod(((ord($ch) + $key) - $offset), 26) + $offset);
	}

	// Enchiper = Enkripsi
	function Encipher($input, $key) {
			$output = "";
			
			// str_split berguna untuk membagi string menjadi array
			$inputArr = str_split($input);
			foreach ($inputArr as $ch)
			$output .= Cipher($ch, $key);
			
			return $output;
	}

	// Decipher = Deskripsi
	function Decipher($input, $key) {
			return Encipher($input, 26 - $key);
	}

	// Kondisi lain jika submit1 ditolak
} else if(isset($_POST['submit2'])) {
	function Cipher($ch, $key) {
			if (!ctype_alpha($ch))
			return $ch;
			
			$offset = ord(ctype_upper($ch) ? 'A' : 'a');
			return chr(fmod(((ord($ch) + $key) - $offset), 26) + $offset);
	}
	
	function Encipher($input, $key) {
			$output = "";

			$inputArr = str_split($input);
			foreach ($inputArr as $ch)
			$output .= Cipher($ch, $key);

			return $output;
	}

	function Decipher($input, $key) {
			return Encipher($input, 26 - $key);
	}
}

// VIGENERE CIPHER
// variabel
$kunci = "";
$kode = "";
$error = "";
$valid = true;
$color = "#FF0000";

// jika form di submit
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	// mendeklarasi fungsi enkripsi dan dekripsi
	require_once('convert.php');
	
	// set variabel-variabel
	$kunci = $_POST['kunci'];
	$kode = $_POST['kode'];
	
	// cek apakah kunci ada atau tidak
	if (empty($_POST['kunci']))
	{
		$error = "Mohon isi kuncinya!";
		$valid = false;
	}
	
	// cek apakah teks ada atau tidak
	else if (empty($_POST['kode']))
	{
		$error = "Ketikkan teks atau kode agar bisa dienkripsi atau dekripsi!";
		$valid = false;
	}
	
	// cek jika kunci mengandung angka atau karakter
	else if (isset($_POST['kunci']))
	{
		if (!ctype_alpha($_POST['kunci']))
		{
			$error = "Kunci hanya boleh di isi dengan huruf!";
			$valid = false;
		}
	}
	
	// jika yang di input valid
	if ($valid)
	{
		// jika enkripsi dijalankan atau tombol enkrip di klik
		if (isset($_POST['enkripsi']))
		{
			$kode = enkripsi($kunci, $kode);
			$error = "Teks berhasil dienkripsi!";
			$color = "#526F35";
		}
			
		// jika dekripsi dijalankan atau tombol dekrip di klik
		if (isset($_POST['dekripsi']))
		{
			$kode = dekripsi($kunci, $kode);
			$error = "Kode berhasil didekripsi!";
			$color = "#526F35";
		}
	}     
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Tugas Vigenere Cipher</title>
        <!-- Beri warna background -->
        <style>
        body {
            background-color: aliceblue;
        }
        </style>
	</head>
	<body>
		<!-- Judul Page Website -->
		<center>
			<h1>UTS Prak. Sistem Keamanan Data Kelas E</h1>
			<h3>V3920057 - Tanzil Rahmatul Karim</h3>
		</center>

		<!-- CAESAR CIPHER -->
		<br>
		<form action="index.php" method="POST">
			<table cellpadding="5" align="center" cellpadding="2" border="7">
				<caption><hr><b>Caesar Cipher</b><hr></caption>

				<!-- Area untuk input kunci pergeseran -->
				<tr>
					<!-- type-nya number, karena caesar cipher menggunakan angka untuk kunci pergeserannya -->
					<!-- diberi alert jika kunci belum dimasukkan -->
					<td align="center">Kunci: <input type="number" name="metode" required="true"
								oninvalid="this.setCustomValidity('Tidak boleh kosong!')" oninput="setCustomValidity('')" /></td>
				</tr>

				<!-- Area teks untuk memasukkan kalimat yang ingin di enkrip/dekrip -->
				<tr>
					<!-- diberi alert jika teks belum dimasukkan -->
					<td align="center"><textarea id="box" name="plain" oninvalid="this.setCustomValidity('Tidak boleh kosong!')" 
								oninput="setCustomValidity('')">Isikan plaintextnya..</textarea></td>
				</tr>

				<!-- Tombol submit untuk enkrip plaintext -->
				<tr>
					<td><input type="submit" name="submit1" class="button" value="Enkrip" /></td>
				</tr>

				<!-- Tombol submit untuk dekrip plaintext -->
				<tr>
					<td><input type="submit" name="submit2" class="button" value="Dekrip" /></td>
				</tr>

				<!-- Hasil Ciphertext/output dari kalimat yang sudah di enkrip/dekrip -->
				<tr>
					<td><center>Ciphertext : <b><?php if (isset($_POST['submit1'])){ echo Encipher($_POST['plain'], $_POST['metode']);} 
                    if (isset($_POST['submit2'])){ echo Decipher($_POST['plain'], $_POST['metode']);}?></b></center></td>
				</tr>

				<!-- Menampilkan informasi plaintext/kalimat yang di enkrip/dekrip yang sebelumnnya di ketik -->
				<tr>
					<td><center>Plaintext : <b><?php if (isset($_POST['submit1'])){ echo Decipher(Encipher($_POST['plain'], $_POST['metode']),$_POST['metode']);} 
                    if (isset($_POST['submit2'])){ echo Encipher(Decipher($_POST['plain'], $_POST['metode']),$_POST['metode']);}?></b></center></td>
				</tr>

				<!-- Menampilkan informasi kunci pergeseran yang digunakan -->
				<tr>
					<td><center>Kunci : <b><?php if (isset($_POST['submit1'])){ echo $_POST['metode'];} 
                    if (isset($_POST['submit2'])){ echo $_POST['metode'];}?></b></center></td>
				</tr>
                <tr></tr>
			</table>
		</form>
    
		<!-- VIGENERE CIPHER -->
		<form action="index.php" method="POST">
			<table cellpadding="5" align="center" cellpadding="2" border="7">
				<caption><hr><b>Vigenere Cipher</b><hr></caption>

				<!-- Area untuk input kunci pergeseran -->
				<tr>
					<!-- Karena vigenere cipher menggunakan huruf untuk kuncinya, jadi type-nya adalah text -->
					<td align="center">Kunci: <input type="text" name="kunci" id="pass" value="<?php echo $kunci; ?>" /></td>
				</tr>

				<!-- Area teks untuk memasukkan kalimat yang ingin di enkrip/dekrip -->
				<tr>
					<td align="center"><textarea id="box" name="kode">Isikan plaintextnya..</textarea></td>
				</tr>

				<!-- Tombol submit enkripsi dan dekripsi -->
				<tr>
					<td><input type="submit" name="enkripsi" class="button" value="Enkrip" onclick="validate(1)" /></td>
				</tr>
				<tr>
					<td><input type="submit" name="dekripsi" class="button" value="Dekrip" onclick="validate(2)" /></td>
				</tr>

				<!-- Diberi alert jika teks atau kunci belum dimasukkan dan jika teks berhasil di enkrip/dekrip -->
				<tr>
					<td><center><div><?php echo $error ?></div></center></td>
				</tr>

				<!-- Menampilkan informasi kunci yang dimasukkan -->
				<tr>
					<td><center><div><?php echo 'Kunci : ', $kunci ?></div></center></td>
				</tr>

				<!-- Menampilkan hasil Ciphertext/output dari teks yang sudah di enkrip/dekrip -->
				<tr>
					<td><center><div><?php echo 'Ciphertext : ', $kode ?></div></center></td>
				</tr>
                <tr></tr>
			</table>
		</form>
		<br><br>

		<script>
			// Untuk CAESAR CIPHER
			$(function () {
				// Menginisialisasi elemen select2
				$('.select2').select2()

			})
		</script>
	</body>
</html>