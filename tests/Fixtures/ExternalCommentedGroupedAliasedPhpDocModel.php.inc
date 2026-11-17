<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
use Anthropic\Lib\Contracts\StructuredOutputModel;
use Tests\Core\{NestedAddress, /* documented alias */ SkillItem as PayloadItem};

class ExternalCommentedGroupedAliasedPhpDocModel implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    /** @var array<PayloadItem> */
    public array $skills;
}
