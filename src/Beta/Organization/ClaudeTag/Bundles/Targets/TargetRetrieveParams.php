<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get one Bundle Target. Returns 404 when `target_id` is the identifier of another Bundle's Bundle Target, or the Bundle Target was detached.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeTag\Bundles\TargetsService::retrieve()
 *
 * @phpstan-type TargetRetrieveParamsShape = array{
 *   bundleID: string,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class TargetRetrieveParams implements BaseModel
{
    /** @use SdkModel<TargetRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The Bundle's identifier, starting with `capp_`.
     */
    #[Required]
    public string $bundleID;

    /**
     * This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new TargetRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TargetRetrieveParams::with(bundleID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TargetRetrieveParams())->withBundleID(...)
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
    public static function with(string $bundleID, ?array $betas = null): self
    {
        $self = new self;

        $self['bundleID'] = $bundleID;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The Bundle's identifier, starting with `capp_`.
     */
    public function withBundleID(string $bundleID): self
    {
        $self = clone $this;
        $self['bundleID'] = $bundleID;

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
