<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A tool as an MCP server lists it: its name on that server, its
 * description, and its input schema.
 *
 * @phpstan-type BetaMCPToolParamShape = array{
 *   inputSchema: array<string,mixed>, name: string, description?: string|null
 * }
 */
final class BetaMCPToolParam implements BaseModel
{
    /** @use SdkModel<BetaMCPToolParamShape> */
    use SdkModel;

    /**
     * The tool's input schema as the MCP server lists it, verbatim.
     *
     * @var array<string,mixed> $inputSchema
     */
    #[Required('input_schema', map: 'mixed')]
    public array $inputSchema;

    /**
     * The tool's name as the MCP server lists it (not prefixed with the server name).
     */
    #[Required]
    public string $name;

    /**
     * The tool's description as the MCP server lists it.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * `new BetaMCPToolParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMCPToolParam::with(inputSchema: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMCPToolParam)->withInputSchema(...)->withName(...)
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
     * @param array<string,mixed> $inputSchema
     */
    public static function with(
        array $inputSchema,
        string $name,
        ?string $description = null
    ): self {
        $self = new self;

        $self['inputSchema'] = $inputSchema;
        $self['name'] = $name;

        null !== $description && $self['description'] = $description;

        return $self;
    }

    /**
     * The tool's input schema as the MCP server lists it, verbatim.
     *
     * @param array<string,mixed> $inputSchema
     */
    public function withInputSchema(array $inputSchema): self
    {
        $self = clone $this;
        $self['inputSchema'] = $inputSchema;

        return $self;
    }

    /**
     * The tool's name as the MCP server lists it (not prefixed with the server name).
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * The tool's description as the MCP server lists it.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }
}
