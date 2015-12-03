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

        // They have a list of the dimensions (length l, width w, and height h) of each present.
        foreach ($input as $gift) {
            sort($gift);

            $sides = [
                $gift[0] * $gift[1],
                $gift[1] * $gift[2],
                $gift[2] * $gift[0],
            ];

            // Find the surface area of the box.
            $paperSize += $sides[0] * 2 + $sides[1] * 2 + $sides[2] * 2;

            // The elves also need a little extra paper for
            // each present: the area of the smallest side.
            $paperSize += $sides[0];

            // The ribbon required to wrap a present is the shortest distance
            // around its sides, or the smallest perimeter of any one face.
            $ribbonLength += $gift[0] * 2 + $gift[1] * 2;

            // Each present also requires a bow made out of ribbon as well; the feet of ribbon
            // required for the perfect bow is equal to the cubic feet of volume of the present.
            $ribbonLength += $gift[0] * $gift[1] * $gift[2];
        }

        // 0 => How many total square feet of wrapping paper should they order?
        // 1 => How many total feet of ribbon should they order?
        return [$paperSize, $ribbonLength];
    }
}
