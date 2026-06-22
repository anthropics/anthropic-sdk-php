<?php

declare(strict_types=1);

namespace Tests\Lib\Helpers;

use Anthropic\Lib\Helpers\StainlessHelperHeader;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class StainlessHelperHeaderTest extends TestCase
{
    #[Test]
    public function appendsToEmpty(): void
    {
        self::assertSame(
            'BetaToolRunner',
            StainlessHelperHeader::mergedValue([], StainlessHelperHeader::BETA_TOOL_RUNNER),
        );
    }

    #[Test]
    public function appendsToExisting(): void
    {
        self::assertSame(
            'mcp_tool, BetaToolRunner',
            StainlessHelperHeader::mergedValue(
                [StainlessHelperHeader::HEADER => 'mcp_tool'],
                StainlessHelperHeader::BETA_TOOL_RUNNER,
            ),
        );
    }

    #[Test]
    public function dedups(): void
    {
        self::assertSame(
            'BetaToolRunner',
            StainlessHelperHeader::mergedValue(
                [StainlessHelperHeader::HEADER => 'BetaToolRunner'],
                StainlessHelperHeader::BETA_TOOL_RUNNER,
            ),
        );
    }

    #[Test]
    public function collapsesCasingsAndMultiValues(): void
    {
        self::assertSame(
            'a, b, c, BetaToolRunner',
            StainlessHelperHeader::mergedValue(
                ['X-Stainless-Helper' => 'a', StainlessHelperHeader::HEADER => ['b, c']],
                StainlessHelperHeader::BETA_TOOL_RUNNER,
            ),
        );
    }
}
