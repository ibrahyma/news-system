<?php
namespace Model;

use OCFram\Manager;
use Entity\News;

abstract class NewsManager extends Manager
{
	abstract public function add(News $n);

	abstract public function count();

	abstract public function delete(News $n);

	abstract public function get($info);
 
	abstract public function getAll();

	abstract public function getNewest(int $nbNews);
 
	abstract public function update(News $n);
}