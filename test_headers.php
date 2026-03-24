<?php
$url = "http://127.0.0.1:8000/login";
$headers = get_headers($url, 1);
print_r($headers);
