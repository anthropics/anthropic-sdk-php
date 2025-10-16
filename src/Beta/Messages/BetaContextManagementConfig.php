<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_context_management_config = array{
 *   edits?: list<BetaClearToolUses20250919Edit>
 * }
 */
final class BetaContextManagementConfig implements BaseModel
{
    /** @use SdkModel<beta_context_management_config> */
    use SdkModel;

    /**
     * List of context management edits to apply.
     *
     * @var list<BetaClearToolUses20250919Edit>|null $edits
     */
    #[Api(list: BetaClearToolUses20250919Edit::class, optional: true)]
    public ?array $edits;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<BetaClearToolUses20250919Edit> $edits
     */
    public static function with(?array $edits = null): self
    {
        $obj = new self;

        null !== $edits && $obj->edits = $edits;

        return $obj;
    }

    /**
     * List of context management edits to apply.
     *
     * @param list<BetaClearToolUses20250919Edit> $edits
     */
    public function withEdits(array $edits): self
    {
        $obj = clone $this;
        $obj->edits = $edits;

        return $obj;
    }
}
