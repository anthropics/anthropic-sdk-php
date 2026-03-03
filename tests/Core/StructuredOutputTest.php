<?php

namespace Tests\Core;

use Anthropic\Core\Attributes\Required;
use Anthropic\Lib\Attributes\Constrained;
use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
use Anthropic\Lib\Contracts\StructuredOutputModel;
use Anthropic\Lib\Helpers\SchemaInference;
use Anthropic\Lib\Helpers\StructuredOutput;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

// Test model classes - defined outside the test class to avoid reflection issues

class SimpleModel implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $name;
    public int $age;
    public float $score;
    public bool $active;
}

class ModelWithDescriptions implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    #[Constrained(description: 'The person\'s full name')]
    public string $name;

    #[Constrained(description: 'Age in years')]
    public int $age;
}

class ModelWithOptionalFields implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $requiredField;
    public ?string $optionalField = null;
    public ?int $optionalNumber = null;
}

class ModelWithEnum implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    #[Required(enum: ['active', 'inactive', 'pending'])]
    #[Constrained(description: 'Current status')]
    public string $status;
}

class ModelWithFormat implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    #[Constrained(description: 'Email address', format: 'email')]
    public string $email;

    #[Constrained(description: 'Website URL', format: 'uri')]
    public string $website;

    #[Constrained(description: 'IP address', format: 'ipv4')]
    public string $ip;
}

class ModelWithUnsupportedConstraints implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    #[Constrained(description: 'Age with constraints', minimum: 0, maximum: 150)]
    public int $age;

    #[Constrained(description: 'Username', minLength: 3, maxLength: 20)]
    public string $username;

    #[Constrained(description: 'Score', multipleOf: 0.5)]
    public float $score;
}

class ModelWithConst implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    #[Constrained(description: 'API version', const: '1.0')]
    public string $version;
}

class ModelWithDefault implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $priority = 'normal';
}

class NestedAddress implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $street;
    public string $city;
    public string $country;
}

class ModelWithNestedObject implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $name;
    public NestedAddress $address;
}

class SkillItem implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $name;

    #[Required(enum: ['beginner', 'intermediate', 'expert'])]
    #[Constrained(description: 'Skill level')]
    public string $level;
}

class ModelWithArrayOfObjects implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $name;

    /** @var array<SkillItem> */
    #[Constrained(description: 'List of skills', itemClass: SkillItem::class, minItems: 1)]
    public array $skills;
}

class ModelWithArrayMinItemsUnsupported implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    /** @var array<SkillItem> */
    #[Constrained(description: 'Items with high minItems', itemClass: SkillItem::class, minItems: 5)]
    public array $items;
}

class ModelWithDescription implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $content;

    public static function description(): ?string
    {
        return 'A model with a custom description';
    }
}

class ModelWithPhpDocItemClass implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $name;

    /** @var SkillItem[] */
    public array $skills;
}

class ModelWithPhpDocArraySyntax implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $name;

    /** @var array<SkillItem> */
    public array $skills;
}

class ModelWithPhpDocAndExplicitItemClass implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $name;

    /** @var SkillItem[] */
    #[Constrained(description: 'List of skills', itemClass: NestedAddress::class)]
    public array $skills;
}

class ModelWithPhpDefaultValue implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $status = 'pending';
    public int $retries = 3;
    public ?string $optional = null;
}

class RecursiveTreeNode implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $value;
    public ?RecursiveTreeNode $left = null;
    public ?RecursiveTreeNode $right = null;
}

class ModelWithUntypedProperty implements StructuredOutputModel
{
    use StructuredOutputModelTrait;
    public string $name;
    /** @phpstan-ignore-next-line missingType.property */
    public $anything;
}

/**
 * @internal
 */
#[CoversClass(StructuredOutput::class)]
#[CoversClass(SchemaInference::class)]
#[CoversClass(\Anthropic\Lib\Concerns\StructuredOutputModelTrait::class)]
#[CoversClass(Required::class)]
#[CoversClass(Constrained::class)]
class StructuredOutputTest extends TestCase
{
    // =========================================================================
    // Schema Generation Tests
    // =========================================================================

    #[Test]
    public function testBasicTypeInference(): void
    {
        $schema = StructuredOutput::toJsonSchema(SimpleModel::class);

        $this->assertEquals('object', $schema['type']);
        $this->assertArrayHasKey('properties', $schema);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        /** @var array<string> $required */
        $required = $schema['required'];

        // Check type mappings
        $this->assertEquals('string', $properties['name']['type']);
        $this->assertEquals('integer', $properties['age']['type']);
        $this->assertEquals('number', $properties['score']['type']);
        $this->assertEquals('boolean', $properties['active']['type']);

        // All fields should be required
        $this->assertContains('name', $required);
        $this->assertContains('age', $required);
        $this->assertContains('score', $required);
        $this->assertContains('active', $required);

        // additionalProperties should always be false
        $this->assertFalse($schema['additionalProperties']);
    }

    #[Test]
    public function testUntypedPropertyOmitsType(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithUntypedProperty::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        $this->assertEquals('string', $properties['name']['type']);
        // Untyped property should have no 'type' key — accepts any JSON value
        $this->assertArrayNotHasKey('type', $properties['anything']);
    }

    #[Test]
    public function testDescriptionsAreIncluded(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithDescriptions::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        $this->assertEquals('The person\'s full name', $properties['name']['description']);
        $this->assertEquals('Age in years', $properties['age']['description']);
    }

    #[Test]
    public function testOptionalFieldsNotInRequired(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithOptionalFields::class);

        /** @var array<string> $required */
        $required = $schema['required'];

        $this->assertContains('requiredField', $required);
        $this->assertNotContains('optionalField', $required);
        $this->assertNotContains('optionalNumber', $required);
    }

    #[Test]
    public function testEnumIsIncluded(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithEnum::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        $this->assertEquals(['active', 'inactive', 'pending'], $properties['status']['enum']);
    }

    #[Test]
    public function testSupportedFormatsAreIncluded(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithFormat::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        $this->assertEquals('email', $properties['email']['format']);
        $this->assertEquals('uri', $properties['website']['format']);
        $this->assertEquals('ipv4', $properties['ip']['format']);
    }

    #[Test]
    public function testUnsupportedConstraintsMovedToDescription(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithUnsupportedConstraints::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        // Age should have constraints in description
        $this->assertIsString($properties['age']['description']);
        $ageDesc = $properties['age']['description'];
        $this->assertStringContainsString('minimum', $ageDesc);
        $this->assertStringContainsString('maximum', $ageDesc);
        $this->assertStringContainsString('0', $ageDesc);
        $this->assertStringContainsString('150', $ageDesc);

        // Username should have length constraints in description
        $this->assertIsString($properties['username']['description']);
        $usernameDesc = $properties['username']['description'];
        $this->assertStringContainsString('minLength', $usernameDesc);
        $this->assertStringContainsString('maxLength', $usernameDesc);

        // Score should have multipleOf in description
        $this->assertIsString($properties['score']['description']);
        $scoreDesc = $properties['score']['description'];
        $this->assertStringContainsString('multipleOf', $scoreDesc);

        // Unsupported constraints should NOT be in the schema properties directly
        /** @var array<string, mixed> $ageProps */
        $ageProps = $properties['age'];

        /** @var array<string, mixed> $usernameProps */
        $usernameProps = $properties['username'];

        $this->assertArrayNotHasKey('minimum', $ageProps);
        $this->assertArrayNotHasKey('maximum', $ageProps);
        $this->assertArrayNotHasKey('minLength', $usernameProps);
        $this->assertArrayNotHasKey('maxLength', $usernameProps);
    }

    #[Test]
    public function testConstIsIncluded(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithConst::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        $this->assertEquals('1.0', $properties['version']['const']);
    }

    #[Test]
    public function testDefaultIsIncluded(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithDefault::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        $this->assertEquals('normal', $properties['priority']['default']);
    }

    #[Test]
    public function testNestedObjectSchema(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithNestedObject::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        // Address should be an object type
        /** @var array<string, mixed> $addressSchema */
        $addressSchema = $properties['address'];
        $this->assertEquals('object', $addressSchema['type']);
        $this->assertArrayHasKey('properties', $addressSchema);

        /** @var array<string, array<string, mixed>> $addressProps */
        $addressProps = $addressSchema['properties'];
        $this->assertEquals('string', $addressProps['street']['type']);
        $this->assertEquals('string', $addressProps['city']['type']);
        $this->assertEquals('string', $addressProps['country']['type']);
        $this->assertFalse($addressSchema['additionalProperties']);
    }

    #[Test]
    public function testArrayOfObjectsSchema(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithArrayOfObjects::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        // Skills should be an array with items schema
        /** @var array<string, mixed> $skillsSchema */
        $skillsSchema = $properties['skills'];
        $this->assertEquals('array', $skillsSchema['type']);
        $this->assertEquals(1, $skillsSchema['minItems']);
        $this->assertArrayHasKey('items', $skillsSchema);

        // Items should be objects
        /** @var array<string, mixed> $itemsSchema */
        $itemsSchema = $skillsSchema['items'];
        $this->assertEquals('object', $itemsSchema['type']);

        /** @var array<string, array<string, mixed>> $itemsProps */
        $itemsProps = $itemsSchema['properties'];
        $this->assertEquals('string', $itemsProps['name']['type']);
        $this->assertEquals(['beginner', 'intermediate', 'expert'], $itemsProps['level']['enum']);
    }

    #[Test]
    public function testMinItemsGreaterThanOneMovedToDescription(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithArrayMinItemsUnsupported::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        // minItems > 1 should be moved to description, not in schema
        /** @var array<string, mixed> $itemsSchema */
        $itemsSchema = $properties['items'];
        $this->assertArrayNotHasKey('minItems', $itemsSchema);
        $this->assertIsString($itemsSchema['description']);
        $this->assertStringContainsString('minItems', $itemsSchema['description']);
        $this->assertStringContainsString('5', $itemsSchema['description']);
    }

    #[Test]
    public function testModelDescriptionIsIncluded(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithDescription::class);

        $this->assertEquals('A model with a custom description', $schema['description']);
    }

    // =========================================================================
    // Response Parsing Tests
    // =========================================================================

    #[Test]
    public function testParseSimpleModel(): void
    {
        $data = [
            'name' => 'Alice',
            'age' => 30,
            'score' => 95.5,
            'active' => true,
        ];

        $model = SimpleModel::fromArray($data);

        $this->assertInstanceOf(SimpleModel::class, $model); // @phpstan-ignore method.alreadyNarrowedType
        $this->assertEquals('Alice', $model->name);
        $this->assertEquals(30, $model->age);
        $this->assertEquals(95.5, $model->score);
        $this->assertTrue($model->active);
    }

    #[Test]
    public function testParseModelWithOptionalFields(): void
    {
        // With optional field present
        $data = [
            'requiredField' => 'value',
            'optionalField' => 'optional value',
            'optionalNumber' => 42,
        ];

        $model = ModelWithOptionalFields::fromArray($data);
        $this->assertEquals('value', $model->requiredField);
        $this->assertEquals('optional value', $model->optionalField);
        $this->assertEquals(42, $model->optionalNumber);

        // Without optional fields
        $data2 = ['requiredField' => 'value'];
        $model2 = ModelWithOptionalFields::fromArray($data2);
        $this->assertEquals('value', $model2->requiredField);
    }

    #[Test]
    public function testParseModelWithNullOptionalFields(): void
    {
        $data = [
            'requiredField' => 'value',
            'optionalField' => null,
            'optionalNumber' => null,
        ];

        $model = ModelWithOptionalFields::fromArray($data);
        $this->assertEquals('value', $model->requiredField);
        $this->assertNull($model->optionalField);
        $this->assertNull($model->optionalNumber);
    }

    #[Test]
    public function testParseNestedObject(): void
    {
        $data = [
            'name' => 'Alice',
            'address' => [
                'street' => '123 Main St',
                'city' => 'San Francisco',
                'country' => 'USA',
            ],
        ];

        $model = ModelWithNestedObject::fromArray($data);

        $this->assertEquals('Alice', $model->name);
        $this->assertInstanceOf(NestedAddress::class, $model->address); // @phpstan-ignore method.alreadyNarrowedType
        $this->assertEquals('123 Main St', $model->address->street);
        $this->assertEquals('San Francisco', $model->address->city);
        $this->assertEquals('USA', $model->address->country);
    }

    #[Test]
    public function testParseArrayOfObjects(): void
    {
        $data = [
            'name' => 'Bob',
            'skills' => [
                ['name' => 'PHP', 'level' => 'expert'],
                ['name' => 'Python', 'level' => 'intermediate'],
                ['name' => 'Go', 'level' => 'beginner'],
            ],
        ];

        $model = ModelWithArrayOfObjects::fromArray($data);

        $this->assertEquals('Bob', $model->name);
        $this->assertCount(3, $model->skills);

        $this->assertInstanceOf(SkillItem::class, $model->skills[0]); // @phpstan-ignore method.alreadyNarrowedType
        $this->assertEquals('PHP', $model->skills[0]->name);
        $this->assertEquals('expert', $model->skills[0]->level);

        $this->assertInstanceOf(SkillItem::class, $model->skills[1]); // @phpstan-ignore method.alreadyNarrowedType
        $this->assertEquals('Python', $model->skills[1]->name);
        $this->assertEquals('intermediate', $model->skills[1]->level);

        $this->assertInstanceOf(SkillItem::class, $model->skills[2]); // @phpstan-ignore method.alreadyNarrowedType
        $this->assertEquals('Go', $model->skills[2]->name);
        $this->assertEquals('beginner', $model->skills[2]->level);
    }

    #[Test]
    public function testModelSerializesToJson(): void
    {
        $data = [
            'name' => 'Alice',
            'age' => 30,
            'score' => 95.5,
            'active' => true,
        ];

        $model = SimpleModel::fromArray($data);
        $json = $model->toJson();
        $decoded = json_decode($json, true);

        $this->assertEquals($data, $decoded);
    }

    #[Test]
    public function testNestedModelSerializesToJson(): void
    {
        $data = [
            'name' => 'Alice',
            'address' => [
                'street' => '123 Main St',
                'city' => 'San Francisco',
                'country' => 'USA',
            ],
        ];

        $model = ModelWithNestedObject::fromArray($data);
        $json = $model->toJson();
        $decoded = json_decode($json, true);

        $this->assertEquals($data, $decoded);
    }

    // =========================================================================
    // Constrained Validation Tests
    // =========================================================================

    #[Test]
    public function testValidateMinimumConstraint(): void
    {
        // Generate schema to populate constraints cache
        StructuredOutput::toJsonSchema(ModelWithUnsupportedConstraints::class);

        // Valid data
        $validData = ['age' => 25, 'username' => 'alice', 'score' => 10.0];
        $violations = StructuredOutput::validateAgainstConstraints($validData, ModelWithUnsupportedConstraints::class);
        $this->assertArrayNotHasKey('age', $violations);

        // Invalid data - below minimum
        $invalidData = ['age' => -5, 'username' => 'alice', 'score' => 10.0];
        $violations = StructuredOutput::validateAgainstConstraints($invalidData, ModelWithUnsupportedConstraints::class);
        $this->assertArrayHasKey('age', $violations);
        $this->assertStringContainsString('minimum', $violations['age']);
    }

    #[Test]
    public function testValidateMaximumConstraint(): void
    {
        StructuredOutput::toJsonSchema(ModelWithUnsupportedConstraints::class);

        // Invalid data - above maximum
        $invalidData = ['age' => 200, 'username' => 'alice', 'score' => 10.0];
        $violations = StructuredOutput::validateAgainstConstraints($invalidData, ModelWithUnsupportedConstraints::class);
        $this->assertArrayHasKey('age', $violations);
        $this->assertStringContainsString('maximum', $violations['age']);
    }

    #[Test]
    public function testValidateMinLengthConstraint(): void
    {
        StructuredOutput::toJsonSchema(ModelWithUnsupportedConstraints::class);

        // Invalid data - too short
        $invalidData = ['age' => 25, 'username' => 'ab', 'score' => 10.0];
        $violations = StructuredOutput::validateAgainstConstraints($invalidData, ModelWithUnsupportedConstraints::class);
        $this->assertArrayHasKey('username', $violations);
        $this->assertStringContainsString('minimum', $violations['username']);
    }

    #[Test]
    public function testValidateMaxLengthConstraint(): void
    {
        StructuredOutput::toJsonSchema(ModelWithUnsupportedConstraints::class);

        // Invalid data - too long
        $invalidData = ['age' => 25, 'username' => 'this_username_is_way_too_long', 'score' => 10.0];
        $violations = StructuredOutput::validateAgainstConstraints($invalidData, ModelWithUnsupportedConstraints::class);
        $this->assertArrayHasKey('username', $violations);
        $this->assertStringContainsString('maximum', $violations['username']);
    }

    #[Test]
    public function testValidateMultipleOfConstraint(): void
    {
        StructuredOutput::toJsonSchema(ModelWithUnsupportedConstraints::class);

        // Valid - is multiple of 0.5
        $validData = ['age' => 25, 'username' => 'alice', 'score' => 10.5];
        $violations = StructuredOutput::validateAgainstConstraints($validData, ModelWithUnsupportedConstraints::class);
        $this->assertArrayNotHasKey('score', $violations);

        // Invalid - not multiple of 0.5
        $invalidData = ['age' => 25, 'username' => 'alice', 'score' => 10.3];
        $violations = StructuredOutput::validateAgainstConstraints($invalidData, ModelWithUnsupportedConstraints::class);
        $this->assertArrayHasKey('score', $violations);
        $this->assertStringContainsString('multiple', $violations['score']);
    }

    #[Test]
    public function testValidateMinItemsConstraint(): void
    {
        StructuredOutput::toJsonSchema(ModelWithArrayMinItemsUnsupported::class);

        // Invalid - not enough items
        $invalidData = ['items' => [['name' => 'PHP', 'level' => 'expert']]];
        $violations = StructuredOutput::validateAgainstConstraints($invalidData, ModelWithArrayMinItemsUnsupported::class);
        $this->assertArrayHasKey('items', $violations);
        $this->assertStringContainsString('minimum', $violations['items']);
    }

    #[Test]
    public function testGetConstraintsForModel(): void
    {
        StructuredOutput::toJsonSchema(ModelWithUnsupportedConstraints::class);

        $constraints = StructuredOutput::getConstraintsForModel(ModelWithUnsupportedConstraints::class);

        $this->assertArrayHasKey('age', $constraints);
        /** @var array{minimum: int, maximum: int} $ageConstraints */
        $ageConstraints = $constraints['age'];
        $this->assertEquals(0, $ageConstraints['minimum']);
        $this->assertEquals(150, $ageConstraints['maximum']);

        $this->assertArrayHasKey('username', $constraints);
        /** @var array{minLength: int, maxLength: int} $usernameConstraints */
        $usernameConstraints = $constraints['username'];
        $this->assertEquals(3, $usernameConstraints['minLength']);
        $this->assertEquals(20, $usernameConstraints['maxLength']);

        $this->assertArrayHasKey('score', $constraints);
        /** @var array{multipleOf: float} $scoreConstraints */
        $scoreConstraints = $constraints['score'];
        $this->assertEquals(0.5, $scoreConstraints['multipleOf']);
    }

    // =========================================================================
    // Edge Cases
    // =========================================================================

    #[Test]
    public function testEmptyArrayParsesCorrectly(): void
    {
        $data = [
            'name' => 'Bob',
            'skills' => [],
        ];

        $model = ModelWithArrayOfObjects::fromArray($data);
        $this->assertEquals('Bob', $model->name);
        $this->assertIsArray($model->skills); // @phpstan-ignore method.alreadyNarrowedType
        $this->assertEmpty($model->skills);
    }

    #[Test]
    public function testDescriptionWithConstraintsAppended(): void
    {
        // Test that constraints are properly appended to existing description
        $schema = StructuredOutput::toJsonSchema(ModelWithUnsupportedConstraints::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];
        $this->assertIsString($properties['age']['description']);
        $ageDesc = $properties['age']['description'];

        // Should start with the original description
        $this->assertStringStartsWith('Age with constraints', $ageDesc);

        // Should have JSON constraints appended after double newline
        $this->assertStringContainsString("\n\n{", $ageDesc);
    }

    // =========================================================================
    // PHPDoc Inference Tests
    // =========================================================================

    #[Test]
    public function testPhpDocItemClassInference(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithPhpDocItemClass::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        // Skills should be an array with items schema inferred from @var SkillItem[]
        /** @var array<string, mixed> $skillsSchema */
        $skillsSchema = $properties['skills'];
        $this->assertEquals('array', $skillsSchema['type']);
        $this->assertArrayHasKey('items', $skillsSchema);

        // Items should be the SkillItem schema
        /** @var array<string, mixed> $itemsSchema */
        $itemsSchema = $skillsSchema['items'];
        $this->assertEquals('object', $itemsSchema['type']);

        /** @var array<string, array<string, mixed>> $itemsProps */
        $itemsProps = $itemsSchema['properties'];
        $this->assertArrayHasKey('name', $itemsProps);
        $this->assertArrayHasKey('level', $itemsProps);
        $this->assertEquals(['beginner', 'intermediate', 'expert'], $itemsProps['level']['enum']);
    }

    #[Test]
    public function testPhpDocArraySyntaxInference(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithPhpDocArraySyntax::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        // Skills should be an array with items schema inferred from @var array<SkillItem>
        /** @var array<string, mixed> $skillsSchema */
        $skillsSchema = $properties['skills'];
        $this->assertEquals('array', $skillsSchema['type']);
        $this->assertArrayHasKey('items', $skillsSchema);

        // Items should be the SkillItem schema
        /** @var array<string, mixed> $itemsSchema */
        $itemsSchema = $skillsSchema['items'];
        $this->assertEquals('object', $itemsSchema['type']);

        /** @var array<string, array<string, mixed>> $itemsProps */
        $itemsProps = $itemsSchema['properties'];
        $this->assertArrayHasKey('name', $itemsProps);
        $this->assertArrayHasKey('level', $itemsProps);
    }

    #[Test]
    public function testExplicitItemClassOverridesPhpDoc(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithPhpDocAndExplicitItemClass::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        // Skills should use the explicit itemClass (NestedAddress), not the PHPDoc (SkillItem)
        /** @var array<string, mixed> $skillsSchema */
        $skillsSchema = $properties['skills'];
        $this->assertEquals('array', $skillsSchema['type']);
        $this->assertArrayHasKey('items', $skillsSchema);

        // Items should be NestedAddress schema, not SkillItem
        /** @var array<string, mixed> $itemsSchema */
        $itemsSchema = $skillsSchema['items'];
        $this->assertEquals('object', $itemsSchema['type']);

        /** @var array<string, array<string, mixed>> $itemsProps */
        $itemsProps = $itemsSchema['properties'];
        $this->assertArrayHasKey('street', $itemsProps);
        $this->assertArrayHasKey('city', $itemsProps);
        $this->assertArrayHasKey('country', $itemsProps);
        $this->assertArrayNotHasKey('name', $itemsProps);
        $this->assertArrayNotHasKey('level', $itemsProps);
    }

    #[Test]
    public function testPhpDefaultValueInference(): void
    {
        $schema = StructuredOutput::toJsonSchema(ModelWithPhpDefaultValue::class);

        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];

        // PHP default values should be inferred
        $this->assertEquals('pending', $properties['status']['default']);
        $this->assertEquals(3, $properties['retries']['default']);

        // Null defaults should not be included
        $this->assertArrayNotHasKey('default', $properties['optional']);
    }

    // =========================================================================
    // Schema Snapshot Tests
    // =========================================================================

    #[Test]
    public function testSimpleModelSchemaSnapshot(): void
    {
        $this->assertEquals([
            'type' => 'object',
            'properties' => [
                'name' => ['type' => 'string'],
                'age' => ['type' => 'integer'],
                'score' => ['type' => 'number'],
                'active' => ['type' => 'boolean'],
            ],
            'required' => ['name', 'age', 'score', 'active'],
            'additionalProperties' => false,
        ], StructuredOutput::toJsonSchema(SimpleModel::class));
    }

    #[Test]
    public function testModelWithOptionalFieldsSchemaSnapshot(): void
    {
        $this->assertEquals([
            'type' => 'object',
            'properties' => [
                'requiredField' => ['type' => 'string'],
                'optionalField' => ['type' => 'string'],
                'optionalNumber' => ['type' => 'integer'],
            ],
            'required' => ['requiredField'],
            'additionalProperties' => false,
        ], StructuredOutput::toJsonSchema(ModelWithOptionalFields::class));
    }

    #[Test]
    public function testNestedObjectSchemaSnapshot(): void
    {
        $this->assertEquals([
            'type' => 'object',
            'properties' => [
                'name' => ['type' => 'string'],
                'address' => [
                    'type' => 'object',
                    'properties' => [
                        'street' => ['type' => 'string'],
                        'city' => ['type' => 'string'],
                        'country' => ['type' => 'string'],
                    ],
                    'required' => ['street', 'city', 'country'],
                    'additionalProperties' => false,
                ],
            ],
            'required' => ['name', 'address'],
            'additionalProperties' => false,
        ], StructuredOutput::toJsonSchema(ModelWithNestedObject::class));
    }

    // =========================================================================
    // Recursion Tests
    // =========================================================================

    #[Test]
    public function testRecursiveModelIsNotSupported(): void
    {
        // Recursive schemas cannot be represented in JSON Schema.
        // Self-referential models cause infinite recursion during schema generation.
        // This is a known limitation - users should avoid self-referential model structures.
        // TODO: Add cycle detection to fail fast with a descriptive error.
        $this->markTestIncomplete(
            'Recursive models are not supported: self-referential models cause infinite recursion in schema generation (known limitation).'
        );
    }
}
