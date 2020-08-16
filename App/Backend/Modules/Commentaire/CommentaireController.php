<?php
namespace App\Backend\Modules\Commentaire;

use Entity\Commentaire;
use OCFram\BackController;
use OCFram\HTTPRequest;

class CommentaireController extends BackController
{
    public function executeModify(HTTPRequest $request)
    {
        $this->page()->addVar("title", "Admin : Modifier un commentaire");
        $id = (int)$request->getData("id");
        $c_manager = $this->managers->getManagerOf("Commentaire");
        if ($commentaire = $c_manager->get($id))
        {
            $this->page()->addVar("auteur", $commentaire->getAuteur());
            $this->page()->addVar("contenu", $commentaire->getContenu());
            $this->page()->addVar("date", $commentaire->getDate());
            $this->page()->addVar("id_news", (int)$commentaire->getIdNews());
        }
        else
        {
            $this->app()->httpResponse()->redirect404();
        }

        if ($request->postExists("modifier"))
        {
            $contenu = $request->postData("contenu");
            if ($contenu != "")
            {
                $id_news = (int)$request->postData("id_news");
                $commentaire->setContenu($contenu);
                $c_manager->update($commentaire);
                $this->app->user()->setFlash('Le commentaire a bien été modifié !');
                $this->app()->httpResponse()->redirect("/admin/news-$id_news.html?app=Backend");
            }
            else
            {
                $commentaire->addErreur(Commentaire::CONTENU_INVALIDE);
                $this->page()->addVar("erreurs", $commentaire->erreurs());
            }
        }
    }

    public function executeDelete(HTTPRequest $request)
    {
        $this->page()->addVar("title", "Admin : Supprimer un commentaire");
        $id = (int)$request->getData("id");
        $c_manager = $this->managers->getManagerOf("Commentaire");
        
        if ($commentaire = $c_manager->get($id))
        {
            $this->page()->addVar("auteur", $commentaire->getAuteur());
            $this->page()->addVar("contenu", $commentaire->getContenu());
            $this->page()->addVar("date", $commentaire->getDate());
            $this->page()->addVar("id_news", (int)$commentaire->getIdNews());
        }
        else
        {
            $this->app()->httpResponse()->redirect404();
        }

        if ($request->postExists("supprimer"))
        {
            $c_manager->delete($commentaire);
            $this->app->user()->setFlash('Le commentaire a bien été supprimé !');
        }
        if ($request->postExists("annuler") OR $request->postExists("supprimer"))
        {
            $id_news = (int)$request->postData("id_news");
            $this->app()->httpResponse()->redirect("/admin/news-$id_news.html?app=Backend");
        }
            
    }

    public function executeShowAll(HTTPRequest $request)
    {
        $c_manager = $this->managers->getManagerOf("Commentaire");
        $this->page()->addVar("title", "Admin : Gérer les commentaires");
        $this->page()->addVar("lesCommentaires", $c_manager->getAll());
        $this->page()->addVar("nbCommentaires", $c_manager->count());
    }
}