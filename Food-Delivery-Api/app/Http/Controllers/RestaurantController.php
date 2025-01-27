<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{   
    //All Restaurants: With Conditions
    public function index(Request $request): JsonResponse{
        $query = Restaurant::query();

        if($request->has('cuisine')){
            $query->where('cuisine', $request->cuisine);
        }

        if($request->has('location')){
            $query->where('location', 'like', "%{$request->location}%");
        }

        $restaurants = $query->orderBy('rating', 'desc')->paginate(10);

        return response()->json([$restaurants]);
    }

    //Specific Restaurants
    public function show($id){
        $restaurant = Restaurant::findOrFail($id);
        return response()->json([
            $restaurant
        ]);
    }

    //Restaurant Menu Items
    public function menu($id){
        $menuItems = MenuItem::where('restaurant_id', $id)->get();
        return response()->json($menuItems);
    }

    //Implement Search.....
    public function search(Request $request){
        $query = $request->query('query');
        $results = Restaurant::where('name', 'like', "%$query%")
        ->orWhereHas('MenuItems', function ($q) use ($query){
            $q->where('name', 'like', "%query%");
        })->get();

        return response()->json($results);
    }

    //Create a Restaurant(Admin only)
    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string',
            'cuisine' => 'required|string',
            'location' => 'required|string',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric',
            'image_url' => 'nullable|url',
        ]);

        $Restaurant = Restaurant::Create($validatedData);

        return response()->json([$Restaurant], 201);


    }
}
