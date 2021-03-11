# [Utilities](util.md) / [Event](util-Event.md) :: __construct
 > im\util\Event
____

## Synopsis
```php
public __construct(int $flag, im\util\EventHandler $target, null|string $subject = NULL, mixed $data = NULL, mixed $meta = NULL, bool $recursive = FALSE)
```

## Parameters
| Name | Description |
| :--- | :---------- |
| flag | The event flag that defines the type of event this is |
| target | The event handler that triggered this event |
| subject | An optional subject for this event |
| data | Optional data that can be attached to the event |
| meta | Additional information that can be attached to the event |
| recursive | Whether recursive calls is allowed on this event.<br />If not, the event stops propagation after a recursive event. |
