<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;


class RegistrationController extends BaseController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository, ContainerInterface $container)
    {
        parent::__construct($container);
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request): Response
    {
        if ($this->user != null) {
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
            'user' => $this->user,
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
