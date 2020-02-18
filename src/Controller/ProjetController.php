<?php

namespace App\Controller;

use App\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/projet")
 */
class ProjetController extends AbstractController
{
    /**
     * @Route("/", name="projet_list")
     */
    public function index()
    {

        $projets = $this->getDoctrine()->getRepository(Projet::class)->findall();

        return $this->render('steg/projet/index.html.twig', array(
            'projets' => $projets
        ));
    }

    /**
     * @Route("/create", name="create_projet")
     */
    public function create()
    {
        return $this->render('steg/projet/create.html.twig');
    }

    /**
     * @Route("/store", name="store_projet", methods={"POST"})
     */
    public function store(Request $request)
    {

        if ($request->getMethod() == Request::METHOD_POST) {
            $projet = new Projet();

            $nom_du_projet = $request->request->get('nom_du_projet');
            $date_debut_s = $request->request->get('date_debut');
            $date_fin_s =  $request->request->get('date_fin');
            $budget = $request->request->get('budget');
            $description = $request->request->get('description');

            //$date_debut = date('Y-m-d', strtotime($date_debut_s));
            //$date_fin = date('Y-m-d', strtotime($date_fin_s));

            $date_debut = date_create_from_format('Y-m-d', $date_debut_s);
            $date_fin = date_create_from_format('Y-m-d', $date_fin_s);

            $projet->setNomProjet($nom_du_projet);
            $projet->setDateDebut($date_debut->getTimestamp());
            $projet->setDateFin($date_fin->getTimestamp());
            $projet->setBudget($budget);
            $projet->setDescription($description);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('projet_list');
        }


        return $this->render('steg/projet/create.html.twig');
    }

    /**
     * @Route("/edit/{id}", name="edit_entreprise")
     */
    public function edit($id)
    {
        $projet = new Projet();
        $projet = $this->getDoctrine()->getRepository(Projet::class)->find($id);

        return $this->render('steg/projet/edit.html.twig', array(
            'projet' => $projet
        ));
    }

    /**
     * @Route("/update", name="store_entreprise", methods={"POST"})
     */
    public function update(Request $request)
    {

        if ($request->getMethod() == Request::METHOD_POST) {
            $projet = new Projet();

            $id = $request->request->get('ent_id');

            $projet = $this->getDoctrine()->getRepository(Projet::class)->find($id);

            $nom_du_projet = $request->request->get('nom_du_projet');
            $date_debut_s = $request->request->get('date_debut');
            $date_fin_s =  $request->request->get('date_fin');
            $budget = $request->request->get('budget');
            $description = $request->request->get('description');

            $date_debut = strtotime($date_debut_s);
            $date_fin = strtotime($date_fin_s);

            $projet->setNomProjet($nom_du_projet);
            $projet->setDateDebut($date_debut);
            $projet->setDateFin($date_fin);
            $projet->setBudget($budget);
            $projet->setDescription($description);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('projet_list');
        }

        return $this->render('steg/projet/create.html.twig');
    }

    /**
     * @Route("/show/{id}", name="show_projet")
     */
    public function show($id)
    {

        $projet = new Projet();
        $projet = $this->getDoctrine()->getRepository(Projet::class)->find($id);

        return $this->render('steg/projet/show.html.twig', array(
            'projet' => $projet
        ));
    }

    /**
     * @Route("/destroy/{id}", name="delete_projet", methods={"DELETE"})
     */
    public function destroy(Request $request, $id)
    {
        $projet = new Projet();
        $projet = $this->getDoctrine()->getRepository(Projet::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($projet);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }
}
