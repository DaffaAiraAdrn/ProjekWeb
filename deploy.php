<?php
/**
 * Automated Deployment Script for Hostinger
 * This script unzips the uploaded build.zip and moves files to the current directory.
 */

$zipFile = 'build.zip';
$extractTo = './';

if (!file_exists($zipFile)) {
    die("Error: $zipFile not found. Please wait for the upload to finish.");
}

$zip = new ZipArchive;
if ($zip->open($zipFile) === TRUE) {
    echo "Unzipping files...<br>";
    $zip->extractTo($extractTo);
    $zip->close();
    echo "Success! Files extracted.<br>";
    
    // Cleanup
    unlink($zipFile);
    echo "Cleanup: build.zip removed.<br>";
} else {
    echo "Error: Failed to open $zipFile";
}
?>
