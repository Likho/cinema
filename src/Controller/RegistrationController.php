<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request): Response
    {
        if ($this->getUser() != null) {
            return  $this->redirect('/');
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $validationErrors = [];
        $registrationError = '';
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $this->userRepository->save($user);
                    return $this->redirectToRoute('app_login');
                } catch (\Exception $exception) {
                    $registrationError = $exception->getMessage();
                }

            }
            $validationErrors = $this->getErrorsFromForm($form);
        }
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
            'validationErrors' => $validationErrors,
            'registrationError' => $registrationError,
        ]);
    }

    private function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }
}
