<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Form\AgenceType;
use App\Repository\AgenceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AgenceController extends AbstractController
{
    // repo variable
    private $agRepo;

    public function __construct(AgenceRepository $agenceRepository)
    {
        $this->agRepo = $agenceRepository;
    }

    #[Route('/addAgence/{id}', name: 'addAgence', methods: ['GET', 'POST'])]
    public function addAgence(Request $request, ManagerRegistry $managerRegistry, string $id)
    {
        // creation de l'objet vide si moins 1
        $agence = $this->agRepo->find(intval($id)) ?? new Agence();

        $form = $this->createForm(AgenceType::class, $agence); // on passe l'objet lors de la création du formulaire
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $managerRegistry->getManager();
            $em->persist($form->getData());
            $em->flush();
            $this->addFlash('success', "l'agence à été modifiée");
            return  $this->redirectToRoute('listAg');
        }


        return $this->render("home/form/formAgence.html.twig", [
           'form' => $form->createView(),
        ]);
    }


    #[Route('/delAgence/{id}', name: 'delAgence', methods: ['POST'])]
    public function delAgence(string $id, Request $request, ManagerRegistry $managerRegistry)
    {
        if($this->isCsrfTokenValid('delete'.$id, $request->get('_token'))){
            $em = $managerRegistry->getManager(); // instanciation de l'entity manager
            $agence = $this->agRepo->find(intval($id)); // récupération de l'objet
            $em->remove($agence); // préparation de la suppression
            $em->flush(); // execution de la suppression
        } else {
            $this->addFlash('error', "tantative d'intrusion");
        }
        return $this->redirectToRoute('listAg');
    }

}