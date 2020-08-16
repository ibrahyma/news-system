<!DOCTYPE html>
<html>
    <head>
        <title>
            <?= isset($title) ? $title : 'Mon super site' ?>
        </title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="/css/Envision.css" type="text/css" />
    </head>
    <body>
        <div id="wrap">
            <header>
                <h1><a href=<?= $user->isAuthenticated() ? "/admin/" : "." ?>>Mini-news</a></h1>
                <p>En cours de développement...</p>
            </header>
            <nav>
                <ul>
                    <li><a href=<?= $user->isAuthenticated() ? "/admin/" : "." ?>>Accueil</a></li>

                    <?php if ($user->isAuthenticated()) { ?>

                    <li><a href="/admin/news-insert.html">Ajouter une news</a></li>
                    <li><a href="/admin/list-com.html">Liste des commentaires</a></li>
                    <li><a href="/admin/disconnect.html">Déconnexion</a></li>

                    <?php } else { ?>
                    
                    <li><a href="/admin/">Connexion</a></li>

                    <?php } ?>
                </ul>
            </nav>
            <div id="content-wrap">
                <section id="main">
                    <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
                    <?= $content ?>
                </section>
            </div>
            <footer></footer>
        </div>
    </body>
</html>