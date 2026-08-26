<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\Organization\BetaOrganization;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\OrganizationRawContract;

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
     * @return BaseResponse<BetaOrganization>
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/me?beta=true',
            options: $requestOptions,
            convert: BetaOrganization::class,
        );
    }
}
