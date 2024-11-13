<?php

require_once __DIR__ . "/../src/Fonctions/calculComplexiteMDP.php";
use PHPUnit\Framework\TestCase;

class CalculComplexiteMdpTest extends TestCase {

    public function testMotDePasseSimpleMinuscules() {
        $this->assertEquals(24, CalculComplexiteMdp("aubry")); // Entropie attendue : ~23 bits
    }

    public function testMotDePasseMinusculesAvecSymbole() {
        $this->assertEquals(59, CalculComplexiteMdp("super@ubry")); // Entropie attendue : ~47 bits
    }

    public function testMotDePasseComplexeAvecMajusculesChiffresSymboles() {
        $this->assertEquals(92, CalculComplexiteMdp("Super@ubry2022")); // Entropie attendue : ~77 bits
    }

    public function testMotDePasseTresComplexe() {
        $this->assertEquals(151, CalculComplexiteMdp("Giroud-Président||2027")); // Entropie attendue : ~135 bits
    }

    public function testMotDePasseVide() {
        $this->assertEquals(0, CalculComplexiteMdp("")); // Entropie attendue : 0 bits
    }
}