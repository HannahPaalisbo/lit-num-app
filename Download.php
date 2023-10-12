<?php
$fileName = 'TTLN_app.apk';
$filePath = 'https://www.tagakauloedu.com/Mobile/$fileName'; // Replace with the actual path to your APK file
 // Replace with the desired name for the downloaded file

// Set the appropriate headers for APK file download
header('Content-Type: application/vnd.android.package-archive');
header("Content-Disposition: attachment; filename=\"$fileName\"");
header('Content-Length: ' . filesize($filePath));

// Output the APK file
readfile($filePath);
?>
