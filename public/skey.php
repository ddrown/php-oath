<?php
require_once "../vendor/autoload.php";

$seed = "testing";
$sharedSecret = 'fetchedFromDatabaseOrSimilar';
if(!array_key_exists("counter", $_POST) || strlen($_POST["counter"]) == 0 || preg_match("/[^0-9]/",$_POST["counter"])) {
  $counter = 500;
} else {
  $counter = $_POST["counter"];
}
if($counter > 10000) { // limit max
  $counter = 10000;
}
if($counter < 1) {
  $counter = 1;
}

$skey = new ddrown\skey();
$loader = new Twig_Loader_Filesystem('../views/');
$twig = new Twig_Environment($loader);
echo $twig->render('skey.html', array("counter" => $counter, "output" => $skey->output($seed, $sharedSecret, $counter), "seed" => $seed, "secret" => $sharedSecret));
