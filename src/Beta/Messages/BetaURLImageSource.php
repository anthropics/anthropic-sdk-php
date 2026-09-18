<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaURLImageSourceShape = array{type: 'url', url: string}
 */
final class BetaURLImageSource implements BaseModel
{
    /** @use SdkModel<BetaURLImageSourceShape> */
    use SdkModel;

    /** @var 'url' $type */
    #[Required(type: new ConstantOf('url'))]
    public string $type = 'url';

    #[Required]
    public string $url;

    /**
     * `new BetaURLImageSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaURLImageSource::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaURLImageSource)->withURL(...)
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
    public static function with(string $url): self
    {
        $self = new self;

        $self['url'] = $url;

        return $self;
    }

    /**
     * @param 'url' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
