<?php

declare(strict_types=1);

/*
 * This file is part of the Advent of Code package.
 *
 * (c) Jonas Stendahl <jonas@stendahl.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boo\AdventOfCode\Commands;

use Boo\AdventOfCode\Exceptions\MissingInputException;
use Boo\AdventOfCode\Exceptions\SolverException;
use ByteUnits\Binary;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SolveCommand extends Command
{
    /**
     * @var float
     */
    private $startTime;

    /**
     * Constructor.
     *
     * @param float $startTime
     */
    public function __construct(float $startTime)
    {
        $this->startTime = $startTime;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('solve');
        $this->setDescription('Solves a puzzle');
        $this->addArgument('year', InputArgument::REQUIRED, 'The puzzle\'s year');
        $this->addArgument('day', InputArgument::REQUIRED, 'The puzzle\'s day');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $year = $input->getArgument('year');
        $day = $input->getArgument('day');
        $solverClass = sprintf('Boo\\AdventOfCode\\Solvers\\Year%u\\Day%u', $year, $day);

        if (class_exists($solverClass) === false) {
            throw new SolverException(sprintf('No puzzle solver found in year %u for day %u', $year, $day));
        }

        $input = sprintf('input/%u/%u.input', $year, $day);

        if (is_readable($input) === false) {
            throw new MissingInputException(sprintf('No input file found in year %u for day %u', $year, $day));
        }

        $output->write(sprintf('Solving <info>Day %s</info> in <info>Year %s</info> .. ', $day, $year));

        $solver = new $solverClass($output);
        $result = $solver(trim(file_get_contents($input)));

        $output->writeln('Done!');
        $output->writeln('');

        $timing = (microtime(true) - $this->startTime) * 1000;
        $memory = Binary::bytes(memory_get_peak_usage(true))->format();

        $output->writeln(sprintf('First Answer: <info>%s</info>', $result->getFirstAnswer()));
        $output->writeln(sprintf('Second Answer: <info>%s</info>', $result->getSecondAnswer()));
        $output->writeln('');
        $output->write(vsprintf('Puzzle solved in <info>%gms</info> using <info>%s</info> of memory.', [
            $timing,
            $memory,
        ]));
    }
}
