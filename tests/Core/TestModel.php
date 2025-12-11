<?php

namespace Tests\Core;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class TestModel implements BaseModel
{
    /** @use SdkModel<array<string, mixed>> */
    use SdkModel;

    #[Api]
    public string $name;

    #[Api('age_years')]
    public int $ageYears;

    /** @var list<string>|null */
    #[Api(optional: true)]
    public ?array $friends;

    #[Api]
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

        null != $friends && $this->friends = $friends;
    }
}

/**
 * @internal
 *
 * @coversNothing
 */
#[CoversNothing]
class TestModelTest extends TestCase
{
    #[Test]
    public function testBasicGetAndSet(): void
    {
        $model = new TestModel(
            name: 'Bob',
            ageYears: 12,
            owner: null,
        );
        $this->assertEquals(12, $model->ageYears);

        ++$model->ageYears;
        $this->assertEquals(13, $model->ageYears);
    }

    #[Test]
    public function testNullAccess(): void
    {
        $model = new TestModel(
            name: 'Bob',
            ageYears: 12,
            owner: null,
        );
        $this->assertNull($model->owner);
        $this->assertNull($model->friends);
    }

    #[Test]
    public function testArrayGetAndSet(): void
    {
        $model = new TestModel(
            name: 'Bob',
            ageYears: 12,
            owner: null,
        );
        $model->friends ??= [];
        $this->assertEquals([], $model->friends);
        $model->friends[] = 'Alice';
        $this->assertEquals(['Alice'], $model->friends);
    }

    #[Test]
    public function testDiscernsBetweenNullAndUnset(): void
    {
        $modelUnsetFriends = new TestModel(
            name: 'Bob',
            ageYears: 12,
            owner: null,
        );
        $modelNullFriends = new TestModel(
            name: 'bob',
            ageYears: 12,
            owner: null,
        );
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
        $model = new TestModel(
            name: 'Bob',
            ageYears: 12,
            owner: null,
        );
        $this->assertFalse(isset($model->owner));
        $this->assertFalse(isset($model->friends));
    }

    #[Test]
    public function testSerializeBasicModel(): void
    {
        $model = new TestModel(
            name: 'Bob',
            ageYears: 12,
            owner: 'Eve',
            friends: ['Alice', 'Charlie'],
        );
        $this->assertEquals(
            '{"name":"Bob","age_years":12,"friends":["Alice","Charlie"],"owner":"Eve"}',
            json_encode($model)
        );
    }

    #[Test]
    public function testSerializeModelWithOmittedProperties(): void
    {
        $model = new TestModel(
            name: 'Bob',
            ageYears: 12,
            owner: null,
        );
        $this->assertEquals(
            '{"name":"Bob","age_years":12,"owner":null}',
            json_encode($model)
        );
    }

    #[Test]
    public function testSerializeModelWithExplicitNull(): void
    {
        $model = new TestModel(
            name: 'Bob',
            ageYears: 12,
            owner: null,
        );
        $model->friends = null;
        $this->assertEquals(
            '{"name":"Bob","age_years":12,"friends":null,"owner":null}',
            json_encode($model)
        );
    }
}
