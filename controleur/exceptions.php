<?php
//Controlleur de substitut pour les utilisateurs qui ne sont pas autorisés à accéder au BO;
//Reprend les mêmes functions du BO pour les réadapté en erreur

function erreur() 
{
    throw new Exception('ERREUR : Vous essayer de pénétrer une zone interdite, vous risquerez d\'avoir quelques ennuies si vous continuez ainsi!');
}

function bo($twig)
{
    return erreur();
}

function addArticle($twig, $title, $chapo, $content, $id)
{
    return erreur();
}

function deleteArticle($twig, $article)
{
    return erreur();
}

function updateArticle($twig, $title, $chapo, $content, $id) 
{
    return erreur();
}

function validate($comment) 
{
    return erreur();
}

function change($role, $user)
{
    return erreur();
}