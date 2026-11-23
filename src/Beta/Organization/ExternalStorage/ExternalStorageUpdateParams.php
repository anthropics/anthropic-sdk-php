<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Rename External Storage or clear its name, in any status.
 *
 * @see Anthropic\Services\Beta\Organization\ExternalStorageService::update()
 *
 * @phpstan-type ExternalStorageUpdateParamsShape = array{
 *   displayName: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class ExternalStorageUpdateParams implements BaseModel
{
    /** @use SdkModel<ExternalStorageUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Human-friendly display name; null clears it.
     */
    #[Required('display_name')]
    public ?string $displayName;

    /**
     * This endpoint is in beta: requests must send `efs-2026-10-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new ExternalStorageUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExternalStorageUpdateParams::with(displayName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExternalStorageUpdateParams())->withDisplayName(...)
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
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(?string $displayName, ?array $betas = null): self
    {
        $self = new self;

        $self['displayName'] = $displayName;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Human-friendly display name; null clears it.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `efs-2026-10-01` in this header.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
