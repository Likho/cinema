<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseController extends AbstractController
{
    protected $user;
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $authChecker = $this->container->get('security.authorization_checker');

        if ($authChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->user = $this->getUser();
        }
    }
}