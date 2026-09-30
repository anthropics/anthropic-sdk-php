<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\OrganizationInfo;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface OrganizationContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): OrganizationInfo;
}
