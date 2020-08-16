<?php
namespace App\Backend\Modules\News;

use Entity\News;
use Entity\Commentaire;
use OCFram\BackController;
use OCFram\HTTPRequest;

class NewsController extends BackController
{
    public function executeIndex()
    {
        $n_manager = $this->managers->getManagerOf("News");
        $this->page()->addVar("title", "Admin : Gérer les news");
        $this->page()->addVar("nombreNews", $n_manager->count());
        $this->page()->addVar("lesNews", $n_manager->getAll());
    }

    public function executeInsert(HTTPRequest $request)
    {
        $n_manager = $this->managers->getManagerOf("News");
        $this->page()->addVar("title", "Admin : Ajouter une news");

        if ($request->postExists('ajouter'))
        {
            $auteurValide = ($auteur = $request->postData('auteur')) != "";
            $titreValide = ($titre = $request->postData('titre')) != "";
            $contenuValide = ($contenu = $request->postData('contenu')) != "";
            $news = new News([
                "auteur" => $auteur,
                "contenu" => $contenu,
                "titre" => $titre
            ]);
            if ($auteurValide AND $titreValide AND $contenuValide)
            {
                $n_manager->add($news);
                $this->app()->user()->setFlash("Votre news a bien été ajoutée.");
                $this->app()->httpResponse()->redirect("/admin/");
            }
            else
            {
                if (!$auteurValide)
                    $news->addErreur(News::AUTEUR_INVALIDE);
                if (!$contenuValide)
                    $news->addErreur(News::CONTENU_INVALIDE);
                if (!$titreValide)
                    $news->addErreur(News::TITRE_INVALIDE);
                
                $this->page()->addVar("erreurs", $news->erreurs());
            }
        }
    }

    public function executeUpdate(HTTPRequest $request)
    {
        $id = (int)$request->getData('id');
        $n_manager = $this->managers->getManagerOf("News");
        $news = $n_manager->get($id);
        $this->page()->addVar("news", $news);

        if ($request->postExists('modifier'))
        {
            $auteurValide = ($auteur = $request->postData('auteur')) != "";
            $titreValide = ($titre = $request->postData('titre')) != "";
            $contenuValide = ($contenu = $request->postData('contenu')) != "";
            $news->hydrate([
                "auteur" => $auteur,
                "contenu" => $contenu,
                "titre" => $titre
            ]);
            if ($auteurValide AND $titreValide AND $contenuValide)
            {
                $n_manager->update($news);
                $this->app()->user()->setFlash("Votre news a bien été modifiée.");
                $this->app()->httpResponse()->redirect("/admin/");
            }
            else
            {
                if (!$auteurValide)
                    $news->addErreur(News::AUTEUR_INVALIDE);
                if (!$contenuValide)
                    $news->addErreur(News::CONTENU_INVALIDE);
                if (!$titreValide)
                    $news->addErreur(News::TITRE_INVALIDE);
                
                $this->page()->addVar("erreurs", $news->erreurs());
            }
        }
    }

    public function executeDelete(HTTPRequest $request)
    {
        $id = (int)$request->getData('id');
        $n_manager = $this->managers->getManagerOf("News");
        $news = $n_manager->get($id);

        $this->page()->addVar("news", $news);
        $this->page()->addVar("nbCommentaires", $this->managers->getManagerOf("Commentaire")->countList($news));
        
        if ($request->postExists('supprimer') OR $request->postExists('annuler'))
        {
            if ($request->postExists('supprimer'))
            {
                $n_manager->delete($news);
                $this->app()->user()->setFlash("La news a été supprimée.");
            }
            
            $this->app()->httpResponse()->redirect("/admin/");
        }
    }

    public function executeShow(HTTPRequest $request)
    {
        $news = $this->managers->getManagerOf('News')->get((int)$request->getData('id'));
        $m_commentaire = $this->managers->getManagerOf("Commentaire");
        $lesCommentaires = $m_commentaire->getList($news);
        $nbCommentaires = $m_commentaire->countList($news);
        
        $this->page()->addVar("title", $news->getTitre());

        if (empty($news))
            $this->app()->httpResponse()->redirect404();
        
        $this->page->addVar('title', $news->getTitre());
        $this->page->addVar('news', $news);
        $this->page->addVar('lesCommentaires', $lesCommentaires);
        $this->page->addVar('nbCommentaires', $nbCommentaires);
        $this->page->addVar('user', $this->app()->user());

        if ($request->postExists('ajouter'))
        {
            $commentaire = new Commentaire([
                'idNews' => $news->getId(),
                'auteur' => $request->postData('auteur'),
                'contenu' => $request->postData('contenu')
            ]);
            if ($request->postData('auteur') != "" && $request->postData('contenu') != "")
            {
                $m_commentaire->add($commentaire);
                $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
                $this->app->httpResponse()->redirect('/admin/news-'.$news->getId().'.html');
            }
            else
            {
                if ($request->postData('auteur') == "")
                    $commentaire->addErreur(Commentaire::AUTEUR_INVALIDE);
                if ($request->postData('contenu') == "")
                    $commentaire->addErreur(Commentaire::CONTENU_INVALIDE);
                $this->page->addVar('erreurs', $commentaire->erreurs());
            }
        }
    }
}