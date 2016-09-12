<?php

namespace Application;

use Application\Listener\LayoutListener;
use Zend\Mvc\MvcEvent;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();

        (new LayoutListener())->attach($eventManager);
    }
}
