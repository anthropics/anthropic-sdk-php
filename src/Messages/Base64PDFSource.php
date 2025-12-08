<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type Base64PDFSourceShape = array{
 *   data: string, media_type: 'application/pdf', type: 'base64'
 * }
 */
final class Base64PDFSource implements BaseModel
{
    /** @use SdkModel<Base64PDFSourceShape> */
    use SdkModel;

    /** @var 'application/pdf' $media_type */
    #[Required]
    public string $media_type = 'application/pdf';

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
        $obj = new self;

        $obj['data'] = $data;

        return $obj;
    }

    public function withData(string $data): self
    {
        $obj = clone $this;
        $obj['data'] = $data;

        return $obj;
    }
}
