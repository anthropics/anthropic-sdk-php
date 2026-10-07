<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type AWSExternalKeyConfigShape = array{
 *   kmsARN: string, type: 'aws', region?: string|null
 * }
 */
final class AWSExternalKeyConfig implements BaseModel
{
    /** @use SdkModel<AWSExternalKeyConfigShape> */
    use SdkModel;

    /** @var 'aws' $type */
    #[Required(type: new ConstantOf('aws'))]
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
     * (new AWSExternalKeyConfig())->withKMSARN(...)
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
    public static function with(string $kmsARN, ?string $region = null): self
    {
        $self = new self;

        $self['kmsARN'] = $kmsARN;

        null !== $region && $self['region'] = $region;

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
}
