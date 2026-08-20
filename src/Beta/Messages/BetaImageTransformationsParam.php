<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaImageTransformationsParam\OversizedImage;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configures the transformations the server applies to this image before the model observes it. Each key names a condition the server transforms images for; its value selects the transformation applied. Omitted keys keep their default behavior, and an empty object is equivalent to omitting the field.
 *
 * @phpstan-type BetaImageTransformationsParamShape = array{
 *   oversizedImage?: null|OversizedImage|value-of<OversizedImage>
 * }
 */
final class BetaImageTransformationsParam implements BaseModel
{
    /** @use SdkModel<BetaImageTransformationsParamShape> */
    use SdkModel;

    /**
     * What the server does when this image exceeds the model's maximum image size. `"downsize"` (the default) scales the image down to fit, which changes the dimensions the model observes without telling you. `"error"` instead rejects the request with a 400 error naming the image's dimensions and the largest dimensions that fit, so you can scale the image deliberately — your image is never silently scaled down.
     *
     * @var value-of<OversizedImage>|null $oversizedImage
     */
    #[Optional('oversized_image', enum: OversizedImage::class)]
    public ?string $oversizedImage;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param OversizedImage|value-of<OversizedImage>|null $oversizedImage
     */
    public static function with(
        OversizedImage|string|null $oversizedImage = null
    ): self {
        $self = new self;

        null !== $oversizedImage && $self['oversizedImage'] = $oversizedImage;

        return $self;
    }

    /**
     * What the server does when this image exceeds the model's maximum image size. `"downsize"` (the default) scales the image down to fit, which changes the dimensions the model observes without telling you. `"error"` instead rejects the request with a 400 error naming the image's dimensions and the largest dimensions that fit, so you can scale the image deliberately — your image is never silently scaled down.
     *
     * @param OversizedImage|value-of<OversizedImage> $oversizedImage
     */
    public function withOversizedImage(
        OversizedImage|string $oversizedImage
    ): self {
        $self = clone $this;
        $self['oversizedImage'] = $oversizedImage;

        return $self;
    }
}
