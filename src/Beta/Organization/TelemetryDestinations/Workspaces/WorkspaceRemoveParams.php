<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations\Workspaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Remove one workspace from a destination's workspace list.
 *
 * Under `include` the workspace's spans stop going to the destination. Under `exclude` they start. An archived workspace can be removed too.
 *
 * The API returns 404 when the workspace isn't on the list. A destination whose `workspaces.type` is `all` doesn't have a list, so the API returns 400.
 *
 * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#choose-workspaces-for-a-destination) to learn more about choosing the workspaces of a destination.
 *
 * @see Anthropic\Services\Beta\Organization\TelemetryDestinations\WorkspacesService::remove()
 *
 * @phpstan-type WorkspaceRemoveParamsShape = array{
 *   destinationID: string,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class WorkspaceRemoveParams implements BaseModel
{
    /** @use SdkModel<WorkspaceRemoveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the destination (`tdst_...`).
     */
    #[Required]
    public string $destinationID;

    /**
     * This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new WorkspaceRemoveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkspaceRemoveParams::with(destinationID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspaceRemoveParams())->withDestinationID(...)
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
    public static function with(
        string $destinationID,
        ?array $betas = null
    ): self {
        $self = new self;

        $self['destinationID'] = $destinationID;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * ID of the destination (`tdst_...`).
     */
    public function withDestinationID(string $destinationID): self
    {
        $self = clone $this;
        $self['destinationID'] = $destinationID;

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
