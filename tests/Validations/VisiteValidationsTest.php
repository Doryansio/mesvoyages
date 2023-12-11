<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Visite;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of VisiteValidationsTest
 *
 * @author Doryan
 */
class VisiteValidationsTest extends KernelTestCase {
    public function getVisite():Visite{
        return (new Visite())
                ->setVille("New York")
                ->setPays("USA");
        
    }
    
    public function testNoteVisite(){
        $visite = $this->getVisite()->setNote(10);
        $this->assertsErrors($visite, 0);
        $this->assertsErrors($this->getVisite()->setNote(10), 0, "10 devrait reussir");
        $this->assertsErrors($this->getVisite()->setNote(0), 0, "0 devrait réussir");
        $this->assertsErrors($this->getVisite()->setNote(20), 0, "20 devrait réussir");
        
    } 
    
     public function testNonValidNoteVisite(){
        $visite = $this->getVisite()->setNote(21);
        $this->assertsErrors($visite, 1);
        $this->assertsErrors($this->getVisite()->setNote(-1), 1, "-1 devrait échouer");
        $this->assertsErrors($this->getVisite()->setNote(21), 1, "21 devrait échouer");
        $this->assertsErrors($this->getVisite()->setNote(-15), 1, "-15 devrait échouer");
        $this->assertsErrors($this->getVisite()->setNote(30), 1, "30 devrait échouer");
    }
    
    public function testTempMax(){
        $visite = $this->getVisite()
                ->setTempmin(0)
                ->setTempmax(10);
        $this->assertsErrors($visite, 0, "min=0 , max=10 devrait reussir");
        $this->assertsErrors($this->getVisite()->setTempmin(1) ->setTempmax(2), 0,"min=1 , max=2 devrait reussir" );      
    }
    
    public function testNonValidTempMaxVisite(){
        $visite= $this->getVisite()
                ->setTempmin(20)
                ->setTempmax(18);
        $this->assertsErrors($visite, 1, "min=20, max=18 devrait échouer");
        $this->assertsErrors($this->getVisite()->setTempmin(1) ->setTempmax(1), 1,"min=1 , max=1 devrait echouer" );
    }
    
    public function testValidDatecreationVisite(){
        $aujourdhui = new DateTime();
        $this->assertsErrors($this->getVisite()->setDatecreation($aujourdhui), 0, "aujourdhui devrait reussir");
        $plustot =(new DateTime())->sub(new DateInterval("P5D"));
        $this->assertsErrors($this->getVisite()->setDatecreation($plustot), 0, "aujourdhui devrait reussir");
    }
    
    public function testNonValidDatecreationVisite(){
        $plustard = (new DateTime())->add(new DateInterval("P5D"));
        $this->assertsErrors($this->getVisite()->setDatecreation($plustard), 1, "plustard devrait echouer");
        $demain = (new DateTime())->add(new DateInterval("P1D"));
        $this->assertsErrors($this->getVisite()->setDatecreation($demain), 1, "demain devrait echouer");
    }
    
    public function assertsErrors(Visite $visite, int $nbErreursAttendues, string $message=""){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
    
}
