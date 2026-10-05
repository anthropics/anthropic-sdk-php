<?php

declare(strict_types=1);

namespace Tests\Lib\Tools;

use Anthropic\Beta\Messages\BetaTool;
use Anthropic\Core\FileParam;
use Anthropic\Lib\Tools\BetaMcp;
use Anthropic\Lib\Tools\UnsupportedMCPValueError;
use Mcp\Client;
use Mcp\Schema\Content\AudioContent;
use Mcp\Schema\Content\BlobResourceContents;
use Mcp\Schema\Content\EmbeddedResource;
use Mcp\Schema\Content\ImageContent;
use Mcp\Schema\Content\PromptMessage;
use Mcp\Schema\Content\TextContent;
use Mcp\Schema\Content\TextResourceContents;
use Mcp\Schema\Enum\Role;
use Mcp\Schema\Result\CallToolResult;
use Mcp\Schema\Result\ReadResourceResult;
use Mcp\Schema\Tool;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class BetaMcpTest extends TestCase
{
    #[Test]
    #[DataProvider('imageMediaTypes')]
    public function testImageMediaTypeVariants(string $mime, string $expected): void
    {
        $image = new ImageContent('AQID', $mime);
        $before = json_encode($image, JSON_THROW_ON_ERROR);
        $block = BetaMcp::content($image, cacheControl: ['type' => 'ephemeral']);
        $this->assertSame([
            'type' => 'image',
            'source' => ['type' => 'base64', 'data' => 'AQID', 'media_type' => $expected],
            'cache_control' => ['type' => 'ephemeral'],
        ], $block);
        $message = BetaMcp::message(new PromptMessage(Role::User, $image));
        $this->assertSame($block['source'], $message['content'][0]['source']);
        $this->assertSame($before, json_encode($image, JSON_THROW_ON_ERROR));
    }

    /** @return iterable<string, array{string, string}> */
    public static function imageMediaTypes(): iterable
    {
        foreach (['image/jpeg', 'image/png', 'image/gif', 'image/webp'] as $expected) {
            foreach ([$expected, strtoupper($expected), $expected.'; charset=binary', ' '.strtoupper($expected).' ; profile="A;B" '] as $mime) {
                yield $mime => [$mime, $expected];
            }
        }
    }

    #[Test]
    #[DataProvider('resourceMediaTypes')]
    public function testResourceMediaTypesSelectTheFirstSupportedItem(string $mime, string $expected): void
    {
        $resource = new BlobResourceContents('file:///item', $mime, base64_encode('exact bytes'));
        $result = new ReadResourceResult([
            new BlobResourceContents('file:///unknown', 'application/octet-stream', 'AA=='),
            $resource,
            new TextResourceContents('file:///fallback', 'text/plain', 'wrong item'),
        ]);
        $before = json_encode($result, JSON_THROW_ON_ERROR);
        $block = BetaMcp::resourceToContent($result, cacheControl: ['type' => 'ephemeral']);
        $source = $block['source'];
        $this->assertIsArray($source);
        $this->assertSame($expected, $source['media_type']);
        $this->assertSame('text/plain' === $expected ? 'exact bytes' : base64_encode('exact bytes'), $source['data']);
        $this->assertSame(['type' => 'ephemeral'], $block['cache_control']);
        $this->assertSame($source, BetaMcp::content(new EmbeddedResource($resource))['source']);
        $file = BetaMcp::resourceToFile(new ReadResourceResult([$resource]));
        $this->assertSame($mime, $file->contentType);
        $this->assertSame('exact bytes', $file->data);
        $this->assertSame($before, json_encode($result, JSON_THROW_ON_ERROR));
    }

    /** @return iterable<string, array{string, string}> */
    public static function resourceMediaTypes(): iterable
    {
        yield 'image' => [' IMAGE/PNG ; profile="A;B" ', 'image/png'];

        yield 'pdf' => ['Application/PDF; version=1.7', 'application/pdf'];

        yield 'text' => ['TEXT/PLAIN; charset=utf-8', 'text/plain'];

        yield 'markdown' => [' Text/Markdown ; charset=utf-8 ', 'text/plain'];
    }

    #[Test]
    public function testNormalizedMediaTypesKeepUnsupportedAndMissingBlobChecks(): void
    {
        foreach (['IMAGE/BMP; version=1', 'application/octet-stream', '', '; charset=utf-8'] as $mime) {
            try {
                BetaMcp::resourceToContent(new ReadResourceResult([new BlobResourceContents('file:///x', $mime, 'AQID')]));
                $this->fail('Unsupported resource accepted');
            } catch (UnsupportedMCPValueError $error) {
                $this->assertStringContainsString('No supported MIME type', $error->getMessage());
            }
        }
        foreach (['IMAGE/PNG; version=1', 'APPLICATION/PDF; version=1'] as $mime) {
            try {
                BetaMcp::content(new EmbeddedResource(new TextResourceContents('file:///x', $mime, 'not a blob')));
                $this->fail('Missing blob accepted');
            } catch (UnsupportedMCPValueError $error) {
                $this->assertStringContainsString('must have blob data', $error->getMessage());
            }
        }
        $block = BetaMcp::resourceToContent(new ReadResourceResult([new TextResourceContents('file:///x', null, 'default')]));
        $source = $block['source'];
        $this->assertIsArray($source);
        $this->assertSame('default', $source['data']);
    }

    #[Test]
    public function testRunnableToolReturnsNormalizedImageResults(): void
    {
        $tool = BetaMcp::tool(
            self::makeTool(name: 'image'),
            self::makeClient(fn (string $name, array $args): CallToolResult => new CallToolResult([
                new ImageContent('AQID', 'IMAGE/PNG; profile=srgb'),
            ])),
        );
        $this->assertSame([
            ['type' => 'image', 'source' => ['type' => 'base64', 'data' => 'AQID', 'media_type' => 'image/png']],
        ], $tool->run([]));
    }

    // -------------------------------------------------------------------------
    // tool()
    // -------------------------------------------------------------------------

    #[Test]
    public function testToolWrapsMcpDefinitionAsBetaRunnableTool(): void
    {
        $tool = self::makeTool(
            name: 'get_weather',
            description: 'Get the weather',
            properties: ['location' => ['type' => 'string']],
            required: ['location'],
        );

        $runnable = BetaMcp::tool(
            $tool,
            self::makeClient(
                fn (string $name, array $args): CallToolResult => new CallToolResult([new TextContent('Sunny')]),
            ),
        );

        $this->assertSame('get_weather', $runnable->name());

        /** @var BetaTool $def */
        $def = $runnable->definition;
        $this->assertSame('get_weather', $def->name);
        $this->assertSame('Get the weather', $def->description);
    }

    #[Test]
    public function testToolForwardsExtraProperties(): void
    {
        $runnable = BetaMcp::tool(
            self::makeTool(name: 'x'),
            self::makeClient(fn (string $name, array $args): CallToolResult => new CallToolResult([])),
            cacheControl: ['type' => 'ephemeral'],
            deferLoading: true,
            strict: true,
        );

        /** @var BetaTool $def */
        $def = $runnable->definition;
        $serialized = $def->jsonSerialize();
        $this->assertIsArray($serialized);

        $this->assertSame(['type' => 'ephemeral'], $serialized['cache_control']);
        $this->assertTrue($serialized['defer_loading']);
        $this->assertTrue($serialized['strict']);
    }

    #[Test]
    public function testToolRunConvertsCallToolResult(): void
    {
        $seen = [];
        $runnable = BetaMcp::tool(
            self::makeTool(name: 'echo'),
            self::makeClient(
                function (string $name, array $args) use (&$seen): CallToolResult {
                    $seen[] = [$name, $args];

                    return new CallToolResult([new TextContent('hello')]);
                },
            ),
        );

        $result = $runnable->run(['msg' => 'hi']);

        $this->assertSame([['echo', ['msg' => 'hi']]], $seen);
        $this->assertSame([['type' => 'text', 'text' => 'hello']], $result);
    }

    #[Test]
    public function testToolRunReturnsJsonForEmptyContentWithStructuredContent(): void
    {
        $runnable = BetaMcp::tool(
            self::makeTool(name: 'structured'),
            self::makeClient(
                fn (string $name, array $args): CallToolResult => new CallToolResult(
                    content: [],
                    isError: false,
                    structuredContent: ['answer' => 42],
                ),
            ),
        );

        $result = $runnable->run([]);
        $this->assertSame('{"answer":42}', $result);
    }

    #[Test]
    public function testToolRunThrowsOnIsError(): void
    {
        $runnable = BetaMcp::tool(
            self::makeTool(name: 'boom'),
            self::makeClient(
                fn (string $name, array $args): CallToolResult => CallToolResult::error([new TextContent('it broke')]),
            ),
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('it broke');

        $runnable->run([]);
    }

    // -------------------------------------------------------------------------
    // tools()
    // -------------------------------------------------------------------------

    #[Test]
    public function testToolsBatchesConversion(): void
    {
        $tools = [self::makeTool(name: 'a'), self::makeTool(name: 'b')];

        $result = BetaMcp::tools(
            $tools,
            self::makeClient(fn (string $name, array $args): CallToolResult => new CallToolResult([])),
        );

        $this->assertCount(2, $result);
        $this->assertSame('a', $result[0]->name());
        $this->assertSame('b', $result[1]->name());
    }

    // -------------------------------------------------------------------------
    // content()
    // -------------------------------------------------------------------------

    #[Test]
    public function testContentText(): void
    {
        $block = BetaMcp::content(new TextContent('hi'));
        $this->assertSame(['type' => 'text', 'text' => 'hi'], $block);
    }

    #[Test]
    public function testContentTextWithCacheControl(): void
    {
        $block = BetaMcp::content(new TextContent('hi'), cacheControl: ['type' => 'ephemeral']);
        $this->assertSame(
            ['type' => 'text', 'text' => 'hi', 'cache_control' => ['type' => 'ephemeral']],
            $block,
        );
    }

    #[Test]
    public function testContentImage(): void
    {
        $block = BetaMcp::content(new ImageContent('AAAA', 'image/png'));

        $this->assertSame([
            'type' => 'image',
            'source' => ['type' => 'base64', 'data' => 'AAAA', 'media_type' => 'image/png'],
        ], $block);
    }

    #[Test]
    public function testContentImageRejectsUnsupportedMimeType(): void
    {
        $this->expectException(UnsupportedMCPValueError::class);
        $this->expectExceptionMessage('Unsupported image MIME type: image/bmp');

        BetaMcp::content(new ImageContent('AAAA', 'image/bmp'));
    }

    #[Test]
    public function testContentAudioThrows(): void
    {
        $this->expectException(UnsupportedMCPValueError::class);
        $this->expectExceptionMessage('Unsupported MCP content type: audio');

        BetaMcp::content(new AudioContent('AAAA', 'audio/mpeg'));
    }

    #[Test]
    public function testContentEmbeddedResource(): void
    {
        $block = BetaMcp::content(new EmbeddedResource(
            new TextResourceContents('file:///readme.txt', 'text/plain', 'hello'),
        ));

        $this->assertSame([
            'type' => 'document',
            'source' => ['type' => 'text', 'data' => 'hello', 'media_type' => 'text/plain'],
        ], $block);
    }

    // -------------------------------------------------------------------------
    // message()
    // -------------------------------------------------------------------------

    #[Test]
    public function testMessageWrapsContentInArray(): void
    {
        $msg = BetaMcp::message(new PromptMessage(Role::User, new TextContent('hello')));

        $this->assertSame('user', $msg['role']);
        $this->assertSame([['type' => 'text', 'text' => 'hello']], $msg['content']);
    }

    #[Test]
    public function testMessageForwardsCacheControlToBlock(): void
    {
        $msg = BetaMcp::message(
            new PromptMessage(Role::Assistant, new TextContent('hi')),
            cacheControl: ['type' => 'ephemeral'],
        );

        $this->assertSame(['type' => 'ephemeral'], $msg['content'][0]['cache_control']);
    }

    // -------------------------------------------------------------------------
    // resourceToContent()
    // -------------------------------------------------------------------------

    #[Test]
    public function testResourceToContentPicksFirstSupportedMimeType(): void
    {
        $result = new ReadResourceResult([
            new BlobResourceContents('file:///a.bin', 'application/octet-stream', 'AAAA'),
            new TextResourceContents('file:///b.txt', 'text/plain', 'ok'),
        ]);

        $block = BetaMcp::resourceToContent($result);

        $this->assertSame([
            'type' => 'document',
            'source' => ['type' => 'text', 'data' => 'ok', 'media_type' => 'text/plain'],
        ], $block);
    }

    #[Test]
    public function testResourceToContentHandlesPdf(): void
    {
        $block = BetaMcp::resourceToContent(new ReadResourceResult([
            new BlobResourceContents('file:///doc.pdf', 'application/pdf', 'PDFBASE64'),
        ]));

        $this->assertSame([
            'type' => 'document',
            'source' => [
                'type' => 'base64',
                'data' => 'PDFBASE64',
                'media_type' => 'application/pdf',
            ],
        ], $block);
    }

    #[Test]
    public function testResourceToContentHandlesImage(): void
    {
        $block = BetaMcp::resourceToContent(new ReadResourceResult([
            new BlobResourceContents('file:///p.png', 'image/png', 'IMGDATA'),
        ]));

        $this->assertSame([
            'type' => 'image',
            'source' => ['type' => 'base64', 'data' => 'IMGDATA', 'media_type' => 'image/png'],
        ], $block);
    }

    #[Test]
    public function testResourceToContentDecodesTextBlob(): void
    {
        $block = BetaMcp::resourceToContent(new ReadResourceResult([
            new BlobResourceContents('file:///readme.txt', 'text/plain', base64_encode('hello')),
        ]));

        /** @var array<string, mixed> $source */
        $source = $block['source'];
        $this->assertSame('hello', $source['data']);
    }

    #[Test]
    public function testResourceToContentThrowsOnEmpty(): void
    {
        $this->expectException(UnsupportedMCPValueError::class);
        BetaMcp::resourceToContent(new ReadResourceResult([]));
    }

    #[Test]
    public function testResourceToContentThrowsIfImageResourceIsText(): void
    {
        $this->expectException(UnsupportedMCPValueError::class);
        $this->expectExceptionMessage('Image resource must have blob data');

        BetaMcp::resourceToContent(new ReadResourceResult([
            new TextResourceContents('file:///p.png', 'image/png', 'not-binary'),
        ]));
    }

    #[Test]
    public function testResourceToContentThrowsWhenNoSupportedMimeType(): void
    {
        $this->expectException(UnsupportedMCPValueError::class);
        $this->expectExceptionMessage('No supported MIME type found');

        BetaMcp::resourceToContent(new ReadResourceResult([
            new BlobResourceContents('file:///a.bin', 'application/octet-stream', 'AAAA'),
        ]));
    }

    // -------------------------------------------------------------------------
    // resourceToFile()
    // -------------------------------------------------------------------------

    #[Test]
    public function testResourceToFileFromTextResource(): void
    {
        $file = BetaMcp::resourceToFile(new ReadResourceResult([
            new TextResourceContents('file:///notes/readme.txt', 'text/plain', 'hello world'),
        ]));

        $this->assertSame('readme.txt', $file->filename);
        $this->assertSame('text/plain', $file->contentType);
        $this->assertSame('hello world', $file->data);
    }

    #[Test]
    public function testResourceToFileFromBlobResource(): void
    {
        $bytes = "\x00\x01\x02hello";
        $file = BetaMcp::resourceToFile(new ReadResourceResult([
            new BlobResourceContents(
                'file:///binary/data.bin',
                'application/octet-stream',
                base64_encode($bytes),
            ),
        ]));

        $this->assertSame('data.bin', $file->filename);
        $this->assertSame('application/octet-stream', $file->contentType);
        $this->assertSame($bytes, $file->data);
    }

    #[Test]
    public function testResourceToFileDefaultsFilenameAndMimeType(): void
    {
        $file = BetaMcp::resourceToFile(new ReadResourceResult([
            new TextResourceContents('', null, 'x'),
        ]));

        $this->assertSame('file', $file->filename);
        $this->assertSame(FileParam::DEFAULT_CONTENT_TYPE, $file->contentType);
    }

    #[Test]
    public function testResourceToFileThrowsOnEmpty(): void
    {
        $this->expectException(UnsupportedMCPValueError::class);
        BetaMcp::resourceToFile(new ReadResourceResult([]));
    }

    /**
     * Build a minimal `Mcp\Client` subclass that overrides `callTool`. Skips the
     * real constructor (Protocol/Configuration aren't needed when callTool is
     * overridden) so tests don't need a transport.
     *
     * @param \Closure(string, array<string, mixed>): CallToolResult $fn
     */
    private static function makeClient(\Closure $fn): Client
    {
        return new class($fn) extends Client {
            /**
             * @param \Closure(string, array<string, mixed>): CallToolResult $fn
             */
            public function __construct(private readonly \Closure $fn)
            {
                // Intentionally skip parent::__construct — overriding callTool means
                // Protocol/Configuration are never touched.
            }

            public function callTool(string $name, array $arguments = [], ?callable $onProgress = null): CallToolResult
            {
                return ($this->fn)($name, $arguments);
            }
        };
    }

    /**
     * @param array<string, mixed> $properties
     * @param list<string>|null $required
     */
    private static function makeTool(
        string $name = 'noop',
        ?string $description = null,
        array $properties = [],
        ?array $required = null,
    ): Tool {
        return new Tool(
            name: $name,
            title: null,
            inputSchema: ['type' => 'object', 'properties' => $properties, 'required' => $required],
            description: $description,
            annotations: null,
        );
    }
}
