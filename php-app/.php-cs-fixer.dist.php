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

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@PSR12:risky' => true,
        'array_push' => true,
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'one',
                'method' => 'one',
                'property' => 'one',
                'trait_import' => 'none',
                'case' => 'none'
            ],
        ],
        'concat_space' => ['spacing' => 'one'],
        'declare_strict_types' => true,
        'lowercase_keywords' => true,
        'lowercase_static_reference' => true,
        'function_declaration' => [
            'closure_fn_spacing' => 'none'
        ],
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true
        ],
        'modernize_types_casting' => true,
        'new_with_parentheses' => false,
        'no_superfluous_elseif' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_multiple_statements_per_line' => true,
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'case',
                'constant',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
                'magic',
                'phpunit'
            ],
            'sort_algorithm' => 'none'
        ],
        'ordered_interfaces' => true,
        'ordered_imports' => [
            'imports_order' => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha'
        ],
        'ordered_traits' => true,
        'self_accessor' => true,
        'self_static_accessor' => true,
        'strict_comparison' => true,
        'visibility_required' => true,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect());
