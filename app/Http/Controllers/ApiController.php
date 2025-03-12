<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function fetchData()
    {
    	//Getting all pet entries from API. Since there is no default way to get entries, so entries are retrieved using status. 
        $response = Http::get('https://petstore.swagger.io/v2/pet/findByStatus?status=available,pending,sold');
        //dd($response->json());
        $data = $response->json();
        
        //Sorting by ID. For debug only
        /*usort($data, function ($a, $b) {
            return $a['id'] - $b['id'];
        });*/

        return view('api.index', ['data' => $data]);
    }

    public function createForm()
    {
    	// Render the form
        return view('api.create');
    }

    public function create(Request $request)
    {
        return $this->savePet($request);
    }

    public function editForm($petId)
    {
        $response = Http::get("https://petstore.swagger.io/v2/pet/{$petId}");
        $pet = $response->json();

        return view('api.edit', ['pet' => $pet]);
    }

    public function update(Request $request, $petId)
    {
        return $this->savePet($request, $petId);
    }

    //Depending on function/provided arguments, function will either create or update pet and try to send it (function overload). If it fails , it will redirect back to appropriate form with  error message
    private function savePet(Request $request, $petId = null)
    {
        $data = [
            'id' => $petId? (int)$petId : 0,
            'name' => $request->input('name'),
            'status' => $request->input('status'),
            'category' => [
                'id' => 0, // placeholder data, replace with $request->input('category_id') if category number is desired
                'name' => $request->input('category'),
            ],
        ];

        $url = "https://petstore.swagger.io/v2/pet/";
        $response = $petId ? Http::put($url, $data) : Http::post($url, $data); //dd($response->json());


        if ($response->successful()) {
        //dd($response->json());
            return redirect()->route('pets')->with('success', $petId ? 'Pet updated successfully!' : 'Pet created successfully!');
        } else {
            return redirect()->route($petId ? 'pets.editForm' : 'pets.add', ['petId' => $petId])->with('error', 'Failed to save pet. Please try again.');
        }
    }

    public function destroy($petId)
    {
        $response = Http::delete("https://petstore.swagger.io/v2/pet/{$petId}");

        return redirect()->route('pets')->with('success', 'Pet deleted successfully!');
    }
}
