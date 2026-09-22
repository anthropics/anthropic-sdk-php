<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RateLimits;

use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimit\Group;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimit\GroupType;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type GroupVariants from \Anthropic\Beta\Organization\RateLimits\OrganizationRateLimit\Group
 * @phpstan-import-type GroupShape from \Anthropic\Beta\Organization\RateLimits\OrganizationRateLimit\Group
 * @phpstan-import-type OrganizationRateLimitValueShape from \Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitValue
 *
 * @phpstan-type OrganizationRateLimitShape = array{
 *   id: string,
 *   group: GroupShape,
 *   groupType: GroupType|value-of<GroupType>,
 *   limits: list<OrganizationRateLimitValue|OrganizationRateLimitValueShape>,
 *   models: list<string>|null,
 *   type: 'rate_limit',
 * }
 */
final class OrganizationRateLimit implements BaseModel
{
    /** @use SdkModel<OrganizationRateLimitShape> */
    use SdkModel;

    /**
     * Object type. Always `rate_limit` for organization rate-limit entries.
     *
     * @var 'rate_limit' $type
     */
    #[Required(type: new ConstantOf('rate_limit'))]
    public string $type = 'rate_limit';

    /**
     * Identifier of this rate-limit entry. It is stable within the organization and differs between organizations; the group's own identifier is `group.id`.
     */
    #[Required]
    public string $id;

    /**
     * The rate-limit group this entry's limits apply to. Its `type` equals `group_type`.
     *
     * @var GroupVariants $group
     */
    #[Required(union: Group::class)]
    public OrganizationRateLimitModelGroup|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup $group;

    /**
     * @deprecated Use `group.type` instead. `group_type` is still returned and always equals `group.type`.
     *
     * Deprecated: use `group.type` instead. The kind of rate-limit group this entry represents. `model_group` entries apply to a family of models (listed in `models`); other values apply to an API-surface category and have `models` set to `null`. Always equal to `group.type`.
     *
     * @var value-of<GroupType> $groupType
     */
    #[Required('group_type', enum: GroupType::class)]
    public string $groupType;

    /**
     * The limiter values that apply to this group.
     *
     * @var list<OrganizationRateLimitValue> $limits
     */
    #[Required(list: OrganizationRateLimitValue::class)]
    public array $limits;

    /**
     * Model names this entry's limits apply to, including aliases. `null` when `group_type` is not `"model_group"`.
     *
     * @var list<string>|null $models
     */
    #[Required(list: 'string')]
    public ?array $models;

    /**
     * `new OrganizationRateLimit()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationRateLimit::with(
     *   id: ..., group: ..., groupType: ..., limits: ..., models: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationRateLimit)
     *   ->withID(...)
     *   ->withGroup(...)
     *   ->withGroupType(...)
     *   ->withLimits(...)
     *   ->withModels(...)
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
     * @param GroupShape $group
     * @param GroupType|value-of<GroupType> $groupType
     * @param list<OrganizationRateLimitValue|OrganizationRateLimitValueShape> $limits
     * @param list<string>|null $models
     */
    public static function with(
        string $id,
        OrganizationRateLimitModelGroup|array|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup $group,
        GroupType|string $groupType,
        array $limits,
        ?array $models,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['group'] = $group;
        $self['groupType'] = $groupType;
        $self['limits'] = $limits;
        $self['models'] = $models;

        return $self;
    }

    /**
     * Identifier of this rate-limit entry. It is stable within the organization and differs between organizations; the group's own identifier is `group.id`.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The rate-limit group this entry's limits apply to. Its `type` equals `group_type`.
     *
     * @param GroupShape $group
     */
    public function withGroup(
        OrganizationRateLimitModelGroup|array|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup $group,
    ): self {
        $self = clone $this;
        $self['group'] = $group;

        return $self;
    }

    /**
     * Deprecated: use `group.type` instead. The kind of rate-limit group this entry represents. `model_group` entries apply to a family of models (listed in `models`); other values apply to an API-surface category and have `models` set to `null`. Always equal to `group.type`.
     *
     * @param GroupType|value-of<GroupType> $groupType
     */
    public function withGroupType(GroupType|string $groupType): self
    {
        $self = clone $this;
        $self['groupType'] = $groupType;

        return $self;
    }

    /**
     * The limiter values that apply to this group.
     *
     * @param list<OrganizationRateLimitValue|OrganizationRateLimitValueShape> $limits
     */
    public function withLimits(array $limits): self
    {
        $self = clone $this;
        $self['limits'] = $limits;

        return $self;
    }

    /**
     * Model names this entry's limits apply to, including aliases. `null` when `group_type` is not `"model_group"`.
     *
     * @param list<string>|null $models
     */
    public function withModels(?array $models): self
    {
        $self = clone $this;
        $self['models'] = $models;

        return $self;
    }

    /**
     * Object type. Always `rate_limit` for organization rate-limit entries.
     *
     * @param 'rate_limit' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
