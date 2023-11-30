<?php

namespace App\Tests\Repository;

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of VisiteRepositoryTest
 *
 * @author Jadem
 */
class VisiteRepositoryTest extends KernelTestCase
{
    
    /**
     * Récupère le repository de Visite
     * @return VisiteRepository
     */
    public function recupRepository(): VisiteRepository
    {
        self::bootKernel();
        return self::getContainer()->get(VisiteRepository::class);
    }

    public function testNBVisites()
    {
        $repository = $this->recupRepository();
        $nbVisites = $repository->count([]);
        $this->assertEquals(2, $nbVisites);
    }
    private const TEST_VILLE = "New York";
    /**
     * @return Visite
     */
    public function newVisite(): Visite
    {
        return (new Visite())
            ->setVille(self::TEST_VILLE)
            ->setPays("USA")
            ->setDatecreation(new DateTime("now"));
    }
    
    public function testAddVisite()
    {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $nbVisites = $repository->count([]);
        $repository->add($visite, true);
        $this->assertEquals($nbVisites + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testRemoveVisite()
    {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository->add($visite, true);
        $nbVisites = $repository->count([]);
        $repository->remove($visite, true);
        $this->assertEquals($nbVisites - 1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindByEqualValue()
    {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository->add($visite, true);
        $visites = $repository->findByEqualValue("ville", self::TEST_VILLE);
        $nbVisites = count($visites);
        $this->assertEquals(1, $nbVisites);
        $this->assertEquals(self::TEST_VILLE, $visites[0]->getVille());
    }
}
