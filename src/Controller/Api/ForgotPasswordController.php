<?php

namespace App\Controller\Api;

use App\Service\ForgotPasswordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ForgotPasswordController extends AbstractController
{
    /**
     * Submit forgotten password form
     *
     * @param Request $request
     * @param ForgotPasswordService $validatorService
     * @return JsonResponse
     */
    #[Route('/api/v1/forgot-password', methods: ['POST'])]
    public function __invoke(Request $request, ForgotPasswordService $validatorService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $errors = $validatorService->validate($data);
        if (!empty($errors)) {
            return new JsonResponse([
                'status' => 'error',
                'errors' => $errors
            ],
                422
            );
        }

        // Send mail for forgotten password with Mailer here...

        return $this->json([
            'status'  => 'success',
            'message' => 'If the email exists in our system, you will receive instructions to reset your password.',
        ]);
    }
}
