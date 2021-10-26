<?php declare(strict_types=1);
/*
 * This file is part of the IMPHP Project: https://github.com/IMPHP
 *
 * Copyright (c) 2021 Daniel Bergløv, License: MIT
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO
 * THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR
 * THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * ---------------------------------------------------------
 * Based on PHPTerminalProgressBar by @MacroMan
 */

namespace im\util;

use Closure;
use im\io\Stream;
use im\io\RawStream;

/**
 * Provides a CLI Progress bar that can be used for terminal scripts.
 *
 * @example
 *
 *      ```php
 *      $progress = new CLIProgress();
 *      $progress->start(100, "Running");
 *
 *      for ($i=0; $i < 100; $i++) {
 *          $progress->update($i);
 *      }
 *
 *      $progress->stop();
 *      ```
 *
 *      Output:
 *      ```sh
 *      Running [=====          ] 33% - 33/100
 *      ```
 */
class CLIProgress {

    /** @ignore */
    const CLEAR = "\033[1G\033[2K"; // Clear line

    /** @ignore */
    const HIDE = "\033[?25l"; // Hide cursor

    /** @ignore */
    const SHOW = "\033[?25h"; // Show cursor

    /** @ignore */
    protected bool $cAsyncSig = false;

    /** @ignore */
    protected ?Closure $mHandler = null;

    /** @ignore */
    protected Stream $mStream;

    /** @ignore */
    protected int $mProgressMax = 0;

    /** @ignore */
    protected int $mProgressDone = 0;

    /** @ignore */
    protected float $mUpdated = 0;

    /** @ignore */
    protected string $mLayout = ":text: :bar: :percent:% - :done:/:total:";

    /** @ignore */
    protected int $mLayoutWidth;

    /** @ignore */
    protected string $mLayoutText = "";

    /**
     * @param $stream
     *      The stream to draw the progress.
     *      By default it uses `STDERR`.
     */
    public function __construct(?Stream $stream = NULL) {
        if ($stream == null) {
            $stream = new RawStream(STDERR);
        }

        $width = exec("tput cols");

        if (!is_numeric($width)) {
            $width = 80;
        }

        $this->mStream = $stream;
        $this->mLayoutWidth = intval($width);
    }

    /**
     * @ignore
     */
    public function __destruct() {
        $this->stop();
    }

    /**
     * Change the layout.
     *
     * | Token      | Description                       |
     * | ---------- | --------------------------------- |
     * | :bar:      | The progress bar                  |
     * | :percent:  | The current percentage            |
     * | :done:     | Current progress state            |
     * | :total:    | Total progress to reach           |
     * | :text:     | The optional text from start()    |
     *
     * @param $layout
     *      The new layout
     *
     * @example
     *
     *      ```php
     *      $progress->setLayout(":text: :bar: :percent:% - :done:/:total:");
     *      ```
     */
    public function setLayout(string $layout): void {
        $this->mLayout = $layout;
    }

    /**
     * Print a message above the progress bar.
     *
     * @param $message
     *      The message to print
     */
    public function interupt($message): void {
        if ($this->mHandler != null) {
            if (strrpos($message, -1) != "\n") {
                $message .= "\n";
            }

            $this->mStream->write(CLIProgress::CLEAR);
            $this->mStream->write($message);

            $this->draw();
        }
    }

    /**
     * Start a new progress bar.
     *
     * @param $max
     *      The total progress to reach
     *
     * @param $text
     *      Text for the `:text:` layout option
     */
    public function start(int $max, ?string $text = null): void {
        if ($this->mHandler == null) {
            $this->mProgressMax = $max;
            $this->mLayoutText = $text ?? "";
            $this->cAsyncSig = pcntl_async_signals(true);
            $this->mHandler = Closure::fromCallable(function(int $signo, mixed $siginfo): void {
                $this->stop();
                exit(1);

            })->bindTo($this);

            $this->mStream->write(CLIProgress::HIDE);

            pcntl_signal(SIGINT, $this->mHandler);
        }
    }

    /**
     * Stop this progress and return the terminal to working state.
     */
    public function stop(): void {
        if ($this->mHandler != null) {
            /*
             * Needs an extra update to reach full status.
             * Otherwise it may end at 97% despite being at 100%
             */
            $this->draw();

            pcntl_async_signals($this->cAsyncSig);
            pcntl_signal(SIGINT, SIG_DFL);

            $this->mStream->write(CLIProgress::SHOW);
            $this->mStream->write("\n");
            $this->mHandler = null;
        }
    }

    /**
     * Update the progress.
     *
     * @param $done
     *      Current progress state
     */
    public function update(int $done): void {
        if ($this->mHandler != null) {
            $this->mProgressDone = $done;

            if (($elapsed = microtime(true)) - $this->mUpdated >= 0.1) {
                $this->mUpdated = $elapsed;
                $this->draw();
            }
        }
    }

    /**
     * @internal
     */
    protected function draw(): void {
        $percent = intval($this->mProgressDone / $this->mProgressMax * 100);
        $output = str_replace(
            [":text:", ":percent:", ":done:", ":total:"],
            [$this->mLayoutText, $percent, $this->mProgressDone, $this->mProgressMax],
            $this->mLayout
        );

        if (strpos($output, ":bar:") !== false) {
            /*
             * When calculating, we leave room for the [] characters and also
             * leave 2 characters free space for ^C when manually triggering SIGINT.
             * Otherwise the last call to 'draw()' will draw it on a new line.
             */
            $remaining = $this->mLayoutWidth - strlen($output) + 1;
            $left = intval($this->mProgressDone / $this->mProgressMax * $remaining);
            $right = $remaining - $left;

            $output = str_replace(":bar:", "[" . str_repeat("=", $left) . str_repeat(" ", $right) . "]", $output);
        }

        $this->mStream->write(CLIProgress::CLEAR);
        $this->mStream->write($output);
    }
}
