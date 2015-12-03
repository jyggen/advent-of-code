<?php
namespace Boo\AdventOfCode\Commands;

class DayTwoCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        '2x3x4'  => 58,
        '1x1x10' => 43,
    ];

    protected $testDataTwo = [
        '2x3x4'  => 34,
        '1x1x10' => 14,
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('I Was Told There Would Be No Math');
    }

    protected function normalizeData(array $input)
    {
        return array_map(function ($gift) {
            list($length, $width, $height) = explode('x', $gift);

            return [
                (int) $length,
                (int) $width,
                (int) $height,
            ];
        }, $input);
    }

    protected function getDayNumber()
    {
        return 2;
    }

    protected function perform(array &$input)
    {
        $paperSize    = 0;
        $ribbonLength = 0;

        foreach ($input as $gift) {
            sort($gift);

            $sides = [
                $gift[0] * $gift[1],
                $gift[1] * $gift[2],
                $gift[2] * $gift[0],
            ];

            $area   = $sides[0] * 2 + $sides[1] * 2 + $sides[2] * 2;
            $ribbon = $gift[0] * 2 + $gift[1] * 2;
            $bow    = $gift[0] * $gift[1] * $gift[2];

            $paperSize    += $area + $sides[0];
            $ribbonLength += $ribbon + $bow;
        }

        return [$paperSize, $ribbonLength];
    }
}
