<?php

function accueil($twig) 
{
    echo $twig->render('homeView.twig', array('titre' => 'Ballinity - Home'));
}

function liste($twig, $page) 
{
    $postMapper = new PostManager;
    $articles = $postMapper->getList($page);
    $nbarticles = $postMapper->getNbArticles();
    $numpage = 0;
    $pages = array();
    for ($i = (int)$nbarticles[0]; $i > 0; $i -= 5) {
        $numpage++;
        $pages[] = $numpage;
    }

    echo $twig->render('listPosts.twig', array('titre' => 'Ballinity - Articles', 'articles' => $articles, 'pages' => $pages, 'page' => $page));
}

function single($twig, $id, $page)
{
    $postMapper = new PostManager;
    $article = $postMapper->getArticle($id);
    echo $twig->render('singlePost.twig', array('article' => $article, 'page' => $page));
}


