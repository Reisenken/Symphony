<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 13/02/2019
 * Time: 10:58
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;

class ArticleController extends AbstractController
{

    /**
     * @return Response
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        $titre = "Nouveau titre";
        return $this->render("article/home.html.twig", ["title" => $titre]);
    }

    /**
     *
     *  @Route("/article/liste", name="list_articles")
     */
    public function listArticle()
    {
        $request = $this->getDoctrine()->getRepository(Article::class);
        $article = $request->findAll();


        return $this->render('article/liste.html.twig',
            [
                "article"=> $article
            ]);
    }
    /**
     * @Route("/articles/{titre}")
     */
    public function show($titre)
    {
        $comments = ["Commentaire 1", "Commentaire 2", "Commentaire 3"];
        return $this->render("article/show.html.twig", ["title" => $titre, "comments" => $comments]);
    }


    /**
     * @Route("/articleCreate", name="article_create")
     */

    public function create()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $article = new Article();
        $article->setTitre('Titre n°3');
        $article->setContenu('Pour avoir plusieurs lignes à afficher.');


        // Cette instruction permet d'indiquer à Doctrine qu'on souhaite sauvegarder en mémoire le nouvel enregistrement
        $entityManager->persist($article);

        // Cette instruction éxécute la requete , en réalité il s'agit d'éxécuter toutes les requetes plaçées en mémoire,
        // dans notre cas, il n'y en a qu'une
        $entityManager->flush();

        return new Response('Saved new article with id ' . $article->getId());
    }


    /**
     * @Route("/article/{id}", name="article_show_from_db")
     */
    public function showFromDB(Article $article)
    {

        $comments = ["Commentaire 1", "Commentaire 2", "Commentaire "];

        return $this->render('article/show.html.twig',
            [   "title" => $article->getTitre(),
                "contenu" => $article->getContenu(),
                "comments" => $comments
            ]);
    }



}