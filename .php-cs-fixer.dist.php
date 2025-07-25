<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

return (new Config())
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setFinder(Finder::create()->in([__DIR__.'/src', __DIR__.'/tests']))
    ->setRules(['@PhpCsFixer' => true, 'phpdoc_align' => false, 'new_with_parentheses' => ['named_class' => false]])
;
