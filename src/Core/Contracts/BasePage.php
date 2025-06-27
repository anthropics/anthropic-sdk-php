<?php

declare(strict_types=1);

namespace Anthropic\Core\Contracts;

interface BasePage extends \Stringable
{
    /**
     * @return \Traversable<mixed>
     */
    public function pagingEachItem(): \Traversable;
}
