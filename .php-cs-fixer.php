<?php

$finder = (new PhpCsFixer\Finder())
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true)
    ->in([
        'inc',
        'src',
        'dist',
    ])
    ->exclude([
        'vendor',
    ])
    ->append([
        __DIR__ . '/config.php',
        __DIR__ . '/.php-cs-fixer',
    ])
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer' => true,
        '@Symfony' => true,
        '@PER-CS' => true,
        '@PHP71Migration' => true,
        '@PHP73Migration' => true,
        '@PHP74Migration' => true,
        '@PHP80Migration' => true,
        '@PHP81Migration' => true,
        '@PHP82Migration' => true,
        '@PHP83Migration' => true,
        '@PHP84Migration' => true,

        '@PhpCsFixer:risky' => true,
        '@Symfony:risky' => true,
        '@PER-CS:risky' => true,
        '@PHP74Migration:risky' => true,
        '@PHP80Migration:risky' => true,
        '@PHP82Migration:risky' => true,

        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'braces_position' => [
            'functions_opening_brace' => 'same_line',
            'classes_opening_brace' => 'same_line',
        ],
        'simplified_if_return' => true,
        'simplified_null_return' => true,
        'yoda_style' => false,

        // TODO: fix these
        'psr_autoloading' => false,
        'strict_comparison' => false,
    ])
    ->setFinder($finder)
    ->setIndent("  ")
    ->setLineEnding("\n")
;
