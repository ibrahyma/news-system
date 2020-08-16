<h2>Voulez-vous vraiment supprimer cette news ?</h2>

<em> <?= $nbCommentaires > 0 ? "Supprimer cette news entrainera la perte de tous ses commentaires (au nombre de $nbCommentaires)" : "" ?> </em>

<table>
    <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th></tr>
    <tr>
        <td><?= $news->getAuteur() ?></td>
        <td><?= $news->getTitre() ?></td>
        <td>le <?= $news->getDateAjout() ?></td>
        <td><?= ($news->getDateAjout() == $news->getDateModif() ? '-' : 'le '.$news->getDateModif()) ?></td>
    </tr>
</table>

<form action="" method="POST">
    <input type="submit" name="supprimer" value="OUI"/>
    <input type="submit" name="annuler" value="NON"/>
</form>