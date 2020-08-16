<div>
    <form action="" method="POST">
        <h3>Modifier un commentaire</h3>
        <p>Par <b><?= $auteur ?></b> le <?= $date ?></p>
        <?= (isset($erreurs) && in_array(\Entity\Commentaire::CONTENU_INVALIDE, $erreurs)) ? "Le commentaire est invalide." : "" ?>
        <p><label>Commentaire</label><textarea name="contenu"><?= $contenu ?></textarea></p>
        <p>
            <input type="hidden" name="id_news" value="<?= $id_news ?>"/>
            <input type="reset" value="Rétablir"/>
            <input type="submit" name="modifier" value="Modifier"/>
        </p>
    </form>
</div>