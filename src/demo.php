<?php

declare(strict_types=1);

// True source: https://github.com/juaniquillo/crud-assistant/blob/main/src/Concerns/IsDataContainer.php
// Minimal faithful replica for the lesson (no composer dep). Behavior matches the
// trait for every method demonstrated below.

/**
 * @template TValue
 * @implements IteratorAggregate<array-key, TValue>
 */
final class DemoContainer implements IteratorAggregate, Countable, ArrayAccess
{
    /** @var array<array-key, TValue> */
    protected array $data = [];

    /** @param array<array-key, TValue> $data */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    /** @param array<array-key, TValue> $data */
    public static function make(array $data = []): static
    {
        return new static($data);
    }

    /** @return TValue */
    public function __get(string $name): mixed
    {
        if (!array_key_exists($name, $this->data)) {
            throw new InvalidArgumentException("The {$name} key does not exist in the container.");
        }

        return $this->data[$name];
    }

    /** @param TValue $value */
    public function __set(string $name, mixed $value): void
    {
        $this->data[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    public function __unset(string $name): void
    {
        unset($this->data[$name]);
    }

    public function __toString(): string
    {
        return json_encode($this->data) ?: '{}';
    }

    /** @return TValue */
    public function get(mixed $name): mixed
    {
        if (!array_key_exists($name, $this->data)) {
            throw new InvalidArgumentException("The {$name} key does not exist in the container.");
        }

        return $this->data[$name];
    }

    /** @param TValue $value */
    public function set(mixed $name, mixed $value): static
    {
        $this->data[$name] = $value;

        return $this;
    }

    /** @param array<array-key, TValue> $data */
    public function fill(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /** @param array<array-key, TValue> $data */
    public function merge(array $data): static
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /** @param TValue $value */
    public function push(mixed $value): static
    {
        $this->data[] = $value;

        return $this;
    }

    /** @param array<int, array-key> $keys */
    public function contains(array $keys): bool
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $this->data)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array<int, array-key> $keys
     *
     * @return array-key|false
     */
    public function missing(array $keys): mixed
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $this->data)) {
                return $key;
            }
        }

        return false;
    }

    /** @return array<array-key, TValue> */
    public function toArray(): array
    {
        return $this->data;
    }

    /** @return array<array-key, TValue> */
    public function all(): array
    {
        return $this->toArray();
    }

    /** @return ArrayIterator<array-key, TValue> */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    /** @return TValue */
    public function offsetGet(mixed $offset): mixed
    {
        if (!array_key_exists($offset, $this->data)) {
            throw new InvalidArgumentException("The {$offset} key does not exist in the container.");
        }

        return $this->data[$offset];
    }
}

function show(string $label, mixed $value): void
{
    echo str_pad($label, 28) . json_encode($value) . PHP_EOL;
}

echo "== 1. Three read styles agree (when key exists) ==" . PHP_EOL;
$c = DemoContainer::make(['name' => 'Ada', 'role' => 'admin']);
show('get(name)', $c->get('name'));
show('$c[name]', $c['name']);
show('$c->name', $c->name);

echo PHP_EOL . "== 2. Missing-key reads throw (all three) ==" . PHP_EOL;
foreach (['get()', 'offsetGet', '__get'] as $style) {
    try {
        match ($style) {
            'get()' => $c->get('nope'),
            'offsetGet' => $c['nope'],
            '__get' => $c->nope,
        };
        echo "$style: NO THROW (unexpected)" . PHP_EOL;
    } catch (InvalidArgumentException $e) {
        echo "$style throws: " . $e->getMessage() . PHP_EOL;
    }
}

echo PHP_EOL . "== 3. fill (replace) vs merge (array_merge) vs push (append) ==" . PHP_EOL;
$c->fill(['a' => 1]);
show('after fill', $c->toArray());
$c->merge(['b' => 2]);
show('after merge', $c->toArray());
$c->push(99);
show('after push', $c->toArray());

$ints = DemoContainer::make([10, 20]);
$ints->merge([30]); // array_merge renumbers int keys
show('int keys merged', $ints->toArray());

echo PHP_EOL . "== 4. null-value trap: isset vs array_key_exists ==" . PHP_EOL;
$n = DemoContainer::make(['maybe' => null]);
show('contains([maybe])', $n->contains(['maybe'])); // true (array_key_exists)
show('isset($n->maybe)', isset($n->maybe));          // false (isset)
show('isset($n[maybe])', isset($n['maybe']));        // false (offsetExists uses isset)
show('missing([maybe])', $n->missing(['maybe']));    // false = not missing
echo "get('maybe') returns: " . var_export($n->get('maybe'), true) . " (no throw)" . PHP_EOL;

echo PHP_EOL . "== 5. contains/missing + count/iterate/toString ==" . PHP_EOL;
$d = DemoContainer::make(['x' => 1, 'y' => 2]);
show('contains([x,y])', $d->contains(['x', 'y']));
show('contains([x,z])', $d->contains(['x', 'z']));
show('missing([x,z])', $d->missing(['x', 'z']));
show('count()', count($d));
echo "foreach: ";
foreach ($d as $k => $v) {
    echo "$k=$v ";
}
echo PHP_EOL;
echo "toString: " . ((string) $d) . PHP_EOL;
show('toArray==all', $d->toArray() === $d->all());

echo PHP_EOL . "== 6. @template TValue is phpdoc-only ==" . PHP_EOL;
$mixed = DemoContainer::make(['s' => 'str', 'i' => 42, 'a' => [1]]);
show('mixed types accepted', $mixed->toArray());

echo PHP_EOL . "lesson from explain-me-template-data-container (template: https://github.com/juaniquillo/explain-me-template)" . PHP_EOL;
