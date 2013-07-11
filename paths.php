<?php
/**
 * XtraUpload Paths Registry
 *
 * Code from Laravel 3.0
 *
 * Thank you to Taylor Otwell, @taylorotwell
 */
$paths['filestore'] = 'filestore';
$paths['thumbstore'] = 'thumbstore';
$paths['cache'] = 'application/cache';
$paths['public'] = 'public';
$paths['temp'] = 'temp';
$paths['logs'] = 'application/logs';

$GLOBALS['xtraupload_paths']['base'] = __DIR__.DIRECTORY_SEPARATOR;

foreach ($paths as $name => $path)
{
    if ( ! isset($GLOBALS['xtraupload_paths'][$name]))
    {
        $GLOBALS['xtraupload_paths'][$name] = realpath(path('base').$path).DIRECTORY_SEPARATOR;
    }
}

/**
 * A global path helper function.
 *
 * <code>
 *     $storage = path('storage');
 * </code>
 *
 * @param  string  $path
 * @return string
 */
function path($path)
{
    return $GLOBALS['xtraupload_paths'][$path];
}

/**
 * A global path setter function.
 *
 * @param  string  $path
 * @param  string  $value
 * @return void
 */
function set_path($path, $value)
{
    $GLOBALS['xtraupload_paths'][$path] = $value;
}