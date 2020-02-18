<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function home_page()
    {
        return $this->render('steg/index.html.twig');
    }

    /**
     * @Route("/login", name="login_page")
     */
    public function login_page()
    {
        return $this->render('steg/login.html.twig');
    }

    /**
     * @Route("/checklogin", name="checklogin", methods={"POST"})
     */
    public function checklogin()
    {
        return $this->redirectToRoute('home_page');
    }
}
