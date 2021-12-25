<?php

$header = <<<HEADER
This file is part of the Laravel 5.7 env() shim, a PHP Experts, Inc., project.

Copyright © 2019-2022 PHP Experts, Inc.
Author: Theodore R. Smith <theodore@phpexperts.pro>
  GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
  https://www.phpexperts.pro/
  https://github.com/PHPExpertsInc/Laravel57-env-polyfill

This file is licensed under the MIT License.
HEADER;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony'       => true,
        'elseif'         => false,
        'yoda_style'     => false,
        'list_syntax'    => ['syntax'  => 'short'],
        'concat_space'   => ['spacing' => 'one'],
        'binary_operator_spaces' => [
            'operators' => [
                '='  => 'align',
                '=>' => 'align',
            ],
        ],
        'phpdoc_no_alias_tag'          => false,
        'declare_strict_types'         => true,
        'no_superfluous_elseif'        => true,
        'blank_line_after_opening_tag' => false,
        'header_comment' => [
            'header'       => $header,
            'location'     => 'after_declare_strict',
            'comment_type' => 'PHPDoc',
        ]
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->in(__DIR__)
    );
