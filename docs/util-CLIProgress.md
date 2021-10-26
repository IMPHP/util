# [Utilities](util.md) / CLIProgress
 > im\util\CLIProgress
____

## Description
Provides a CLI Progress bar that can be used for terminal scripts.

## Synopsis
```php
class CLIProgress {

    // Methods
    public __construct(null|im\io\Stream $stream = NULL)
    public setLayout(string $layout): void
    public interupt($message): void
    public start(int $max, null|string $text = NULL): void
    public stop(): void
    public update(int $done): void
}
```

## Methods
| Name | Description |
| :--- | :---------- |
| [__CLIProgress&nbsp;::&nbsp;\_\_construct__](util-CLIProgress-__construct.md) |  |
| [__CLIProgress&nbsp;::&nbsp;setLayout__](util-CLIProgress-setLayout.md) | Change the layout |
| [__CLIProgress&nbsp;::&nbsp;interupt__](util-CLIProgress-interupt.md) | Print a message above the progress bar |
| [__CLIProgress&nbsp;::&nbsp;start__](util-CLIProgress-start.md) | Start a new progress bar |
| [__CLIProgress&nbsp;::&nbsp;stop__](util-CLIProgress-stop.md) | Stop this progress and return the terminal to working state |
| [__CLIProgress&nbsp;::&nbsp;update__](util-CLIProgress-update.md) | Update the progress |

## Example 1
```php
$progress = new CLIProgress();
$progress->start(100, "Running");

for ($i=0; $i < 100; $i++) {
    $progress->update($i);
}

$progress->stop();
```

Output:
```sh
Running [=====          ] 33% - 33/100
```
