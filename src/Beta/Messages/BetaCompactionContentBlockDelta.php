<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCompactionContentBlockDeltaShape = array{
 *   content: string|null, type: 'compaction_delta'
 * }
 */
final class BetaCompactionContentBlockDelta implements BaseModel
{
    /** @use SdkModel<BetaCompactionContentBlockDeltaShape> */
    use SdkModel;

    /** @var 'compaction_delta' $type */
    #[Required]
    public string $type = 'compaction_delta';

    #[Required]
    public ?string $content;

    /**
     * `new BetaCompactionContentBlockDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCompactionContentBlockDelta::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCompactionContentBlockDelta)->withContent(...)
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
    public static function with(?string $content): self
    {
        $self = new self;

        $self['content'] = $content;

        return $self;
    }

    public function withContent(?string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * @param 'compaction_delta' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
