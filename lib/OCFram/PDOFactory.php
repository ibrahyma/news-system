<?php
namespace OCFram;

use PDO;
use PDOException;

class PDOFactory
{
    public static function getMysqlConnexion()
    {
        try
        {
            $dao = new PDO('mysql:host=localhost;port=3308;dbname=mini-news;charset=utf8', 'root', '');
            $dao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dao;
        }
        catch (PDOException $e)
        {
            die("Erreur : ".$e->getMessage());
        }
    }
}