<?php

declare(strict_types=1);

namespace Anthropic\Core\Contracts;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @template R
 */
interface BaseResponse extends ResponseInterface
{
    public function getRequest(): RequestInterface;

    /**
     * @return R
     */
    public function parse(): mixed;
}
