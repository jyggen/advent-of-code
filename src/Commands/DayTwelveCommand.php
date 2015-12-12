<?php
namespace Boo\AdventOfCode\Commands;

class DayTwelveCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        '[1,2,3]'              => 6,
        '{"a":2,"b":4}'        => 6,
        '[[[3]]]'              => 3,
        '{"a":{"b":4},"c":-1}' => 3,
        '{"a":[-1,1]}'         => 0,
        '[-1,{"a":1}]'         => 0,
        '[]'                   => 0,
        '{}'                   => 0,
    ];

    protected $testDataTwo = [
        '[1,2,3]'                         => 6,
        '[1,{"c":"red","b":2},3]'         => 4,
        '{"d":"red","e":[1,2,3,4],"f":5}' => 0,
        '[1,"red",5]'                     => 6,

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
