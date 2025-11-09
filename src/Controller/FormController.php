<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

final class FormController extends AbstractController
{
    #[Route(
        '/hello/{prenom}',
        name: 'app_hello',
        defaults: ['prenom' => 'Bryan'], // 👈 valeur par défaut
        methods: ['GET']
    )]
    public function hello(string $prenom, Environment $twig): Response
    {
        $html = $twig->render('hello.html.twig', ['prenom' => $prenom]);
        return new Response($html);
    }
    //Nouvelle méthode pour afficher les tuteurs
    #[Route('/tuteurs', name: 'app_tuteurs')]
    public function liste(Environment $twig): Response
    {
        // Déclaration du tableau
        $tuteurs = [
            'tuteurs' => [
                ['nom' => 'Johnson', 'prenom' => 'Paul'],
                ['nom' => 'Walberg', 'prenom' => 'Mark']
            ]
        ];

        // On transmet ce tableau au template
        $html = $twig->render('tuteurs.html.twig', $tuteurs);
        return new Response($html);
    }

    // 1) Affiche le formulaire de recherche (GET)
    #[Route('/search_tuteur', name: 'app_search_tuteur', methods: ['GET'])]
    public function searchTuteur(Environment $twig): Response
    {
        $html = $twig->render('search_tuteur.html.twig');
        return new Response($html);
    }

    // 2) Traite la recherche (POST) – méthode verify
    #[Route('/verify', name: 'app_verify_tuteur', methods: ['POST'])]
    public function verify(Request $request, Environment $twig): Response
    {
        // Récupération du nom saisi
        $nomRecherche = trim((string) $request->request->get('nom', ''));

        // Tableau "précédent" demandé par l’énoncé
        $tuteurs = [
            ['nom' => 'Johnson', 'prenom' => 'Paul'],
            ['nom' => 'Walberg', 'prenom' => 'Mark'],
        ];

        // Recherche (insensible à la casse)
        $found = false;
        $match  = null;
        foreach ($tuteurs as $tuteur) {
            if (mb_strtolower($tuteur['nom']) === mb_strtolower($nomRecherche)) {
                $found = true;
                $match = $tuteur;
                break;
            }
        }

        $html = $twig->render('verify_tuteur.html.twig', [
            'nomRecherche' => $nomRecherche,
            'found' => $found,
            'tuteur' => $match,
        ]);

        return new Response($html);
    }
}
