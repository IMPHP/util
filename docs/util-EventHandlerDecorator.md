# [Utilities](util.md) / EventHandlerDecorator
 > im\util\res\EventHandlerDecorator
____

## Description
Provides an implementation of `im\util\EventHandler`.

## Synopsis
```php
trait EventHandlerDecorator {

    // Methods
    protected __trait_construct()
    protected dispatchEvent(im\utils\Event $event): void
    protected dispatchEventArgs(int $flag, null|string $subject = NULL, mixed $data = NULL, mixed $meta = NULL, bool $recursive = FALSE): void
    public setEventListener(int $events, im\utils\EventListener|callable $listener): void
}
```

## Methods
| Name | Description |
| :--- | :---------- |
| [__EventHandlerDecorator&nbsp;::&nbsp;\_\_trait\_construct__](util-EventHandlerDecorator-__trait_construct.md) | This should be called from the main class constructor |
| [__EventHandlerDecorator&nbsp;::&nbsp;dispatchEvent__](util-EventHandlerDecorator-dispatchEvent.md) | Dispatch an event |
| [__EventHandlerDecorator&nbsp;::&nbsp;dispatchEventArgs__](util-EventHandlerDecorator-dispatchEventArgs.md) | Create an event from arguments and dispatch it |
| [__EventHandlerDecorator&nbsp;::&nbsp;setEventListener__](util-EventHandlerDecorator-setEventListener.md) | Set a new event listener on this handler |
