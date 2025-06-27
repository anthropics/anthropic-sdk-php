<?php

$finder = (new PhpCsFixer\Finder())
    ->in([__DIR__.'/src', __DIR__.'/tests']);

return (new PhpCsFixer\Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRules([
        '@PhpCsFixer' => true,
        '@PER' => true,
        '@Symfony' => true,
        '@PSR12' => true,
        'array_indentation' => true,
        'align_multiline_comment' => true,
        'multiline_whitespace_before_semicolons' => false,
        'phpdoc_line_span' => true,
    ])
    ->setFinder($finder);
