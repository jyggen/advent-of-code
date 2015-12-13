<?php
namespace Boo\AdventOfCode\Commands;

class DayNineCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input'  => [
                'London to Dublin = 464',
                'London to Belfast = 518',
                'Dublin to Belfast = 141',
            ],
            'output' => 605,
        ],
    ];

    protected $testDataTwo = [
        [
            'input' => [
                'London to Dublin = 464',
                'London to Belfast = 518',
                'Dublin to Belfast = 141',
            ],
            'output' => 982,
        ],
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('All in a Single Night');
    }

    protected function normalizeData(array $input)
    {
        $output = [];

        foreach ($input as $key => $row) {
            $row = trim($row);

            if ($row === '') {
                unset($input[$key]);
                continue;
            }

            if (preg_match('/([\w]+) to ([\w]+) = ([\d]+)/', $row, $match) !== 1) {
                throw new RuntimeException('Unable to parse input');
            }

            $output[] = [
                'to'       => $match[1],
                'from'     => $match[2],
                'distance' => (int) $match[3],
            ];
        }

        return $output;
    }

    protected function getDayNumber()
    {
        return 9;
    }

    protected function perform(array &$input)
    {
        $allRoutes = [];

        foreach ($input as $route) {
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

        return [$shortestRoute, $longestRoute];
    }

    protected function calculateRoute(array $possibleRoutes, array $routes)
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

    protected function getPossibleRoutes(array $routes)
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
