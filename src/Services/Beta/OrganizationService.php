<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\Organization\BetaOrganization;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\OrganizationContract;
use Anthropic\Services\Beta\Organization\APIKeysService;
use Anthropic\Services\Beta\Organization\ExternalKeysService;
use Anthropic\Services\Beta\Organization\FederationService;
use Anthropic\Services\Beta\Organization\InvitesService;
use Anthropic\Services\Beta\Organization\RateLimitsService;
use Anthropic\Services\Beta\Organization\ServiceAccountsService;
use Anthropic\Services\Beta\Organization\UsersService;
use Anthropic\Services\Beta\Organization\WorkspacesService;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class OrganizationService implements OrganizationContract
{
    /**
     * @api
     */
    public OrganizationRawService $raw;

    /**
     * @api
     */
    public APIKeysService $apiKeys;

    /**
     * @api
     */
    public ExternalKeysService $externalKeys;

    /**
     * @api
     */
    public FederationService $federation;

    /**
     * @api
     */
    public InvitesService $invites;

    /**
     * @api
     */
    public ServiceAccountsService $serviceAccounts;

    /**
     * @api
     */
    public UsersService $users;

    /**
     * @api
     */
    public WorkspacesService $workspaces;

    /**
     * @api
     */
    public RateLimitsService $rateLimits;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new OrganizationRawService($client);
        $this->apiKeys = new APIKeysService($client);
        $this->externalKeys = new ExternalKeysService($client);
        $this->federation = new FederationService($client);
        $this->invites = new InvitesService($client);
        $this->serviceAccounts = new ServiceAccountsService($client);
        $this->users = new UsersService($client);
        $this->workspaces = new WorkspacesService($client);
        $this->rateLimits = new RateLimitsService($client);
    }

    /**
     * @api
     *
     * Retrieve information about the organization associated with the authenticated API key.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BetaOrganization {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(requestOptions: $requestOptions);

        return $response->parse();
    }
}
