<p style="text-align: center">Il y a actuellement <?= $nombreNews ?> news.</p>

<table>
    <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
<?php
foreach ($lesNews as $news)
{
    ?> <tr>
        <td><?= $news->getAuteur() ?></td>
        <td><a href="news-<?= $news->getId() ?>.html"><?= $news->getTitre() ?></a></td>
        <td>le <?= $news->getDateAjout() ?></td>
        <td><?= ($news->getDateAjout() == $news->getDateModif() ? '-' : 'le '.$news->getDateModif()) ?></td>
        <td>
            <a href="news-update-<?= $news->getId() ?>.html">
                <img src="/images/update.png" alt="Modifier"/>
            </a>
            <a href="news-delete-<?= $news->getId() ?>.html">
                <img src="/images/delete.png" alt="Supprimer"/>
            </a>
        </td>
    </tr> <?php
}
?>
</table>