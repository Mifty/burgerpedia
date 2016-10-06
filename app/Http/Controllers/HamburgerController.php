<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Hamburger;

class HamburgerController extends Controller
{
	
	public function index(){
		return Hamburger::paginate();
	}
	
	public function show($id){
		$hamburger = Hamburger::findOrFail($id);
			
		return $hamburger;
	}
	
	public function store(Request $request){
		
		// validate our input burger
		$this->validate($request, [	'name' => 'required|unique:hamburgers|max:255' ]);
		$this->validate($request, [	'author' => 'required' ]);
		$this->validate($request, [	'overview' => 'required' ]);

		
		// we have a hamburger with a valid name
		$hamburger = Hamburger::create([
			'name' => $request->input('name'),
			'author' => $request->input('author'),
			'overview' => $request->input('overview')
		]);
			
		return $hamburger;
	}
	
	public function update(Request $request, $id ){
		
		$hamburger = Hamburger::findOrFail($id);
		
		if($request->input('author') == $hamburger['author']){
			// validate our input burger
			$this->validate($request, [	'name' => 'required|unique:hamburgers|max:255' ]);
			$this->validate($request, [	'overview' => 'required' ]);
		
			$hamburger->update([
				'name' => $request->input('name'),
				'overview' => $request->input('overview'),
				'author' => $request->input('author')
			]);
			return $hamburger;
		}else{
			// Unprocessable entity
			return response()->json(['name' => 'Failure! You are not the author of this hamburger'], 422);

		}
	}
	
}
