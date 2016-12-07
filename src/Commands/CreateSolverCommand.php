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

use Boo\AdventOfCode\Exceptions\SolverException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Twig_Environment;

final class CreateSolverCommand extends Command
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * Constructor.
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('solver:create');
        $this->setDescription('Creates a new puzzle solver');
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
        $solverTest = sprintf('Boo\\AdventOfCode\\Tests\\Solvers\\Year%u\\Day%u', $year, $day);

        if (class_exists($solverClass) === true) {
            throw new SolverException(vsprintf('A puzzle solver already exists for day %u in year %u', [
                $day,
                $year,
            ]));
        }

        if (class_exists($solverTest) === true) {
            throw new SolverException(vsprintf('A puzzle solver test case already exists for day %u in year %u', [
                $day,
                $year,
            ]));
        }

        $classPath = sprintf('src/Solvers/Year%u/Day%u.php', $year, $day);
        $testPath = sprintf('test/Solvers/Year%u/Day%uTest.php', $year, $day);
        $helper = $this->getHelper('question');
        $question = new Question('<question>Please enter the title of the puzzle:</question> ');

        file_put_contents($classPath, $this->twig->render('DayX.php.twig', [
            'year' => $year,
            'day' => $day,
            'title' => trim($helper->ask($input, $output, $question)),
        ]));

        file_put_contents($testPath, $this->twig->render('DayXTest.php.twig', [
            'year' => $year,
            'day' => $day,
        ]));

        $output->writeln('');
        $output->writeln(sprintf('Solver Class: <info>%s</info>', $classPath));
        $output->writeln(sprintf('Solver Test: <info>%s</info>', $testPath));
    }
}
