<?php

function randomURL($URLlength = 8) {
    $charray = array_merge(range('a','z'), range('0','9'));
    $max = count($charray) - 1;
    $url = "";
    for ($i = 0; $i < $URLlength; $i++) {
        $randomChar = mt_rand(0, $max);
        $url .= $charray[$randomChar];
    }
    return $url;
}

$link = randomURL(10);

$mypage = fopen("$link.html", "w");

$user = "jackkie";

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