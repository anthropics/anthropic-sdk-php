<?php

declare(strict_types=1);

namespace Anthropic\Bedrock;

use Anthropic\Bedrock\Services\MessagesService;
use Anthropic\Core\BaseClient;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Aws\Configuration\ConfigurationResolver;
use Aws\Credentials\CredentialProvider;
use Aws\Credentials\Credentials;
use Aws\Credentials\CredentialsInterface;
use Aws\Sdk;
use Aws\Signature\SignatureInterface;
use Aws\Signature\SignatureProvider;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * Note: This client is not thread-safe; avoid sharing instances across parallel requests.
 *
 * @phpstan-import-type NormalizedRequest from \Anthropic\Core\BaseClient
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class Client extends BaseClient
{
    /**
     * @var non-empty-string
     */
    private const DEFAULT_REGION = 'us-east-1';

    public MessagesService $messages;

    public string $apiKey;

    private ?CredentialsInterface $credentials = null;

    private ?SignatureInterface $signer = null;

    /**
     * @param non-empty-string $region
     * @param RequestOpts|null $requestOptions
     */
    private function __construct(
        private ?\Closure $signatureProvider,
        private ?\Closure $credentialProvider,
        private string $region,
        ?string $apiKey = null,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $this->apiKey = $apiKey ?? '';

        $hasApiKey = '' !== $this->apiKey;
        $hasSignatureProvider = null !== $signatureProvider;
        $hasCredentialProvider = null !== $credentialProvider;

        if ($hasApiKey === ($hasSignatureProvider || $hasCredentialProvider)) {
            throw new \InvalidArgumentException(
                'Bedrock client auth must use either an API key or AWS credential/signature providers, but not both.'
            );
        }

        if ($hasSignatureProvider !== $hasCredentialProvider) {
            throw new \InvalidArgumentException(
                'Bedrock client AWS auth requires both credential and signature providers.'
            );
        }

        $options = RequestOptions::parse(
            RequestOptions::with(
                uriFactory: Psr17FactoryDiscovery::findUriFactory(),
                streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
                requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
                transporter: Psr18ClientDiscovery::find(),
            ),
            $requestOptions,
        );

        parent::__construct(
            headers: [],
            baseUrl: '',
            options: $options
        );

        $this->messages = new MessagesService($this);
    }

    /**
     * @param RequestOpts|null $requestOptions
     * @param non-empty-string|null $region
     */
    public static function fromEnvironment(?string $region = null, RequestOptions|array|null $requestOptions = null): self
    {
        $region = self::resolveRegion($region);
        $apiKey = Util::getenv('AWS_BEARER_TOKEN_BEDROCK');

        if (is_string($apiKey) && '' !== $apiKey) {
            return new self(
                signatureProvider: null,
                credentialProvider: null,
                region: $region,
                apiKey: $apiKey,
                requestOptions: $requestOptions,
            );
        }

        self::ensureAwsSdkIsInstalled();

        $credentialProvider = CredentialProvider::defaultProvider()(...);
        $signatureProvider = SignatureProvider::defaultProvider()(...);

        // @phpstan-ignore-next-line argument.type
        return new self($signatureProvider, $credentialProvider, $region, requestOptions: $requestOptions);
    }

    /**
     * @param non-empty-string $accessKeyId
     * @param non-empty-string $secretAccessKey
     * @param non-empty-string|null $region
     * @param non-empty-string|null $securityToken
     * @param RequestOpts|null $requestOptions
     */
    public static function withCredentials(
        string $accessKeyId,
        string $secretAccessKey,
        ?string $region = null,
        ?string $securityToken = null,
        RequestOptions|array|null $requestOptions = null,
    ): self
    {
        self::ensureAwsSdkIsInstalled();

        $region = self::resolveRegion($region);

        $credentialProvider = CredentialProvider::fromCredentials(new Credentials($accessKeyId, $secretAccessKey, $securityToken))(...);
        $signatureProvider = SignatureProvider::defaultProvider()(...);

        // @phpstan-ignore-next-line argument.type
        return new self($signatureProvider, $credentialProvider, $region, requestOptions: $requestOptions);
    }

    /**
     * @param non-empty-string $apiKey
     * @param non-empty-string|null $region
     * @param RequestOpts|null $requestOptions
     */
    public static function withApiKey(string $apiKey, ?string $region = null, RequestOptions|array|null $requestOptions = null): self
    {
        $region = self::resolveRegion($region);

        return new self(
            signatureProvider: null,
            credentialProvider: null,
            region: $region,
            apiKey: $apiKey,
            requestOptions: $requestOptions,
        );
    }

    protected function getBaseUrl(): UriInterface
    {
        assert(!is_null($this->options->uriFactory));

        return $this->options->uriFactory->createUri(
            'https://bedrock-runtime.'.$this->region.'.amazonaws.com'
        );
    }

    protected function transformRequest(RequestInterface $request): RequestInterface
    {
        if ('' !== $this->apiKey) {
            return $request;
        }

        // Refresh credentials if not set or expired.
        if (null === $this->credentials || $this->areCredentialsExpired($this->credentials)) {
            assert(null !== $this->credentialProvider);
            // @phpstan-ignore-next-line method.nonObject
            $this->credentials = ($this->credentialProvider)()->wait();
        }
        assert(null !== $this->credentials);

        $signer = $this->signer;

        if (null === $signer) {
            assert(null !== $this->signatureProvider);
            $resolvedSigner = ($this->signatureProvider)('v4', 'bedrock', $this->region);

            if (!($resolvedSigner instanceof SignatureInterface)) {
                throw new \RuntimeException('Failed to resolve AWS request signer.');
            }

            $this->signer = $resolvedSigner;
            $signer = $resolvedSigner;
        }

        return $signer->signRequest($request, $this->credentials);
    }

    /** @return array<string,string> */
    protected function bearerAuth(): array
    {
        return '' !== $this->apiKey ? ['Authorization' => "Bearer {$this->apiKey}"] : [];
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
            headers: [...$this->bearerAuth(), ...$headers],
            body: $body,
            opts: $opts,
        );
    }

    /**
     * Check if credentials are expired.
     * Permanent credentials (no expiration) are never considered expired.
     */
    private function areCredentialsExpired(CredentialsInterface $credentials): bool
    {
        $expiration = $credentials->getExpiration();

        if (null === $expiration) {
            return false; // Permanent credentials
        }

        // Refresh if credentials expire within 5 minutes
        return $expiration <= (time() + 300);
    }

    private static function ensureAwsSdkIsInstalled(): void
    {
        if (!class_exists(Sdk::class)) {
            throw new \RuntimeException('The `aws/aws-sdk-php` package is required to use Bedrock. Please install it via Composer.');
        }
    }

    /**
     * @param non-empty-string|null $region
     *
     * @return non-empty-string
     */
    private static function resolveRegion(?string $region): string
    {
        $resolvedRegion = $region ?? ConfigurationResolver::resolve('region', self::DEFAULT_REGION, 'string');

        if (!is_string($resolvedRegion) || '' === $resolvedRegion) {
            throw new \InvalidArgumentException('Unable to resolve region from environment and no region was provided.');
        }

        return $resolvedRegion;
    }
}
