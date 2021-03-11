# [Utilities](util.md) / [EventHandlerDecorator](util-EventHandlerDecorator.md) :: setEventListener
 > im\util\res\EventHandlerDecorator
____

## Description
Set a new event listener on this handler.

 > You can "pipe" events together to add one listener on multiple events like `event1|event2`.  

## Synopsis
```php
public setEventListener(int $events, im\utils\EventListener|callable $listener): void
```

## Parameters
| Name | Description |
| :--- | :---------- |
| listener | The listener that will be called on the registered events |
