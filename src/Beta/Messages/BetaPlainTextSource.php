<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaPlainTextSourceShape = array{
 *   data: string, mediaType?: 'text/plain', type?: 'text'
 * }
 */
final class BetaPlainTextSource implements BaseModel
{
    /** @use SdkModel<BetaPlainTextSourceShape> */
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
     * `new BetaPlainTextSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaPlainTextSource::with(data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaPlainTextSource)->withData(...)
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
