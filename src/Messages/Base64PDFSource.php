<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type Base64PDFSourceShape = array{
 *   data: string, mediaType?: 'application/pdf', type?: 'base64'
 * }
 */
final class Base64PDFSource implements BaseModel
{
    /** @use SdkModel<Base64PDFSourceShape> */
    use SdkModel;

    /** @var 'application/pdf' $mediaType */
    #[Required('media_type')]
    public string $mediaType = 'application/pdf';

    /** @var 'base64' $type */
    #[Required]
    public string $type = 'base64';

    #[Required]
    public string $data;

    /**
     * `new Base64PDFSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Base64PDFSource::with(data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Base64PDFSource)->withData(...)
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
