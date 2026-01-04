<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaURLPDFSourceShape = array{type: 'url', url: string}
 */
final class BetaURLPDFSource implements BaseModel
{
    /** @use SdkModel<BetaURLPDFSourceShape> */
    use SdkModel;

    /** @var 'url' $type */
    #[Required]
    public string $type = 'url';

    #[Required]
    public string $url;

    /**
     * `new BetaURLPDFSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaURLPDFSource::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaURLPDFSource)->withURL(...)
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

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
