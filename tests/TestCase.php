<?php

namespace Jialbanc\Ami\Tests;

use Illuminate\Config\Repository;
use React\EventLoop\LoopInterface;
use Illuminate\Container\Container;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Console\Application as Console;
use React\Stream\WritableResourceStream;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \React\EventLoop\LoopInterface
     */
    protected $loop;

    /**
     * @var \React\Stream\WritableResourceStream
     */
    protected $stream;

    /**
     * @var bool
     */
    protected $running;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $app = new Container();
        $app->instance('config', new Repository());
        (new EventServiceProvider($app))->register();
        (new AmiServiceProvider($app))->register();
        $this->loop = $app[LoopInterface::class];
        $this->loop->futureTick(function () {
            if (!$this->running) {
                $this->loop->stop();
            }
        });
        $this->stream = $app[WritableResourceStream::class];
        $this->events = $app['events'];
        $this->app = $app;
    }

    /**
     * Call console command.
     *
     * @param string $command
     * @param array $options
     * @return int
     */
    protected function console($command, array $options = [])
    {
        return (new Console($this->app, $this->events, '5.3'))->call($command, $options);
    }
}
