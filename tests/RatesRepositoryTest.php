<?php

namespace Tests;

use Taxman\Taxes;
use PHPUnit\Framework\TestCase;

class RatesRepositoryTest extends TestCase
{
   /** @test */
   function it_finds_taxes_rates_for_a_canadian_province()
   {
       $alberta = Taxes::stateRateFor('alberta');
       $this->assertEquals('5', $alberta);

       $britishColumbia = Taxes::stateRateFor('british_columbia');
       $this->assertEquals('7', $britishColumbia);

       $manitoba = Taxes::stateRateFor('manitoba');
       $this->assertEquals('8', $manitoba);

       $newBrunswick = Taxes::stateRateFor('new_brunswick');
       $this->assertEquals('15', $newBrunswick);

       $newfoundlandAndLabrador = Taxes::stateRateFor('newfoundland_and_labrador');
       $this->assertEquals('15', $newfoundlandAndLabrador);

       $northwestTerritories = Taxes::stateRateFor('northwest_territories');
       $this->assertEquals('5', $northwestTerritories);

       $novaScotia = Taxes::stateRateFor('nova_scotia');
       $this->assertEquals('15', $novaScotia);

       $nunavut = Taxes::stateRateFor('nunavut');
       $this->assertEquals('5', $nunavut);

       $princeEdwardIsland = Taxes::stateRateFor('prince_edward_island');
       $this->assertEquals('15', $princeEdwardIsland);

       $ontario = Taxes::stateRateFor('ontario');
       $this->assertEquals('13', $ontario);

       $quebec = Taxes::stateRateFor('quebec');
       $this->assertEquals('9.975', $quebec);

       $saskatchewan = Taxes::stateRateFor('saskatchewan');
       $this->assertEquals('6', $saskatchewan);

       $yukon = Taxes::stateRateFor('yukon');
       $this->assertEquals('5', $yukon);
   }

   /** @test */
   function it_finds_canada_taxe_rate_for_canadian_provinces()
   {
        $provinces = [
            'alberta', 
            'british_columbia', 
            'manitoba', 
            'new_brunswick', 
            'newfoundland_and_labrador',
            'northwest_territories', 
            'nova_scotia', 
            'nunavut', 
            'prince_edward_island', 
            'ontario',
            'quebec', 
            'saskatchewan',
            'yukon'
        ];

        foreach ($provinces as $province) {
            $countryRate = Taxes::countryRateFor($province);
            $this->assertEquals('5', $countryRate);
        }
   }

   /** @test */
   function it_calculates_provinces_taxes_rates_on_amount()
   {
        $alberta = new Taxes('10.00', 'alberta');
        $this->assertEquals('10.5', $alberta->total());
   }
   
}

// sluggify name
// translate name fr / en
// allow abbreviation (i.e Alberta => AB)
// calculate rates using tax name