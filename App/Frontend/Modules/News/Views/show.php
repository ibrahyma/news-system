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
    <strong>Commentaires (<?= $nbCommentaires ?>)</strong>
    <p>
    <?php
    if (!empty($lesCommentaires))
    {
        foreach ($lesCommentaires as $commentaire)
        {
            $id = $commentaire->getId();

            ?> <p>

                De <em><?= $commentaire->getAuteur() ?></em>, le <?= $commentaire->getDate() ?> : <br>
                <?= nl2br($commentaire->getContenu()) ?> <br>

            </p> <?php
        }
    }
    else
    {
        echo "<p>Aucun commentaire n'a été laissé. Le premier sera peut-être le vôtre.</p>";
    }
    ?>
</p>