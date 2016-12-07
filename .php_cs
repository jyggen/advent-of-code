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

use PhpCsFixer\Finder;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;

$finder = Finder::create()->exclude('build')->exclude('data')->in(__DIR__);
$header = <<<'EOF'
This file is part of the Advent of Code package.

(c) Jonas Stendahl <jonas@stendahl.me>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

return PhpCsFixer\Config::create()->setUsingCache(true)->setRules([
    '@PHP70Migration' => true,
    '@PHP71Migration' => true,
    '@Symfony' => true,
    'array_syntax' => [
        'syntax' => 'short',
    ],
    'combine_consecutive_unsets' => true,
    'declare_strict_types' => true,
    'dir_constant' => true,
    'ereg_to_preg' => true,
    'header_comment' => [
        'header' => $header,
    ],
    'linebreak_after_opening_tag' => true,
    'mb_str_functions' => true,
    'modernize_types_casting' => true,
    'no_multiline_whitespace_before_semicolons' => true,
    'no_php4_constructor' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'not_operator_with_space' => true,
    'not_operator_with_successor_space' => true,
    'ordered_class_elements' => true,
    'ordered_imports' => true,
    'php_unit_construct' => true,
    'php_unit_dedicate_assert' => true,
    'php_unit_strict' => true,
    'phpdoc_order' => true,
    'protected_to_private' => true,
    'psr4' => true,
    'strict_comparison' => true,
    'strict_param' => true,
])->setFinder($finder);
