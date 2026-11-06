# Topic — PHP `DataContainer` (crud-assistant)

## What I worked on

Typed array-wrapper `DataContainer` in `juaniquillo/crud-assistant`. Touched it as the payload object passed between CRUD actions/inputs — `DataContainer::make([...])` then `get/set/fill/merge/push`, plus `$c->key`, `$c['key']`, `foreach`, `count()`.

## Origin link

- Lesson target: https://github.com/juaniquillo/crud-assistant/blob/main/src/DataContainer.php
- Real logic: `src/Concerns/IsDataContainer.php` (trait), `src/Contracts/DataContainerInterface.php` (contract)

## What I think happens

`DataContainer` is a `final` class with `@template TValue` that wraps `array<array-key, TValue> $data`. All behavior comes from the `IsDataContainer` trait. It offers three equivalent read/write styles (method `get()/set()`, magic `->__get/__set`, `ArrayAccess` `[]`), plus bulk ops `fill()` (replace), `merge()` (`array_merge`), `push()` (`$data[] =`), predicates `contains()`/`missing()`, and `toArray()/all()`, `count()`, iteration, and JSON `__toString`. Missing-key reads throw `InvalidArgumentException`.

## What confuses me / what I need

1. Why split into final class + trait + interface? What does `IsDataContainer` buy vs. putting code in the class?
2. When to use `get()` vs `->prop` vs `['key']` — are they identical, including on missing keys and `null` values?
3. `fill()` vs `merge()` vs `push()` — replace vs. append semantics, especially with int keys?
4. `contains()`/`missing()` vs `isset($c->k)` / `isset($c[k])` — do they agree on `null` values?
5. What does `@template TValue` actually enforce at runtime vs. static analysis?
