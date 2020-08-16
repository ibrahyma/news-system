<p style="text-align: center">Il y a actuellement <?= $nbCommentaires ?> commentaire<?= ($nbCommentaires > 1) ? "s" : "" ?>.</p>

<table>
    <tr><th>Auteur</th><th>Commentaire</th><th>Date d'ajout</th><th>Action</th></tr>
<?php
foreach ($lesCommentaires as $commentaire)
{
    ?> <tr>
        <td><?= $commentaire->getAuteur() ?></td>
        <td><?= $commentaire->getContenu() ?></td>
        <td>le <?= $commentaire->getDate() ?></td>
        <td>
            <a href="/admin/modify-com-<?= $commentaire->getId() ?>.html">
                <img src="/images/update.png" alt="Modifier"/>
            </a>
            <a href="/admin/delete-com-<?= $commentaire->getId() ?>.html">
                <img src="/images/delete.png" alt="Supprimer"/>
            </a>
        </td>
    </tr> <?php
}
?>
</table>