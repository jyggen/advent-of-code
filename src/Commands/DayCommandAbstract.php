<?php
namespace Boo\AdventOfCode\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class DayCommandAbstract extends Command
{
    protected $input;
    protected $output;

    protected $testDataOne = [];
    protected $testDataTwo = [];

    protected function configure()
    {
        parent::configure();
        $this->setName('day:'.$this->getDayNumber());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;

        $output->getFormatter()->setStyle('fail', new OutputFormatterStyle('red'));
        $output->getFormatter()->setStyle('pass', new OutputFormatterStyle('green'));

        if ($this->runTests(1) === false || $this->runTests(2) === false) {
            return 1;
        }

        $normalized = $this->normalizeData($this->loadInputData());
        $startTime  = microtime(true);
        $result     = $this->perform($normalized);
        $stopTime   = microtime(true);

        $output->writeln('');
        $output->writeln('Answer for <comment>Step #1</comment>: <pass>'.$result[0].'</pass>');
        $output->writeln('Answer for <comment>Step #2</comment>: <pass>'.$result[1].'</pass>');
        $output->writeln('');
        $output->writeln('Total execution time: <pass>'.round($stopTime - $startTime, 2).'s</pass>');
        $output->writeln('Total memory usage: <pass>'.get_memory_usage().'</pass>');
    }

    protected function runTests($testNumber)
    {
        $tests = ($testNumber === 1) ? $this->testDataOne : $this->testDataTwo;

        $this->output->write('Running tests for <comment>Step #'.$testNumber.'</comment>: ');

        foreach ($tests as $input => $expected) {
            $input  = $this->normalizeData([$input]);
            $result = $this->perform($input);

            if ($result[$testNumber - 1] !== $expected) {
                $this->output->writeln('<fail>✘</fail>');
                $this->output->writeln(vsprintf('  Failed asserting that %s is identical to %s on input %s.', [
                    '<fail>'.$result[$testNumber - 1].'</fail>',
                    '<pass>'.$expected.'</pass>',
                    '<comment>'.$input[0].'</comment>',
                ]));

                return false;
            }
        }

        $this->output->writeln('<pass>✔</pass>');

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
