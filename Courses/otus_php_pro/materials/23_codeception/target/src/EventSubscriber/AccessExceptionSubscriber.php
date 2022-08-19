<?php

namespace App\EventSubscriber;

use App\DTO\BadRequestDTO;
use App\DTO\ForbiddenDTO;
use App\DTO\UnauthorizedDTO;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AccessExceptionSubscriber implements EventSubscriberInterface
{
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof AccessDeniedHttpException) {
            $response = new Response();
            $content = new ForbiddenDTO();
            $response->setContent($this->serializer->serialize($content, 'json'));
            $response->setStatusCode($content->getCode());
            $event->setResponse($response);

            return;
        }

        if ($exception instanceof BadRequestHttpException) {
            $response = new Response();
            $content = new BadRequestDTO();
            $response->setContent($this->serializer->serialize($content, 'json'));
            $response->setStatusCode($content->getCode());
            $event->setResponse($response);

            return;
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
