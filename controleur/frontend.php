<?php

function accueil($twig) 
{
    echo $twig->render('homeView.twig', array('titre' => 'Ballinity - Home'));
}

function liste($twig) 
{
    $list = new liste;

    $articles = $list->getList();

    echo $twig->render('listPosts.twig', array('titre' => 'Ballinity - Articles', 'articles' => $articles));
}


