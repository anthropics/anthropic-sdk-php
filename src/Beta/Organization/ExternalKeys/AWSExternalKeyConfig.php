<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type AWSExternalKeyConfigShape = array{
 *   kmsARN: string, type: 'aws', region?: string|null, roleARN?: string|null
 * }
 */
final class AWSExternalKeyConfig implements BaseModel
{
    /** @use SdkModel<AWSExternalKeyConfigShape> */
    use SdkModel;

    /** @var 'aws' $type */
    #[Required]
    public string $type = 'aws';

    /**
     * Full ARN of the AWS KMS key. On Claude Platform on AWS the key must be a single-Region key in your organization's own AWS account; cross-account keys, multi-Region keys, and alias ARNs are rejected.
     */
    #[Required('kms_arn')]
    public string $kmsARN;

    /**
     * AWS region. Derived from `kms_arn` if omitted.
     */
    #[Optional(nullable: true)]
    public ?string $region;

    /**
     * @deprecated
     *
     * IAM role ARN. Deprecated — Anthropic reaches the KMS key through its own intermediate role (or, on Claude Platform on AWS, with credentials AWS issues for the Workspace); this field is ignored.
     */
    #[Optional('role_arn', nullable: true)]
    public ?string $roleARN;

    /**
     * `new AWSExternalKeyConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AWSExternalKeyConfig::with(kmsARN: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AWSExternalKeyConfig)->withKMSARN(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        string $kmsARN,
        ?string $region = null,
        ?string $roleARN = null
    ): self {
        $self = new self;

        $self['kmsARN'] = $kmsARN;

        null !== $region && $self['region'] = $region;
        null !== $roleARN && $self['roleARN'] = $roleARN;

        return $self;
    }

    /**
     * Full ARN of the AWS KMS key. On Claude Platform on AWS the key must be a single-Region key in your organization's own AWS account; cross-account keys, multi-Region keys, and alias ARNs are rejected.
     */
    public function withKMSARN(string $kmsARN): self
    {
        $self = clone $this;
        $self['kmsARN'] = $kmsARN;

        return $self;
    }

    /**
     * @param 'aws' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * AWS region. Derived from `kms_arn` if omitted.
     */
    public function withRegion(?string $region): self
    {
        $self = clone $this;
        $self['region'] = $region;

        return $self;
    }

    /**
     * IAM role ARN. Deprecated — Anthropic reaches the KMS key through its own intermediate role (or, on Claude Platform on AWS, with credentials AWS issues for the Workspace); this field is ignored.
     */
    public function withRoleARN(?string $roleARN): self
    {
        $self = clone $this;
        $self['roleARN'] = $roleARN;

        return $self;
    }
}
