<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

class OfferController extends Controller
{
    public function save_additonal(Request $request, $id){
        $application = Application::findOrFail($id);

        $request->validate([
            'no_of_days' => 'required|integer|min:0',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $application->update([
            'no_of_days' => $request->no_of_days,
            'total_additional_offer' => $request->total_amount,
        ]);

        return response()->json([
            'message' => 'Saved successfully!',
            'application' => $application
        ]);
    }

    public function save_warmcloth(Request $request, $id){
        $application = Application::findOrFail($id);

        $request->validate([
            'is_country_in_the_northern_hemisphere' => 'required',
            'north_latitude' => 'required',
            'is_country_in_the_southern_hemisphere' => 'required',
            'south_latitude'=> 'required',
            'situated_more_than_5000_feet_above_sea_level' => 'required',
            'height' => 'required',
        ]);

        $application->update([
            'is_country_in_the_northern_hemisphere' => $request->is_country_in_the_northern_hemisphere,
            'north_latitude' => $request->north_latitude,
            'is_country_in_the_southern_hemisphere' => $request->is_country_in_the_southern_hemisphere,
            'south_latitude'=> $request->south_latitude,
            'situated_more_than_5000_feet_above_sea_level' => $request->situated_more_than_5000_feet_above_sea_level,
            'height' => $request->height,
        ]);

        return response()->json([
            'message' => 'Saved successfully!',
            'application' => $application
        ]);
    }
}
