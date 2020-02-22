<?php

namespace App\Controller;

use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function home_page()
    {
        //return $this->render('steg/index.html.twig');
        return $this->redirectToRoute('projet_list');
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
    public function checklogin(Request $request)
    {
        if ($request->getMethod() == Request::METHOD_POST) {

            $admin = new Admin();

            $email = $request->request->get('email');
            $mot_de_passe = $request->request->get('mot_de_passe');

            $password = md5($mot_de_passe);

            $admin->setEmail($email);
            $admin->setPassword($password);

            $adminRepository = $this->getDoctrine()->getRepository(Admin::class);

            $result = $adminRepository->checkLogin($admin);

            if ($result) {
                return $this->redirectToRoute('home_page');
            } else {
                $this->addFlash('error','svp, vérifiez vos coordonées');
                return $this->redirectToRoute('login_page');
            }
        }

        return $this->redirectToRoute('login_page', array(
            'error' => ''
        ));
    }
}
