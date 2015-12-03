<?php
namespace Boo\AdventOfCode\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class DayCommandAbstract extends Command
{
    protected $testDataOne = [];
    protected $testDataTwo = [];

    protected function configure()
    {
        parent::configure();
        $this->setName('day:'.$this->getDayNumber());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        unset($input);

        $output->getFormatter()->setStyle('fail', new OutputFormatterStyle('red'));
        $output->getFormatter()->setStyle('pass', new OutputFormatterStyle('green'));

        if ($this->runTests($output, 1) === false || $this->runTests($output, 2) === false) {
            return 1;
        }

        $normalized = $this->normalizeData($this->loadInputData());
        $result     = $this->perform($normalized);

        $output->writeln('');
        $output->writeln('Answer for <comment>Step #1</comment>: <pass>'.$result[0].'</pass>');
        $output->writeln('Answer for <comment>Step #2</comment>: <pass>'.$result[1].'</pass>');
    }

    protected function runTests(OutputInterface $output, $testNumber)
    {
        $tests = ($testNumber === 1) ? $this->testDataOne : $this->testDataTwo;

        $output->write('Running tests for <comment>Step #'.$testNumber.'</comment>: ');

        foreach ($tests as $input => $expected) {
            $input  = $this->normalizeData([$input]);
            $result = $this->perform($input);

            if ($result[$testNumber - 1] !== $expected) {
                $output->writeln('<fail>✘</fail>');
                $output->writeln(vsprintf('  Failed asserting that %s is identical to %s.', [
                    '<fail>'.$result[$testNumber - 1].'</fail>',
                    '<pass>'.$expected.'</pass>',
                ]));

                return false;
            }
        }

        $output->writeln('<pass>✔</pass>');

        return true;
    }

    protected function loadInputData()
    {
        return parse_input_file($this->getDayNumber().'.input');
    }

    abstract protected function getDayNumber();
    abstract protected function normalizeData(array $input);
    abstract protected function perform(array &$input);
}
