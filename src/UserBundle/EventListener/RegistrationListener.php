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
            FOSUserEvents::REGISTRATION_FAILURE => 'onRegistrationFailure',
            );
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event)
    {
        /** @var RedirectResponse $response */
        $response = $event->getResponse();
        $response->setTargetUrl($this->router->generate('home'));
    }

    public function onRegistrationFailure(FormEvent $event)
    {
        $this->session->getFlashBag()->add('warning', 'Wystąpił błąd podczas rejestracji. Proszę spróbować później!');
        $url = $this->router->generate('home');
        $event->setResponse(new RedirectResponse($url));
    }
}