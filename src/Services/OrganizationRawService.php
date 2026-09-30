<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\OrganizationInfo;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\OrganizationRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class OrganizationRawService implements OrganizationRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieve information about the organization associated with the authenticated API key.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationInfo>
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/me',
            options: $requestOptions,
            convert: OrganizationInfo::class,
        );
    }
}
