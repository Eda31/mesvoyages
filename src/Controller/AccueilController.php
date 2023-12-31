<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AccueilController
 *
 * @author Jadem
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     * @return Response
     */
    public function index(VisiteRepository $repository): Response
    {
        // Obtenez les 2 derniers voyages
        $derniersVoyages = $repository->findLatestVisites(2);

        return $this->render("pages/accueil.html.twig", [
            'derniersVoyages' => $derniersVoyages,
        ]);
    }
}
