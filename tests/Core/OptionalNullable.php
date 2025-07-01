<?php

namespace Tests\Core;

use Anthropic\Core\None;

class OptionalNullable
{
    /** @var array<mixed> */
    public array $args;

    public function __construct(
        ?int $x = null,
        None|string $y = None::NOT_SET,
        null|None|string $z = None::NOT_SET,
        null|None|string $w = None::NOT_SET,
    ) {
        $this->args = ['x' => null];
        $args = func_get_args();
        foreach ($args as $key => $value) {
            if (None::NOT_SET == $value) {
                continue;
            }
            $argName = ['x', 'y', 'z', 'w'][$key];
            $this->args[$argName] = $value;
        }
    }
}

describe('disambiguate null vs not set', function () {
    it('can be created with no args', function () {
        $ex = new OptionalNullable();
        expect(isset($ex->args['x']))->toBe(false);
        expect(isset($ex->args['y']))->toBe(false);
        expect(isset($ex->args['z']))->toBe(false);
        expect(isset($ex->args['w']))->toBe(false);
    });

    it('can be created with one argument', function () {
        $ex = new OptionalNullable(y: '42');
        expect($ex->args['x'])->toBe(null);
        expect($ex->args['y'])->toBe('42');
        expect(isset($ex->args['z']))->toBe(false);
        expect(isset($ex->args['w']))->toBe(false);
    });

    it('can be created with two arguments', function () {
        $ex = new OptionalNullable(z: null, y: '42');
        expect($ex->args['x'])->toBe(null);
        expect($ex->args['y'])->toBe('42');
        expect($ex->args['z'])->toBe(null);
        expect(isset($ex->args['w']))->toBe(false);
    });

    it('can be created with three arguments', function () {
        $x = new OptionalNullable(x: 42, y: '42', w: 'hello');
        expect($x->args['x'])->toBe(42);
        expect($x->args['y'])->toBe('42');
        expect(isset($x->args['z']))->toBe(false);
        expect($x->args['w'])->toBe('hello');
    });
});
