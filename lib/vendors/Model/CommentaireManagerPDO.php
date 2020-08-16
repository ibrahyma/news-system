<?php
namespace Model;

use Entity\Commentaire;
use Entity\News;
use OCFram\PDOFactory;
use PDO;

class CommentaireManagerPDO extends CommentaireManager
{
    public function __construct()
    {
        $this->dao = PDOFactory::getMysqlConnexion();
    }

    public function add(Commentaire $c)
    {
        $req = "INSERT INTO commentaire (id_news, auteur, contenu, `date`) VALUES (:id_news, :auteur, :contenu, NOW())";
        $q = $this->dao->prepare($req);
        $q->bindValue(":id_news", $c->getIdNews(), PDO::PARAM_INT);
        $q->bindValue(":auteur", $c->getAuteur());
        $q->bindValue(":contenu", $c->getContenu());
        $q->execute();
        $c->hydrate(["id" => $this->dao->lastInsertId()]);
    }

    public function count()
    {
        $req = "SELECT count(*) FROM commentaire";
        $q = $this->dao->prepare($req);
        $q->execute();
        return (int)$q->fetchColumn();
    }

    public function countList(News $n)
    {
        $req = "SELECT count(*) FROM commentaire WHERE id_news = :id_news";
        $q = $this->dao->prepare($req);
        $q->bindValue(":id_news", $n->getId(), PDO::PARAM_INT);
        $q->execute();
        return (int)$q->fetchColumn();
    }

    public function delete(Commentaire $c)
    {
        $req = "DELETE FROM commentaire WHERE id = :id";
        $q = $this->dao->prepare($req);
        $q->bindValue(":id", $c->getId(), PDO::PARAM_INT);
        $q->execute();
    }

    public function get($info)
    {
        $req = "SELECT * FROM commentaire WHERE ".(is_int($info) ? "id = :info" : "auteur = :info OR contenu = :info");
        $q = $this->dao->prepare($req);
        $q->bindValue(":info", $info, (is_int($info) ? PDO::PARAM_INT : PDO::PARAM_STR));
        $q->execute();
        $q->setFetchMode(PDO::FETCH_CLASS, Commentaire::class);
        return $q->fetch();
    }

    public function getAll()
    {
        $req = "SELECT * FROM commentaire";
        $q = $this->dao->prepare($req);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Commentaire::class);
        return $q->fetchAll();
    }

    public function getList(News $n)
    {
        $req = "SELECT * FROM commentaire WHERE id_news = :id_news ORDER BY `date` DESC";
        $q = $this->dao->prepare($req);
        $q->bindValue(":id_news", $n->getId(), PDO::PARAM_INT);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Commentaire::class);
        return $q->fetchAll();
    }

    public function update(Commentaire $c)
    {
        $req = "UPDATE commentaire SET contenu = :contenu WHERE id = :id";
        $q = $this->dao->prepare($req);
        $q->bindValue(":contenu", $c->getContenu());
        $q->bindValue(":id", $c->getId(), PDO::PARAM_INT);
        $q->execute();
    }
}