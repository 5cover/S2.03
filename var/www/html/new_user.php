<?php

function link_random_part($length = 13): string {
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($length / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
    } else {
        throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $length);
}

$user = "jackkie";

$link = $user.'-'.link_random_part();

$mypage = fopen("/user/$link.html", "w");


$content = "<!DOCTYPE html>
<html lang=\"en\">

<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <title>$user's page</title>
</head>

<body>
  <h1>Bonjour $user</h1>
</body>

</html>";


fwrite($mypage, $content);
?>
