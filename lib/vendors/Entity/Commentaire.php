<?php
namespace Entity;

use DateTime;
use OCFram\Entity;

class Commentaire extends Entity
{
    protected $id_news, $auteur, $contenu, $date;

    const AUTEUR_INVALIDE = 1;
    const CONTENU_INVALIDE = 2;

    public function getAuteur()
    {
        return $this->auteur;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getIdNews()
    {
        return $this->id_news;
    }

    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    }

    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    public function setDate()
    {
        $this->date = new DateTime();
    }

    public function setIdNews($id_news)
    {
        $this->id_news = $id_news;
    }
}