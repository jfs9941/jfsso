<?php
/**
 * Jfs Encrypted Source Loader
 *
 * Custom SPL autoloader that loads .php.enc files via Encoder::loadClass()
 * inside jfs.so — decrypted source never touches PHP userland variables.
 *
 * Dev mode: if the plain .php file exists alongside .php.enc, require it directly.
 * Production should only ship .php.enc files (no .php originals).
 */

if (!extension_loaded('jfs')) {
    throw new \RuntimeException(
        'The jfs PHP extension is required but not loaded. '
        . 'Check that jfs.so is installed and enabled in php.ini.'
    );
}

define('JFS_ENC_BASE', __DIR__ . '/src');
define('JFS_DEV_BASE', __DIR__ . '/src');

$GLOBALS['__jfs_loaded'] = [];
$GLOBALS['__jfs_manifest'] = null;

/**
 * Load and decrypt the manifest (once). Maps relative paths to random filenames.
 */
function jfs_manifest(): array
{
    if ($GLOBALS['__jfs_manifest'] !== null) {
        return $GLOBALS['__jfs_manifest'];
    }

    $manifestFile = JFS_ENC_BASE . '/manifest.bin';
    if (!file_exists($manifestFile)) {
        $GLOBALS['__jfs_manifest'] = [];
        return [];
    }

    // Decrypt + parse manifest entirely inside jfs.so
    $GLOBALS['__jfs_manifest'] = \Jfs\Core\Encoder::loadManifest($manifestFile);
    return $GLOBALS['__jfs_manifest'];
}

spl_autoload_register(function (string $class): void {
    if (strncmp($class, 'Jfs\\', 4) !== 0) {
        return;
    }

    if (class_exists($class, false)
        || interface_exists($class, false)
        || trait_exists($class, false)
        || enum_exists($class, false)
    ) {
        return;
    }

    if (isset($GLOBALS['__jfs_loaded'][$class])) {
        return;
    }

    $relativePath = str_replace('\\', '/', substr($class, 4)) . '.php';

    // Dev mode: plain .php exists, use it directly
    $phpFile = JFS_DEV_BASE . '/' . $relativePath;
    if (file_exists($phpFile)) {
        $GLOBALS['__jfs_loaded'][$class] = true;
        require $phpFile;
        return;
    }

    // Production: look up random filename from encrypted manifest
    $manifest = jfs_manifest();
    if (!isset($manifest[$relativePath])) {
        return;
    }

    $entry = $manifest[$relativePath];
    $encFile = JFS_ENC_BASE . '/' . $entry['file'];

    if (!file_exists($encFile)) {
        return;
    }

    $GLOBALS['__jfs_loaded'][$class] = true;
    \Jfs\Core\Encoder::loadClass($encFile);

}, true, true);


function jfs_require_encrypted(string $relativePath): mixed
{
    // Dev mode: plain .php exists, use it directly
    $phpFile = JFS_DEV_BASE . '/' . $relativePath;
    if (file_exists($phpFile)) {
        return require $phpFile;
    }

    // Production: look up random filename from encrypted manifest
    $manifest = jfs_manifest();
    if (!isset($manifest[$relativePath])) {
        throw new \RuntimeException("Encrypted file not found in manifest: $relativePath");
    }

    $entry = $manifest[$relativePath];
    $encFile = JFS_ENC_BASE . '/' . $entry['file'];

    if (!file_exists($encFile)) {
        throw new \RuntimeException("Encrypted file missing: $encFile");
    }

    return \Jfs\Core\Encoder::loadFile($encFile);
}
