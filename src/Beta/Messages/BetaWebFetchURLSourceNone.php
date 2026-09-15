<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The ``url_sources`` variant under which a source contributes nothing:
 * no result of the tool filter's source, or no user input.
 *
 * @phpstan-type BetaWebFetchURLSourceNoneShape = array{type: 'none'}
 */
final class BetaWebFetchURLSourceNone implements BaseModel
{
    /** @use SdkModel<BetaWebFetchURLSourceNoneShape> */
    use SdkModel;

    /** @var 'none' $type */
    #[Required]
    public string $type = 'none';

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
     * @param 'none' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
