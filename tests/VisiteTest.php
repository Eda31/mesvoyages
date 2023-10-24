<?php

namespace App\Tests;

use App\Entity\Environnement;
use App\Entity\Visite;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Description of VisiteTest
 *
 * @author Jadem
 */
class VisiteTest extends TestCase {
    public function testGetDatecreationString() {
        $visite = new Visite();
        $visite->setDatecreation(new DateTime("2022-04-14"));
        $this->assertEquals("14/04/2022", $visite->getDatecreationString());
    }
    
    public function testAjoutEnvironnementDejaPresent() {
        $visite = new Visite();
        // Crée un environnement
        $environnement = new Environnement();
        $environnement->setNom('Montagne');
        // Ajoute l'environnement à la visite
        $visite->addEnvironnement($environnement);
        // Vérifie que l'environnement est présent dans la visite
        $this->assertContains($environnement, $visite->getEnvironnements());
        // Ajoute le même environnement à la visite à nouveau
        $visite->addEnvironnement($environnement);
        // Vérifie que l'environnement n'a pas été ajouté une deuxième fois
        $this->assertCount(1, $visite->getEnvironnements());
    }
}
