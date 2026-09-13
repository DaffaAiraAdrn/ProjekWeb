<?php
/**
 * DF_137 — Laravel release extractor.
 *
 * Unpacks the release.zip that the GitHub Actions deploy uploads, into the
 * application root (the parent of this public/ directory).
 *
 * Two things differ from the earlier version of this script:
 *
 * 1. It no longer deletes itself. Every deploy needs it, and re-uploading it
 *    by hand each time defeats the point of deploying on push.
 * 2. Because it now stays online permanently, it is guarded by DEPLOY_TOKEN
 *    in .env. Without a token set there and supplied as ?token=... it refuses
 *    to run — this endpoint would otherwise let anyone unpack an archive into
 *    a directory shared with other people's websites.
 */

header('Content-Type: text/html; charset=utf-8');

$appRoot = dirname(__DIR__);

/** Read one key out of .env without booting Laravel (vendor/ may be mid-update). */
function envValue(string $envPath, string $key): string
{
    if (!is_readable($envPath)) {
        return '';
    }

    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$name, $value] = explode('=', $line, 2);
        if (trim($name) === $key) {
            return trim(trim($value), "\"'");
        }
    }

    return '';
}

$expected = envValue($appRoot . '/.env', 'DEPLOY_TOKEN');
$supplied = (string) ($_GET['token'] ?? '');

if ($expected === '' || !hash_equals($expected, $supplied)) {
    http_response_code(403);
    exit(
        '<h3>Forbidden</h3>'
        . '<p>Set <code>DEPLOY_TOKEN</code> to a long random string in the .env file '
        . 'at the application root, then call this script as '
        . '<code>extract.php?token=YOUR_TOKEN</code>.</p>'
    );
}

// The deploy uploads release.zip to the application root; the copy inside
// public/ is only a fallback. Either way it unpacks to the application root —
// extracting a Laravel tree into public/ would be wrong.
$zipFile = null;
foreach ([$appRoot . '/release.zip', __DIR__ . '/release.zip'] as $candidate) {
    if (file_exists($candidate)) {
        $zipFile = $candidate;
        break;
    }
}

if ($zipFile === null) {
    http_response_code(404);
    exit('<h3>Nothing to extract</h3><p>release.zip was not found. Check that the deploy workflow finished and that FTP_APP_DIR points at this directory.</p>');
}

echo '<h3>Extracting ' . htmlspecialchars(basename($zipFile)) . '…</h3>';

$zip = new ZipArchive();
$opened = $zip->open($zipFile);

if ($opened !== true) {
    http_response_code(500);
    exit('<p><b>Failed to open the archive.</b> ZipArchive error code: ' . (int) $opened . '</p>');
}

if (!$zip->extractTo($appRoot)) {
    $zip->close();
    http_response_code(500);
    exit('<p><b>Extraction failed.</b> Check write permissions on ' . htmlspecialchars($appRoot) . '.</p>');
}

$fileCount = $zip->numFiles;
$zip->close();

unlink($zipFile);

// Compiled Blade templates are keyed by absolute source path, so the ones
// built on the CI runner never match this server and are simply dead weight.
// Dropping them forces a clean recompile from the templates just extracted.
$compiled = glob($appRoot . '/storage/framework/views/*.php') ?: [];
foreach ($compiled as $view) {
    @unlink($view);
}

echo '<p><b>Done.</b> ' . $fileCount . ' entries extracted, release.zip removed, '
   . count($compiled) . ' stale compiled views cleared.</p>';
echo '<p>This script stays in place for the next deploy.</p>';
