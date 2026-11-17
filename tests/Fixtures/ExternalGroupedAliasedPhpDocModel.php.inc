<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
use Anthropic\Lib\Contracts\StructuredOutputModel;
use Tests\Core\{NestedAddress, SkillItem as PayloadItem};

class ExternalGroupedAliasedPhpDocModel implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    /** @var array<PayloadItem> */
    public array $skills;
}
