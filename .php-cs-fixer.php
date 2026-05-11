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
        '@PER-CS' => true,
        '@PER-CS:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,

        '@PHP7x0Migration' => true,
        '@PHP7x0Migration:risky' => true,
        '@PHP7x1Migration' => true,
        '@PHP7x1Migration:risky' => true,
        '@PHP7x3Migration' => true,
        '@PHP7x4Migration' => true,
        '@PHP7x4Migration:risky' => true,
        '@PHP8x0Migration' => true,
        '@PHP8x0Migration:risky' => true,
        '@PHP8x1Migration' => true,
        '@PHP8x1Migration:risky' => true,
        '@PHP8x2Migration' => true,
        '@PHP8x2Migration:risky' => true,
        '@PHP8x3Migration' => true,
        '@PHP8x3Migration:risky' => true,
        '@PHP8x4Migration' => true,
        '@PHP8x4Migration:risky' => true,
        '@PHP8x5Migration' => true,
        '@PHP8x5Migration:risky' => true,

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
    ])
    ->setFinder($finder)
    ->setIndent("  ")
    ->setLineEnding("\n")
;
