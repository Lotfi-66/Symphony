<?php

namespace App\Controller;

use App\Repository\AgenceRepository;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
//    private $articles = [
//        ["titre"=> "le grand maulne",
//            "resume"=> "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid deleniti dolorum eveniet fuga incidunt iste magnam minima nihil omnis possimus quae, qui, quod recusandae rem rerum sint sunt voluptatem.",
//            "img" =>"p2", "prix"=> 25.50 ],
//        ["titre"=> "Les guerres de l'étoile",
//            "resume"=>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid deleniti dolorum eveniet fuga incidunt iste magnam minima nihil omnis possimus quae, qui, quod recusandae rem rerum sint sunt voluptatem.",
//            "img"=>"p4", "prix" => 28.90 ],
//        ["titre"=> "La communauté de l'anneau",
//            "resume"=>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid deleniti dolorum eveniet fuga incidunt iste magnam minima nihil omnis possimus quae, qui, quod recusandae rem rerum sint sunt voluptatem.",
//            "img"=>"p6", "prix" => 30.15 ],
//    ];

    private $data = [];
    private $absolutPath;

    public function __construct(ParameterBagInterface $param)
    {
        $this->absolutPath = $param->get('kernel.project_dir'); // récupération du chemin absolu vie l'injection d'interface
        $this->loadData($this->absolutPath); // chargement des données
    }

    /**
     * @return void
     * charger et décoder le json
     */
    private function loadData($absPath){
        // chemin de mon fichier json
//        $path2 = "/var/www/html/images/p6.jpg";
        $path = $absPath . "/public/data/data.json";
        // lecture du fichier
        $json = file_get_contents($path);
        // décodage + modification du tableau de donnée
        $this->data = $this->changeTab(json_decode($json, true));
    }

    /**
     * @param $data
     * @return void
     * sauvegarde du json
     */
    private function saveData($data)
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        $path = $this->absolutPath . "/public/data/data.json";
        $fp = fopen($path, 'w');
        fwrite($fp, $json);
        fclose($fp);
//        $this->loadData($this->absolutPath);
    }

    #[Route("/", name: "homepage",methods: ['GET'])]
    public function bienvenue() // premier methode
    {

//        dump($this->data);
        $date = new \DateTime();
        return $this->render("home/homepage.html.twig", [
            "articles" => $this->data,
            "titrepage" => "noUs listons des articles",
            "dateDuJour" => $date->format("Y-m-d"),
        ]);

//        return new Response(
//            "<html><head><title>Première vue</title></head>
//            <body><h1>Welcome</h1>
//            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
//            Itaque, vitae voluptatibus. Autem hic itaque laborum maiores minus sed.
//            Asperiores assumenda commodi dolores ipsum molestiae officiis quae saepe
//            suscipit tempora voluptatem.</p>
//            <p><a href='/page/1'>page1</a>&nbsp;<a href='/page/2'>page2</a></p>
//            </body></html>"
//        );
    }

    #[Route("/article/{numdetail}", name: "detailpage", methods: ['GET'])]
    public function detail(string $numdetail)
    {
//        $tabArticles = $this->changeTab($this->articles);
        $tabArticles = $this->data;


        return $this->render("home/detail.html.twig",[
            "article" => $tabArticles[intval($numdetail)],
            "articles" => $tabArticles,
        ]);
    }

    #[Route("/listArticles/{articles}", name: "listArticles", methods: ['GET'])]
    public function listArticles($articles)
    {
//        dump($articles);
//        dump($this->articles);
        $tabArticles = json_decode($articles, true);

        $tabArticles =  $this->changeTab($tabArticles);
//        dump($tabArticles);
        return $this->render("home/templatePart/_listeArticles.html.twig", [
            "articles" => $tabArticles,
        ]);
    }


    // function de page
    #[Route("/page/{numpage}", methods: ['GET'])]
    public function page(string $numpage)
    {
        return new Response(
            "<html><head><title>Page $numpage</title></head>
            <body><h1>Welcome sur la page $numpage</h1>
            <p>je suis à l'école</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
            Itaque, vitae voluptatibus. Autem hic itaque laborum maiores minus sed. 
            Asperiores assumenda commodi dolores ipsum molestiae officiis quae saepe 
            suscipit tempora voluptatem.</p>
            <p><a href='/page/1'>page1</a>&nbsp;<a href='/page/2'>page2</a></p>
            </body></html>"
        );
    }

    #[Route('/addArticle', name: 'addArticle', methods: ['GET', 'POST'])]
    public function addArticle(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('titre', TextType::class,[
                'required' => false,
                'label' => "Titre de l'article",

            ])
            ->add('resume', TextType::class)
            ->add('prix', NumberType::class)
            ->add('img', TextType::class)
            ->add('enregistre', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $this->data[] = $data;
            $this->saveData($this->data);
            return $this->redirectToRoute('homepage');
            // dump($data);
        }
        return $this->render("home/form/formArticle.html.twig",[
            'form' => $form->createView()
        ]);

//        $newArticle = [
//            "titre" => "un autre livre",
//            "resume" => "bla bla bla",
//            "prix" => 15.40,
//            "img" => "p4.jpg",
//        ];
//        $this->data[] = $newArticle;
////        array_push($this->data, $newArticle);
//        $this->saveData($this->data);
//
//        return $this->redirectToRoute('homepage');
    }


    /**
     * @param array $tab
     * @return array
     *
     * changement du contenue du tableau
     */
    private function changeTab(array $tab) : array
    {
        foreach ($tab as $key => $art){ // parcour du tableau
            $art['ttc'] = $art['prix'] * 1.2; // ajout de l'index ttc
            $tab[$key] = $art;
        }
        return $tab;
    }

    #[Route("/listAgence", name: 'listAg', methods: ['GET'])]
    public function listAgence(AgenceRepository $agenceRepository)
    {
        $ags = $agenceRepository->optimisedFindAll();
  //      dump($ags);
//        $agences = $agenceRepository->findAll();

        return $this->render("home/listAgence.html.twig",[
            "agences" => $ags,
        ]);
    }






}