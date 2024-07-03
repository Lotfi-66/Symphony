<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AnnonceController extends AbstractController
{
    private $repoAn;
    private $manReg;

    public function __construct(AnnonceRepository $annonceRepository,
                                ManagerRegistry $managerRegistry)
    {
        $this->repoAn = $annonceRepository;
        $this->manReg = $managerRegistry;
    }

    /**
     * liste de l'ensemble des annonces
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route("/listAnnonce", name: "listAn", methods: ['GET'])]
    public function listAnnonce(PaginatorInterface $paginator, Request $request)
    {
//         $annonces = $this->repoAn->findAllAnnonces();
        // $annonces = $this->repoAn->findAllByOrderDate('datePublication', 'DESC');
//        dump($annonces);
        // tableau d'annonce avec paginator
        $annonces = $paginator->paginate($this->repoAn->findAllByOrderDateQuery('datePublication', 'DESC'),
            $request->query->getInt('page', 1), 6);
        return $this->render("home/listAnnonce.html.twig",[
            "annonces" => $annonces,
        ]);
    }

    /**
     * affichage du détail d'une annonce
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/detailAnnonce', name: 'detailAn', methods: ['GET'])]
    public function detailAnnonce()
    {
        return $this->render('home/detailAnnonce.html.twig',[

        ]);
    }

    /**
     * ajout ou modification d'une annonce
     * @param string $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/addOrEditAn/{id}', name: "addOrEditAn", methods: ['GET','POST'])]
    public function addOrEditAn(string $id, Request $request)
    {

        $annonce = $this->repoAn->find(intval($id)) ?? new Annonce(); // objet vide si il n'existe pas dans la table
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $message = ($annonce->getId() == '') ? "l'annonce est enregistrée" : "l'annonce est modifiée";
            $em = $this->manReg->getManager();
            $em->persist($form->getData());
            $em->flush();
            $this->addFlash('success', $message);
            return $this->redirectToRoute('listAn');
        }

        return $this->render('home/form/formAnnonce.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * suppression d'une annonce
     * @param string $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    #[Route('/delAnnonce/{id}', name: 'delAn', methods: ['POST'])]
    public function delAnnonce(string $id, Request $request)
    {
        if($this->isCsrfTokenValid('deleteAn'.$id, $request->get('_token'))){
            $em = $this->manReg->getManager();
            $annonce = $this->repoAn->find(intval($id));
            $em->remove($annonce);
            $em->flush();
            $this->addFlash('success', "l'annonce a bien été supprimé");
        }
        return $this->redirectToRoute('listAn');
    }

}