<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Visite;
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
    }
    
     public function testNonValidNoteVisite(){
        $visite = $this->getVisite()->setNote(21);
        $this->assertsErrors($visite, 1);
    }
    
    public function testNonValidTempMaxVisite(){
        $visite= $this->getVisite()
                ->setTempmin(20)
                ->setTempmax(18);
        $this->assertsErrors($visite, 1, "min=20, max=18 devrait échouer");
    }
    
    public function assertsErrors(Visite $visite, int $nbErreursAttendues, string $message=""){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
    
}
