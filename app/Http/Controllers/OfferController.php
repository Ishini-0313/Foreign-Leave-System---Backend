<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\WarmClothOffer;
use App\Models\AdditionalOffer;

class OfferController extends Controller
{
    public function save_additonal(Request $request, $id){
        $application = Application::findOrFail($id);
        $user = auth()->user();

        // Check current responsible officer
        if ($application->current_assigned_user_id != $user->id) {
            return response()->json([
                'message' => 'You are not currently responsible for this application.'
            ], 403);
        }

        // Check Subject Officer
        if ($user->role?->role_name !== 'Subject Officer') {
            return response()->json([
                'message' => 'Only the Subject Officer can fill this section.'
            ], 403);
        }

        // Check applicant's institute
        if ($user->office_id != $application->institute_id) {
            return response()->json([
                'message' => 'You are not the Subject Officer of the applicant\'s institute.'
            ], 403);
        }

        $request->validate([
            'no_of_days' => 'required|integer|min:0',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $additionalOffer = AdditionalOffer::updateOrCreate(
            [
                'application_id' => $application->id,
            ],
            [
                'no_of_days' => $request->no_of_days,
                'total_additional_offer' => $request->total_amount,
                'created_by' => auth()->id(),
            ]
        );
        
        return response()->json([
            'message' => 'Saved successfully!',
            'additional_offer' => $additionalOffer,
        ]);
    }

    public function save_warmcloth(Request $request, $id){
        $application = Application::findOrFail($id);
        $user = auth()->user();

        // Check current responsible officer
        if ($application->current_assigned_user_id != $user->id) {
            return response()->json([
                'message' => 'You are not currently responsible for this application.'
            ], 403);
        }

        // Check Subject Officer
        if ($user->role?->role_name !== 'Subject Officer') {
            return response()->json([
                'message' => 'Only the Subject Officer can fill this section.'
            ], 403);
        }

        // Check applicant's institute
        if ($user->office_id != $application->institute_id) {
            return response()->json([
                'message' => 'You are not the Subject Officer of the applicant\'s institute.'
            ], 403);
        }

        $request->validate([
            'is_country_in_the_northern_hemisphere' => 'required',
            'north_latitude' => 'required',
            'is_country_in_the_southern_hemisphere' => 'required',
            'south_latitude'=> 'required',
            'situated_more_than_5000_feet_above_sea_level' => 'required',
            'height' => 'required',
        ]);

        $warmClothOffer = WarmClothOffer::updateOrCreate(
            [
                'application_id' => $application->id,
            ],
            [
                'is_country_in_the_northern_hemisphere' => $request->is_country_in_the_northern_hemisphere,
                'north_latitude' => $request->north_latitude,
                'is_country_in_the_southern_hemisphere' => $request->is_country_in_the_southern_hemisphere,
                'south_latitude'=> $request->south_latitude,
                'situated_more_than_5000_feet_above_sea_level' => $request->situated_more_than_5000_feet_above_sea_level,
                'height' => $request->height,
                'created_by' => auth()->id(),
            ]
        );

        return response()->json([
            'message' => 'Saved successfully!',
            'warm_cloth_offer' => $warmClothOffer,
        ]);
    }
}
