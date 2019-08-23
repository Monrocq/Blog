<?php

function bo($twig)
{
    if ((isset($_SESSION['id'])) && ($_SESSION['lvl'] > 1)) {
        $id = $_SESSION['id'];
        echo $twig->render('bo.twig', array('id' => $id));
    } else {
        echo "ERREUR : Vous essayer de pénétrer une zone interdite, vous risquerez d'avoir quelques ennuies si vous continuez ainsi!";
    }
}

function addArticle($twig, $title, $chapo, $content, $id)
{
    $postMapper = new PostManager;
    $newpost = $postMapper->addArticle($title, $chapo, $content, $id);
    echo $twig->render('bo.twig', array('id' => $id, 'post' => $newpost));
}

function deletearticle($twig, $article)
{
    $postMapper = new PostManager;
    $postMapper->deleteArticle($article);
    header('Location: index.php?action=articles');
}