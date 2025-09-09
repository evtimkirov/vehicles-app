<?php

namespace App\EventSubscriber;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Customise the JWT error messages
 */
class JWTErrorSubscriber implements EventSubscriberInterface
{
    /**
     * JWT events for the failed data
     *
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationFailureEvent::class => 'onAuthenticationFailure',
            JWTInvalidEvent::class            => 'onJwtInvalid',
            JWTExpiredEvent::class            => 'onJwtExpired',
            JWTNotFoundEvent::class           => 'onJwtNotFound',
            ExceptionEvent::class             => 'onKernelException',
        ];
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event): void
    {
        $this->setErrorResponse($event, 'Invalid email or password.', JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function onJwtInvalid(JWTInvalidEvent $event): void
    {
        $this->setErrorResponse($event, 'Token is invalid.', JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function onJwtExpired(JWTExpiredEvent $event): void
    {
        $this->setErrorResponse($event, 'Token has expired.', JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function onJwtNotFound(JWTNotFoundEvent $event): void
    {
        $this->setErrorResponse($event, 'Authorization token not found.', JsonResponse::HTTP_UNAUTHORIZED);
    }

    private function setErrorResponse($event, string $message, int $statusCode): void
    {
        $data = [
            'status'  => 'error',
            'message' => $message,
        ];

        $event->setResponse(new JsonResponse($data, $statusCode));
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof BadRequestHttpException && str_contains($exception->getMessage(), 'The key "email"')) {
            $response = new JsonResponse([
                'status' => 'error',
                'message' => 'Email is required.',
            ], 400);

            $event->setResponse($response);
            $event->stopPropagation();
        }
    }
}
