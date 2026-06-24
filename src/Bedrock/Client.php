<?php

declare(strict_types=1);

namespace Anthropic\Bedrock;

use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Aws\Configuration\ConfigurationResolver;
use Aws\Credentials\CredentialProvider;
use Aws\Credentials\Credentials;
use Aws\Credentials\CredentialsInterface;
use Aws\Sdk;
use Aws\Signature\SignatureInterface;
use Aws\Signature\SignatureProvider;
use Psr\Http\Message\RequestInterface;

/**
 * Note: This client is not thread-safe; avoid sharing instances across parallel requests.
 *
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class Client extends \Anthropic\Client
{
    /**
     * @var non-empty-string
     */
    private const DEFAULT_REGION = 'us-east-1';

    private ?CredentialsInterface $credentials = null;

    private ?SignatureInterface $signer = null;

    /**
     * @param non-empty-string $region
     * @param non-empty-string|null $baseUrl
     * @param RequestOpts|null $requestOptions
     */
    private function __construct(
        private ?\Closure $signatureProvider,
        private ?\Closure $credentialProvider,
        private string $region,
        ?string $apiKey = null,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $hasApiKey = null !== $apiKey && '' !== $apiKey;
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

        $baseUrl ??= Util::getenv('ANTHROPIC_BEDROCK_BASE_URL') ?: 'https://bedrock-runtime.'.$region.'.amazonaws.com';

        // Pass '' for apiKey/authToken to suppress ANTHROPIC_API_KEY and
        // ANTHROPIC_AUTH_TOKEN env lookups; Bedrock auth is handled entirely
        // by the $authorize closure in backendMiddleware().
        parent::__construct(
            apiKey: '',
            authToken: '',
            baseUrl: $baseUrl,
            requestOptions: $requestOptions,
        );

        // Restore the Bedrock bearer token so backendMiddleware() can use it.
        $this->apiKey = $apiKey ?? '';
    }

    /**
     * @param non-empty-string|null $region
     * @param non-empty-string|null $baseUrl
     * @param RequestOpts|null $requestOptions
     */
    public static function fromEnvironment(?string $region = null, ?string $baseUrl = null, RequestOptions|array|null $requestOptions = null): self
    {
        $region = self::resolveRegion($region);
        $apiKey = Util::getenv('AWS_BEARER_TOKEN_BEDROCK');

        if (is_string($apiKey) && '' !== $apiKey) {
            return new self(
                signatureProvider: null,
                credentialProvider: null,
                region: $region,
                apiKey: $apiKey,
                baseUrl: $baseUrl,
                requestOptions: $requestOptions,
            );
        }

        self::ensureAwsSdkIsInstalled();

        $credentialProvider = CredentialProvider::defaultProvider()(...);
        $signatureProvider = SignatureProvider::defaultProvider()(...);

        // @phpstan-ignore-next-line argument.type
        return new self($signatureProvider, $credentialProvider, $region, baseUrl: $baseUrl, requestOptions: $requestOptions);
    }

    /**
     * @param non-empty-string $accessKeyId
     * @param non-empty-string $secretAccessKey
     * @param non-empty-string|null $region
     * @param non-empty-string|null $securityToken
     * @param non-empty-string|null $baseUrl
     * @param RequestOpts|null $requestOptions
     */
    public static function withCredentials(
        string $accessKeyId,
        string $secretAccessKey,
        ?string $region = null,
        ?string $securityToken = null,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
    ): self
    {
        self::ensureAwsSdkIsInstalled();

        $region = self::resolveRegion($region);

        $credentialProvider = CredentialProvider::fromCredentials(new Credentials($accessKeyId, $secretAccessKey, $securityToken))(...);
        $signatureProvider = SignatureProvider::defaultProvider()(...);

        // @phpstan-ignore-next-line argument.type
        return new self($signatureProvider, $credentialProvider, $region, baseUrl: $baseUrl, requestOptions: $requestOptions);
    }

    /**
     * @param non-empty-string $apiKey
     * @param non-empty-string|null $region
     * @param non-empty-string|null $baseUrl
     * @param RequestOpts|null $requestOptions
     */
    public static function withApiKey(string $apiKey, ?string $region = null, ?string $baseUrl = null, RequestOptions|array|null $requestOptions = null): self
    {
        $region = self::resolveRegion($region);

        return new self(
            signatureProvider: null,
            credentialProvider: null,
            region: $region,
            apiKey: $apiKey,
            baseUrl: $baseUrl,
            requestOptions: $requestOptions,
        );
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return [];
    }

    protected function transformRequest(RequestInterface $request): RequestInterface
    {
        return $request;
    }

    protected function backendMiddleware(): array
    {
        assert(null !== $this->options->streamFactory);

        $authorize = '' !== $this->apiKey
            ? fn (RequestInterface $request): RequestInterface => $request->hasHeader('Authorization')
                ? $request
                : $request->withHeader('Authorization', 'Bearer '.$this->apiKey)
            : $this->sign(...);

        return [new BedrockMiddleware($this->options->streamFactory, $authorize)];
    }

    private function sign(RequestInterface $request): RequestInterface
    {
        if (null === $this->credentials || $this->areCredentialsExpired($this->credentials)) {
            assert(null !== $this->credentialProvider);
            // @phpstan-ignore-next-line method.nonObject
            $this->credentials = ($this->credentialProvider)()->wait();
        }
        assert(null !== $this->credentials);

        if (null === $this->signer) {
            assert(null !== $this->signatureProvider);
            $resolvedSigner = ($this->signatureProvider)('v4', 'bedrock', $this->region);

            if (!($resolvedSigner instanceof SignatureInterface)) {
                throw new \RuntimeException('Failed to resolve AWS request signer.');
            }

            $this->signer = $resolvedSigner;
        }

        return $this->signer->signRequest($request, $this->credentials);
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
