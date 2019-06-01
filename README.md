# Affinity4 Collection

Iterable Collections with useful helper methods. Take control of your arrays!

## Installation

```bash
composer require affinity4/collection
```

## Usage

Standard Iteratable API

```php
require_once __DIR__ '/vendor/autoload.php';

use Affinity4\Collection;

$Collection = new Collection([
    0 => 'one',
    1 => 'two',
    2 => 'three'
]);

// TODO: Do this
$Collection->key(); // 0
$Collection->current(); // one
$Collection->valid(); // true

$Collection->next();
$Collection->key(); // 1
$Collection->valid(); // true
$Collection->current(); // two

$Collection->next();
$Collection->key(); // 2
$Collection->valid(); // true
$Collection->current(); // three

$Collection->next();
$Collection->key(); // 3
$Collection->valid(); // false

$Collection->prev();
$Collection->key(); // 2
$Collection->valid(); // true
$Collection->current(); // three

$Collection->rewind();
$Collection->key(); // 0
$Collection->valid(); // true
$Collection->current(); // one

```

Standard ArrayAccess API

```php
require_once __DIR__ '/vendor/autoload.php';

use Affinity4\Collection;

$Collection = new Collection([
    0       => 'one',
    1       => 'two',
    2       => 'three',
    'one'   => 1,
    'two'   => 2,
    'three' => 3
]);

$Collection[0]; // one
$Collection[1]; // two
$Collection[2]; // three

$Collection['one'];   // 1
$Collection['two'];   // 2
$Collection['three']; // 3

```
