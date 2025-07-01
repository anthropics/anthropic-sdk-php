<?php

declare(strict_types=1);

namespace Anthropic\Core\Concerns;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Pagination\PageRequestOptions;
use Psr\Http\Message\ResponseInterface;

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
