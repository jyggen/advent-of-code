<?php
function get_memory_usage()
{
    $memUsage = memory_get_usage(true);

    if ($memUsage < 1024) {
        return $memUsage.'B';
    } elseif ($memUsage < 1048576) {
        return round($memUsage / 1024, 2).'kB';
    }

    return round($memUsage / 1048576, 2).'MB';
}

function parse_input_file($filename)
{
    $path = __DIR__.'/input/'.$filename;

    if (file_exists($path) === false || is_readable($path) === false) {
        throw new \RuntimeException('Unable to open input file "'.$path.'"');
    }

    $input = explode("\n", file_get_contents($path));
    $input = array_map(function ($gift) {
        return trim($gift);
    }, $input);

    return array_filter($input, function ($gift) {
        return $gift !== '';
    });
}

function permutate($items, $perms = [])
{
    if (empty($items) === true) {
        return [$perms];
    }
    $return = [];

    for ($i = count($items) - 1; $i >= 0; --$i) {
        $newitems  = $items;
        $newperms  = $perms;
        list($foo) = array_splice($newitems, $i, 1);

        array_unshift($newperms, $foo);

        $return = array_merge($return, permutate($newitems, $newperms));
    }

    return $return;
}
