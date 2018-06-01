<?php

namespace AppBundle\EventListener;


use AppBundle\Services\UserHomeDirService;
use CoreBundle\Entity\User;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Listener responsible to change the redirection when a form is successfully filled
 */
class FormSuccessListener implements EventSubscriberInterface
{
    private $router;
    private $userhome;

    public function __construct(UrlGeneratorInterface $router,  UserHomeDirService $userHomeDirService)
    {
        $this->router = $router;
        $this->userhome = $userHomeDirService;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_COMPLETED => array('onRegistrationCompleted',-10),

        );
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event)
    {

        $this->userhome->createHomeDir($event->getUser());

    }

}