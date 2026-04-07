<?php

declare(strict_types=1);

namespace Anthropic\Aws;

use Anthropic\Core\Util;
use Aws\Credentials\CredentialProvider;
use Aws\Credentials\Credentials;
use Aws\Credentials\CredentialsInterface;
use Aws\Signature\SignatureV4;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Shared AWS authentication resolver for Anthropic platform clients.
 *
 * Handles SigV4 signing, credential resolution, and auth precedence
 * for clients that authenticate via AWS credentials or API key.
 *
 * Auth is resolved by precedence:
 *  0. $skipAuth (no auth — skips all below)
 *  1. $apiKey arg (x-api-key header)
 *  2. $awsAccessKey + $awsSecretAccessKey args (SigV4)
 *  3. $awsProfile arg (SigV4 via named profile)
 *  4. Primary API key env var (x-api-key header)
 *  5. Fallback API key env var (x-api-key header)
 *  6. Default AWS credential chain (SigV4)
 *
 * @internal
 */
final class AwsAuth
{
    private bool $useSigV4;

    private ?string $resolvedApiKey;

    private ?string $resolvedRegion;

    private string $resolvedBaseUrl;

    /** @var (callable(): PromiseInterface)|null */
    private $credentialProvider;

    /**
     * @param string $serviceName       SigV4 service name (e.g., 'bedrock-mantle')
     * @param string $baseUrlPattern    URL template with {region} placeholder
     * @param string $apiKeyEnvVar      Primary API key env var name
     * @param string $baseUrlEnvVar     Base URL env var name
     * @param string|null $apiKeyFallbackEnvVar      Fallback API key env var
     */
    public function __construct(
        private string $serviceName,
        string $baseUrlPattern,
        string $apiKeyEnvVar,
        string $baseUrlEnvVar,
        ?string $apiKeyFallbackEnvVar = null,
        ?string $apiKey = null,
        private ?string $awsAccessKey = null,
        private ?string $awsSecretAccessKey = null,
        private ?string $awsSessionToken = null,
        private ?string $awsProfile = null,
        ?string $awsRegion = null,
        ?string $baseUrl = null,
        private bool $skipAuth = false,
    ) {
        // Region: arg > AWS_REGION env > AWS_DEFAULT_REGION env
        $this->resolvedRegion = $awsRegion
            ?? Util::getenv('AWS_REGION')
            ?? Util::getenv('AWS_DEFAULT_REGION');

        // Base URL: arg > env var > derived from region + pattern
        if (null === $baseUrl) {
            $baseUrl = Util::getenv($baseUrlEnvVar);
        }
        if (null === $baseUrl && null !== $this->resolvedRegion) {
            $baseUrl = str_replace('{region}', $this->resolvedRegion, $baseUrlPattern);
        }

        // Base URL or region is always required, regardless of auth mode
        if (null === $baseUrl) {
            throw new \InvalidArgumentException(
                "No base URL or region found; set \$baseUrl, {$baseUrlEnvVar}, \$awsRegion, AWS_REGION, or AWS_DEFAULT_REGION"
            );
        }

        $this->resolvedBaseUrl = $baseUrl;

        // Auth mode resolution
        $this->resolvedApiKey = null;
        $this->useSigV4 = false;

        if ($this->skipAuth) {
            return;
        }

        $hasExplicitApiKey = null !== $apiKey;
        $hasExplicitAwsCreds = null !== $awsAccessKey && null !== $awsSecretAccessKey;
        $hasAwsProfile = null !== $awsProfile;

        if ($hasExplicitApiKey) {
            $this->resolvedApiKey = $apiKey;
        } elseif ($hasExplicitAwsCreds || $hasAwsProfile) {
            $this->useSigV4 = true;
        } else {
            $envKey = Util::getenv($apiKeyEnvVar)
                ?? (null !== $apiKeyFallbackEnvVar ? Util::getenv($apiKeyFallbackEnvVar) : null);

            if (null !== $envKey) {
                $this->resolvedApiKey = $envKey;
            } else {
                $this->useSigV4 = true;
            }
        }

        if ($this->useSigV4 && null === $this->resolvedRegion) {
            throw new \InvalidArgumentException(
                'No AWS region found; set $awsRegion, AWS_REGION, or AWS_DEFAULT_REGION'
            );
        }
    }

    public function getBaseUrl(): string
    {
        return $this->resolvedBaseUrl;
    }

    public function getResolvedApiKey(): ?string
    {
        return $this->resolvedApiKey;
    }

    public function isSkipAuth(): bool
    {
        return $this->skipAuth;
    }

    /** @return array<string,string> */
    public function getAuthHeaders(): array
    {
        if ($this->skipAuth) {
            return [];
        }

        if (!$this->useSigV4 && null !== $this->resolvedApiKey) {
            return ['X-Api-Key' => $this->resolvedApiKey];
        }

        return [];
    }

    /**
     * Signs the request with SigV4 if configured.
     */
    public function signRequest(RequestInterface $request): RequestInterface
    {
        if ($this->skipAuth || !$this->useSigV4) {
            return $request;
        }

        if (!class_exists(SignatureV4::class)) {
            throw new \RuntimeException(
                'SigV4 authentication requires the aws/aws-sdk-php package. '
                .'Install it with: composer require aws/aws-sdk-php'
            );
        }

        $credentials = $this->resolveCredentials();
        assert(null !== $this->resolvedRegion);
        $signer = new SignatureV4($this->serviceName, $this->resolvedRegion);

        return $signer->signRequest($request, $credentials);
    }

    private function resolveCredentials(): CredentialsInterface
    {
        if (null !== $this->awsAccessKey && null !== $this->awsSecretAccessKey) {
            return new Credentials(
                $this->awsAccessKey,
                $this->awsSecretAccessKey,
                $this->awsSessionToken,
            );
        }

        if (null === $this->credentialProvider) {
            if (null !== $this->awsProfile) {
                // Try SSO profiles (from ~/.aws/config) first, then fall back to
                // static credentials (from ~/.aws/credentials). ini() alone only
                // reads ~/.aws/credentials and cannot resolve SSO profiles.
                $this->credentialProvider = \Aws\Credentials\CredentialProvider::memoize(
                    \Aws\Credentials\CredentialProvider::chain(
                        \Aws\Credentials\CredentialProvider::sso($this->awsProfile),
                        \Aws\Credentials\CredentialProvider::ini($this->awsProfile),
                    ),
                );
            } else {
                $this->credentialProvider = CredentialProvider::defaultProvider();
            }
        }

        $promise = ($this->credentialProvider)();
        assert($promise instanceof PromiseInterface);
        $credentials = $promise->wait();
        assert($credentials instanceof CredentialsInterface);

        return $credentials;
    }
}
