<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type GCPExternalKeyConfigShape = array{keyName: string, type: 'gcp'}
 */
final class GCPExternalKeyConfig implements BaseModel
{
    /** @use SdkModel<GCPExternalKeyConfigShape> */
    use SdkModel;

    /** @var 'gcp' $type */
    #[Required]
    public string $type = 'gcp';

    /**
     * Full resource name of the Cloud KMS key.
     */
    #[Required('key_name')]
    public string $keyName;

    /**
     * `new GCPExternalKeyConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * GCPExternalKeyConfig::with(keyName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new GCPExternalKeyConfig)->withKeyName(...)
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
    public static function with(string $keyName): self
    {
        $self = new self;

        $self['keyName'] = $keyName;

        return $self;
    }

    /**
     * Full resource name of the Cloud KMS key.
     */
    public function withKeyName(string $keyName): self
    {
        $self = clone $this;
        $self['keyName'] = $keyName;

        return $self;
    }

    /**
     * @param 'gcp' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
