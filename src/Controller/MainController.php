<?php
// src/Controller/MainController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;  // Ajout de la classe Request
use Symfony\Component\Routing\Attribute\Route;

class MainController
{
    #[Route('/index')]
    public function index(): Response
    {
        return new Response('<html><body>Bienvenue sur ma première page web.</body></html>');
    }
    //
    #[Route('/bonjour')]
    public function indexbis(): Response
    {
        //Création de l’objet Request à partir des superglobales PHP($_GET, $_POST, $_SERVER, $_COOKIE, etc.).
        $request = Request::createFromGlobals(); //Équivalent en PHP “classique” : $_GET, $_POST, $_SERVER

        //Récupération du paramètre "nom" passé dans l’URL (ex: ?nom=John)
        // Si aucun nom n’est fourni, la valeur par défaut est "Inconnu"
        //$nom = $request->query->get('nom', 'Inconnu');
        //return new Response("<html><body>Bonjour $nom</body></html>");

        $prenom = $request->query->get('prenom', 'Inconnu');
        return new Response("<html><body>Bonjour $prenom</body></html>");
    }

    //Routes Parametrables
}
