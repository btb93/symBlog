<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Article;
use App\Entity\Commentaire;




class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        // creation de 03 catégories
        for ($i = 1; $i <= 3; $i++) {

            $category = new Category();
            $category->setTitre($faker->sentence())
                ->setDescription($faker->paragraph());

            $manager->persist($category);

            // creation de (4 à 6 ) articles
            for ($j = 1; $j <= mt_rand(4, 6); $j++) {

                $contenu = '<p>' . join($faker->paragraphs(5), '</p><p>') . '<p>';

                $article = new Article();
                $article->setTitre($faker->sentence())
                    ->setContenu($contenu)
                    ->setImage($faker->imageUrl())
                    ->setCreateAt($faker->dateTimeBetween('- 5 months'))
                    ->setCategory($category);

                $manager->persist($article);

                // création de (4 à 10) commentaires
                for ($k = 1; $k <= mt_rand(4, 10); $k++) {

                    $contenuAuteur = '<p>' . join($faker->paragraphs(3), '</p><p>') . '</p>';
                    $now = new \DateTime();
                    $days = $now->diff($article->getCreateAt())->days;

                    $commentaire = new Commentaire();
                    $commentaire->setAuteur($faker->name())
                        ->setContenu($contenuAuteur)
                        ->setCreatedAt($faker->dateTimeBetween('-' . $days . 'days'))
                        ->setArticle($article);

                    $manager->persist($commentaire);
                }

            }

        }

        $manager->flush();
    }
}
