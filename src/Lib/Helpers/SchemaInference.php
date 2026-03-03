<?php

declare(strict_types=1);

namespace Anthropic\Lib\Helpers;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Lib\Attributes\Constrained;
use Anthropic\Lib\Contracts\StructuredOutputModel;

/**
 * Infers JSON schema from PHP type hints and attributes.
 *
 * This class handles the conversion from PHP class definitions to JSON schema,
 * including:
 * - Type inference from PHP type hints
 * - Constraint handling (supported vs unsupported)
 * - Moving unsupported constraints to description
 * - Nested model resolution
 *
 * @internal
 */
final class SchemaInference
{
    /**
     * String formats supported by the Anthropic API.
     *
     * @var list<string>
     */
    private const SUPPORTED_FORMATS = [
        'date-time',
        'time',
        'date',
        'duration',
        'email',
        'hostname',
        'uri',
        'ipv4',
        'ipv6',
        'uuid',
    ];

    /**
     * Infers JSON schema type from PHP type hint.
     *
     * @return array{type: string|null, required: bool, phpType: string|null}
     */
    public static function inferFromProperty(\ReflectionProperty $property): array
    {
        $type = $property->getType();

        if (null === $type) {
            return ['type' => null, 'required' => true, 'phpType' => null];
        }

        $required = true;
        $phpType = null;

        // Handle union types (e.g., string|null)
        if ($type instanceof \ReflectionUnionType) {
            $types = $type->getTypes();
            $required = !$type->allowsNull();

            // Get the first non-null type
            foreach ($types as $unionType) {
                if ($unionType instanceof \ReflectionNamedType && 'null' !== $unionType->getName()) {
                    $phpType = $unionType->getName();

                    break;
                }
            }
        } elseif ($type instanceof \ReflectionNamedType) {
            $required = !$type->allowsNull();
            $phpType = $type->getName();
        }

        $jsonType = self::phpTypeToJsonType($phpType ?? 'string');

        return [
            'type' => $jsonType,
            'required' => $required,
            'phpType' => $phpType,
        ];
    }

    /**
     * Builds a complete JSON schema property from reflection and attributes.
     *
     * This method:
     * 1. Infers type from PHP type hints
     * 2. Extracts enum values from #[Required]/#[Optional] attribute
     * 3. Extracts default from #[Optional] attribute (or PHP default value)
     * 4. Extracts schema fields from #[Constrained] attribute (description, format, const, itemClass, minItems)
     * 5. Extracts validation constraints from #[Constrained] (minimum, maximum, etc.)
     * 6. Moves unsupported constraints to description
     * 7. Handles nested models and arrays
     *
     * @return array{schema: array<string, mixed>, required: bool, unsupportedConstraints: array<string, mixed>}
     */
    public static function buildPropertySchema(\ReflectionProperty $property): array
    {
        // Get inferred info from PHP types
        $inferred = self::inferFromProperty($property);

        $schema = null !== $inferred['type'] ? ['type' => $inferred['type']] : [];
        $required = $inferred['required'];
        $unsupportedConstraints = [];

        // #[Required]/#[Optional] attribute is optional — provides enum values and (for Optional) default
        $requiredAttributes = $property->getAttributes(Required::class, \ReflectionAttribute::IS_INSTANCEOF);
        $attr = !empty($requiredAttributes) ? $requiredAttributes[0]->newInstance() : null;

        // #[Constrained] attribute is optional — provides description, format, const, itemClass, minItems, and validation constraints
        $constraintAttributes = $property->getAttributes(Constrained::class);
        $constraint = !empty($constraintAttributes) ? $constraintAttributes[0]->newInstance() : null;

        // Check if PHP type is a class that implements StructuredOutputModel (for nested objects)
        $phpType = $inferred['phpType'];
        if (null !== $phpType && class_exists($phpType) && is_subclass_of($phpType, StructuredOutputModel::class)) {
            $schema = StructuredOutput::toJsonSchema($phpType);

            // Keep the required status from type inference
            return ['schema' => $schema, 'required' => $required, 'unsupportedConstraints' => []];
        }

        // Start building description from #[Constrained]
        $description = (null !== $constraint && null !== $constraint->description && '' !== $constraint->description)
            ? $constraint->description
            : null;

        // Collect validation-only constraints from #[Constrained]
        if (null !== $constraint) {
            if (null !== $constraint->minLength) {
                $unsupportedConstraints['minLength'] = $constraint->minLength;
            }
            if (null !== $constraint->maxLength) {
                $unsupportedConstraints['maxLength'] = $constraint->maxLength;
            }
            if (null !== $constraint->minimum) {
                $unsupportedConstraints['minimum'] = $constraint->minimum;
            }
            if (null !== $constraint->maximum) {
                $unsupportedConstraints['maximum'] = $constraint->maximum;
            }
            if (null !== $constraint->multipleOf) {
                $unsupportedConstraints['multipleOf'] = $constraint->multipleOf;
            }
        }

        // Handle string format from #[Constrained] (SUPPORTED - filter to valid formats)
        if (null !== $constraint && null !== $constraint->format) {
            if (in_array($constraint->format, self::SUPPORTED_FORMATS, true)) {
                $schema['format'] = $constraint->format;
            } else {
                // Unsupported format — move to description
                $unsupportedConstraints['format'] = $constraint->format;
            }
        }

        // Handle enum from #[Required]/#[Optional] (SUPPORTED)
        if (null !== $attr && null !== $attr->enumValues) {
            $schema['enum'] = $attr->enumValues;
        }

        // Handle const from #[Constrained] (SUPPORTED)
        if (null !== $constraint && null !== $constraint->const) {
            $schema['const'] = $constraint->const;
        }

        // Handle default: first check #[Optional] attribute, then fall back to PHP default value
        if ($attr instanceof Optional && null !== $attr->default) {
            $schema['default'] = $attr->default;
        } elseif ($property->hasDefaultValue()) {
            $defaultValue = $property->getDefaultValue();
            // Include non-null defaults (null defaults are typically just for nullable types)
            if (null !== $defaultValue) {
                $schema['default'] = $defaultValue;
            }
        }

        // Array configuration
        if ('array' === $inferred['type']) {
            // Resolve item class: first from #[Constrained] itemClass, then from PHPDoc
            $itemClass = null !== $constraint ? $constraint->itemClass : null;

            if (null === $itemClass) {
                $itemClass = self::inferItemClassFromDocComment($property);
            }

            if (null !== $itemClass && class_exists($itemClass) && is_subclass_of($itemClass, StructuredOutputModel::class)) {
                $schema['items'] = StructuredOutput::toJsonSchema($itemClass);
            }

            // Handle minItems from #[Constrained] (SUPPORTED for 0 and 1 only)
            if (null !== $constraint && null !== $constraint->minItems) {
                if ($constraint->minItems <= 1) {
                    $schema['minItems'] = $constraint->minItems;
                } else {
                    // minItems > 1 is not supported — move to description
                    $unsupportedConstraints['minItems'] = $constraint->minItems;
                }
            }
        }

        // Append unsupported constraints to description if any exist
        if (!empty($unsupportedConstraints)) {
            $constraintsJson = json_encode($unsupportedConstraints, JSON_UNESCAPED_SLASHES);
            if (null !== $description) {
                $description .= "\n\n".$constraintsJson;
            } else {
                $description = $constraintsJson;
            }
        }

        // Set description if we have one
        if (null !== $description) {
            $schema['description'] = $description;
        }

        return ['schema' => $schema, 'required' => $required, 'unsupportedConstraints' => $unsupportedConstraints];
    }

    /**
     * Converts PHP type to JSON schema type.
     */
    private static function phpTypeToJsonType(string $phpType): string
    {
        return match ($phpType) {
            'int' => 'integer',
            'float' => 'number',
            'bool' => 'boolean',
            'array' => 'array',
            'string' => 'string',
            'null' => 'null',
            default => 'object',
        };
    }

    /**
     * Infers the array item class from PHPDoc @var annotation.
     *
     * Supports patterns like:
     * - @var ClassName[]
     * - @var array<ClassName>
     *
     * @return class-string|null The fully qualified class name, or null if not found
     */
    private static function inferItemClassFromDocComment(\ReflectionProperty $property): ?string
    {
        $docComment = $property->getDocComment();
        if (false === $docComment) {
            return null;
        }

        // Match @var ClassName[] or @var array<ClassName>
        // Pattern 1: @var ClassName[]
        if (preg_match('/@var\s+([\\\a-zA-Z_][\\\a-zA-Z0-9_]*)\[\]/', $docComment, $matches)) {
            return self::resolveClassName($matches[1], $property);
        }

        // Pattern 2: @var array<ClassName>
        if (preg_match('/@var\s+array<([\\\a-zA-Z_][\\\a-zA-Z0-9_]*)>/', $docComment, $matches)) {
            return self::resolveClassName($matches[1], $property);
        }

        return null;
    }

    /**
     * Resolves a class name to its fully qualified form.
     *
     * @param string $className The class name from the doc comment
     * @param \ReflectionProperty $property The property for namespace context
     *
     * @return class-string|null The fully qualified class name, or null if not resolvable
     */
    private static function resolveClassName(string $className, \ReflectionProperty $property): ?string
    {
        // Already fully qualified
        if (str_starts_with($className, '\\')) {
            $fqcn = ltrim($className, '\\');

            return class_exists($fqcn) ? $fqcn : null;
        }

        // Try the declaring class's namespace
        $declaringClass = $property->getDeclaringClass();
        $namespace = $declaringClass->getNamespaceName();

        if ('' !== $namespace) {
            $fqcn = $namespace.'\\'.$className;
            if (class_exists($fqcn)) {
                return $fqcn;
            }
        }

        // Try as a global class
        if (class_exists($className)) {
            return $className;
        }

        return null;
    }
}
