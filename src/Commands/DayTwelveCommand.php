<?php
namespace Boo\AdventOfCode\Commands;

class DayTwelveCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input'  => ['[1,2,3]'],
            'output' => 6,
        ],
        [
            'input'  => ['{"a":2,"b":4}'],
            'output' => 6,
        ],
        [
            'input'  => ['[[[3]]]'],
            'output' => 3,
        ],
        [
            'input'  => ['{"a":{"b":4},"c":-1}'],
            'output' => 3,
        ],
        [
            'input'  => ['{"a":[-1,1]}'],
            'output' => 0,
        ],
        [
            'input'  => ['[-1,{"a":1}]'],
            'output' => 0,
        ],
        [
            'input'  => ['[]'],
            'output' => 0,
        ],
        [
            'input'  => ['{}'],
            'output' => 0,
        ],
    ];

    protected $testDataTwo = [
        [
            'input'  => ['[1,2,3]'],
            'output' => 6,
        ],
        [
            'input'  => ['[1,{"c":"red","b":2},3]'],
            'output' => 4,
        ],
        [
            'input'  => ['{"d":"red","e":[1,2,3,4],"f":5}'],
            'output' => 0,
        ],
        [
            'input'  => ['[1,"red",5]'],
            'output' => 6,
        ],

    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('JSAbacusFramework.io');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 12;
    }

    protected function perform(array &$input)
    {
        return [$this->sumArray(json_decode($input[0], true)), $this->sumArray(json_decode($input[0], true), 'red')];
    }

    protected function sumArray(array $input, $ignore = null)
    {
        $input  = $this->flatten($input, $ignore);
        $number = 0;

        foreach ($input as $value) {
            $number += $value;
        }

        return $number;
    }

    protected function flatten(array $input, $ignore = null)
    {
        $values = [];

        foreach ($input as $key => $value) {
            if (is_array($value) === true) {
                $values = array_merge($values, $this->flatten($value, $ignore));
                continue;
            }

            if (gettype($key) !== 'integer' && $value === $ignore) {
                return [];
            }

            $values[] = $value;
        }

        return $values;
    }
}
