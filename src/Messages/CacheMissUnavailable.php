<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A `cache_miss_reason` for when the API can't give a diagnosis. The request itself was processed normally.
 *
 * This includes a request whose `model`, `system`, and `tools` match the previous request's but whose other prompt-affecting parameters, such as `thinking` or `tool_choice`, differ.
 *
 * See the [cache diagnostics guide](https://platform.claude.com/docs/en/build-with-claude/cache-diagnostics#cache-miss-reason-types) to learn what to change for each reason.
 *
 * @phpstan-type CacheMissUnavailableShape = array{type: 'unavailable'}
 */
final class CacheMissUnavailable implements BaseModel
{
    /** @use SdkModel<CacheMissUnavailableShape> */
    use SdkModel;

    /** @var 'unavailable' $type */
    #[Required(type: new ConstantOf('unavailable'))]
    public string $type = 'unavailable';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'unavailable' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
