<?php

namespace UserBundle\EventListener;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Listener responsible to change the redirection at the end of the registering an account
 */

class RegistrationListener implements EventSubscriberInterface
{
    private $router;
    private $session;
    public function __construct(UrlGeneratorInterface $router, Session $session)
    {
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted',
            FOSUserEvents::REGISTRATION_CONFIRMED => 'onRegistrationConfirmed',

            );
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event)
    {
        /** @var RedirectResponse $response */
        $response = $event->getResponse();
        $response->setTargetUrl($this->router->generate('home'));
    }

    public function onRegistrationConfirmed(FilterUserResponseEvent $event)
    {
        /** @var RedirectResponse $response */
        $this->session->getFlashBag()->add('success', 'Gratulacje, potwierdziłeś swoje konto!');
        $response = $event->getResponse();
        $response->setTargetUrl($this->router->generate('home'));
    }

}