<?php
namespace Boo\AdventOfCode\Commands;

class DaySevenCommand extends DayCommandAbstract
{
    protected $testDataOne = [
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Some Assembly Required');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 7;
    }

    protected function perform(array &$input)
    {
        $wires  = $this->performInstructions($input);
        $wires2 = $this->performInstructions($input, ['b' => $wires['a']]);


        return [$wires['a'], $wires2['a']];
    }

    protected function performInstructions(array $instructions, $override = [])
    {
        $wires = $override;

        while (empty($instructions) === false) {
            foreach ($instructions as $key => $operation) {
                if (preg_match('/^(\d{1,5}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    $this->setWire($wires, $match[2], (int) $match[1], $override);
                    $this->output->writeln('Set wire <pass>'.$match[2].'</pass> to <pass>'.$match[1].'</pass>');
                } elseif (preg_match('/^([a-z]{1,2}) AND ([a-z]{1,2}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[1]]) === false || isset($wires[$match[2]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[3], $wires[$match[1]] & $wires[$match[2]], $override);
                    $this->output->writeln('Set wire <pass>'.$match[3].'</pass> to <pass>'.$match[1].' AND '.$match[2].'</pass>');
                } elseif (preg_match('/^([a-z]{1,2}) OR ([a-z]{1,2}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[1]]) === false || isset($wires[$match[2]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[3], $wires[$match[1]] | $wires[$match[2]], $override);
                    $this->output->writeln('Set wire <pass>'.$match[3].'</pass> to <pass>'.$match[1].' OR '.$match[2].'</pass>');
                } elseif (preg_match('/^([a-z]{1,2}) LSHIFT (\d{1,5}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[1]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[3], $wires[$match[1]] << $match[2], $override);
                    $this->output->writeln('Set wire <pass>'.$match[3].'</pass> to <pass>'.$match[1].' LSHIFT '.$match[2].'</pass>');
                } elseif (preg_match('/^([a-z]{1,2}) RSHIFT (\d{1,5}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[1]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[3], $wires[$match[1]] >> $match[2], $override);
                    $this->output->writeln('Set wire <pass>'.$match[3].'</pass> to <pass>'.$match[1].' RSHIFT '.$match[2].'</pass>');
                } elseif (preg_match('/^NOT ([a-z]{1,2}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[1]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[2], 65536 + ~$wires[$match[1]], $override);
                    $this->output->writeln('Set wire <pass>'.$match[2].'</pass> to <pass>NOT '.$match[1].'</pass>');
                } elseif (preg_match('/^(\d{1,5}) AND ([a-z]{1,2}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[2]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[3], $match[1] & $wires[$match[2]], $override);
                    $this->output->writeln('Set wire <pass>'.$match[3].'</pass> to <pass>'.$match[1].' AND '.$match[2].'</pass>');
                } elseif (preg_match('/^([a-z]{1,2}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[1]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[2], $wires[$match[1]], $override);
                    $this->output->writeln('Set wire <pass>'.$match[2].'</pass> to <pass>'.$match[1].'</pass>');
                } else {
                    $this->output->writeln('No clue how to handle <fail>'.$operation.'</fail>');
                    die;
                }

                unset($instructions[$key]);
            }
        }

        return $wires;
    }

    protected function setWire(array &$wires, $wire, $value, $override)
    {
        $wires[$wire] = (isset($override[$wire]) === true) ? $override[$wire] : $value;
    }
}
