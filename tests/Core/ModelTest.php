<?php

namespace Tests\Core;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\ConstantOf;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Conversion\UnionOf;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class Dog implements BaseModel
{
    /** @use SdkModel<array<string, mixed>> */
    use SdkModel;

    #[Required]
    public string $name;

    #[Required('age_years')]
    public int $ageYears;

    /** @var list<string>|null */
    #[Optional]
    public ?array $friends;

    #[Required]
    public ?string $owner;

    /**
     * @param list<string>|null $friends
     */
    public function __construct(
        string $name,
        int $ageYears,
        ?string $owner,
        ?array $friends = null,
    ) {
        $this->initialize();

        $this->name = $name;
        $this->ageYears = $ageYears;
        $this->owner = $owner;

        null !== $friends && $this['friends'] = $friends;
    }
}

class Collar implements BaseModel
{
    /** @use SdkModel<array<string, mixed>> */
    use SdkModel;

    #[Optional]
    public ?string $color;

    #[Optional('serial_number')]
    public ?string $serialNumber;

    public function __construct()
    {
        $this->initialize();
    }
}

class Kennel implements BaseModel
{
    /** @use SdkModel<array<string, mixed>> */
    use SdkModel;

    #[Required]
    public string $name;

    #[Optional]
    public ?Collar $collar;

    public function __construct(string $name, ?Collar $collar = null)
    {
        $this->initialize();

        $this->name = $name;

        null !== $collar && $this['collar'] = $collar;
    }
}

class Cat implements BaseModel
{
    /** @use SdkModel<array<string, mixed>> */
    use SdkModel;

    #[Required]
    public string $type = 'cat';

    #[Required]
    public string $name;

    public function __construct(string $name)
    {
        $this->initialize();

        $this->name = $name;
    }
}

enum Size: string
{
    case SMALL = 'small';

    case LARGE = 'large';
}

class Crate implements BaseModel
{
    /** @use SdkModel<array<string, mixed>> */
    use SdkModel;

    #[Optional(enum: Size::class)]
    public ?string $size;

    /** @var list<string>|null */
    #[Optional(list: Size::class)]
    public ?array $sizes;

    /** @var array<string, string>|null */
    #[Optional(map: Size::class)]
    public ?array $sizeByDog;

    #[Optional(union: new UnionOf([Size::class, 'int']))]
    public int|string|null $limit;

    public function __construct()
    {
        $this->initialize();
    }
}

enum CommandType: string
{
    case SIT = 'sit';

    case FETCH = 'fetch';
}

class Sit implements BaseModel
{
    /** @use SdkModel<array<string, mixed>> */
    use SdkModel;

    #[Required(type: new ConstantOf('sit'))]
    public string $type = 'sit';

    public function __construct()
    {
        $this->initialize();
    }
}

class Fetch implements BaseModel
{
    /** @use SdkModel<array<string, mixed>> */
    use SdkModel;

    #[Required(type: new ConstantOf('fetch'))]
    public string $type = 'fetch';

    #[Required('toy_name')]
    public string $toyName;

    public function __construct()
    {
        $this->initialize();
    }
}

final class Command implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return array<string, class-string<BaseModel>>
     */
    public static function variants(): array
    {
        return ['sit' => Sit::class, 'fetch' => Fetch::class];
    }
}

class Routine implements BaseModel
{
    /** @use SdkModel<array<string, mixed>> */
    use SdkModel;

    #[Optional(union: Command::class)]
    public Sit|Fetch|null $command;

    /** @var string|list<Sit|Fetch>|null */
    #[Optional(union: new UnionOf(['string', new ListOf(Command::class)]))]
    public string|array|null $commands;

    public function __construct()
    {
        $this->initialize();
    }
}

/**
 * @internal
 *
 * @coversNothing
 */
#[CoversNothing]
class ModelTest extends TestCase
{
    #[Test]
    public function testBasicGetAndSet(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $this->assertEquals(12, $model->ageYears);

        ++$model->ageYears;
        $this->assertEquals(13, $model->ageYears);
    }

    #[Test]
    public function testNullAccess(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $this->assertNull($model->owner);
        $this->assertNull($model->friends);
    }

    #[Test]
    public function testArrayGetAndSet(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $model->friends ??= [];
        $this->assertEquals([], $model->friends);
        $model->friends[] = 'Alice';
        $this->assertEquals(['Alice'], $model->friends);
    }

    #[Test]
    public function testNonStringOffsetThrows(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $calls = [
            'offsetExists' => function () use ($model): void {
                // @phpstan-ignore-next-line argument.type
                $model->offsetExists(0);
            },
            'offsetGet' => function () use ($model): void {
                // @phpstan-ignore-next-line argument.type
                $model->offsetGet(0);
            },
            'offsetSet' => function () use ($model): void {
                // @phpstan-ignore-next-line argument.type
                $model->offsetSet(0, 'x');
            },
            'offsetUnset' => function () use ($model): void {
                // @phpstan-ignore-next-line argument.type
                $model->offsetUnset(0);
            },
        ];

        foreach ($calls as $method => $call) {
            try {
                $call();
                $this->fail("Expected {$method}(0) to throw an InvalidArgumentException");
            } catch (\InvalidArgumentException) {
                $this->addToAssertionCount(1);
            }
        }
    }

    #[Test]
    public function testDiscernsBetweenNullAndUnset(): void
    {
        $modelUnsetFriends = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $modelNullFriends = new Dog(name: 'bob', ageYears: 12, owner: null);
        $modelNullFriends->friends = null;

        $this->assertEquals(12, $modelUnsetFriends->ageYears);
        $this->assertEquals(12, $modelNullFriends->ageYears);

        $this->assertTrue($modelUnsetFriends->offsetExists('ageYears'));
        $this->assertTrue($modelNullFriends->offsetExists('ageYears'));

        $this->assertNull($modelUnsetFriends->friends);
        $this->assertNull($modelNullFriends->friends);

        $this->assertFalse($modelUnsetFriends->offsetExists('friends'));
        $this->assertTrue($modelNullFriends->offsetExists('friends'));
    }

    #[Test]
    public function testIssetOnOmittedProperties(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $this->assertFalse(isset($model->owner));
        $this->assertFalse(isset($model->friends));
    }

    #[Test]
    public function testSerializeBasicModel(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: 'Eve', friends: ['Alice', 'Charlie']);
        $this->assertEquals(
            '{"name":"Bob","age_years":12,"friends":["Alice","Charlie"],"owner":"Eve"}',
            json_encode($model)
        );
    }

    #[Test]
    public function testSerializeModelWithOmittedProperties(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $this->assertEquals(
            '{"name":"Bob","age_years":12,"owner":null}',
            json_encode($model)
        );
    }

    #[Test]
    public function testSerializeModelWithExplicitNull(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $model->friends = null;
        $this->assertEquals(
            '{"name":"Bob","age_years":12,"friends":null,"owner":null}',
            json_encode($model)
        );
    }

    #[Test]
    public function testSerializeEmptyModel(): void
    {
        $this->assertEquals('{}', json_encode(new Collar));
        $this->assertEquals('{"name":"north","collar":{}}', json_encode(new Kennel(name: 'north', collar: new Collar)));
    }

    #[Test]
    public function testCoerceWithOmittedProperties(): void
    {
        /** @var Dog $model */
        $model = Conversion::coerce(Dog::class, value: ['name' => 'Bob', 'age_years' => 12]);

        $this->assertNull($model->owner);
        $this->assertNull($model->friends);
        $this->assertFalse($model->offsetExists('owner'));
        $this->assertFalse($model->offsetExists('friends'));
        $this->assertEquals('{"name":"Bob","age_years":12}', json_encode($model));
    }

    #[Test]
    public function testCoerceWithExplicitNull(): void
    {
        /** @var Dog $model */
        $model = Conversion::coerce(Dog::class, value: ['name' => 'Bob', 'age_years' => 12, 'owner' => null]);

        $this->assertNull($model->owner);
        $this->assertTrue($model->offsetExists('owner'));
        $this->assertEquals('{"name":"Bob","age_years":12,"owner":null}', json_encode($model));
    }

    #[Test]
    public function testCoerceWithOmittedConstantKeepsDefault(): void
    {
        /** @var Cat $model */
        $model = Conversion::coerce(Cat::class, value: ['name' => 'Tom']);

        $this->assertEquals('cat', $model->type);
        $this->assertTrue($model->offsetExists('type'));
        $this->assertEquals('{"type":"cat","name":"Tom"}', json_encode($model));
        $this->assertEquals('cat', Cat::fromArray(['name' => 'Tom'])->type);
    }

    #[Test]
    public function testCoerceWithOmittedNonNullablePropertyThrowsOnAccess(): void
    {
        /** @var Dog $model */
        $model = Conversion::coerce(Dog::class, value: ['age_years' => 12]);

        $this->assertEquals(12, $model->ageYears);
        $this->expectException(\Error::class);
        $this->expectExceptionMessage('must not be accessed before initialization');
        // @phpstan-ignore-next-line expr.resultUnused
        $model->name;
    }

    #[Test]
    public function testEnumCaseReadsBackAsTheCase(): void
    {
        $stored = Size::SMALL;

        $model = new Crate;
        $model['size'] = Size::SMALL;
        $model['sizes'] = [Size::SMALL];
        $model['sizeByDog'] = ['Bob' => Size::SMALL];
        $model['limit'] = Size::SMALL;

        $expected = ['size' => $stored, 'sizes' => [$stored], 'sizeByDog' => ['Bob' => $stored], 'limit' => $stored];
        foreach ($expected as $property => $value) {
            $this->assertSame($value, $model[$property]);
        }
    }

    #[Test]
    public function testBackedEnumSelectsSameVariantAsItsValue(): void
    {
        $byEnum = ['type' => CommandType::FETCH, 'toyName' => 'ball'];
        $byValue = ['type' => 'fetch', 'toyName' => 'ball'];

        $sent = ['type' => 'fetch', 'toy_name' => 'ball'];
        foreach ([$byEnum, $byValue] as $command) {
            $this->assertEquals(
                ['command' => $sent, 'commands' => [$sent]],
                Conversion::dump(Routine::class, value: ['command' => $command, 'commands' => [$command]])
            );
        }

        $fromEnum = new Routine;
        $fromEnum['command'] = $byEnum;
        $fromValue = new Routine;
        $fromValue['command'] = $byValue;

        $this->assertInstanceOf(Fetch::class, $fromValue->command);
        $this->assertEquals($fromValue->command, $fromEnum->command);
    }
}
