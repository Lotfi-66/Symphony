<?php

namespace App\DataFixtures;

use App\Entity\Agence;
use App\Entity\Annonce;
use App\Entity\Capacite;
use App\Entity\Categorie;
use App\Entity\Equipement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // instancier le faker
        $faker = Faker\Factory::create('fr_FR');

        // Gestion de la création des catégories
        $categories = ['terrain', 'appartement', 'friche agricole',
            'maison', 'garage', 'local commercial'];

        foreach ($categories as $k => $category){
            $cat = new Categorie();
            $cat->setLibelle($category);
            $manager->persist($cat);
            $this->addReference('cat-' . $k, $cat);
        }

        // gestion de la création des équipements
        $equipements = ['piscine', 'spa', 'carport', 'panneau photo-voltaique',
            'chauffeau solaire', 'cave', 'géothermie', "cuisine de jardin",
            "pompe à chaleur"];

        foreach ($equipements as $k => $equipement){
            $equip = new Equipement();
            $equip->setLibelle($equipement);
            $manager->persist($equip);
            $this->addReference('eq-' . $k, $equip);
        }

        $proprietes = ["vente", "location", "terrain", "construction"];
        foreach ($proprietes as $k => $p){
            $capacite = new Capacite();
            $capacite->setCapacite($p);
            $manager->persist($capacite);
            $this->addReference('capa-'.$k, $capacite);
        }

//        $agence = new Agence();
//        $agence->setCodeAgence("aa01")
//                ->setNom("immo 2000");
//        $manager->persist($agence);

        for($i = 0; $i < 10; $i++){ // création d'une liste d'agence
            $agence = new Agence();
            $agence->setCodeAgence("aa0" . $i + 1)
                ->setNom("agence"  . $i + 1);
            $manager->persist($agence);
            $this->addReference('ag-' . $i, $agence);

            $rand = rand(1,4);
            for ($z = 0; $z < $rand; $z++){ //ajout aléatoire des capacité
                $agence->addCapacite($this->getReference('capa-'. rand(0, count($proprietes) -1 )));
            }
        }
        $dpe = ['A','B','C','D','E','F','G'];
        // creatioin des annonces
        for($i = 0 ; $i < 50; $i++){
            $annonce = new Annonce();

            $annonce->setTitre($faker->words(6, true))
                ->setDescription($faker->words(140, true ))
                ->setDpe($dpe[rand(0,6)])
                ->setRental($faker->boolean())
                ->setExclusive($faker->boolean())
                ->setVille($faker->city)
                ->setCodePostal($faker->postcode)
                ->setNbrPiece(rand(1,10))
                ->setSurface($faker->numberBetween(50,200))
                ->setDatePublication($faker->dateTime('now'))
                ->setUpdateAt(new \dateTime('now'));

            if($annonce->isRental()) {
                $annonce->setPrix($faker->numberBetween(300, 1500));
            } else{
                $annonce->setPrix($faker->numberBetween(50000, 500000));
            }
            $annonce->setCategorie($this->getReference('cat-' . rand(0, count($categories) - 1) ));
            $manager->persist($annonce);

            // gestion des agences
            if($annonce->isExclusive()){ // appartien à une seule agence
                $annonce->addAgence($this->getReference('ag-' . rand(0,9)));
            } else {
                for($u = 0; $u < rand(1, 9); $u++){
                    $annonce->addAgence($this->getReference('ag-' . rand(0,9)));
                }
            }

            // gestion des équipements
            for ($z = 0; $z < rand(1,5); $z++){
                $annonce->addEquipement($this->getReference("eq-" . rand(0, count($equipements) - 1)));
            }

        }


        $manager->flush();
    }
}
