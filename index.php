
<?php
require_once __DIR__ . '/vendor/autoload.php'; 
use OTPHP\TOTP;
use Symfony\Component\Clock\Clock;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['action']) && isset($_GET['user_id']) ) {
        $action = $_GET['action'];
        if ($action == 'genotp') {
            include('generate-otp.php');
        } elseif ($action == 'valotp' && isset($_GET['user_id']) && isset($_GET['otp'])) {
            include('validate-otp.php');
        } else {
            echo json_encode(['error' => 'Invalid action or missing parameters']);
        }
    } else {
        echo json_encode(['error' => 'No action specified']);
    }
}
