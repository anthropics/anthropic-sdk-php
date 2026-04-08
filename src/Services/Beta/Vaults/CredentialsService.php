<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Vaults;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredential;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsDeletedCredential;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthCreateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthUpdateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerCreateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Vaults\CredentialsContract;

/**
 * @phpstan-import-type AuthShape from \Anthropic\Beta\Vaults\Credentials\CredentialCreateParams\Auth
 * @phpstan-import-type AuthShape from \Anthropic\Beta\Vaults\Credentials\CredentialUpdateParams\Auth as AuthShape1
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class CredentialsService implements CredentialsContract
{
    /**
     * @api
     */
    public CredentialsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CredentialsRawService($client);
    }

    /**
     * @api
     *
     * Create Credential
     *
     * @param string $vaultID Path param: Path parameter vault_id
     * @param AuthShape $auth body param: Authentication details for creating a credential
     * @param string|null $displayName Body param: Human-readable name for the credential. Up to 255 characters.
     * @param array<string,string> $metadata Body param: Arbitrary key-value metadata to attach to the credential. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $vaultID,
        ManagedAgentsMCPOAuthCreateParams|array|ManagedAgentsStaticBearerCreateParams $auth,
        ?string $displayName = null,
        ?array $metadata = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsCredential {
        $params = Util::removeNulls(
            [
                'auth' => $auth,
                'displayName' => $displayName,
                'metadata' => $metadata,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($vaultID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get Credential
     *
     * @param string $credentialID Path param: Path parameter credential_id
     * @param string $vaultID Path param: Path parameter vault_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $credentialID,
        string $vaultID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsCredential {
        $params = Util::removeNulls(['vaultID' => $vaultID, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($credentialID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update Credential
     *
     * @param string $credentialID Path param: Path parameter credential_id
     * @param string $vaultID Path param: Path parameter vault_id
     * @param AuthShape1 $auth body param: Updated authentication details for a credential
     * @param string|null $displayName Body param: Updated human-readable name for the credential. 1-255 characters.
     * @param array<string,string|null>|null $metadata Body param: Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omitted keys are preserved.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $credentialID,
        string $vaultID,
        ManagedAgentsMCPOAuthUpdateParams|array|ManagedAgentsStaticBearerUpdateParams|null $auth = null,
        ?string $displayName = null,
        ?array $metadata = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsCredential {
        $params = Util::removeNulls(
            [
                'vaultID' => $vaultID,
                'auth' => $auth,
                'displayName' => $displayName,
                'metadata' => $metadata,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($credentialID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List Credentials
     *
     * @param string $vaultID Path param: Path parameter vault_id
     * @param bool $includeArchived query param: Whether to include archived credentials in the results
     * @param int $limit Query param: Maximum number of credentials to return per page. Defaults to 20, maximum 100.
     * @param string $page query param: Opaque pagination token from a previous `list_credentials` response
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ManagedAgentsCredential>
     *
     * @throws APIException
     */
    public function list(
        string $vaultID,
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'includeArchived' => $includeArchived,
                'limit' => $limit,
                'page' => $page,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($vaultID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete Credential
     *
     * @param string $credentialID Path param: Path parameter credential_id
     * @param string $vaultID Path param: Path parameter vault_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $credentialID,
        string $vaultID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsDeletedCredential {
        $params = Util::removeNulls(['vaultID' => $vaultID, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($credentialID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Archive Credential
     *
     * @param string $credentialID Path param: Path parameter credential_id
     * @param string $vaultID Path param: Path parameter vault_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $credentialID,
        string $vaultID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsCredential {
        $params = Util::removeNulls(['vaultID' => $vaultID, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($credentialID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
