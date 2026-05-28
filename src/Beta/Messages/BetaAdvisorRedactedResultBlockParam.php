<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaAdvisorRedactedResultBlockParamShape = array{
 *   encryptedContent: string,
 *   type: 'advisor_redacted_result',
 *   stopReason?: string|null,
 * }
 */
final class BetaAdvisorRedactedResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaAdvisorRedactedResultBlockParamShape> */
    use SdkModel;

    /** @var 'advisor_redacted_result' $type */
    #[Required]
    public string $type = 'advisor_redacted_result';

    /**
     * Opaque blob produced by a prior response; must be round-tripped verbatim.
     */
    #[Required('encrypted_content')]
    public string $encryptedContent;

    #[Optional('stop_reason', nullable: true)]
    public ?string $stopReason;

    /**
     * `new BetaAdvisorRedactedResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAdvisorRedactedResultBlockParam::with(encryptedContent: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAdvisorRedactedResultBlockParam)->withEncryptedContent(...)
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
        ?string $stopReason = null
    ): self {
        $self = new self;

        $self['encryptedContent'] = $encryptedContent;

        null !== $stopReason && $self['stopReason'] = $stopReason;

        return $self;
    }

    /**
     * Opaque blob produced by a prior response; must be round-tripped verbatim.
     */
    public function withEncryptedContent(string $encryptedContent): self
    {
        $self = clone $this;
        $self['encryptedContent'] = $encryptedContent;

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

    public function withStopReason(?string $stopReason): self
    {
        $self = clone $this;
        $self['stopReason'] = $stopReason;

        return $self;
    }
}
