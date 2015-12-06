<?php
namespace Boo\AdventOfCode\Commands;

class DaySixCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        'turn on 0,0 through 999,999'     => 1000000,
        'toggle 0,0 through 999,0'        => 1000,
        'turn on 499,499 through 500,500' => 4,
    ];

    protected $testDataTwo = [
        'turn on 0,0 through 0,0'    => 1,
        'toggle 0,0 through 999,999' => 2000000,
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Probably a Fire Hazard');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 6;
    }

    protected function perform(array &$input)
    {


        return [$this->handleLights($input), $this->handleLightsBetter($input)];
    }

    protected function handleLights(array &$input) {
        $lightArray = array_pad([], 1000, array_pad([], 1000, false));

        foreach ($input as $instruction) {
            if (preg_match('/([\d]{1,3}),([\d]{1,3}) through ([\d]{1,3}),([\d]{1,3})$/', $instruction, $lights) !== 1) {
                $this->output->writeln('<error>Unable to find instructions</error>');
            }

            $valueToSet = null;

            if (preg_match('/^turn off/', $instruction) === 1) {
                $valueToSet = false;
            } elseif (preg_match('/^turn on/', $instruction) === 1) {
                $valueToSet = true;
            }

            for ($i = $lights[1]; $i <= $lights[3]; $i++) {
                for ($j = $lights[2]; $j <= $lights[4]; $j++) {
                    $lightArray[$i][$j] = ($valueToSet === null) ? !$lightArray[$i][$j] :$valueToSet;
                }
            }
        }

        $numberOfLights = 0;

        foreach ($lightArray as $lights) {
            foreach ($lights as $value) {
                if ($value === true) {
                    $numberOfLights++;
                }
            }
        }

        return $numberOfLights;
    }

    protected function handleLightsBetter(array &$input) {
        $lightArray = array_pad([], 1000, array_pad([], 1000, 0));

        foreach ($input as $instruction) {
            if (preg_match('/([\d]{1,3}),([\d]{1,3}) through ([\d]{1,3}),([\d]{1,3})$/', $instruction, $lights) !== 1) {
                $this->output->writeln('<error>Unable to find instructions</error>');
            }

            $valueToSet = null;

            if (preg_match('/^turn off/', $instruction) === 1) {
                $valueToSet = -1;
            } elseif (preg_match('/^turn on/', $instruction) === 1) {
                $valueToSet = 1;
            } elseif (preg_match('/^toggle/', $instruction) === 1) {
                $valueToSet = 2;
            }

            for ($i = $lights[1]; $i <= $lights[3]; $i++) {
                for ($j = $lights[2]; $j <= $lights[4]; $j++) {
                    $lightArray[$i][$j] = max(0, $lightArray[$i][$j] + $valueToSet);
                }
            }
        }

        $brightness = 0;

        foreach ($lightArray as $lights) {
            foreach ($lights as $value) {
                $brightness += $value;
            }
        }

        return $brightness;
    }
}
