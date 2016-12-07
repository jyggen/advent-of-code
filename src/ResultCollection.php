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

namespace Boo\AdventOfCode;

use Boo\AdventOfCode\YearInterface;

final class ResultCollection
{
    /**
     * @var string|int
     */
    private $firstAnswer;

    /**
     * @var string|int
     */
    private $secondAnswer;

    /**
     * @var string|int
     */
    private $firstTest;

    /**
     * @var string|int
     */
    private $secondTest;

    /**
     * Constructor.
     *
     * @param string|int $firstAnswer
     * @param string|int $secondAnswer
     * @param string|int $firstTest
     * @param string|int $secondTest
     */
    public function __construct($firstAnswer, $secondAnswer, $firstTest = null, $secondTest = null)
    {
        $this->firstAnswer = $firstAnswer;
        $this->secondAnswer = $secondAnswer;

        if ($firstTest === null) {
            $firstTest = $firstAnswer;
        }

        if ($secondTest === null) {
            $secondTest = $secondAnswer;
        }

        $this->firstTest = $firstTest;
        $this->secondTest = $secondTest;
    }

    /**
     * Gets the first answer.
     *
     * @return string|int
     */
    public function getFirstAnswer()
    {
        return $this->firstAnswer;
    }

    /**
     * Gets the first test answer.
     *
     * @return string|int
     */
    public function getFirstTestAnswer()
    {
        return $this->firstTest;
    }

    /**
     * Gets the second answer.
     *
     * @return string|int
     */
    public function getSecondAnswer()
    {
        return $this->secondAnswer;
    }

    /**
     * Gets the second test answer.
     *
     * @return string|int
     */
    public function getSecondTestAnswer()
    {
        return $this->secondTest;
    }
}
