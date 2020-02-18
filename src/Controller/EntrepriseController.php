<?php

namespace App\Controller;

use App\Entity\Entreprise;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entreprise")
 */
class EntrepriseController extends AbstractController
{
    /**
     * @Route("/", name="entreprise_list")
     */
    public function index()
    {

        $entreprises = $this->getDoctrine()->getRepository(Entreprise::class)->findall();

        return $this->render('steg/entreprise/index.html.twig', array(
            'entreprises' => $entreprises
        ));
    }

    /**
     * @Route("/create", name="create_entreprise")
     */
    public function create()
    {
        return $this->render('steg/entreprise/create.html.twig');
    }

    /**
     * @Route("/store", name="store_entreprise", methods={"POST"})
     */
    public function store(Request $request)
    {

        if ($request->getMethod() == Request::METHOD_POST) {
            $entreprise = new Entreprise();

            $nom_d_entreprise = $request->request->get('nom_d_entreprise');
            $responsable = $request->request->get('responsable');
            $email = $request->request->get('email');
            $num_tel = $request->request->get('num_tel');

            $entreprise->setNomEnt($nom_d_entreprise);
            $entreprise->setResponsable($responsable);
            $entreprise->setEmail($email);
            $entreprise->setNumTel($num_tel);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('entreprise_list');
        }


        return $this->render('steg/entreprise/create.html.twig');
    }

    /**
     * @Route("/edit/{id}", name="edit_entreprise")
     */
    public function edit($id)
    {
        $entreprise = new Entreprise();
        $entreprise = $this->getDoctrine()->getRepository(Entreprise::class)->find($id);

        return $this->render('steg/entreprise/edit.html.twig', array(
            'entreprise' => $entreprise
        ));
    }

    /**
     * @Route("/update", name="store_entreprise", methods={"POST"})
     */
    public function update(Request $request)
    {

        if ($request->getMethod() == Request::METHOD_POST) {
            $entreprise = new Entreprise();

            $id = $request->request->get('ent_id');

            $entreprise = $this->getDoctrine()->getRepository(Entreprise::class)->find($id);

            $nom_d_entreprise = $request->request->get('nom_d_entreprise');
            $responsable = $request->request->get('responsable');
            $email = $request->request->get('email');
            $num_tel = $request->request->get('num_tel');

            $entreprise->setNomEnt($nom_d_entreprise);
            $entreprise->setResponsable($responsable);
            $entreprise->setEmail($email);
            $entreprise->setNumTel($num_tel);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('entreprise_list');
        }

        return $this->render('steg/entreprise/create.html.twig');
    }

    /**
     * @Route("/show/{id}", name="show_entreprise")
     */
    public function show($id)
    {

        $entreprise = new Entreprise();
        $entreprise = $this->getDoctrine()->getRepository(Entreprise::class)->find($id);

        return $this->render('steg/entreprise/show.html.twig', array(
            'entreprise' => $entreprise
        ));
    }

    /**
     * @Route("/destroy/{id}", name="delete_p", methods={"DELETE"})
     */
    public function destroy(Request $request, $id)
    {
        $entreprise = new Entreprise();
        $entreprise = $this->getDoctrine()->getRepository(Entreprise::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($entreprise);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }
}
