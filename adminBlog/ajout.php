<?php
/*
* Ajout d'un article
*/
session_start();
include '../inc/fonctions.php';

(isAdminLogin()) ?: redirectUrl('view/404.php');

(isUserLogin()) ?: redirectUrl('view/404.php');

$titre = $contenu = $image = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') :

    $target_dir = "../uploads/";
    $imageName = $_FILES["image"]["name"];
    $target_file = $target_dir . basename($imageName);
    move_uploaded_file($_FILES['image']['tmp_name'],$target_file);

    
    if ($imageName):
    $image = "./uploads/".$imageName;
    else:
        $image = "";
    endif;

    $titre = cleanData($_POST['titre']);
    $contenu = cleanData($_POST['contenu']);

    insertArticle($titre, $contenu, $image, $_SESSION['id_utilisateur']);

    if ($_SESSION['login'] === 'redacteur') :
        redirectUrl();
    else :
        redirectUrl('./adminBlog/');
    endif;
endif;

require '../view/adminBlog/ajout.view.php';
