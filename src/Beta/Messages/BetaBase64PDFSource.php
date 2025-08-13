<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_base64_pdf_source_alias = array{
 *   data: string, mediaType: string, type: string
 * }
 */
final class BetaBase64PDFSource implements BaseModel
{
    use Model;

    #[Api('media_type')]
    public string $mediaType = 'application/pdf';

    #[Api]
    public string $type = 'base64';

    #[Api]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $data): self
    {
        $obj = new self;

        $obj->data = $data;

        return $obj;
    }

    public function withData(string $data): self
    {
        $obj = clone $this;
        $obj->data = $data;

        return $obj;
    }
}
