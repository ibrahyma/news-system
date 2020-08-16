<form action="" method="post">
    <p>
        <?= isset($erreurs) && in_array(\Entity\News::AUTEUR_INVALIDE, $erreurs) ? 'L\'auteur est invalide.<br />' : '' ?>
        <label>Auteur</label>
        <input type="text" name="auteur" value="<?= isset($news) ? $news->getAuteur() : '' ?>" /><br />
    
        <?= isset($erreurs) && in_array(\Entity\News::TITRE_INVALIDE, $erreurs) ? 'Le titre est invalide.<br />' : '' ?>
        <label>Titre</label><input type="text" name="titre" value="<?= isset($news) ? $news->getTitre() : '' ?>" /><br />
    
        <?= isset($erreurs) && in_array(\Entity\News::CONTENU_INVALIDE, $erreurs) ? 'Le contenu est invalide.<br />' : '' ?>
        <label>Contenu</label><textarea rows="8" cols="60" name="contenu"><?= isset($news) ? $news->getContenu() : '' ?></textarea><br />
        
        <input type="reset" value="Rétablir"/>
        
        <?php if (isset($news) && !$news->isNew()) { ?>
        
        <input type="submit" name="modifier" value="Modifier" />
        
        <?php } else { ?> 
        
        <input type="submit" name="ajouter" value="Ajouter" />
        
        <?php } ?>
    </p>
</form>