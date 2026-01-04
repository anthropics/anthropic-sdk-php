<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type PlainTextSourceShape = array{
 *   data: string, mediaType: 'text/plain', type: 'text'
 * }
 */
final class PlainTextSource implements BaseModel
{
    /** @use SdkModel<PlainTextSourceShape> */
    use SdkModel;

    /** @var 'text/plain' $mediaType */
    #[Required('media_type')]
    public string $mediaType = 'text/plain';

    /** @var 'text' $type */
    #[Required]
    public string $type = 'text';

    #[Required]
    public string $data;

    /**
     * `new PlainTextSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PlainTextSource::with(data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PlainTextSource)->withData(...)
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
    public static function with(string $data): self
    {
        $self = new self;

        $self['data'] = $data;

        return $self;
    }

    public function withData(string $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }
}
