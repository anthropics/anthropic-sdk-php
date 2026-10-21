<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Implementation\StreamingHttpClient;
use Anthropic\Core\Util;
use Anthropic\Lib\Credentials\CredentialResult;
use Anthropic\Lib\Credentials\DefaultCredentials;
use Anthropic\Lib\Credentials\TokenCache;
use Anthropic\Services\BetaService;
use Anthropic\Services\FilesService;
use Anthropic\Services\MessagesService;
use Anthropic\Services\ModelsService;
use Anthropic\Services\OrganizationService;
use Anthropic\Services\SkillsService;
use Anthropic\Services\UserProfilesService;
use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type NormalizedRequest from \Anthropic\Core\BaseClient
 * @phpstan-import-type OpenTelemetryOptions from \Anthropic\Core\BaseClient
 */
class Client extends BaseClient
{
    /** @internal */
    public const ANTHROPIC_API_VERSION = '2026-10-21';

    public string $apiKey;

    public string $authToken;

    public string $webhookKey;

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
    public FilesService $files;

    /**
     * @api
     */
    public SkillsService $skills;

    /**
     * @api
     */
    public UserProfilesService $userProfiles;

    /**
     * @api
     */
    public OrganizationService $organization;

    /**
     * @api
     */
    public BetaService $beta;

    private ?CredentialResult $credentialResult = null;

    private static bool $warnedOfEnvKeyAndToken = false;

    /**
     * Pass at most one of `$apiKey`, `$authToken` and `$credentials`; more than one throws
     * `\InvalidArgumentException`. The one passed is used, and no credential is read from the environment or from
     * a profile on disk.
     *
     * With none passed, the first of these that is set is used: `ANTHROPIC_API_KEY`, `ANTHROPIC_AUTH_TOKEN`, the
     * profile named by `ANTHROPIC_PROFILE`, the workload identity federation variables, the active profile on disk.
     * The constructor throws `AnthropicException` when `ANTHROPIC_PROFILE` names a missing or invalid profile.
     * With both `ANTHROPIC_API_KEY` and `ANTHROPIC_AUTH_TOKEN` set, a warning goes to `error_log()` once per process.
     *
     * @param RequestOpts|null $requestOptions
     * @param OpenTelemetryOptions|null $openTelemetry OpenTelemetry tracing of this client's API calls. Each call emits a span when the application has registered a tracer provider with the OpenTelemetry API. `false`, short for `['traces' => false]`, disables the spans, and `['traces' => false]` is itself short for `['traces' => ['enabled' => false]]`. `traces.contentMode` set to `'content'` adds the content of requests and responses to the spans, within `traces.maxContentBytes` bytes for each span when it is set. `propagation` set to `false` sends the requests without the trace context of their span, for an application whose HTTP client instrumentation already propagates it, so that a request does not carry it twice. The environment variables `ANTHROPIC_OPEN_TELEMETRY`, `ANTHROPIC_OPEN_TELEMETRY_PROPAGATION`, `ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE` and `ANTHROPIC_OPEN_TELEMETRY_TRACES_MAX_CONTENT_BYTES` set `traces.enabled`, `propagation`, `traces.contentMode` and `traces.maxContentBytes` for a client that is given no option, which reads them once, when it is built. A client that is given the option does not read them: what the option leaves unset has its default.
     */
    public function __construct(
        ?string $apiKey = null,
        ?string $authToken = null,
        ?string $webhookKey = null,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
        ?CredentialResult $credentials = null,
        array|false|null $openTelemetry = null,
    ) {
        $passed = array_keys(array_filter(
            ['apiKey' => $apiKey, 'authToken' => $authToken, 'credentials' => $credentials],
            static fn (string|CredentialResult|null $option): bool => !is_null($option),
        ));
        if (count($passed) > 1) {
            throw new \InvalidArgumentException(sprintf(
                'Pass at most one of `apiKey`, `authToken`, or `credentials`. Received `%s`.',
                implode('`, `', $passed),
            ));
        }

        if ([] === $passed) {
            $apiKey = Util::getenv('ANTHROPIC_API_KEY') ?: '';
            $authToken = Util::getenv('ANTHROPIC_AUTH_TOKEN') ?: '';
            if ('' !== $apiKey && '' !== $authToken) {
                $authToken = '';
                if (!self::$warnedOfEnvKeyAndToken) {
                    self::$warnedOfEnvKeyAndToken = true;
                    error_log('Anthropic: ANTHROPIC_API_KEY and ANTHROPIC_AUTH_TOKEN are both set. Using ANTHROPIC_API_KEY.');
                }
            }

            // Subclasses have their own auth, so only the base client looks for a profile or workload identity.
            if ('' === $apiKey && '' === $authToken && self::class === static::class) {
                $credentials = DefaultCredentials::resolve();
            }
        }

        $this->apiKey = $apiKey ?? '';
        $this->authToken = $authToken ?? '';
        $this->webhookKey = $webhookKey ?? Util::getenv('ANTHROPIC_WEBHOOK_SIGNING_KEY') ?? '';

        $this->credentialResult = $credentials;

        $baseUrl ??= Util::getenv('ANTHROPIC_BASE_URL') ?: ($this->credentialResult->baseUrl ?? 'https://api.anthropic.com');

        try {
            $options = RequestOptions::parse(
                RequestOptions::with(
                    uriFactory: Psr17FactoryDiscovery::findUriFactory(),
                    streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
                    requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
                    transporter: Psr18ClientDiscovery::find(),
                ),
                $requestOptions,
            );
        } catch (NotFoundException $e) {
            throw new NotFoundException("No PSR-18 HTTP client or PSR-17 factory found. If you don't have one in your project, run `composer require guzzlehttp/guzzle`.", previous: $e);
        }

        if (is_null($options->streamingTransporter)) {
            assert(!is_null($options->transporter));
            $options->streamingTransporter = new StreamingHttpClient($options->transporter);
        }

        /** @var array<string, string|null> $headers */
        $headers = [
            'anthropic-version' => self::ANTHROPIC_API_VERSION,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => sprintf('anthropic/PHP %s', VERSION),
            'X-Stainless-Lang' => 'php',
            'X-Stainless-Package-Version' => VERSION,
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
            options: $options,
            openTelemetry: $openTelemetry
        );

        $this->messages = new MessagesService($this);
        $this->models = new ModelsService($this);
        $this->files = new FilesService($this);
        $this->skills = new SkillsService($this);
        $this->userProfiles = new UserProfilesService($this);
        $this->organization = new OrganizationService($this);
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
        return $this->apiKey ? ['Authorization' => "Bearer {$this->apiKey}"] : [];
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
        bool $wantsRetryFromException = false,
    ): bool {
        // On 401 with OAuth credentials, invalidate the token cache and retry once.
        if (401 === $rsp?->getStatusCode() && $this->credentialResult?->provider instanceof TokenCache) {
            $this->credentialResult->provider->invalidate();

            return $retryCount < 1;
        }

        return parent::shouldRetry($opts, $retryCount, $rsp, $wantsRetryFromException);
    }

    /**
     * @internal
     *
     * @param string|list<string> $path
     * @param array<string,mixed> $query
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param RequestOpts|null $opts
     *
     * @return array{NormalizedRequest, RequestOptions, string}
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
}
