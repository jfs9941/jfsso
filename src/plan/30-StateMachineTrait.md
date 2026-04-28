# Jfs\Uploader\Core\Traits\StateMachineTrait

**File:** `smoke/Uploader/Core/Traits/StateMachineTrait.php`

## Use Statements
```php
Jfs\Uploader\Contracts\StateChangeObserverInterface
Jfs\Uploader\Enum\FileStatus
Jfs\Uploader\Exception\InvalidStateTransitionException
Illuminate\Database\Eloquent\Model
```

## Properties
- `private $observers = []`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| transitionTo | 18 |
| canTransitionTo | 29 |
