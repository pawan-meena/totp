<?php
require_once __DIR__ . '/vendor/autoload.php';
use OTPHP\TOTP;
use Symfony\Component\Clock\Clock;
$clock = new Clock();
$otp = TOTP::generate($clock);
$secret = $otp->getSecret();
$otp->setLabel('PAWAN_APP');


$otpSecrets = file_exists('otp-secrets.json') ? json_decode(file_get_contents('otp-secrets.json'), true) : [];


$userId = $_GET['user_id'];
$existingIndex = null;

foreach ($otpSecrets as $index => $entry) {
    if ($entry['user_id'] == $userId) {
        $existingIndex = $index;
        break;
    }
}


$grCodeUri = $otp->getQrCodeUri(
    'https://api.qrserver.com/v1/create-qr-code/?data=' . $secret . '&size=300x300&ecc=M',
    $secret
);


if ($existingIndex !== null) {

    $otpSecrets[$existingIndex]['secret'] = $secret;
    $otpSecrets[$existingIndex]['qr_link'] = $grCodeUri;
    $otpSecrets[$existingIndex]['created_at'] = time();
} else {
  
    $otpSecrets[] = [
        'user_id' => $userId,
        'secret' => $secret,
        'qr_link' => $grCodeUri,
        'created_at' => time()
    ];
}


file_put_contents('otp-secrets.json', json_encode($otpSecrets, JSON_PRETTY_PRINT));

echo json_encode([
    'otp_secret' => $grCodeUri,
    'message' => 'OTP secret generated and saved successfully.'
]);
