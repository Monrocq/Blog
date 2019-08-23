<?php

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