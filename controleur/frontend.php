<?php

function accueil($twig) 
{
    echo $twig->render('homeView.twig', array('titre' => 'Ballinity - Home'));
}

function liste($twig, $page) 
{
    $list = new liste;

    $articles = $list->getList($page);

    $nbarticles = $list->getNbArticles();
    $nbarticles = (int)$nbarticles[0];
    $numpage = 0;
    $pages = array();
    for ($i = $nbarticles; $i > 0; $i -= 5) {
        $numpage++;
        $pages[] = $numpage;
    }

    echo $twig->render('listPosts.twig', array('titre' => 'Ballinity - Articles', 'articles' => $articles, 'pages' => $pages));
}


