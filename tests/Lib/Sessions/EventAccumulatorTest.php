<?php

declare(strict_types=1);

namespace Tests\Lib\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsAgentMessagePreview;
use Anthropic\Beta\Sessions\BetaManagedAgentsAgentThinkingPreview;
use Anthropic\Beta\Sessions\BetaManagedAgentsDeltaContent;
use Anthropic\Beta\Sessions\BetaManagedAgentsDeltaEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsStartEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Lib\Sessions\EventAccumulator;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class EventAccumulatorTest extends TestCase
{
    #[Test]
    public function eventStartReturnsFreshEmptySnapshotFromNull(): void
    {
        $msg = self::seed('evt_1');

        self::assertSame('evt_1', $msg->id);
        self::assertSame([], $msg->content);
        self::assertSame(0, $msg->processedAt->getTimestamp());
    }

    #[Test]
    public function eventStartForThinkingPreviewReturnsAccumulatedUnchanged(): void
    {
        $start = BetaManagedAgentsStartEvent::with(
            event: BetaManagedAgentsAgentThinkingPreview::with(id: 'evt_1', type: 'agent.thinking'),
            type: 'event_start',
        );

        self::assertNull(EventAccumulator::accumulate(null, $start));

        $msg = self::seed('evt_1');
        self::assertSame($msg, EventAccumulator::accumulate($msg, $start));
    }

    #[Test]
    public function newIndexInsertsFreshBlock(): void
    {
        $msg = self::fold(self::seed('evt_1'), self::delta('evt_1', 'Hello', 0));

        self::assertTexts(['Hello'], $msg);
    }

    #[Test]
    public function existingTextIndexAppends(): void
    {
        $msg = self::seed('evt_1');
        $msg = self::fold($msg, self::delta('evt_1', 'Hel', 0));
        $msg = self::fold($msg, self::delta('evt_1', 'lo', 0));
        $msg = self::fold($msg, self::delta('evt_1', 'World', 1));

        self::assertTexts(['Hello', 'World'], $msg);
    }

    #[Test]
    public function defaultsIndexToZero(): void
    {
        $msg = self::seed('evt_1');
        $msg = self::fold($msg, self::delta('evt_1', 'a'));
        $msg = self::fold($msg, self::delta('evt_1', 'b'));

        self::assertTexts(['ab'], $msg);
    }

    #[Test]
    public function throwsOnIndexGap(): void
    {
        $msg = self::seed('evt_1');

        $this->expectException(AnthropicException::class);
        $this->expectExceptionMessage('event_delta index 2 is beyond the end of content (length 0)');

        EventAccumulator::accumulate($msg, self::delta('evt_1', 'x', 2));
    }

    #[Test]
    public function throwsOnNegativeIndex(): void
    {
        $msg = self::fold(self::seed('evt_1'), self::delta('evt_1', 'x', 0));

        $this->expectException(AnthropicException::class);
        $this->expectExceptionMessage('event_delta index -1 is beyond the end of content (length 1)');

        EventAccumulator::accumulate($msg, self::delta('evt_1', 'y', -1));
    }

    #[Test]
    public function throwsOnDeltaWithNoPriorSnapshot(): void
    {
        $this->expectException(AnthropicException::class);
        $this->expectExceptionMessage('event_delta for evt_1 received before its event_start');

        EventAccumulator::accumulate(null, self::delta('evt_1', 'x', 0));
    }

    #[Test]
    public function nextSequentialIndexInserts(): void
    {
        $msg = self::seed('evt_1');
        $msg = self::fold($msg, self::delta('evt_1', 'a', 0));
        $msg = self::fold($msg, self::delta('evt_1', 'b', 1));

        self::assertTexts(['a', 'b'], $msg);
    }

    #[Test]
    public function returnsNewSnapshotAndDoesNotMutateInput(): void
    {
        $msg = self::seed('evt_1');
        $next = self::fold($msg, self::delta('evt_1', 'x', 0));

        self::assertNotSame($msg, $next);
        self::assertSame([], $msg->content);

        $after = self::fold($next, self::delta('evt_1', 'y', 0));

        self::assertNotSame($next->content[0], $after->content[0]);
        self::assertTexts(['x'], $next);
        self::assertTexts(['xy'], $after);
    }

    #[Test]
    public function doesNotMutateWireDeltaWhenInsertingAtNewIndex(): void
    {
        $d = self::delta('evt_1', 'x', 0);
        $msg = self::fold(self::seed('evt_1'), $d);
        self::fold($msg, self::delta('evt_1', 'y', 0));

        self::assertSame('x', $d->delta->content->text);
    }

    #[Test]
    public function agentMessageReplacesPreviewWithFinalEvent(): void
    {
        $msg = self::fold(self::seed('evt_1'), self::delta('evt_1', 'partial', 0));
        $final = self::finalMessage('evt_1', 'complete');

        $result = EventAccumulator::accumulate($msg, $final);

        self::assertSame($final, $result);
        self::assertTexts(['complete'], $result);
    }

    #[Test]
    public function agentMessageAcceptsNullSnapshot(): void
    {
        $final = self::finalMessage('evt_1', 'complete');

        self::assertSame($final, EventAccumulator::accumulate(null, $final));
    }

    #[Test]
    public function stragglerDeltaAfterCanonicalEventIsDropped(): void
    {
        $final = self::finalMessage('evt_1', 'complete');
        $msg = EventAccumulator::accumulate($final, self::delta('evt_1', 'straggler', 0));

        self::assertSame($final, $msg);
        self::assertTexts(['complete'], $final);
    }

    #[Test]
    public function eventStartAfterCanonicalEventKeepsCanonical(): void
    {
        $final = self::finalMessage('evt_1', 'complete');
        $start = BetaManagedAgentsStartEvent::with(
            event: BetaManagedAgentsAgentMessagePreview::with(id: 'evt_1', type: 'agent.message'),
            type: 'event_start',
        );

        self::assertSame($final, EventAccumulator::accumulate($final, $start));
    }

    #[Test]
    public function closeOpenPreviewsDropsOpenPreviewsAndKeepsCanonical(): void
    {
        $messages = [
            'evt_1' => self::fold(self::seed('evt_1'), self::delta('evt_1', 'partial', 0)),
            'evt_2' => self::finalMessage('evt_2', 'complete'),
        ];

        $closed = EventAccumulator::closeOpenPreviews($messages);

        self::assertSame(['evt_2'], array_keys($closed));
        self::assertSame($messages['evt_2'], $closed['evt_2']);
    }

    #[Test]
    public function closeOpenPreviewsDropsUndeltaedSeeds(): void
    {
        $closed = EventAccumulator::closeOpenPreviews(['evt_1' => self::seed('evt_1')]);

        self::assertSame([], $closed);
    }

    #[Test]
    public function unknownFragmentTypeOnExistingIndexIsNoOp(): void
    {
        $block = ManagedAgentsTextBlock::with(text: 'kept', type: 'text');
        $block['type'] = 'tool_use'; // a future, non-text block type
        $msg = self::seed('evt_1')->withContent([$block]);

        $next = EventAccumulator::accumulate($msg, self::delta('evt_1', 'ignored', 0));

        self::assertNotNull($next);
        self::assertSame('kept', $next->content[0]->text);
        self::assertSame('tool_use', $next->content[0]['type']);
    }

    private static function seed(string $eventID): ManagedAgentsAgentMessageEvent
    {
        $msg = EventAccumulator::accumulate(null, BetaManagedAgentsStartEvent::with(
            event: BetaManagedAgentsAgentMessagePreview::with(id: $eventID, type: 'agent.message'),
            type: 'event_start',
        ));
        self::assertNotNull($msg);

        return $msg;
    }

    private static function fold(
        ManagedAgentsAgentMessageEvent $msg,
        BetaManagedAgentsDeltaEvent $event,
    ): ManagedAgentsAgentMessageEvent {
        $next = EventAccumulator::accumulate($msg, $event);
        self::assertNotNull($next);

        return $next;
    }

    private static function delta(string $eventID, string $text, ?int $index = null): BetaManagedAgentsDeltaEvent
    {
        return BetaManagedAgentsDeltaEvent::with(
            delta: BetaManagedAgentsDeltaContent::with(
                content: ManagedAgentsTextBlock::with(text: $text, type: 'text'),
                type: 'content_delta',
                index: $index,
            ),
            eventID: $eventID,
            type: 'event_delta',
        );
    }

    private static function finalMessage(string $eventID, string $text): ManagedAgentsAgentMessageEvent
    {
        return ManagedAgentsAgentMessageEvent::with(
            id: $eventID,
            content: [ManagedAgentsTextBlock::with(text: $text, type: 'text')],
            processedAt: new \DateTimeImmutable('2024-01-01T00:00:00Z'),
            type: 'agent.message',
        );
    }

    /**
     * @param list<string> $texts
     */
    private static function assertTexts(array $texts, ManagedAgentsAgentMessageEvent $msg): void
    {
        $actual = array_map(
            static fn (ManagedAgentsTextBlock $block): string => $block->text,
            $msg->content,
        );
        self::assertSame($texts, $actual);
    }
}
