<?php

declare(strict_types=1);

namespace Anthropic\Bedrock;

use Anthropic\Bedrock\Services\MessagesService;
use Anthropic\Core\BaseClient;
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
 */
final class Client extends BaseClient
{
    /**
     * @var non-empty-string
     */
    private const DEFAULT_REGION = 'us-east-1';

    public MessagesService $messages;

    private ?CredentialsInterface $credentials = null;

    private ?SignatureInterface $signer = null;

    /**
     * @param non-empty-string $region
     */
    private function __construct(
        private \Closure $signatureProvider,
        private \Closure $credentialProvider,
        private string $region,
    ) {
        $options = RequestOptions::with(
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            transporter: Psr18ClientDiscovery::find(),
        );

        parent::__construct(
            headers: [],
            baseUrl: '',
            options: $options
        );

        $this->messages = new MessagesService($this);
    }

    /**
     * @param non-empty-string|null $region
     */
    public static function fromEnvironment(?string $region = null): self
    {
        self::ensureAwsSdkIsInstalled();

        $region ??= ConfigurationResolver::resolve('region', self::DEFAULT_REGION, 'string');

        if (null === $region || '' === $region) {
            throw new \InvalidArgumentException('Unable to resolve region from environment and no region was provided.');
        }

        $credentialProvider = CredentialProvider::defaultProvider()(...);
        $signatureProvider = SignatureProvider::defaultProvider()(...);

        // @phpstan-ignore-next-line argument.type
        return new self($signatureProvider, $credentialProvider, $region);
    }

    /**
     * @param non-empty-string $accessKeyId
     * @param non-empty-string $secretAccessKey
     * @param non-empty-string|null $region
     * @param non-empty-string|null $securityToken
     */
    public static function withCredentials(string $accessKeyId, string $secretAccessKey, ?string $region = null, ?string $securityToken = null): self
    {
        self::ensureAwsSdkIsInstalled();

        $region ??= ConfigurationResolver::resolve('region', self::DEFAULT_REGION, 'string');

        if (null === $region || '' === $region) {
            throw new \InvalidArgumentException('Unable to resolve region from environment and no region was provided.');
        }

        $credentialProvider = CredentialProvider::fromCredentials(new Credentials($accessKeyId, $secretAccessKey, $securityToken))(...);
        $signatureProvider = SignatureProvider::defaultProvider()(...);

        // @phpstan-ignore-next-line argument.type
        return new self($signatureProvider, $credentialProvider, $region);
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
        // Refresh credentials if not set or expired.
        if (null === $this->credentials || $this->areCredentialsExpired($this->credentials)) {
            // @phpstan-ignore-next-line method.nonObject
            $this->credentials = ($this->credentialProvider)()->wait();
        }
        assert(null !== $this->credentials);

        // @phpstan-ignore-next-line assign.propertyType
        $this->signer ??= ($this->signatureProvider)('v4', 'bedrock', $this->region);
        assert(null !== $this->signer);

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
}
