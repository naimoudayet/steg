<?php

namespace App\Controller;

use App\Entity\Entreprise;
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
        $entreprises = $this->getDoctrine()->getRepository(Entreprise::class)->findall();
        return $this->render('steg/projet/create.html.twig', array(
            'entreprises' => $entreprises
        ));
    }

    /**
     * @Route("/store", name="store_projet", methods={"POST"})
     */
    public function store(Request $request)
    {

        if ($request->getMethod() == Request::METHOD_POST) {
            $projet = new Projet();

            $id = $request->request->get('entreprise');
            $nom_du_projet = $request->request->get('nom_du_projet');
            $date_debut = $request->request->get('date_debut');
            $date_fin =  $request->request->get('date_fin');
            $budget = $request->request->get('budget');
            $description = $request->request->get('description');

            $entreprise = $this->getDoctrine()->getRepository(Entreprise::class)->find($id);

            $projet->setNomProjet($nom_du_projet);
            $projet->setDateDebut($date_debut);
            $projet->setDateFin($date_fin);
            $projet->setBudget($budget);
            $projet->setDescription($description);
            $projet->setEntreprise($entreprise);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('projet_list');
        }


        return $this->render('steg/projet/create.html.twig');
    }

    /**
     * @Route("/edit/{id}", name="edit_projet")
     */
    public function edit($id)
    {
        $projet = new Projet();
        $projet = $this->getDoctrine()->getRepository(Projet::class)->find($id);

        $entreprises = $this->getDoctrine()->getRepository(Entreprise::class)->findall();

        return $this->render('steg/projet/edit.html.twig', array(
            'projet' => $projet,
            'entreprises' => $entreprises
        ));
    }

    /**
     * @Route("/update", name="update_projet", methods={"POST"})
     */
    public function update(Request $request)
    {

        if ($request->getMethod() == Request::METHOD_POST) {
            $projet = new Projet();

            $id = $request->request->get('ent_id');
            $ide = $request->request->get('entreprise');

            $projet = $this->getDoctrine()->getRepository(Projet::class)->find($id);
            $entreprise = $this->getDoctrine()->getRepository(Entreprise::class)->find($ide);

            $nom_du_projet = $request->request->get('nom_du_projet');
            $date_debut = $request->request->get('date_debut');
            $date_fin =  $request->request->get('date_fin');
            $budget = $request->request->get('budget');
            $description = $request->request->get('description');
 
            $projet->setNomProjet($nom_du_projet);
            $projet->setDateDebut($date_debut);
            $projet->setDateFin($date_fin);
            $projet->setBudget($budget);
            $projet->setDescription($description);
            $projet->setEntreprise($entreprise);

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

    /**
     * @Route("/search", name="search_projet")
     */
    public function search(Request $request)
    {
        if ($request->getMethod() == Request::METHOD_POST) {

            $keyword = $request->request->get('keyword');

            $projetRepository = $this->getDoctrine()->getRepository(Projet::class);

            $projets = $projetRepository->findByKeyword($keyword);

            return $this->render('steg/projet/search.html.twig', array(
                'projets' => $projets
            ));
        }
        return $this->redirectToRoute('projet_list');
    }
}
