<?php

function bo($twig)
{
    $commentMapper = new CommentManager;
    $comments = $commentMapper->getNoValidated();
    $id = $_SESSION['id']; //For add article
    echo $twig->render('bo.twig', array('id' => $id, 'comments' => $comments));
}

function addArticle($twig, $title, $chapo, $content, $id)
{
    $postMapper = new PostManager;
    $newpost = $postMapper->addArticle($title, $chapo, $content, $id);
    echo $twig->render('bo.twig', array('id' => $id, 'post' => $newpost));
}

function deleteArticle($twig, $article)
{
    $postMapper = new PostManager;
    $postMapper->deleteArticle($article);
    header('Location: index.php?action=articles');
}

function updateArticle($twig, $title, $chapo, $content, $id) 
{
    $postMapper = new PostManager;
    $postMapper->updateArticle($title, $chapo, $content, $id);
    header("Location: index.php?action=single&id=$id");
}

function validate($comment)
{
    $commentMapper = new CommentManager;
    $commentMapper->validate($comment);
    header('Location: index.php?action=bo');
}