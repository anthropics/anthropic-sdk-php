<?php

declare(strict_types=1);

namespace Tests\Lib\Credentials;

use Anthropic\Lib\Credentials\IdentityTokenLiteral;
use Anthropic\Lib\Credentials\OAuthException;
use Anthropic\Lib\Credentials\WorkloadIdentityCredentials;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class WorkloadIdentityCredentialsTest extends TestCase
{
    private MockClient $httpClient;

    protected function setUp(): void
    {
        $this->httpClient = new MockClient;
    }

    public function testSuccessfulTokenExchange(): void
    {
        $this->setMockResponse(200, [
            'access_token' => 'sk-ant-oat01-test-token',
            'token_type' => 'Bearer',
            'expires_in' => 600,
        ]);

        $provider = $this->makeProvider();
        $token = $provider->fetchToken();

        $this->assertSame('sk-ant-oat01-test-token', $token->token);
        $this->assertNotNull($token->expiresAt);
        $this->assertGreaterThan(time(), $token->expiresAt);
    }

    public function testTokenExchangeSendsCorrectPayload(): void
    {
        $this->setMockResponse(200, [
            'access_token' => 'tok',
            'token_type' => 'Bearer',
            'expires_in' => 300,
        ]);

        $provider = $this->makeProvider(
            federationRuleId: 'fdrl_01abc',
            organizationId: 'org-uuid-123',
            serviceAccountId: 'svac_01def',
        );
        $provider->fetchToken();

        $request = $this->getLastRequest();

        /** @var array<string,mixed> $body */
        $body = json_decode((string) $request->getBody(), true);

        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('/v1/oauth/token', $request->getUri()->getPath());
        $this->assertSame('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertSame('urn:ietf:params:oauth:grant-type:jwt-bearer', $body['grant_type']);
        $this->assertSame('test-jwt-assertion', $body['assertion']);
        $this->assertSame('fdrl_01abc', $body['federation_rule_id']);
        $this->assertSame('org-uuid-123', $body['organization_id']);
        $this->assertSame('svac_01def', $body['service_account_id']);
        $this->assertArrayNotHasKey('workspace_id', $body);
    }

    public function testTokenExchangeBetaHeaders(): void
    {
        $this->setMockResponse(200, [
            'access_token' => 'tok',
            'token_type' => 'Bearer',
            'expires_in' => 300,
        ]);

        $this->makeProvider()->fetchToken();
        $request = $this->getLastRequest();

        $betaHeader = $request->getHeaderLine('anthropic-beta');
        $this->assertStringContainsString('oauth-2025-04-20', $betaHeader);
        $this->assertStringContainsString('oidc-federation-2026-04-01', $betaHeader);
    }

    public function testHttpsEnforced(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('HTTPS');

        new WorkloadIdentityCredentials(
            identityProvider: new IdentityTokenLiteral('jwt'),
            federationRuleId: 'fdrl_01x',
            organizationId: 'org-1',
            tokenEndpointBaseUrl: 'http://api.anthropic.com',
            httpClient: $this->httpClient,
        );
    }

    public function testLocalhostAllowedWithHttp(): void
    {
        $this->setMockResponse(200, [
            'access_token' => 'tok',
            'token_type' => 'Bearer',
            'expires_in' => 300,
        ]);

        $provider = new WorkloadIdentityCredentials(
            identityProvider: new IdentityTokenLiteral('jwt'),
            federationRuleId: 'fdrl_01x',
            organizationId: 'org-1',
            tokenEndpointBaseUrl: 'http://localhost:8080',
            httpClient: $this->httpClient,
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
        );

        $token = $provider->fetchToken();
        $this->assertSame('tok', $token->token);
    }

    public function testErrorResponseThrowsOAuthException(): void
    {
        $this->setMockResponse(401, [
            'error' => 'invalid_grant',
            'error_description' => 'The assertion is expired',
        ]);

        $provider = $this->makeProvider();

        $this->expectException(OAuthException::class);

        $provider->fetchToken();
    }

    public function testErrorBodyIsRedacted(): void
    {
        $this->setMockResponse(400, [
            'error' => 'invalid_request',
            'error_description' => 'Bad assertion',
            'secret_field' => 'this-should-not-appear',
        ]);

        $provider = $this->makeProvider();

        try {
            $provider->fetchToken();
            $this->fail('Expected OAuthException');
        } catch (OAuthException $e) {
            $this->assertStringContainsString('invalid_request', $e->getMessage());
            $this->assertStringContainsString('Bad assertion', $e->getMessage());
            $this->assertStringNotContainsString('this-should-not-appear', $e->getMessage());
        }
    }

    public function test401WithoutWorkspaceIdIncludesHint(): void
    {
        // No workspaceId — the hint should include the federation-rule guidance,
        // the workspace-id remedy, and the auth-events pointer.
        $this->setMockResponse(401, ['error' => 'unauthorized']);

        $provider = $this->makeProvider(workspaceId: null);

        try {
            $provider->fetchToken();
            $this->fail('Expected OAuthException');
        } catch (OAuthException $e) {
            $this->assertStringContainsString('Ensure your federation rule matches your identity token', $e->getMessage());
            $this->assertStringContainsString('ANTHROPIC_WORKSPACE_ID', $e->getMessage());
            $this->assertStringContainsString('View your authentication events', $e->getMessage());
        }
    }

    public function test401WithWorkspaceIdSetOmitsWorkspaceHint(): void
    {
        // workspaceId already set — the workspace-id remedy is noise, but the
        // federation-rule and auth-events guidance still applies.
        $this->setMockResponse(401, ['error' => 'unauthorized']);

        $provider = $this->makeProvider(workspaceId: 'wrkspc_x');

        try {
            $provider->fetchToken();
            $this->fail('Expected OAuthException');
        } catch (OAuthException $e) {
            $this->assertStringContainsString('Ensure your federation rule', $e->getMessage());
            $this->assertStringContainsString('View your authentication events', $e->getMessage());
            $this->assertStringNotContainsString('ANTHROPIC_WORKSPACE_ID', $e->getMessage());
        }
    }

    public function testNon401WithoutWorkspaceIdOmitsHint(): void
    {
        // The hint is 401-specific; a 5xx or 400 shouldn't suggest a config change.
        $this->setMockResponse(500, ['error' => 'server_error']);

        $provider = $this->makeProvider(workspaceId: null);

        try {
            $provider->fetchToken();
            $this->fail('Expected OAuthException');
        } catch (OAuthException $e) {
            $this->assertStringNotContainsString('Ensure your federation rule', $e->getMessage());
            $this->assertStringNotContainsString('ANTHROPIC_WORKSPACE_ID', $e->getMessage());
            $this->assertStringNotContainsString('View your authentication events', $e->getMessage());
        }
    }

    public function testMissingAccessTokenThrows(): void
    {
        $this->setMockResponse(200, ['token_type' => 'Bearer', 'expires_in' => 300]);

        $provider = $this->makeProvider();

        $this->expectException(OAuthException::class);
        $this->expectExceptionMessage('missing access_token');

        $provider->fetchToken();
    }

    public function testTokenWithoutExpiresIn(): void
    {
        $this->setMockResponse(200, [
            'access_token' => 'tok_no_expiry',
            'token_type' => 'Bearer',
        ]);

        $provider = $this->makeProvider();
        $token = $provider->fetchToken();

        $this->assertSame('tok_no_expiry', $token->token);
        $this->assertNull($token->expiresAt);
    }

    public function testExpiresInAsStringIsParsed(): void
    {
        $this->setMockResponse(200, [
            'access_token' => 'tok',
            'token_type' => 'Bearer',
            'expires_in' => '3600',
        ]);

        $provider = $this->makeProvider();
        $token = $provider->fetchToken();

        $this->assertSame('tok', $token->token);
        $this->assertNotNull($token->expiresAt);
        $this->assertGreaterThan(time(), $token->expiresAt);
    }

    public function testExpiresInAsZeroStringGivesNullExpiry(): void
    {
        $this->setMockResponse(200, [
            'access_token' => 'tok',
            'token_type' => 'Bearer',
            'expires_in' => '0',
        ]);

        $provider = $this->makeProvider();
        $token = $provider->fetchToken();

        $this->assertNull($token->expiresAt);
    }

    public function testExpiresInAsNonNumericStringGivesNullExpiry(): void
    {
        $this->setMockResponse(200, [
            'access_token' => 'tok',
            'token_type' => 'Bearer',
            'expires_in' => 'never',
        ]);

        $provider = $this->makeProvider();
        $token = $provider->fetchToken();

        $this->assertNull($token->expiresAt);
    }

    public function testServiceAccountIdOmittedWhenNull(): void
    {
        $this->setMockResponse(200, [
            'access_token' => 'tok',
            'token_type' => 'Bearer',
            'expires_in' => 300,
        ]);

        $this->makeProvider(serviceAccountId: null)->fetchToken();
        $request = $this->getLastRequest();

        /** @var array<string,mixed> $body */
        $body = json_decode((string) $request->getBody(), true);

        $this->assertArrayNotHasKey('service_account_id', $body);
        $this->assertArrayNotHasKey('workspace_id', $body);
    }

    public function testWorkspaceIdIncluded(): void
    {
        $this->setMockResponse(200, [
            'access_token' => 'tok',
            'token_type' => 'Bearer',
            'expires_in' => 300,
        ]);

        $this->makeProvider(workspaceId: 'wrkspc_01abc')->fetchToken();
        $request = $this->getLastRequest();

        /** @var array<string,mixed> $body */
        $body = json_decode((string) $request->getBody(), true);

        $this->assertSame('wrkspc_01abc', $body['workspace_id']);
    }

    public function testWorkspaceIdDefaultSentinel(): void
    {
        $this->setMockResponse(200, [
            'access_token' => 'tok',
            'token_type' => 'Bearer',
            'expires_in' => 300,
        ]);

        $this->makeProvider(workspaceId: 'default')->fetchToken();
        $request = $this->getLastRequest();

        /** @var array<string,mixed> $body */
        $body = json_decode((string) $request->getBody(), true);

        $this->assertSame('default', $body['workspace_id']);
    }

    private function makeProvider(
        string $federationRuleId = 'fdrl_01test',
        string $organizationId = 'org-test-uuid',
        ?string $serviceAccountId = null,
        ?string $workspaceId = null,
    ): WorkloadIdentityCredentials {
        return new WorkloadIdentityCredentials(
            identityProvider: new IdentityTokenLiteral('test-jwt-assertion'),
            federationRuleId: $federationRuleId,
            organizationId: $organizationId,
            serviceAccountId: $serviceAccountId,
            workspaceId: $workspaceId,
            tokenEndpointBaseUrl: 'https://api.anthropic.com',
            httpClient: $this->httpClient,
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
        );
    }

    /**
     * @param array<string,mixed> $body
     */
    private function setMockResponse(int $status, array $body): void
    {
        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($body) ?: '{}'))
        ;

        $this->httpClient->setDefaultResponse($response);
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->httpClient->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
