<?php

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of VoyagesController
 *
 * @author Jadem
 */
class VoyagesController extends AbstractController
{
    /**
     * Constante pour le chemin du modèle
     */
    private const VOYAGES_TEMPLATE = "pages/voyages.html.twig";
    /**
     * @var VisiteRepository
     */
    private $repository;

    /**
     * @param VisiteRepository $repository
     */
    public function __construct(VisiteRepository $repository)
    {
        $this->repository = $repository;
        
    }
    
    /**
     * @Route("/voyages", name="voyages")
     * @return Response
     */
    public function index(): Response
    {
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render(self::VOYAGES_TEMPLATE, [
            'visites' => $visites
        ]);

    }
    /**
     * @Route("/voyages/tri/{champ}/{ordre}", name="voyages.sort")
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    public function sort($champ, $ordre): Response
    {
        $visites = $this->repository->findAllOrderBy($champ, $ordre);
        return $this->render(self::VOYAGES_TEMPLATE, [
            'visites' => $visites
        ]);
        
    }
    /**
     * @Route("/voyages/recherche/{champ}", name="voyages.findallequal")
     * @param type $champ
     * @param Resquest $request
     * @return Response
     */
    public function findAllEqual($champ, Request $request): Response
    {
        if ($this->isCsrfTokenValid('filtre_'.$champ, $request->get('_token'))) {
            $valeur = $request->get("recherche");
            $visites = $this->repository->findByEqualValue($champ, $valeur);
            return $this->render(self::VOYAGES_TEMPLATE, [
                'visites' => $visites
                    ]);
            }
        return $this->redirectToRoute("voyages");
    }
    /**
     * @Route("/voyages/voyage/{id}", name="voyages.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response
    {
        $visite = $this->repository->find($id);
        return $this->render("pages/voyage.html.twig", [
            'visite' => $visite
        ]);
        
    }
    
}
