<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type plain_text_source_alias = array{
 *   data: string, mediaType: string, type: string
 * }
 */
final class PlainTextSource implements BaseModel
{
    use ModelTrait;

    #[Api('media_type')]
    public string $mediaType = 'text/plain';

    #[Api]
    public string $type = 'text';

    #[Api]
    public string $data;

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
    public static function new(string $data): self
    {
        $obj = new self;

        $obj->data = $data;

        return $obj;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }
}
