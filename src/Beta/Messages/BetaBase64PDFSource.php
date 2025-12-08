<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaBase64PDFSourceShape = array{
 *   data: string, media_type: 'application/pdf', type: 'base64'
 * }
 */
final class BetaBase64PDFSource implements BaseModel
{
    /** @use SdkModel<BetaBase64PDFSourceShape> */
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
     * `new BetaBase64PDFSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBase64PDFSource::with(data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBase64PDFSource)->withData(...)
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
