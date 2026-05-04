<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Util;
use Anthropic\Lib\Credentials\CredentialResult;
use Anthropic\Lib\Credentials\DefaultCredentials;
use Anthropic\Lib\Credentials\TokenCache;
use Anthropic\Services\BetaService;
use Anthropic\Services\MessagesService;
use Anthropic\Services\ModelsService;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @phpstan-import-type NormalizedRequest from \Anthropic\Core\BaseClient
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
class Client extends BaseClient
{
    public string $apiKey;

    public string $authToken;

    /**
     * @api
     */
    public MessagesService $messages;

    /**
     * @api
     */
    public ModelsService $models;

    /**
     * @api
     */
    public BetaService $beta;

    private ?CredentialResult $credentialResult = null;

    private ?TokenCache $tokenCache = null;

    /**
     * @param RequestOpts|null $requestOptions
     */
    public function __construct(
        ?string $apiKey = null,
        ?string $authToken = null,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
        ?CredentialResult $credentials = null,
    ) {
        $this->apiKey = (string) ($apiKey ?? getenv('ANTHROPIC_API_KEY'));
        $this->authToken = (string) ($authToken ?? getenv('ANTHROPIC_AUTH_TOKEN'));

        $baseUrl ??= Util::getenv(
            'ANTHROPIC_BASE_URL'
        ) ?: 'https://api.anthropic.com';

        $options = RequestOptions::parse(
            RequestOptions::with(
                uriFactory: Psr17FactoryDiscovery::findUriFactory(),
                streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
                requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
                transporter: Psr18ClientDiscovery::find(),
            ),
            $requestOptions,
        );

        /** @var array<string, string|null> $headers */
        $headers = [
            'anthropic-version' => '2023-06-01',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => sprintf('anthropic/PHP %s', VERSION),
            'X-Stainless-Lang' => 'php',
            'X-Stainless-Package-Version' => '0.17.1',
            'X-Stainless-Arch' => Util::machtype(),
            'X-Stainless-OS' => Util::ostype(),
            'X-Stainless-Runtime' => php_sapi_name(),
            'X-Stainless-Runtime-Version' => phpversion(),
        ];

        $customHeadersEnv = Util::getenv('ANTHROPIC_CUSTOM_HEADERS');
        if (null !== $customHeadersEnv) {
            foreach (explode("\n", $customHeadersEnv) as $line) {
                $colon = strpos($line, ':');
                if (false !== $colon) {
                    $headers[trim(substr($line, 0, $colon))] = trim(substr($line, $colon + 1));
                }
            }
        }

        parent::__construct(
            headers: $headers,
            baseUrl: $baseUrl,
            options: $options
        );

        // If explicit credentials were provided, use them.
        // Otherwise, if no apiKey/authToken are configured and this is
        // the base Client class (not a subclass), auto-detect credentials.
        if (!is_null($credentials)) {
            $this->setCredentials($credentials);
        } elseif ('' === $this->apiKey && '' === $this->authToken && self::class === static::class) {
            $resolved = DefaultCredentials::resolve();
            if (!is_null($resolved)) {
                $this->setCredentials($resolved);
            }
        }

        $this->messages = new MessagesService($this);
        $this->models = new ModelsService($this);
        $this->beta = new BetaService($this);
    }

    public function close(): void
    {
        $this->credentialResult?->close();
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        // When OAuth credentials are active, auth is handled by transformRequest()
        // (which runs on every retry) rather than here (which runs once).
        if (!is_null($this->credentialResult)) {
            return $this->credentialResult->extraHeaders;
        }

        return [...$this->apiKeyAuth(), ...$this->bearerAuth()];
    }

    /** @return array<string,string> */
    protected function apiKeyAuth(): array
    {
        return $this->apiKey ? ['X-Api-Key' => $this->apiKey] : [];
    }

    /** @return array<string,string> */
    protected function bearerAuth(): array
    {
        return $this->authToken ? [
            'Authorization' => "Bearer {$this->authToken}",
        ] : [];
    }

    /**
     * Injects OAuth Bearer token and beta header on every request (including retries).
     *
     * This method is idempotent: it uses withHeader() to replace (not append)
     * so that retries after 401 token refresh get the fresh token.
     */
    protected function transformRequest(RequestInterface $request): RequestInterface
    {
        if (!is_null($this->credentialResult)) {
            $token = $this->credentialResult->provider->fetchToken();
            $request = $request->withHeader('Authorization', "Bearer {$token->token}");

            $existing = $request->getHeaderLine('anthropic-beta');
            if ('' !== $existing) {
                // Avoid duplicating the oauth beta on retry.
                if (!str_contains($existing, 'oauth-2025-04-20')) {
                    $request = $request->withHeader('anthropic-beta', $existing.',oauth-2025-04-20');
                }
            } else {
                $request = $request->withHeader('anthropic-beta', 'oauth-2025-04-20');
            }
        }

        return $request;
    }

    protected function shouldRetry(
        RequestOptions $opts,
        int $retryCount,
        ?ResponseInterface $rsp,
    ): bool {
        // On 401 with OAuth credentials, invalidate the token cache and retry once.
        if (401 === $rsp?->getStatusCode() && !is_null($this->tokenCache)) {
            $this->tokenCache->invalidate();

            return $retryCount < 1;
        }

        return parent::shouldRetry($opts, $retryCount, $rsp);
    }

    /**
     * @internal
     *
     * @param string|list<string> $path
     * @param array<string,mixed> $query
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param RequestOpts|null $opts
     *
     * @return array{NormalizedRequest, RequestOptions}
     */
    protected function buildRequest(
        string $method,
        string|array $path,
        array $query,
        array $headers,
        mixed $body,
        RequestOptions|array|null $opts,
    ): array {
        return parent::buildRequest(
            method: $method,
            path: $path,
            query: $query,
            headers: [...$this->authHeaders(), ...$headers],
            body: $body,
            opts: $opts,
        );
    }

    private function setCredentials(CredentialResult $credentials): void
    {
        $this->credentialResult = $credentials;

        // Keep a reference to the TokenCache for invalidation on 401.
        $provider = $credentials->provider;
        if ($provider instanceof TokenCache) {
            $this->tokenCache = $provider;
        }
    }
}
