<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_url_image_source_alias = array{type: string, url: string}
 */
final class BetaURLImageSource implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'url';

    #[Api]
    public string $url;

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
    public static function from(string $url): self
    {
        $obj = new self;

        $obj->url = $url;

        return $obj;
    }

    public function setURL(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
