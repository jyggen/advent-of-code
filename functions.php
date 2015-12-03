<?php
function parse_input_file($filename)
{
    $path = __DIR__.'/input/'.$filename;

    if (file_exists($path) === false || is_readable($path) === false) {
        throw new \RuntimeException('Unable to open input file "'.$path.'"');
    }

    return array_filter(explode("\n", file_get_contents($path)), function ($gift) {
        return (trim($gift) !== '');
    });
}
