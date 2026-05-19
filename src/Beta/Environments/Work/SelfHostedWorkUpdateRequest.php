<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * Request to update work item metadata.
 *
 * @phpstan-type SelfHostedWorkUpdateRequestShape = array{
 *   metadata: array<string,string|null>
 * }
 */
final class SelfHostedWorkUpdateRequest implements BaseModel
{
    /** @use SdkModel<SelfHostedWorkUpdateRequestShape> */
    use SdkModel;

    /**
     * Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve existing metadata.
     *
     * @var array<string,string|null> $metadata
     */
    #[Required(type: new MapOf('string', nullable: true))]
    public array $metadata;

    /**
     * `new SelfHostedWorkUpdateRequest()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SelfHostedWorkUpdateRequest::with(metadata: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SelfHostedWorkUpdateRequest)->withMetadata(...)
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
     *
     * @param array<string,string|null> $metadata
     */
    public static function with(array $metadata): self
    {
        $self = new self;

        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve existing metadata.
     *
     * @param array<string,string|null> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }
}
