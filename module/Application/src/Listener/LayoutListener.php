<?php

namespace Application\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class LayoutListener extends AbstractListenerAggregate
{
    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     * @param int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $events->attach(
            MvcEvent::EVENT_DISPATCH,
            [$this, 'initializeLayout']
        );
    }

    /**
     * Initialise les layouts
     * @param MvcEvent $event
     */
    public function initializeLayout(MvcEvent $event)
    {
        if ($event->getRouteMatch() === null) {
            $this->initializeDefaultLayout($event);
        }
        elseif (strpos($event->getRouteMatch()->getMatchedRouteName(), 'admin-') === 0) {
            $this->initializeBackofficeLayout($event);
        }
        else {
            $this->initializeDefaultLayout($event);
        }
    }

    /**
     * Initialize le layout par défaut
     * @param MvcEvent $event
     */
    private function initializeDefaultLayout(MvcEvent $event)
    {
        $serviceManager = $event->getApplication()->getServiceManager();
        $viewHelperManager = $serviceManager->get('ViewHelperManager');

        $viewHelperManager->get('headTitle')
            ->setSeparator(' - ')
            ->append('Blog')
            ->setAutoEscape(false)
        ;
    }

    /**
     * Initialise le layout pour l'administration
     * @param MvcEvent $event
     */
    private function initializeBackofficeLayout(MvcEvent $event)
    {
        $layout = $event->getViewModel();
        $layout->setTemplate('layout/backoffice');

        $serviceManager = $event->getApplication()->getServiceManager();
        $viewHelperManager = $serviceManager->get('ViewHelperManager');

        $viewHelperManager->get('headTitle')
            ->setSeparator(' - ')
            ->append('Blog - Administration')
            ->setAutoEscape(false)
        ;
    }
}