<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use App\Entity\Environnement;
use App\Entity\Visite;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Description of VisiteTest
 *
 * @author Doryan
 */
class VisiteTest extends TestCase {
    
    
    public function testGetDateCreationString(){
        $visite = new Visite();
        $visite->setDatecreation(new DateTime("2023-12-08"));
        $this->assertEquals("08/12/2023", $visite->getDatecreationString());
    }
    
    public function testAddEnvironnement(){
        $environnement = new Environnement();
        $environnement->setNom("plage");
        $visite = new Visite();
        $visite->addEnvironnement($environnement);
        $nbEnvironementAvant = $visite->getEnvironnements()->count();
        $visite->addEnvironnement($environnement);
        $nbEnvironementApres = $visite->getEnvironnements()->count();
        $this->assertEquals($nbEnvironementAvant, $nbEnvironementApres, "ajout même environnement devrait echouer"); 
    }
}
