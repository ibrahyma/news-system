<?php
foreach ($lesNews as $news)
{
?> 
    <h2><a href="news-<?= $news->getId() ?>.html"><?= $news->getTitre() ?></a></h2>
    <p><?= $news->getContenu() ?></p>
<?php
}