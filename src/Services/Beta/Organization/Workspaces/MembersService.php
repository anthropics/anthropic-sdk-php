<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\Workspaces\Members\MemberRemoveResponse;
use Anthropic\Beta\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\Beta\Organization\Workspaces\WorkspaceMember;
use Anthropic\Beta\Organization\Workspaces\WorkspaceRole;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Workspaces\MembersContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MembersService implements MembersContract
{
    /**
     * @api
     */
    public MembersRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MembersRawService($client);
    }

    /**
     * @api
     *
     * Get Workspace Member
     *
     * @param string $userID ID of the User
     * @param string $workspaceID ID of the Workspace
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $userID,
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceMember {
        $params = Util::removeNulls(['workspaceID' => $workspaceID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($userID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update Workspace Member
     *
     * @param string $userID path param: ID of the User
     * @param string $workspaceID path param: ID of the Workspace
     * @param WorkspaceRole|value-of<WorkspaceRole> $workspaceRole body param: New workspace role for the User
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $userID,
        string $workspaceID,
        WorkspaceRole|string $workspaceRole,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceMember {
        $params = Util::removeNulls(
            ['workspaceID' => $workspaceID, 'workspaceRole' => $workspaceRole]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($userID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List Workspace Members
     *
     * @param string $workspaceID ID of the Workspace
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param RequestOpts|null $requestOptions
     *
     * @return Page<WorkspaceMember>
     *
     * @throws APIException
     */
    public function list(
        string $workspaceID,
        ?string $afterID = null,
        ?string $beforeID = null,
        ?int $limit = null,
        RequestOptions|array|null $requestOptions = null,
    ): Page {
        $params = Util::removeNulls(
            ['afterID' => $afterID, 'beforeID' => $beforeID, 'limit' => $limit]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($workspaceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Create Workspace Member
     *
     * @param string $workspaceID ID of the Workspace
     * @param string $userID ID of the User
     * @param NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole> $workspaceRole Role of the new Workspace Member. Cannot be `workspace_billing`.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $workspaceID,
        string $userID,
        NoBillingWorkspaceRole|string $workspaceRole,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceMember {
        $params = Util::removeNulls(
            ['userID' => $userID, 'workspaceRole' => $workspaceRole]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->add($workspaceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete Workspace Member
     *
     * @param string $userID ID of the User
     * @param string $workspaceID ID of the Workspace
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $userID,
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null,
    ): MemberRemoveResponse {
        $params = Util::removeNulls(['workspaceID' => $workspaceID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->remove($userID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
