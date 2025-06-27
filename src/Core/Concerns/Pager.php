<?php

declare(strict_types=1);

namespace Anthropic\Core\Concerns;

use Psr\Http\Message\ResponseInterface;
use Anthropic\Core\BaseClient;
use Anthropic\Core\Pagination\PageRequestOptions;

/**
 * @internal
 */
interface Pager
{
    public function __construct(
        BaseClient $client,
        PageRequestOptions $options,
        ResponseInterface $response,
        mixed $body,
    );
}
