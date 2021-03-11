<?php declare(strict_types=1);
/*
 * This file is part of the IMPHP Project: https://github.com/IMPHP
 *
 * Copyright (c) 2016 Daniel Bergløv, License: MIT
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
 */

namespace im\util\res;

use im\utils\MapArray;
use im\utils\HashMap;
use im\utils\Event;
use im\utils\EventListener;

/**
 * Provides an implementation of `im\util\EventHandler`.
 */
trait EventHandlerDecorator {

    /** @internal */
    protected MapArray $_listeners;

    /** @internal */
    protected int $_availableFlags = 0;

    /** @internal */
    protected int $_activeFlags = 0;

    /**
     * This should be called from the main class constructor
     */
    protected function __trait_construct() {
        $this->_listeners = new HashMap();
    }

    /**
     * Dispatch an event
     *
     * @param $event
     *      An event object
     */
    protected function dispatchEvent(Event $event): void {
        $flag = $event->flag;

        if ($this->_availableFlags & $flag) {
            /*
             * Deal with recursive calls
             */
            $this->_activeFlags |= $flag;

            foreach ($this->_listeners as $listener => $flags) {
                if (!($this->_activeFlags & $flag)
                        && !$event->recursive) {

                    // The last listener just made a recursive dispatch
                    break;

                } else if ($flags & $flag) {
                    if ($listener instanceof EventListener) {
                        $listener->onEvent($event);

                    } else {
                        $listener($event);
                    }
                }
            }

            $this->_activeFlags &= ~$flag;
        }
    }

    /**
     * Create an event from arguments and dispatch it
     *
     * @param $flag
     *      The event flag that defines the type of event this is
     *
     * @param $subject
     *      An optional subject for this event
     *
     * @param $data
     *      Optional data that can be attached to the event
     *
     * @param $meta
     *      Additional information that can be attached to the event
     *
     * @param $recursive
     *      Whether recursive calls is allowed on this event.
     *      If not, the event stops propagation after a recursive event.
     */
    protected function dispatchEventArgs(int $flag, string $subject = null, mixed $data = null, mixed $meta = null, bool $recursive = false): void {
        if ($this->_availableFlags & $flag) {
            $this->dispatchEvent(new Event(
                $flag,
                $this,
                $subject,
                $data,
                $meta,
                $recursive
            ));
        }
    }

    /**
     * @inheritDoc
     */
    #[Override("im\util\EventHandler")]
    public function setEventListener(int $events, callable|EventListener $listener): void {
        $flags = $this->_listeners->get($listener);

        if ($flags == null || $flags != $events) {
            $this->_listeners->set($listener, $events);

            if ($flags != null) {
                /*
                 * This listener updated the flags
                 */
                $this->_availableFlags = 0;

                foreach ($this->_listeners as $listener => $flags) {
                    $this->_availableFlags |= $flags;
                }

            } else {
                $this->_availableFlags |= $events;
            }
        }
    }
}
