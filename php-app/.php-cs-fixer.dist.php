<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__,
        __DIR__ . '/../2021/php',
        __DIR__ . '/../2022/php',
        __DIR__ . '/../2023/php',
        __DIR__ . '/../2024/php',
        __DIR__ . '/../2025/php',
    ])
    ->exclude('vendor')
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PSR12' => true,
    '@PSR12:risky' => true,
    '@PER-CS' => true,
    '@PER-CS:risky' => true,
    'strict_param' => true,
    'declare_strict_types' => true,
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'no_unused_imports' => true,
    'trailing_comma_in_multiline' => [
        'elements' => ['array_destructuring', 'arrays', 'match'],
    ],
    'phpdoc_scalar' => true,
    'unary_operator_spaces' => true,
    'binary_operator_spaces' => true,
    'blank_line_before_statement' => [
        'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
    ],
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_var_without_name' => true,
    'class_attributes_separation' => true,
    'method_argument_space' => [
        'on_multiline' => 'ensure_fully_multiline',
        'keep_multiple_spaces_after_comma' => true,
    ],
    'single_trait_insert_per_statement' => true,
])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
