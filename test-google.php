<?php

$ch = curl_init("https://www.google.com");

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
]);

$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo "ERROR:\n";
    echo curl_error($ch);
} else {
    echo "SUCCESS";
}

curl_close($ch);