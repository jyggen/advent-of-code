<?php
namespace Boo\AdventOfCode\Commands;

class DayTwentyCommand extends DayCommandAbstract
{
    protected $testDataOne = [
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Infinite Elves and Infinite Houses');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 20;
    }

    protected function perform(array &$input)
    {
        return [$this->performOne($input), $this->performTwo($input)];
    }

    protected function performOne(array &$input)
    {
        $magicNumber   = $input[0];
        $houseToCheck  = 100000;
        $increment     = 100000;
        $decrease      = 1000;
        $lowest        = PHP_INT_MAX;
        $checkedHouses = [];

        while (true) {
            if (isset($checkedHouses[$houseToCheck]) === false) {
                $presents = 0;

                for ($i = $houseToCheck; $i > 0; $i--) {
                    if ($houseToCheck % $i === 0) {
                        $presents += $i * 10;
                    }
                }

                $checkedHouses[$houseToCheck]= true;

                if ($presents >= $magicNumber) {
                    $lowest = min($lowest, $houseToCheck);
                }

                if ($lowest === PHP_INT_MAX) {
                    $houseToCheck += $increment;
                    continue;
                }
            }

            $houseToCheck -= $increment;

            if ($houseToCheck < ($magicNumber / 100) * 2) {
                $increment -= $decrease;

                if ($increment === 0) {
                    $increment = $decrease;
                    $decrease  = $decrease / 10;

                    if ($decrease === 10) {
                        $increment = 20;
                    }

                    if ($decrease === 1) {
                        break;
                    }

                    $increment -= $decrease;
                }

                cli_set_process_title('Increment: '.$increment.' | Expected: 786240 | Lowest: '.$lowest);

                $houseToCheck = $lowest;
            }
        }

        return $lowest;
    }

    protected function performTwo(array &$input)
    {
        $magicNumber   = $input[0];
        $houseToCheck  = 100000;
        $increment     = 100000;
        $decrease      = 1000;
        $lowest        = PHP_INT_MAX;
        $checkedHouses = [];

        while (true) {
            if (isset($checkedHouses[$houseToCheck]) === false) {
                $presents = 0;

                for ($i = $houseToCheck; $i > 0; $i--) {
                    if ($i * 50 >= $houseToCheck && $houseToCheck % $i === 0) {
                        $presents += $i * 11;
                    }
                }

                $checkedHouses[$houseToCheck]= true;

                if ($presents >= $magicNumber) {
                    $lowest = min($lowest, $houseToCheck);
                }

                if ($lowest === PHP_INT_MAX) {
                    $houseToCheck += $increment;
                    continue;
                }
            }

            $houseToCheck -= $increment;

            if ($houseToCheck < ($magicNumber / 100) * 2) {
                $increment -= $decrease;

                if ($increment === 0) {
                    $increment = $decrease;
                    $decrease  = $decrease / 10;

                    if ($decrease === 10) {
                        $increment = 20;
                    }

                    if ($decrease === 1) {
                        break;
                    }

                    cli_set_process_title('Increment: '.$increment.' | Expected: 786240 | Lowest: '.$lowest);

                    $increment -= $decrease;
                }

                $houseToCheck = $lowest;
            }
        }

        return $lowest;
    }

}
