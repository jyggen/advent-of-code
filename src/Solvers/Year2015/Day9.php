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

namespace Boo\AdventOfCode\Solvers\Year2015;

use Boo\AdventOfCode\Exceptions\SolverException;
use Boo\AdventOfCode\ResultCollection;
use Boo\AdventOfCode\SolverInterface;

/**
 * Day 9: All in a Single Night
 *
 * @see http://adventofcode.com/2015/day/9
 */
final class Day9 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);
        $routes = [];

        foreach ($input as $key => $row) {
            $row = trim($row);

            if ($row === '') {
                unset($input[$key]);
                continue;
            }

            if (preg_match('/([\w]+) to ([\w]+) = ([\d]+)/', $row, $match) !== 1) {
                throw new SolverException('Unable to parse input');
            }

            $routes[] = [
                'to'       => $match[1],
                'from'     => $match[2],
                'distance' => (int) $match[3],
            ];
        }

        $allRoutes = [];

        foreach ($routes as $route) {
            $allRoutes[$route['to']][$route['from']] = $route['distance'];
            $allRoutes[$route['from']][$route['to']] = $route['distance'];
        }

        $possibleRoutes = $this->getPossibleRoutes($allRoutes);
        $shortestRoute  = null;
        $longestRoute   = null;

        foreach ($possibleRoutes as $route) {
            $distance     = 0;
            $prevLocation = null;
            foreach ($route as $location) {
                if ($prevLocation !== null) {
                    $distance += $allRoutes[$prevLocation][$location];
                }

                $prevLocation = $location;
            }

            if ($shortestRoute === null || $shortestRoute > $distance) {
                $shortestRoute = $distance;
            }

            if ($longestRoute === null || $longestRoute < $distance) {
                $longestRoute = $distance;
            }
        }

        return new ResultCollection($shortestRoute, $longestRoute);
    }

    private function calculateRoute(array $possibleRoutes, array $routes): array
    {
        $shouldGoDeeper = false;

        foreach ($possibleRoutes as $key => $route) {
            end($route);
            $possibleRoute = current($route);

            foreach (array_keys($routes[$possibleRoute]) as $possibility) {
                if (in_array($possibility, $route) === false) {
                    $newRoute = $route;

                    array_push($newRoute, $possibility);

                    $possibleRoutes[] = $newRoute;
                    $shouldGoDeeper   = true;

                    unset($possibleRoutes[$key]);
                }
            }
        }

        if ($shouldGoDeeper === true) {
            $possibleRoutes = $this->calculateRoute(array_values($possibleRoutes), $routes);
        }

        return $possibleRoutes;
    }

    private function getPossibleRoutes(array $routes): array
    {
        $routesFound = [];

        foreach (array_keys($routes) as $route) {
            $possibleRoutes = [];
            foreach (array_keys($routes[$route]) as $possibleRoute) {
                $possibleRoutes[] = [
                    $route,
                    $possibleRoute,
                ];
            }

            $routesFound = array_merge($routesFound, $this->calculateRoute($possibleRoutes, $routes));
        }

        $numOfLocations = count(array_keys($routes));

        foreach ($routesFound as $key => $route) {
            if (count($route) !== $numOfLocations) {
                unset($routesFound[$key]);
            }
        }

        return $routesFound;
    }
}
