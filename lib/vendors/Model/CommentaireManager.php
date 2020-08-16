<?php
namespace Model;

use Entity\Commentaire;
use Entity\News;
use OCFram\Manager;

abstract class CommentaireManager extends Manager
{
    abstract public function add(Commentaire $c);

    abstract public function count();

    abstract public function countList(News $n);

    abstract public function delete(Commentaire $c);

    abstract public function get($info);

    abstract public function getAll();

    abstract public function getList(News $n);

    abstract public function update(Commentaire $c);
}