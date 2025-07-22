<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaBase64ImageSource\MediaType;

/**
 * @phpstan-type beta_base64_image_source_alias = array{
 *   data: string, mediaType: MediaType::*, type: string
 * }
 */
final class BetaBase64ImageSource implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'base64';

    #[Api]
    public string $data;

    /** @var MediaType::* $mediaType */
    #[Api('media_type', enum: MediaType::class)]
    public string $mediaType;

    /**
     * You must use named parameters to construct this object.
     *
     * @param MediaType::* $mediaType
     */
    final public function __construct(string $data, string $mediaType)
    {
        self::introspect();

        $this->data = $data;
        $this->mediaType = $mediaType;
    }
}
