<?php

declare(strict_types=1);

namespace Anthropic\Lib\Helpers;

use Anthropic\Lib\Contracts\StructuredOutputModel;
use Anthropic\Messages\JSONOutputFormat;

/**
 * Helper class for working with structured output models.
 *
 * This class provides utilities to:
 * - Convert StructuredOutputModel classes to JSON schemas
 * - Transform schemas for API compatibility (removing unsupported constraints)
 * - Extract and process structured output models from API requests
 * - Parse and validate API responses back into model instances
 *
 * ## Schema Transformation
 *
 * When converting a model to JSON schema, this class:
 * 1. Converts PHP type hints and attributes to JSON schema
 * 2. Removes unsupported constraints (minimum, maximum, minLength, maxLength, etc.)
 * 3. Appends removed constraints to property descriptions as JSON
 * 4. Adds `additionalProperties: false` to all objects
 * 5. Filters string formats to supported values
 *
 * ## Response Validation
 *
 * When parsing responses, this class validates against the original constraints
 * (including those that were removed from the API schema) and reports violations.
 *
 * @internal
 */
final class StructuredOutput
{
    /**
     * Extracts structured output models from request parameters and converts them to JSON schemas.
     *
     * This method:
     * 1. Finds StructuredOutputModel classes in the outputConfig parameter
     * 2. Converts them to JSON schemas (transforming for API compatibility)
     * 3. Returns the model class for later parsing
     *
     * @param array<string, mixed> $params The request parameters (modified in place)
     *
     * @return class-string<StructuredOutputModel>|null The model class if found, null otherwise
     */
    public static function distillInputSchemas(array &$params): ?string
    {
        // Check if outputConfig.format is a StructuredOutputModel class
        if (isset($params['outputConfig']) && is_array($params['outputConfig'])) {
            $format = $params['outputConfig']['format'] ?? null;

            // If format is a class string that extends StructuredOutputModel
            if (is_string($format) && class_exists($format) && is_subclass_of($format, StructuredOutputModel::class)) {
                $schema = self::toJsonSchema($format);

                // Replace the class with the JSON schema format
                $params['outputConfig']['format'] = JSONOutputFormat::with(schema: $schema);

                return $format;
            }
        }

        return null;
    }

    /**
     * Converts a StructuredOutputModel class to a JSON schema array.
     *
     * The schema is transformed for API compatibility:
     * - Unsupported constraints are removed and moved to descriptions
     * - `additionalProperties: false` is added to all objects
     *
     * @param class-string<StructuredOutputModel> $modelClass
     *
     * @return array<string, mixed> The JSON schema
     */
    public static function toJsonSchema(string $modelClass): array
    {
        $reflection = new \ReflectionClass($modelClass);
        $properties = [];
        $required = [];

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->isStatic()) {
                continue;
            }

            // Use schema inference to build property schema
            $result = SchemaInference::buildPropertySchema($property);
            $propertyName = $property->getName();

            $properties[$propertyName] = $result['schema'];

            if ($result['required']) {
                $required[] = $propertyName;
            }
        }

        $jsonSchema = [
            'type' => 'object',
            'properties' => $properties,
        ];

        if (!empty($required)) {
            $jsonSchema['required'] = $required;
        }

        // Always add additionalProperties: false for objects
        $jsonSchema['additionalProperties'] = false;

        // Add model description if available
        $description = $modelClass::description();
        if (null !== $description) {
            $jsonSchema['description'] = $description;
        }

        return $jsonSchema;
    }

    /**
     * Parses API response content blocks and adds parsed data when a model class is available.
     *
     * This method looks for text blocks in the response and attempts to parse the JSON
     * into instances of the model class. It also validates the data against original
     * constraints that were removed from the API schema.
     *
     * @param array<string, mixed> $content The content array from the API response (modified in place)
     * @param class-string<StructuredOutputModel>|null $modelClass The model class to parse into
     */
    public static function parseResponseContent(array &$content, ?string $modelClass): void
    {
        if (null === $modelClass) {
            return;
        }

        foreach ($content as &$block) {
            if (!is_array($block)) {
                continue;
            }

            // Look for text blocks (which contain the JSON output for structured outputs)
            if (($block['type'] ?? null) === 'text' && isset($block['text']) && is_string($block['text'])) {
                try {
                    $json = json_decode($block['text'], true, 512, JSON_THROW_ON_ERROR);

                    if (!is_array($json)) {
                        throw new \RuntimeException('Expected JSON object, got '.gettype($json));
                    }

                    /** @var array<string, mixed> $jsonData */
                    $jsonData = $json;

                    // Validate against original constraints
                    $violations = self::validateAgainstConstraints($jsonData, $modelClass);

                    $parsed = $modelClass::fromArray($jsonData);
                    $block['parsed'] = $parsed;

                    // Store validation violations if any
                    if (!empty($violations)) {
                        $block['validation_warnings'] = $violations;
                    }
                } catch (\Exception $e) {
                    // If parsing fails, store the error
                    $block['parsed'] = ['error' => $e->getMessage()];
                }
            }
        }
    }

    /**
     * Validates data against the original constraints that were removed from the API schema.
     *
     * @param array<string, mixed> $data The parsed JSON data
     * @param class-string<StructuredOutputModel> $modelClass The model class
     *
     * @return array<string, string> Array of property names to violation messages
     */
    public static function validateAgainstConstraints(array $data, string $modelClass): array
    {
        $violations = [];

        $constraints = self::getConstraintsForModel($modelClass);

        foreach ($constraints as $propertyName => $propConstraints) {
            if (!is_array($propConstraints)) {
                continue;
            }

            /** @var array<string, mixed> $typedConstraints */
            $typedConstraints = $propConstraints;

            if (!array_key_exists($propertyName, $data)) {
                continue;
            }

            $value = $data[$propertyName];
            $propViolations = self::validateValue($value, $typedConstraints);

            if (!empty($propViolations)) {
                $violations[$propertyName] = implode('; ', $propViolations);
            }
        }

        return $violations;
    }

    /**
     * Extracts unsupported constraints from a model class.
     *
     * @param class-string<StructuredOutputModel> $modelClass
     *
     * @return array<string, mixed>
     */
    public static function getConstraintsForModel(string $modelClass): array
    {
        $reflection = new \ReflectionClass($modelClass);
        $allConstraints = [];

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $result = SchemaInference::buildPropertySchema($property);
            $propertyName = $property->getName();

            if (!empty($result['unsupportedConstraints'])) {
                $allConstraints[$propertyName] = $result['unsupportedConstraints'];
            }
        }

        return $allConstraints;
    }

    /**
     * Validates a single value against constraints.
     *
     * @param mixed $value The value to validate
     * @param array<string, mixed> $constraints The constraints to validate against
     *
     * @return array<string> Array of violation messages
     */
    private static function validateValue(mixed $value, array $constraints): array
    {
        $violations = [];

        // String length constraints
        if (is_string($value)) {
            $minLength = $constraints['minLength'] ?? null;
            $maxLength = $constraints['maxLength'] ?? null;

            if (is_int($minLength) && strlen($value) < $minLength) {
                $violations[] = 'String length '.strlen($value)." is less than minimum {$minLength}";
            }
            if (is_int($maxLength) && strlen($value) > $maxLength) {
                $violations[] = 'String length '.strlen($value)." exceeds maximum {$maxLength}";
            }
        }

        // Number constraints
        if (is_numeric($value)) {
            $minimum = $constraints['minimum'] ?? null;
            $maximum = $constraints['maximum'] ?? null;
            $multipleOf = $constraints['multipleOf'] ?? null;

            if (is_numeric($minimum) && $value < $minimum) {
                $violations[] = "Value {$value} is less than minimum {$minimum}";
            }
            if (is_numeric($maximum) && $value > $maximum) {
                $violations[] = "Value {$value} exceeds maximum {$maximum}";
            }
            if (is_numeric($multipleOf) && 0.0 !== fmod((float) $value, (float) $multipleOf)) {
                $violations[] = "Value {$value} is not a multiple of {$multipleOf}";
            }
        }

        // Array minItems constraint (for values > 1 that were removed)
        if (is_array($value)) {
            $minItems = $constraints['minItems'] ?? null;
            if (is_int($minItems) && count($value) < $minItems) {
                $violations[] = 'Array has '.count($value)." items, minimum is {$minItems}";
            }
        }

        return $violations;
    }
}
