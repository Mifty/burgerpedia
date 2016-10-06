<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HamburgerTest extends TestCase
{
	use DatabaseTransactions;
	
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
	
	function testHamburgersList(){
		// create 3 hamburgers using the factory
		$hamburgers = factory(\App\Hamburger::Class, 3)->create();
		
		$this->get(route('hamburgers.index'))->assertResponseOk();
		
		// loop over our created collection of hamburgers and make sure that we can see the hamburgers
		array_map(function($hamburger){ 
			$this->seeJson($hamburger->jsonSerialize());
		}, $hamburgers->all());
	}
	
	function testHamburgerDescriptionsList(){
		// create a single hamburger with many descriptions using the factory
		$hamburger = factory(\App\Hamburger::Class)->create();
		// now creae many descritions for this hamburger
		$hamburger->descriptions()->saveMany(factory(\App\Description::Class, 5)->make());
		
		$this->get(route('hamburgers.descriptions.index', ['hamburgers' => $hamburger->id]))->assertResponseOk();
		
		array_map(function($description){ 
			$this->seeJson($description->jsonSerialize());
		}, $hamburger->descriptions->all());
	}
	
	
	function testHamburgerCreation(){
		$hamburger = factory(\App\Hamburger::Class)->make(['name' => 'super ultra burger']);
		$this->post(route('hamburgers.store'), $hamburger->jsonSerialize(), ['Accept' => 'application/json'])
		->SeeInDatabase('hamburgers', ['name' => $hamburger->name])
		->assertResponseOk();
	}
	
	
	function testHamburgerDescriptionCreation(){
		$hamburger = factory(\App\Hamburger::Class)->create(['name' => 'superburger']);
		$description = factory(\App\Description::Class)->make();
		
		$this->post(route('hamburgers.descriptions.store',['hamburger' => $hamburger->id]), $description->jsonSerialize(), ['Accept' => 'application/json'])
		->SeeInDatabase('descriptions', ['description' => $description->description])
		->assertResponseOk();
	}
	
	
	function testHamburgerUpdate(){
		$hamburger = factory(\App\Hamburger::Class)->create(['name' => 'Hero Burger']);
		$hamburger->name = "Hahahaha. I've just updated this burger's name";
		$this->put(route('hamburgers.update',['hamburgers' => $hamburger->id]), $hamburger->jsonSerialize(), ['Accept' => 'application/json'])
		->SeeInDatabase('hamburgers', ['name' => $hamburger->name])
		->assertResponseOk();
	}
	
	function testHamburgerDescriptionUpdate(){
		$description = factory(\App\Description::Class)->create(['description' => 'This is some random description','hamburger_id' => 1]);
		$description->description = "Hahahaha. I've just updated this burger's description";
		
		$this->put(route('hamburgers.descriptions.update',['hamburgers' => 1 ,'descriptions' => $description->id]), $description->jsonSerialize())
		->SeeInDatabase('descriptions', ['description' => $description->description])
		->assertResponseOk();
		
		

	}
	
	function testHamburgerCreationFailOnEmptyName(){
		$hamburger = factory(\App\Hamburger::Class)->make(['name' => '']);
		$this->post(route('hamburgers.store'), $hamburger->jsonSerialize(), ['Accept' => 'application/json'])
		->SeeJson(['name' => ['The name field is required.']])
		->assertResponseStatus(422);
	}
	
	
	function testHamburgerCreationFailOnDuplicateName(){
		$name = 'duplicateBurger';
		$hamburger1 = factory(\App\Hamburger::Class)->create(['name' => $name]);
		$hamburger2 = factory(\App\Hamburger::Class)->make(['name' => $name]);
		$this->post(route('hamburgers.store'), $hamburger2->jsonSerialize(), ['Accept' => 'application/json'])
		->SeeJson(['name' => ['The name has already been taken.']])
		->assertResponseStatus(422);
	}
	
	function testHamburgerDescriptionCreationFailOnEmptyDesc(){
		$hamburger = factory(\App\Hamburger::Class)->create(['name' => 'superburger']);
		$description = factory(\App\Description::Class)->make(['description' => '']);
		
		$this->post(route('hamburgers.descriptions.store',['hamburger' => $hamburger->id]), $description->jsonSerialize(), ['Accept' => 'application/json'])
		->SeeJson(['description' => ['The description field is required.']])
		->assertResponseStatus(422);
	}
	
	
}
