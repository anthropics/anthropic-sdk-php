<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaAdvisorRedactedResultBlockShape = array{
 *   encryptedContent: string,
 *   stopReason: string|null,
 *   type: 'advisor_redacted_result',
 * }
 */
final class BetaAdvisorRedactedResultBlock implements BaseModel
{
    /** @use SdkModel<BetaAdvisorRedactedResultBlockShape> */
    use SdkModel;

    /** @var 'advisor_redacted_result' $type */
    #[Required]
    public string $type = 'advisor_redacted_result';

    /**
     * Opaque blob containing the advisor's output. Round-trip verbatim; do not inspect or modify.
     */
    #[Required('encrypted_content')]
    public string $encryptedContent;

    /**
     * The advisor sub-inference's stop reason (same values as the top-level message `stop_reason`).
     */
    #[Required('stop_reason')]
    public ?string $stopReason;

    /**
     * `new BetaAdvisorRedactedResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAdvisorRedactedResultBlock::with(encryptedContent: ..., stopReason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAdvisorRedactedResultBlock)
     *   ->withEncryptedContent(...)
     *   ->withStopReason(...)
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
    public static function with(
        string $encryptedContent,
        ?string $stopReason
    ): self {
        $self = new self;

        $self['encryptedContent'] = $encryptedContent;
        $self['stopReason'] = $stopReason;

        return $self;
    }

    /**
     * Opaque blob containing the advisor's output. Round-trip verbatim; do not inspect or modify.
     */
    public function withEncryptedContent(string $encryptedContent): self
    {
        $self = clone $this;
        $self['encryptedContent'] = $encryptedContent;

        return $self;
    }

    /**
     * The advisor sub-inference's stop reason (same values as the top-level message `stop_reason`).
     */
    public function withStopReason(?string $stopReason): self
    {
        $self = clone $this;
        $self['stopReason'] = $stopReason;

        return $self;
    }

    /**
     * @param 'advisor_redacted_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
