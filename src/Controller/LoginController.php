<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        //récupéation éventuelle de l'erreur
        $error = $authenticationUtils->getLastAuthenticationError();
        // récupération éventuelle du dernier nom de login utilisé
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        // Cette méthode ne nécessite pas de code spécifique,
        // car la déconnexion est gérée par le système de sécurité Symfony.
        // Symfony interceptera automatiquement les requêtes vers /logout et déconnectera l'utilisateur.

        // Vous pouvez personnaliser le comportement de déconnexion dans le fichier security.yaml.
        // Pour cela, vous pouvez définir des paramètres comme la redirection après déconnexion, etc.
        // Consultez la documentation Symfony pour plus d'informations sur la
    }
}
