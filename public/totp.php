<?php
require_once "../vendor/autoload.php";

class TotpOutput extends Markenwerk\OathServerSuite\Validation\Oath\Base\OathBaseValidator
{
	/**
	 * The valid period of time in that the one time password has to be validated in seconds
	 *
	 * @var int
	 */
	private $validPeriod;

	/**
	 * TotpOutput constructor.
	 *
	 * @param int $passwordLength
	 * @param int $validPeriod
	 */
	public function __construct($passwordLength = 6, $validPeriod = 30)
	{
		$this->validPeriod = $validPeriod;
		$this->passwordLength = $passwordLength;
	}

	/**
	 * @return int
	 */
	public function getValidPeriod()
	{
		return $this->validPeriod;
	}

	/**
	 * @param string $sharedSecret
	 * @return string
	 */
	private function calculateValidTotp($sharedSecret)
	{
		$counter = $this->getTimeCounter();
		return $this->calculateValidHotp($sharedSecret, $counter);
	}

	/**
	 * @return int
	 */
	public function getTimeRemaining()
	{
		return $this->validPeriod - (time() % $this->validPeriod);
	}

	/**
	 * @return int
	 */
	private function getTimeCounter()
	{
		return floor(time() / $this->validPeriod);
	}

	/**
	 * Returns the current TOTP
	 *
	 * @param string $sharedSecret
	 * @return string
	 */
	public function output($sharedSecret)
	{
		$sharedSecret = bin2hex($sharedSecret);
		return $this->calculateValidTotp($sharedSecret);
	}
}

$sharedSecret = 'fetchedFromDatabaseOrSimilar';

$code = new TotpOutput();
$secret_url = new Markenwerk\OathServerSuite\SecretSharing\SharedSecretUrlEncoder\TotpBase32SharedSecretUrlEncoder();
$loader = new Twig_Loader_Filesystem('../views/');
$twig = new Twig_Environment($loader);
echo $twig->render('totp.html', array("output" => $code->output($sharedSecret), "timeremaining" => $code->getTimeRemaining(), "url" => $secret_url->encode("totp", $sharedSecret)));
