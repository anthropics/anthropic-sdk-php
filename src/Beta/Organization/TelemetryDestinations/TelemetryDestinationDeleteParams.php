<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Delete a destination and its workspace list.
 *
 * The API stops sending spans to the destination. The spans of the workspaces it covered still go to the other destinations that cover them. A deleted destination can't be read, listed, or restored.
 *
 * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#delivery-and-health) to learn more about managing a destination.
 *
 * @see Anthropic\Services\Beta\Organization\TelemetryDestinationsService::delete()
 *
 * @phpstan-type TelemetryDestinationDeleteParamsShape = array{
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null
 * }
 */
final class TelemetryDestinationDeleteParams implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header.
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
    public static function with(?array $betas = null): self
    {
        $self = new self;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header.
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
