<div>
    <h3>Voulez-vous vraiment supprimer ce commentaire ?</h3>
    <div>
        <p>
            Par <b><?= $auteur ?></b> le <?= $date ?> : <br>
            <?= $contenu ?>
        </p>
    </div>
    <form action="" method="POST">
        <input type="hidden" name="id_news" value="<?= $id_news ?>"/>
        <input type="submit" name="supprimer" value="OUI"/>
    </form>
    <form action="" method="POST">
        <input type="hidden" name="id_news" value="<?= $id_news ?>"/>
        <input type="submit" name="annuler" value="NON"/>
    </form>
</div>