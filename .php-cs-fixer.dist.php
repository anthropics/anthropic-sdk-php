<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

ini_set('memory_limit', -1);

return (new Config)
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setFinder(Finder::create()->in([__DIR__.'/src', __DIR__.'/tests']))
    ->setRules([
        '@PhpCsFixer' => true,
        'phpdoc_align' => false,
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_summary' => false,
        // The other groups would rewrite a class that is named Resource or Integer.
        'phpdoc_types' => ['groups' => ['simple']],
        'new_with_parentheses' => ['named_class' => false],
        'ordered_types' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
        'phpdoc_types_order' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
    ])
;
