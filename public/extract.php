<?php
/**
 * DF_137 — Laravel Zip Auto Extractor
 * Automatically extracts the release.zip bundle and cleans itself up.
 */

$zipFile = __DIR__ . '/../release.zip';
$extractPath = __DIR__ . '/../';

// If release.zip is at the public root or parent
if (!file_exists($zipFile)) {
    $zipFile = __DIR__ . '/release.zip';
    $extractPath = __DIR__;
}

if (!file_exists($zipFile)) {
    die("Error: release.zip not found on the server.");
}

$zip = new ZipArchive;
if ($zip->open($zipFile) === TRUE) {
    // Extract to the parent directory of public (which is the app root)
    $zip->extractTo($extractPath);
    $zip->close();
    
    // Clean up files after successful extraction
    unlink($zipFile);
    unlink(__FILE__);
    
    echo "<h1>Extraction Success!</h1><p>The release.zip has been successfully extracted and cleaned up.</p>";
} else {
    echo "<h1>Extraction Failed!</h1><p>Could not open release.zip.</p>";
}
?>
