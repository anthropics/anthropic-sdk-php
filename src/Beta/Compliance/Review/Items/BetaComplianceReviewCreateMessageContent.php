<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A request to create a message, and its response.
 *
 * @phpstan-import-type BetaMessageShape from \Anthropic\Beta\Messages\BetaMessage
 *
 * @phpstan-type BetaComplianceReviewCreateMessageContentShape = array{
 *   request: array<string,mixed>,
 *   response: null|BetaMessage|BetaMessageShape,
 *   type: 'create_message',
 * }
 */
final class BetaComplianceReviewCreateMessageContent implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewCreateMessageContentShape> */
    use SdkModel;

    /** @var 'create_message' $type */
    #[Required(type: new ConstantOf('create_message'))]
    public string $type = 'create_message';

    /**
     * The `POST /v1/messages` request body, without thinking blocks or unpublished fields. For a user's message from an Anthropic app, such as Claude Code, `system` is a placeholder.
     *
     * @var array<string,mixed> $request
     */
    #[Required(map: 'mixed')]
    public array $request;

    /**
     * The model's `Message`, without thinking blocks or unpublished fields. Null when no response was stored, for example because the client disconnected.
     */
    #[Required]
    public ?BetaMessage $response;

    /**
     * `new BetaComplianceReviewCreateMessageContent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewCreateMessageContent::with(request: ..., response: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewCreateMessageContent())
     *   ->withRequest(...)
     *   ->withResponse(...)
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
     * @param array<string,mixed> $request
     * @param BetaMessage|BetaMessageShape|null $response
     */
    public static function with(
        array $request,
        BetaMessage|array|null $response
    ): self {
        $self = new self;

        $self['request'] = $request;
        $self['response'] = $response;

        return $self;
    }

    /**
     * The `POST /v1/messages` request body, without thinking blocks or unpublished fields. For a user's message from an Anthropic app, such as Claude Code, `system` is a placeholder.
     *
     * @param array<string,mixed> $request
     */
    public function withRequest(array $request): self
    {
        $self = clone $this;
        $self['request'] = $request;

        return $self;
    }

    /**
     * The model's `Message`, without thinking blocks or unpublished fields. Null when no response was stored, for example because the client disconnected.
     *
     * @param BetaMessage|BetaMessageShape|null $response
     */
    public function withResponse(BetaMessage|array|null $response): self
    {
        $self = clone $this;
        $self['response'] = $response;

        return $self;
    }

    /**
     * @param 'create_message' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
