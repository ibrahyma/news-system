<?php
namespace Entity;

use OCFram\Entity;
use DateTime;

class News extends Entity
{
	protected $titre, $auteur, $contenu, $date_ajout, $date_modif;

	const AUTEUR_INVALIDE = 1;
	const CONTENU_INVALIDE = 2;
	const TITRE_INVALIDE = 3;

	public function getAuteur()
	{
		return $this->auteur;
	}

	public function getContenu()
	{
		return $this->contenu;
	}

	public function getDateAjout()
	{
		return $this->date_ajout;
	}

	public function getDateModif()
	{
		return $this->date_modif;
	}

	public function getTitre()
	{
		return $this->titre;
	}

	public function setAuteur($auteur)
	{
		$this->auteur = $auteur;
	}

	public function setContenu($contenu)
	{
		$this->contenu = $contenu;
	}
	
	public function setDateAjout()
	{
		$this->date_ajout = new DateTime();
	}

	public function setDateModif()
	{
		$this->date_modif = new DateTime();
	}
	
	public function setTitre($titre)
	{
		$this->titre = $titre;
	}
}