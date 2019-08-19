<?php

namespace Jialbanc\Ami\Tests;

use Clue\React\Ami\Factory;
use React\EventLoop\LoopInterface;
use React\Socket\ConnectorInterface;
use React\Stream\WritableResourceStream;

class AmiServiceProvider extends \Jialbanc\Ami\AmiServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->registerStream();
        parent::register();
    }

    /**
     * Register stream.
     */
    protected function registerStream()
    {
        $this->app->singleton(WritableResourceStream::class, function ($app) {
            return new WritableResourceStream(fopen('php://memory', 'r+'), $app[LoopInterface::class]);
        });
        $this->app->alias(WritableResourceStream::class, 'ami.stream');
    }

    /**
     * {@inheritdoc}
     */
    protected function registerFactory()
    {
        $this->app->singleton(Factory::class, function ($app) {
            return new Factory($app[LoopInterface::class], $app[ConnectorInterface::class]);
        });
        $this->app->alias(Factory::class, 'ami.factory');
    }
}
