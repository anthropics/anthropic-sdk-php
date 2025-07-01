<?php

namespace Tests\Core;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class TestModel implements BaseModel
{
    use Model;

    #[Api(optional: false)]
    public ?string $name = null;

    #[Api('age_years')]
    public ?int $ageYears = null;

    /** @var null|list<string> */
    #[Api]
    public ?array $friends = null;

    #[Api]
    public ?string $owner;

    /**
     * @param array{
     *    name: string,
     *    age_years?: int,
     *    friends?: list<string>,
     *    owner?: string|null,
     * } $data
     */
    public function __construct(array $data)
    {
        $this->_loadMetadata();
        $this->__unserialize($data);
    }
}

describe('try serializing from array', function () {
    it('supports basic get and set', function () {
        $model = new TestModel([
            'name' => 'Bob',
            'ageYears' => 12,
        ]);

        expect($model->ageYears)->toBe(12);

        ++$model->ageYears;
        expect($model->ageYears)->toBe(13);
    });

    it('supports array get and set', function () {
        $model = new TestModel([
            'name' => 'Bob',
        ]);
        $model->friends ??= [];
        expect($model->friends)->toBe([]);

        // TODO(alpha): this doesn't work yet but should.
        $model->friends[] = 'Alice';
        expect($model->friends)->toBe(['Alice']);
    });

    it('discerns between null and unset', function () {
        $model = new TestModel([
            'name' => 'bob',
            'ageYears' => 12,
        ]);

        $model2 = new TestModel([
            'name' => 'bob',
            'ageYears' => 12,
            'owner' => null,
        ]);

        expect($model->ageYears)->toBe(12);
        expect($model2->ageYears)->toBe(12);

        expect($model->offsetExists('ageYears'))->toBeTrue();
        expect($model2->offsetExists('ageYears'))->toBeTrue();

        // expect($model->owner)->toBe(null);
        expect($model2->owner)->toBe(null);

        expect($model->offsetExists('owner'))->toBeFalse();
        expect($model2->offsetExists('owner'))->toBeTrue();
    });

    it('can serialize a basic model', function () {
        $model = new TestModel([
            'name' => 'Bob',
            'age_years' => 12,
            'friends' => ['Alice', 'Charlie'],
        ]);
        expect(json_encode($model))->toBe('{"name":"Bob","age_years":12,"friends":["Alice","Charlie"]}');
    });

    it('can serialize a basic model with explicit null', function () {
        $model = new TestModel([
            'name' => 'Bob',
            'age_years' => 12,
            'friends' => ['Alice', 'Charlie'],
            'owner' => null,
        ]);
        expect(json_encode($model))->toBe('{"name":"Bob","age_years":12,"friends":["Alice","Charlie"],"owner":null}');
    });
});
