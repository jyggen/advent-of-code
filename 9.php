<?php
declare(strict_types=1);

function calculate_route(array $possibleRoutes, array $routes) : array
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
        $possibleRoutes = calculate_route(array_values($possibleRoutes), $routes);
    }

    return $possibleRoutes;
}


function find_shortest_and_longest_route(array $routes) : array
{
    $allRoutes = [];

    foreach ($routes as $route) {
        $allRoutes[$route['to']][$route['from']] = $route['distance'];
        $allRoutes[$route['from']][$route['to']] = $route['distance'];
    }

    $possibleRoutes = get_possible_routes($allRoutes);
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

function get_possible_routes(array $routes) : array
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

        $routesFound = array_merge($routesFound, calculate_route($possibleRoutes, $routes));
    }

    $confirmedRoutes = [];
    $numOfLocations  = count(array_keys($routes));

    foreach ($routesFound as $key => $route) {
        if (count($route) !== $numOfLocations) {
            unset($routesFound[$key]);
        }
    }

    return $routesFound;
}

function normalize_input(array $input) : array
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

$result = find_shortest_and_longest_route(normalize_input([
    'London to Dublin = 464',
    'London to Belfast = 518',
    'Dublin to Belfast = 141',
]));

assert($result[0] === 605, 'Failed asserting that '.$result[0].' matches expected 605');
assert($result[1] === 982, 'Failed asserting that '.$result[1].' matches expected 982');

$result = find_shortest_and_longest_route(normalize_input(explode("\n", file_get_contents('9.input'))));

print 'Shortest: '.$result[0].PHP_EOL;
print 'Longest: '.$result[1].PHP_EOL;
