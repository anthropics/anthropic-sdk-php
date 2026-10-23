<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Confirms that a Bundle was detached.
 *
 * @phpstan-type BetaClaudeTagDeletedBundleTargetShape = array{
 *   id: string, type: 'bundle_target_deleted'
 * }
 */
final class BetaClaudeTagDeletedBundleTarget implements BaseModel
{
    /** @use SdkModel<BetaClaudeTagDeletedBundleTargetShape> */
    use SdkModel;

    /** @var 'bundle_target_deleted' $type */
    #[Required(type: new ConstantOf('bundle_target_deleted'))]
    public string $type = 'bundle_target_deleted';

    /**
     * The identifier the Bundle Target had.
     */
    #[Required]
    public string $id;

    /**
     * `new BetaClaudeTagDeletedBundleTarget()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClaudeTagDeletedBundleTarget::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClaudeTagDeletedBundleTarget())->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    /**
     * The identifier the Bundle Target had.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'bundle_target_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
