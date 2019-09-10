<?php

//Affiche le BO
function bo($twig)
{
    $commentMapper = new CommentManager;
    $comments = $commentMapper->getNoValidated();

    $userMapper = new UserManager;
    $groups = $userMapper->listUsers();

    $id = $_SESSION['id']; //For add article
    echo $twig->render('bo.twig', array('id' => $id, 'comments' => $comments, 'groups' => $groups));
}

//Quand l'article est ajouté
function addArticle($twig, $title, $chapo, $content, $id)
{
    $postMapper = new PostManager;
    $newpost = $postMapper->addArticle($title, $chapo, $content, $id);
    echo $twig->render('bo.twig', array('id' => $id, 'post' => $newpost));
}

//Pour la suppression d'article
function deleteArticle($twig, $article)
{
    $postMapper = new PostManager;
    $postMapper->deleteArticle($article);
    header('Location: index.php?action=articles');
}

//Pour la MAJ d'un article
function updateArticle($twig, $title, $chapo, $content, $id) 
{
    $postMapper = new PostManager;
    $postMapper->updateArticle($title, $chapo, $content, $id);
    header("Location: index.php?action=single&id=$id");
}

//Pour approuver un commentaire
function validate($comment)
{
    $commentMapper = new CommentManager;
    $commentMapper->validate($comment);
    header('Location: index.php?action=bo');
}

//Pour modifier le statut d'un utilisateur
function change($role, $user)
{
    $userMapper = new UserManager;
    $userMapper->change($role, $user);
    header('Location: index.php?action=bo');
}