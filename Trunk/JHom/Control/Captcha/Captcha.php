<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

 class Captcha
{
	public $Libelle;

	//Constructeur
	function Captcha()
	{
	}

	//Crée le code
	function getCode($length)
  	{
	  $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ'; // Certains caractères ont été enlevés car ils prêtent à confusion
	  $rand_str = '';
	  for ($i=0; $i<$length; $i++) {
	    $rand_str .= $chars{ mt_rand( 0, strlen($chars)-1 ) };
	  }
	  return $rand_str;
	}

	// Retourne un élement aléatoire du tableau
	function random($tab)
	{
  		return $tab[array_rand($tab)];
	}

	function Show()
	{
		$textControl ="<img src='images.php?type=captcha' alt='img' id='captcha'>";
		return $textControl;
	}

	//Genere un image captcha
	function GetCaptcha()
	{
		session_start();
		//Envoi de l'entete
		header("Content-type: image/png");

		//Recuperation de l'image de fond
		$image = imagecreatefrompng('Images/captcha.png');

		//Recuperation des font
		$fonts = glob('JHom/Font/*.ttf');

		//Generation du code
		$theCode = $this->getCode(5);
		$_SESSION['captcha'] = md5($theCode);


		//Generation des couleurs pour les textes
		$colors=array (	imagecolorallocate($image, 131,154,255),
		                imagecolorallocate($image,  89,186,255),
		                imagecolorallocate($image, 155,190,214),
		                imagecolorallocate($image, 255,128,234),
		                imagecolorallocate($image, 255,123,123) );

		//Generation des caractère
		$char1 = substr($theCode,0,1);
		$char2 = substr($theCode,1,1);
		$char3 = substr($theCode,2,1);
		$char4 = substr($theCode,3,1);
		$char5 = substr($theCode,4,1);


		imagettftext($image, 28, -10,   0, 37, $this->random($colors),  $this->random($fonts), $char1);
		imagettftext($image, 28,  20,  37, 37, $this->random($colors),  $this->random($fonts), $char2);
		imagettftext($image, 28, -35,  55, 37, $this->random($colors),  $this->random($fonts), $char3);
		imagettftext($image, 28,  25, 100, 37, $this->random($colors),  $this->random($fonts), $char4);
		imagettftext($image, 28, -15, 120, 37, $this->random($colors),  $this->random($fonts), $char5);


		/* .. et on envoie notre image PNG au navigateur. */
		imagepng($image);

		/*image ayant été envoyée, on libère toute la mémoire qui lui est associée via imagedestroy() */
		imagedestroy($image);

	}
}
?>
