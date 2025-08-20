<?php

declare(strict_types=1);

namespace Anthropic\Core\Contracts;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Pagination\PageRequestOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
interface BasePage
{
    public function __construct(
        BaseClient $client,
        PageRequestOptions $options,
        ResponseInterface $response,
        mixed $body,
    );
}
