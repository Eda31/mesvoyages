<?php

namespace App\Tests\Validations;

use App\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
/**
 * Description of VisiteValidationsTest
 *
 * @author Jadem
 */
class VisiteValidationsTest extends KernelTestCase{
    /**
     * 
     * @return Visite
     */
    public function getVisite(): Visite {
        return (new Visite())
                ->setVille("New York")
                ->setPays("USA");
    }
    /**
     * 
     * @param Visite $visite
     * @param int $nbErreursAttendues
     */
    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message="") {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
    public function testValidNoteVisite() {
        $visite = $this->getVisite()->setNote(10);
        $this->assertErrors($visite, 0);
    }
    public function testNonValidNoteVisite(){
        $visite = $this->getVisite()->setNote(21);
        $this->assertErrors($visite, 1);
    }
    
    public function testNonTempmaxVisite(){
        $visite = $this->getVisite()
                ->setTempmin(20)
                ->setTempmax(18);
        $this->assertErrors($visite, 1, "min=20, max=18 devrait échouer");
    }
    
    public function testNonValidTempmaxVisite(){
        $this->assertErrors($this->getVisite()->setTempmin(20)->setTempmax(18), 1, "min=20, max=18 devrait échouer");
        $this->assertErrors($this->getVisite()->setTempmin(20)->setTempmax(20), 1, "min=20, max=20 devrait échouer");
    }
    
    public function testValidDatecreationVisite(){ 
        $aujourdhui = new \DateTime();
        $this->assertErrors($this->getVisite()->setDatecreation($aujourdhui), 0, "aujourd'hui devrait réussir");
        $plustot = (new \DateTime())->sub(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($plustot), 0, "plus tôt devrait réussir");
    }
    
    public function testNonValidDatecreationVisite(){ 
        $demain = (new \DateTime())->add(new \DateInterval("P1D"));
        $this->assertErrors($this->getVisite()->setDatecreation($demain), 1, "demain devrait échouer");
        $plustard = (new \DateTime())->add(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($plustard), 1, "plus tard devrait échouer");
    }
}
