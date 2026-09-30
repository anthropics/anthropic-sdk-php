<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\OrganizationInfo;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\OrganizationContract;
use Anthropic\Services\Organization\APIKeysService;
use Anthropic\Services\Organization\ComplianceSettingsService;
use Anthropic\Services\Organization\ExternalKeysService;
use Anthropic\Services\Organization\FederationService;
use Anthropic\Services\Organization\InvitesService;
use Anthropic\Services\Organization\RateLimitsService;
use Anthropic\Services\Organization\ServiceAccountsService;
use Anthropic\Services\Organization\UsersService;
use Anthropic\Services\Organization\WorkspacesService;

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
     * @api
     */
    public ComplianceSettingsService $complianceSettings;

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
        $this->complianceSettings = new ComplianceSettingsService($client);
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
    ): OrganizationInfo {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(requestOptions: $requestOptions);

        return $response->parse();
    }
}
