<?php
namespace App\Frontend\Modules\News;

use Entity\Commentaire;
use OCFram\BackController;
use OCFram\HTTPRequest;

class NewsController extends BackController
{
    public function executeIndex()
    {
        if ($this->app()->user()->isAuthenticated())
            $this->app()->httpResponse()->redirect404();
        
        $param_nbNews = $this->app()->config()->get("nombre_news");
        $param_nbCaracteres = $this->app()->config()->get("nombre_caracteres");
        $news_manager = $this->managers->getManagerOf("News");
        $lesNews = $news_manager->getNewest($param_nbNews);
        
        $this->page()->addVar("title", "Liste des $param_nbNews dernières news");
        
        foreach ($lesNews as $news)
        {
            if (strlen($news->getContenu()) > $param_nbCaracteres)
            {
                $debut = substr($news->getContenu(), 0, $param_nbCaracteres);
                $debut = substr($debut, 0, strrpos($debut, ' ')).'...';
                $news->setContenu($debut);
            }
        }

        $this->page->addVar("lesNews", $lesNews);
    }

    public function executeShow(HTTPRequest $request)
    {
        if ($this->app()->user()->isAuthenticated())
            $this->app()->httpResponse()->redirect404();
        
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
                $this->app->httpResponse()->redirect('news-'.$news->getId().'.html');
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