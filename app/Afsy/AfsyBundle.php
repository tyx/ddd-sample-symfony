<?php

namespace Afsy\Kernel;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

class AfsyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(
            new RegisterListenersPass(
                'afsy.booking_engine.event_dispatcher',
                'afsy.booking_engine.event_listener',
                'afsy.booking_engine.event_subscriber'
            )
        );
    }
}
