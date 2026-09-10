<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The resolved permission_policy was always_ask; accompanies evaluated_permission "ask".
 *
 * @phpstan-type ManagedAgentsAgentToolEvaluationAlwaysAskShape = array{
 *   type: 'always_ask'
 * }
 */
final class ManagedAgentsAgentToolEvaluationAlwaysAsk implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentToolEvaluationAlwaysAskShape> */
    use SdkModel;

    /** @var 'always_ask' $type */
    #[Required]
    public string $type = 'always_ask';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'always_ask' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
