# [Utilities](util.md) / [EventHandlerDecorator](util-EventHandlerDecorator.md) :: dispatchEventArgs
 > im\util\res\EventHandlerDecorator
____

## Description
Create an event from arguments and dispatch it

## Synopsis
```php
protected dispatchEventArgs(int $flag, null|string $subject = NULL, mixed $data = NULL, mixed $meta = NULL, bool $recursive = FALSE): void
```

## Parameters
| Name | Description |
| :--- | :---------- |
| flag | The event flag that defines the type of event this is |
| subject | An optional subject for this event |
| data | Optional data that can be attached to the event |
| meta | Additional information that can be attached to the event |
| recursive | Whether recursive calls is allowed on this event.<br />If not, the event stops propagation after a recursive event. |
