<?php

// membuat function untuk mengenkripsi teks yang di input
function enkripsi($kunci, $text)
{
	// ubah kunci ke huruf kecil
	$kunci = strtolower($kunci);
	
	// variabel
	$kode = "";
	$ki = 0;
	$kl = strlen($kunci);
	$length = strlen($text);
	
	// pengulangan setiap baris di teks
	for ($i = 0; $i < $length; $i++)
	{
		// jika teks yang dimasukkan adalah alphabet/huruf, maka akan dienkripsi
		if (ctype_alpha($text[$i]))
		{
			// uppercase atau huruf kapital
			if (ctype_upper($text[$i]))
			{
				$text[$i] = chr(((ord($kunci[$ki]) - ord("a") + ord($text[$i]) - ord("A")) % 26) + ord("A"));
			}
			
			// lowercase atau huruf kecil
			else
			{
				$text[$i] = chr(((ord($kunci[$ki]) - ord("a") + ord($text[$i]) - ord("a")) % 26) + ord("a"));
			}
			
			// perbarui index kunci
			$ki++;
			if ($ki >= $kl)
			{
				$ki = 0;
			}
		}
	}
	
	// mengembalikan kode yang dienkripsi
	return $text;
}

// membuat function untuk mengdeskripsi teks yang di input
function dekripsi($kunci, $text)
{
	// ubah kunci ke huruf kecil
	$kunci = strtolower($kunci);
	
	// variabel
	$kode = "";
	$ki = 0;
	$kl = strlen($kunci);
	$length = strlen($text);
	
	// pengulangan setiap baris di teks
	for ($i = 0; $i < $length; $i++)
	{
		// jika teks yang dimasukkan adalah alphabet/huruf, maka akan dideskripsi
		if (ctype_alpha($text[$i]))
		{
			// uppercase
			if (ctype_upper($text[$i]))
			{
				$x = (ord($text[$i]) - ord("A")) - (ord($kunci[$ki]) - ord("a"));
				
				if ($x < 0)
				{
					$x += 26;
				}
				
				$x = $x + ord("A");
				
				$text[$i] = chr($x);
			}
			
			// lowercase
			else
			{
				$x = (ord($text[$i]) - ord("a")) - (ord($kunci[$ki]) - ord("a"));
				
				if ($x < 0)
				{
					$x += 26;
				}
				
				$x = $x + ord("a");
				
				$text[$i] = chr($x);
			}
			
			// perbarui index kunci
			$ki++;
			if ($ki >= $kl)
			{
				$ki = 0;
			}
		}
	}
	
	/// mengembalikan text yang dideskripsi
	return $text;
}

?>