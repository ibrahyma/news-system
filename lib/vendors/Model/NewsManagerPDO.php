<?php
namespace Model;

use Entity\News;
use OCFram\PDOFactory;
use PDO;

class NewsManagerPDO extends NewsManager
{
    public function __construct()
    {
        $this->dao = PDOFactory::getMysqlConnexion();
    }

    public function add(News $n)
	{
		$req = "INSERT INTO news (titre, auteur, contenu, date_ajout, date_modif) VALUES (:titre, :auteur, :contenu, NOW(), NOW())";
		$q = $this->dao->prepare($req);
		$q->bindValue(":titre", $n->getTitre());
		$q->bindValue(":auteur", $n->getAuteur());
		$q->bindValue(":contenu", $n->getContenu());
		$q->execute();
		$n->hydrate(array("id" => $this->dao->lastInsertId()));
	}

	public function count()
	{
		return (int)($this->dao->query("SELECT count(*) FROM news")->fetchColumn());
	}

	public function delete(News $n)
	{
		$req = "DELETE FROM commentaire WHERE id_news = :id; DELETE FROM news WHERE id = :id;";
		$q = $this->dao->prepare($req);
		$q->bindValue(":id", $n->getId(), PDO::PARAM_INT);
		$q->execute();
	}

	public function get($info)
	{
		$req = "SELECT * FROM news WHERE ".(is_int($info) ? " id = :info" : "titre = :info OR auteur = :info OR contenu = :info");
		$q = $this->dao->prepare($req);
		$q->bindValue(":info", $info, (is_int($info) ? PDO::PARAM_INT : PDO::PARAM_STR));
		if ($q->execute())
		{
			$q->setFetchMode(PDO::FETCH_CLASS, News::class);
			return $q->fetch();
		}
		else
		{
			return false;
		}
	}

	public function getAll()
	{
		$req = "SELECT * FROM news ORDER BY date_ajout";
		$q = $this->dao->prepare($req);
		$q->execute();
		$q->setFetchMode(PDO::FETCH_CLASS, News::class);
		return $q->fetchAll();
	}

	public function getNewest(int $nbNews)
	{
		$req = "SELECT * FROM news ORDER BY date_ajout DESC LIMIT :nbNews";
		$q = $this->dao->prepare($req);
		$q->bindValue(':nbNews', $nbNews, PDO::PARAM_INT);
		$q->execute();
		$q->setFetchMode(PDO::FETCH_CLASS, News::class);
		return $q->fetchAll();
	}

	public function update(News $n)
	{
		$req = "UPDATE news SET titre = :titre, auteur = :auteur, contenu = :contenu, date_modif = NOW() WHERE id = :id";
		$q = $this->dao->prepare($req);
		$q->bindValue(":id", $n->getId(), PDO::PARAM_INT);
		$q->bindValue(":titre", $n->getTitre());
		$q->bindValue(":auteur", $n->getAuteur());
		$q->bindValue(":contenu", $n->getContenu());
		$q->execute();
	}
}