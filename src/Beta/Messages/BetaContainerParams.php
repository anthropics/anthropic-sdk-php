<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaSkillParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Container parameters with skills to be loaded.
 *
 * @phpstan-type BetaContainerParamsShape = array{
 *   id?: string|null, skills?: list<BetaSkillParams>|null
 * }
 */
final class BetaContainerParams implements BaseModel
{
    /** @use SdkModel<BetaContainerParamsShape> */
    use SdkModel;

    /**
     * Container id.
     */
    #[Optional(nullable: true)]
    public ?string $id;

    /**
     * List of skills to load in the container.
     *
     * @var list<BetaSkillParams>|null $skills
     */
    #[Optional(list: BetaSkillParams::class, nullable: true)]
    public ?array $skills;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<BetaSkillParams|array{
     *   skillID: string, type: value-of<Type>, version?: string|null
     * }>|null $skills
     */
    public static function with(?string $id = null, ?array $skills = null): self
    {
        $obj = new self;

        null !== $id && $obj['id'] = $id;
        null !== $skills && $obj['skills'] = $skills;

        return $obj;
    }

    /**
     * Container id.
     */
    public function withID(?string $id): self
    {
        $obj = clone $this;
        $obj['id'] = $id;

        return $obj;
    }

    /**
     * List of skills to load in the container.
     *
     * @param list<BetaSkillParams|array{
     *   skillID: string, type: value-of<Type>, version?: string|null
     * }>|null $skills
     */
    public function withSkills(?array $skills): self
    {
        $obj = clone $this;
        $obj['skills'] = $skills;

        return $obj;
    }
}
