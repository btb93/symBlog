<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('blog/admin.html.twig');
        }
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/", name="home")
     *
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }
}
