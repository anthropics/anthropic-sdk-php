<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_url_image_source = array{type: string, url: string}
 */
final class BetaURLImageSource implements BaseModel
{
    /** @use SdkModel<beta_url_image_source> */
    use SdkModel;

    #[Api]
    public string $type = 'url';

    #[Api]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $url): self
    {
        $obj = new self;

        $obj->url = $url;

        return $obj;
    }

    public function withURL(string $url): self
    {
        $obj = clone $this;
        $obj->url = $url;

        return $obj;
    }
}
