<?php

declare(strict_types=1);

namespace Anthropic\Core\Pagination;

use Anthropic\RequestOptions;

/**
 * @internal
 */
class PageRequestOptions extends RequestOptions
{
    public function getQueryAsInt(string $key): ?int
    {
        return null;
    }

    public function getQueryAsString(string $key): ?string
    {
        return null;
    }

    public function getQueryAsBool(string $key): ?bool
    {
        return null;
    }

    public function getHeaderAsString(string $key): ?string
    {
        return null;
    }

    public function getHeaderAsInt(string $key): ?int
    {
        return null;
    }

    public function getHeaderAsBool(string $key): ?bool
    {
        return null;
    }

    public function getBodyAsString(string $key): ?string
    {
        return null;
    }

    public function getBodyAsInt(string $key): ?int
    {
        return null;
    }

    public function getBodyAsBool(string $key): ?bool
    {
        return null;
    }

    public function withBody(string $key, mixed $value): self
    {
        return $this;
    }

    public function withQuery(string $key, mixed $value): self
    {
        return $this;
    }

    public function withHeader(string $key, mixed $value): self
    {
        return $this;
    }
}
