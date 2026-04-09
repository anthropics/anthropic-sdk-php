<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaAdvisorRedactedResultBlockShape = array{
 *   encryptedContent: string, type: 'advisor_redacted_result'
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
     * `new BetaAdvisorRedactedResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAdvisorRedactedResultBlock::with(encryptedContent: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAdvisorRedactedResultBlock)->withEncryptedContent(...)
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
    public static function with(string $encryptedContent): self
    {
        $self = new self;

        $self['encryptedContent'] = $encryptedContent;

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
     * @param 'advisor_redacted_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
