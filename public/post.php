<?php
date_default_timezone_set('Europe/Moscow');
include 'config.php';
include 'functions.php';
include 'recaptchalib.php';

$data = json_decode(file_get_contents('php://input'), true);
echo json_encode($data);




// // ваш секретный ключ
// $secret = "6Lcs-KsUAAAAAAttTwhDk6MieaCOxG8NhAoklJnZ";
// // пустой ответ
// $response = null;
// // проверка секретного ключа
// $reCaptcha = new ReCaptcha($secret);

// // if submitted check response
// if ($_POST["g-recaptcha-response"]) {
//     $response = $reCaptcha->verifyResponse(
//         $_SERVER["REMOTE_ADDR"],
//         $_POST["g-recaptcha-response"]
//     );
// }

// if ($response != null && $response->success) {
//     // echo "Hi " . $_POST["name"] . " (" . $_POST["email"] . "), thanks for submitting the form!";
// } else {

// }