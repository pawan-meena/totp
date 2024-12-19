
<?php
require_once __DIR__ . '/vendor/autoload.php';

use OTPHP\TOTP;
use Symfony\Component\Clock\Clock;

$clock = new Clock();
$secret=$_GET['secret'];
$otp = TOTP::createFromSecret($secret, $clock);
$otp = TOTP::createFromSecret($secret, $clock);
echo json_encode(['current_otp' => $otp->now() ]);

?>