<?php

namespace ByTIC\EventDispatcher\Tests\ListenerProviders\Traits;

use ByTIC\EventDispatcher\ListenerProviders\DefaultProvider;
use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Listeners\SimpleListener;

/**
 * Class ProviderUtilitiesTraitTest
 * @package ByTIC\EventDispatcher\Tests\ListenerProviders\Traits
 */
class ProviderUtilitiesTraitTest extends AbstractTest
{
    public function testMakeListenerWithString()
    {
        $provider = new DefaultProvider();
        $listener = $provider->makeListener(SimpleListener::class);

        self::assertIsCallable($listener);
    }
}