<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type urlpdf_source_alias = array{type: string, url: string}
 */
final class URLPDFSource implements BaseModel
{
    use ModelTrait;

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
    public static function new(string $url): self
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
