<p>Par <em> <?= $news->getAuteur() ?></em>, le <?= $news->getDateAjout() ?></p>
<h2><?= $news->getTitre() ?></h2>
<p><?= nl2br($news->getContenu()) ?></p>
<?php if ($news->getDateAjout() != $news->getDateModif()) { ?>
    <p style="text-align: right;"><small><em>Modifiée le <?= $news->getDateModif() ?></em></small></p>
<?php } ?>
<p>
    <form action="" method="POST">
        <label><h3>Nouveau commentaire</h3></label>

        <?= (isset($erreurs) && in_array(Entity\Commentaire::AUTEUR_INVALIDE, $erreurs)) ? "L'auteur est invalide" : "" ?>
        <p> <label>Auteur</label> <input type="text" name="auteur"/> </p>

        <?= (isset($erreurs) && in_array(Entity\Commentaire::CONTENU_INVALIDE, $erreurs)) ? "Le commentaire est invalide" : "" ?>
        <p> <label>Commentaire</label> <textarea name="contenu"></textarea> </p>

        <p> <input type="submit" name="ajouter" value="Envoyer"/> </p>
    </form>
    <div>
        <div class="link_btn">
            <a href="news-update-<?= $news->getId() ?>.html" style="background-color: #CCCCFF;">
                Modifier cette news
            </a>
        </div>
        <div class="link_btn">
            <a href="news-delete-<?= $news->getId() ?>.html" style="background-color: #FFCCCC;">
                Supprimer cette news
            </a>
        </div>
    </div>
    <strong>Commentaires (<?= $nbCommentaires ?>)</strong>
    <?php
    if (!empty($lesCommentaires))
    {
        foreach ($lesCommentaires as $commentaire)
        {
            $id = $commentaire->getId();

            ?> <p>

                De <em><?= $commentaire->getAuteur() ?></em>, le <?= $commentaire->getDate() ?> : <br>
                <?= nl2br($commentaire->getContenu()) ?> <br>

                <a href="/admin/modify-com-<?= $id ?>.html">Modifier</a> 
                <a href="/admin/delete-com-<?= $id ?>.html">Supprimer</a>

            </p> <?php
        }
    }
    else
    {
        echo "<p>Aucun commentaire n'a été laissé. Le premier sera peut-être le vôtre.</p>";
    }
    ?>
</p>