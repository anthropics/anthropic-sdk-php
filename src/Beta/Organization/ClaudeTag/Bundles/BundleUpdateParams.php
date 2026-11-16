<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\Bundles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Change a Bundle's instructions. The update is partial: a field left out is unchanged, and `instructions` sent as null or as an empty string clears them. The later of two updates wins. Sessions that start after the change use the new instructions; sessions already running keep the ones they started with. Some Bundles are managed in claude.ai, and an update of one returns 400.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeTag\BundlesService::update()
 *
 * @phpstan-type BundleUpdateParamsShape = array{
 *   instructions?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class BundleUpdateParams implements BaseModel
{
    /** @use SdkModel<BundleUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Instructions for Claude, up to 10,000 bytes (UTF-8), added to the instructions of every session that can use the Bundle. Null or an empty string clears them.
     */
    #[Optional(nullable: true)]
    public ?string $instructions;

    /**
     * This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

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
    public static function with(
        ?string $instructions = null,
        ?array $betas = null
    ): self {
        $self = new self;

        null !== $instructions && $self['instructions'] = $instructions;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Instructions for Claude, up to 10,000 bytes (UTF-8), added to the instructions of every session that can use the Bundle. Null or an empty string clears them.
     */
    public function withInstructions(?string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
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
