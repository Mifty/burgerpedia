<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Description;
use App\Hamburger;

class HamburgerDescriptionController extends Controller
{
	public function index($hamburgerId){
		return Description::ofHamburger($hamburgerId)->paginate();
	}
	
	public function show($hamburgerId,$descriptionId){
		$description = Description::ofHamburger($hamburgerId)->findOrFail($descriptionId);
			
		return $description;
	}
	
	public function store(Request $request, $hamburgerId){
		
		// validate our input description
		$this->validate($request, [	'description' => 'required' , 'author' => 'required', 'title' => 'required']);
		
		$hamburger = Hamburger::findOrFail($hamburgerId);
		$hamburger->descriptions()->save(new Description([
			'title' => $request->input('title'),
			'description' => $request->input('description'),
			'author' => $request->input('author')
		]));
			
		return $hamburger->descriptions;
	}
	
	public function update(Request $request, $hamburgerId, $descriptionId){
		
		$description = Description::ofHamburger($hamburgerId)->findOrFail($descriptionId);
		
		if($request->input('author') == $description['author']){
			$description->update([
				'title' => $request->input('title'),
				'description' => $request->input('description'),
				'author' => $request->input('author')
			]);
			return $description;
		}else{
			// Unprocessable entity
			return response()->json(['name' => 'Failure! You are not the author of this description'], 422);

		}
	}
	
	public function destroy($hamburgerId,$descriptionId)
	{
		$description = Description::ofHamburger($hamburgerId)->findOrFail($descriptionId);
	 
		$description->delete();
	 
		return $description;
	}
	
}
