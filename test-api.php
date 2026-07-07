<?php

$apiKey = 'AIzaSyxxxxxxxxxxxxxxxxxxxxxxxx';

$url = "https://generativelanguage.googleapis.com/v1/models?key={$apiKey}";

$response = file_get_contents($url);

echo $response;