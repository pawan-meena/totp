<?php
require_once __DIR__ . '/vendor/autoload.php';

use OTPHP\TOTP;
use Symfony\Component\Clock\Clock;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Writer\PngWriter;
$clock = new Clock();
$otp = TOTP::generate($clock);
$secret = $otp->getSecret();
$otp->setLabel('PAWAN_APP');

$otpSecrets = file_exists('otp-secrets.json') ? json_decode(file_get_contents('otp-secrets.json'), true) : [];
$grCodeUri = $otp->getQrCodeUri(
    'https://api.qrserver.com/v1/create-qr-code/?data='.$secret.'&size=300x300&ecc=M',
    $secret
);
$otpSecrets[] = [
    'user_id' => $_GET['user_id'],
    'secret' => $secret,
    'qr_link' => $grCodeUri ,
    'created_at' => time()
];

file_put_contents('otp-secrets.json', json_encode($otpSecrets, JSON_PRETTY_PRINT));

echo json_encode([
    'otp_secret' => $grCodeUri,
    'message' => 'OTP secret generated and saved successfully.'
]);
