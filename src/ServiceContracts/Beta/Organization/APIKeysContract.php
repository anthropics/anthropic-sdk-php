<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\APIKeys\APIKey;
use Anthropic\Beta\Organization\APIKeys\APIKeyUpdateParams\Status;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface APIKeysContract
{
    /**
     * @api
     *
     * @param string $apiKeyID ID of the API key
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $apiKeyID,
        RequestOptions|array|null $requestOptions = null
    ): APIKey;

    /**
     * @api
     *
     * @param string $apiKeyID ID of the API key
     * @param string|null $name name of the API key
     * @param Status|value-of<Status>|null $status status of the API key
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $apiKeyID,
        ?string $name = null,
        Status|string|null $status = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIKey;

    /**
     * @api
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param string|null $createdByUserID filter by the ID of the User who created the object
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param \Anthropic\Beta\Organization\APIKeys\APIKeyListParams\Status|value-of<\Anthropic\Beta\Organization\APIKeys\APIKeyListParams\Status>|null $status filter by API key status
     * @param string|null $workspaceID filter by Workspace ID
     * @param RequestOpts|null $requestOptions
     *
     * @return Page<APIKey>
     *
     * @throws APIException
     */
    public function list(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?string $createdByUserID = null,
        ?int $limit = null,
        \Anthropic\Beta\Organization\APIKeys\APIKeyListParams\Status|string|null $status = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): Page;
}
