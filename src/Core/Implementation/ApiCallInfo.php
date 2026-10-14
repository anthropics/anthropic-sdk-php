<?php

declare(strict_types=1);

namespace Anthropic\Core\Implementation;

/**
 * What the SDK method that makes an API call knows of it, for the call's span. The method sets it on the call's request options ({@see \Anthropic\RequestOptions::withApiCall()}), which the client reads it from, and which a list keeps for the requests of its later pages.
 *
 * @internal
 */
final class ApiCallInfo
{
    /**
     * @param string|null $name the name of the call span, such as `anthropic.files.list`. A call without one has no span.
     * @param string|null $route the endpoint's path as the API description gives it, such as `/v1/files/{file_id}`, which the call span has as `http.route`
     * @param list<string> $query the query parameters that the endpoint defines, by the names the API gives them: the only ones the call span's `url.query` has
     * @param list<string> $contentQuery the query parameters that are content on this endpoint only
     * @param array<non-empty-string,mixed> $attributes what the call span has from the method's parameters: the attribute of each resource ID in the path, with the ID
     * @param string|array<string,string>|null $createdId the attribute of the ID of the object the SDK method creates, which is the `id` of the parsed response, or `[attribute => field]` when the response has the ID in another field
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $route = null,
        public readonly array $query = [],
        public readonly array $contentQuery = [],
        public readonly array $attributes = [],
        public readonly string|array|null $createdId = null,
    ) {}
}
