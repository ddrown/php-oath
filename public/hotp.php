<?php
require_once "../vendor/autoload.php";

class HotpOutput extends Markenwerk\OathServerSuite\Validation\Oath\Base\OathBaseValidator
{

	/**
	 * HotpOutput constructor.
	 *
	 * @param int $passwordLength
	 */
	public function __construct($passwordLength = 6)
	{
		$this->passwordLength = $passwordLength;
	}

	/**
	 * Returns the HOTP
	 *
	 * @param string $sharedSecret
	 * @param int $counter
	 * @return string
	 */
	public function output($sharedSecret, $counter)
	{
		$sharedSecret = bin2hex($sharedSecret);
		return $this->calculateValidHotp($sharedSecret, $counter);
	}
}

$sharedSecret = 'fetchedFromDatabaseOrSimilar';
if(!array_key_exists("counter", $_POST) || strlen($_POST["counter"]) == 0 || preg_match("/[^0-9]/",$_POST["counter"])) {
  $counter = 1;
} else {
  $counter = $_POST["counter"];
}

$code = new HotpOutput();
$secret_url = new Markenwerk\OathServerSuite\SecretSharing\SharedSecretUrlEncoder\HotpBase32SharedSecretUrlEncoder();
$loader = new Twig_Loader_Filesystem('../views/');
$twig = new Twig_Environment($loader);
echo $twig->render('hotp.html', array("output" => $code->output($sharedSecret, $counter), "counter" => $counter, "url" => $secret_url->encode("hotp", $sharedSecret)));
