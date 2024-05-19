<?php

header ( "Cache-Control max-age=86400, public");

// Security headers
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
// header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; object-src 'none'");
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: no-referrer-when-downgrade');
header("Permissions-Policy: geolocation=(self), microphone=()");
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expect-CT: max-age=86400, enforce');
?>

