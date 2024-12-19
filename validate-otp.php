<?php
require_once __DIR__ . '/vendor/autoload.php';

use OTPHP\TOTP;
use Symfony\Component\Clock\Clock;


if (isset($_GET['user_id']) && isset($_GET['otp'])) {
    $userId = (int) $_GET['user_id'];
    $userOtp = $_GET['otp'];


    $otpSecretsFile = 'otp-secrets.json';
    $otpSecrets = file_exists($otpSecretsFile) ? json_decode(file_get_contents($otpSecretsFile), true) : [];


    $secret = null;
    foreach ($otpSecrets as $entry) {
        if ($entry['user_id'] === $userId) {
            $secret = $entry['secret'];
            break;
        }
    }

    if ($secret) {
  
        $clock = new Clock();
        $otp = TOTP::createFromSecret($secret, $clock);

  
        if ($otp->verify($userOtp)) {
            echo json_encode(['message' => 'OTP is valid']);
        } else {
            echo json_encode(['message' => 'Invalid OTP']);
        }
    } else {
        echo json_encode(['message' => 'Secret not found for the given user ID']);
    }
} else {
    echo json_encode(['error' => 'User ID or OTP is missing']);
}
?>
