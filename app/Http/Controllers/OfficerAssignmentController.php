<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\User;
use App\Models\Role;
use App\Models\OfficeAssignment;
use App\Services\OfficerAssignmentService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class OfficerAssignmentController extends Controller{

    //get current subject, check , recommended officers and admin relevant to an office
    public function show(Office $office){
        $assignment = OfficeAssignment::with([
            'subjectOfficer',
            'checkOfficer',
            'recommendedOfficer',
            'recommendedOfficer2',
            'recommendedOfficer3',
            'cheifSec',
            'admin',
        ])
        ->where('office_id', $office->id)
        ->first();

        return response()->json([
            'office' => $office,
            'assignment' => $assignment,
        ]);
    }

    //get all users of an office
    public function users(Office $office){
        $this->authorizeAssignment($office);
        $users = User::where('office_id',$office->id)->where('status','Active')->select('id','full_name','email')->orderBy('full_name')->get();
        return response()->json($users);
    }


    public function assign(Request $request, Office $office){
        $request->validate([
            'subject_officer_id' => 'required|exists:users,id',
            'check_officer_id' => 'required|exists:users,id',
            'recommended_officer_id' => 'required|exists:users,id',
            'recommended_officer2_id' => 'nullable|exists:users,id',
            'recommended_officer3_id' => 'nullable|exists:users,id',
            'chief_sec_id' => 'nullable|exists:users,id',
            'admin_user_id' => 'nullable|exists:users,id',
            
        ]);

        $subjectId = (int) $request->subject_officer_id;
        $checkId = (int) $request->check_officer_id;
        $recommendedId = (int) $request->recommended_officer_id;

        $recommendedId2 = $request->filled('recommended_officer2_id') ? (int) $request->recommended_officer2_id : null;
        $recommendedId3 = $request->filled('recommended_officer3_id') ? (int) $request->recommended_officer3_id : null;
        $chiefSecId = $request->filled('chief_sec_id') ? (int) $request->chief_sec_id : null;
        $adminId = $request->filled('admin_user_id') ? (int) $request->admin_user_id : null;

        //1. Check the three officer roles are different users
        if (
            $subjectId === $checkId ||
            $subjectId === $recommendedId ||
            $checkId === $recommendedId
        ) {
            return response()->json([
                'message' =>'Subject Officer, Check Officer and Recommended Officer must be three different users.'
            ], 422);
        }

        
        // 2. Check assignment permission
        $this->authorizeAssignment($office);

        
        // 3. Make sure selected users belong to this office
        $selectedUserIds = array_filter([
            $subjectId,
            $checkId,
            $recommendedId,
            $recommendedId2,
            $recommendedId3,
            $chiefSecId,
            $adminId,
        ]);

        $validUserIds = User::where('office_id', $office->id)
            ->where('status', 'Active')
            ->whereIn('id', $selectedUserIds)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        foreach ($selectedUserIds as $userId) {
            if (!in_array($userId, $validUserIds)) {
                return response()->json([
                    'message' => "Selected user ID {$userId} does not belong to this office."
                ], 422);
            }
        }

        
        // 4. Role IDs
        $subjectRoleId = Role::where('role_name','Subject Officer')->value('id');
        $checkRoleId = Role::where('role_name','Check Officer')->value('id');
        $recommendedRoleId = Role::where('role_name','Recommended Officer')->value('id');
        $recommended2RoleId = Role::where('role_name','Recommended Officer-II')->value('id');
        $recommended3RoleId = Role::where('role_name','Recommended Officer-III')->value('id');
        $chiefSecRoleId = Role::where('role_name','Chief Secretary')->value('id');
        $adminRoleId = Role::where('role_name','Admin')->value('id');

        if (
            !$subjectRoleId ||
            !$checkRoleId ||
            !$recommendedRoleId ||
            !$recommended2RoleId ||
            !$recommended3RoleId ||
            !$chiefSecRoleId ||
            !$adminRoleId 
        ) {
            return response()->json([
                'message' => 'Required roles were not found in the roles table.'
            ], 500);
        }

        
        // 5. Save assignment
        DB::transaction(function () use (
            $office,
            $subjectId,
            $checkId,
            $recommendedId,
            $recommendedId2,
            $recommendedId3,
            $chiefSecId,
            $adminId,
            $subjectRoleId,
            $checkRoleId,
            $recommendedRoleId,
            $recommended2RoleId,
            $recommended3RoleId,
            $chiefSecRoleId,
            $adminRoleId,
        ) {
            User::where('id', $subjectId)->update(['role_id' => $subjectRoleId]);

            User::where('id', $checkId)->update(['role_id' => $checkRoleId]);

            User::where('id', $recommendedId)->update(['role_id' => $recommendedRoleId]);

            User::where('id', $recommendedId2)->update(['role_id' => $recommended2RoleId]);

            User::where('id', $recommendedId3)->update(['role_id' => $recommended3RoleId]);

            User::where('id', $chiefSecId)->update(['role_id' => $chiefSecRoleId]);

            
            //Save office assignment
            OfficeAssignment::updateOrCreate(
                [
                    'office_id' => $office->id,
                ],
                [
                    'subject_officer_id' => $subjectId,
                    'check_officer_id' => $checkId,
                    'recommended_officer_id' => $recommendedId,
                    'recommended_officer2_id' => $recommendedId2,
                    'recommended_officer3_id' => $recommendedId3,
                    'chief_sec_id' => $chiefSecId,
                    'admin_user_id' => $adminId,
                    'assigned_by' => auth()->id(),
                ]
            );
        });

        
        // 6. Return updated assignment
        $assignment = OfficeAssignment::with([
            'office',
            'subjectOfficer',
            'checkOfficer',
            'recommendedOfficer',
            'recommendedOfficer2',
            'recommendedOfficer3',
            'cheifSec',
            'admin',
            'assignedBy',
        ])
        ->where('office_id', $office->id)
        ->first();

        return response()->json([
            'message' => 'Office roles assigned successfully.',
            'assignment' => $assignment,
        ]);
    }

    

    private function authorizeAssignment(Office $office){
        $currentUser = auth()->user();

        // SYSTEM ADMIN -  System Admin can assign ALL roles of the Chief Secretary Personal & Training office.
        if ($currentUser->role?->role_name === 'System Admin') {
            if ($office->type === 'Chief Secretary Personal and Training') {
                return;
            }

            abort(
                403,
                'System Admin can only assign roles of the Chief Secretary Personal and Training office.'
            );
        }

        // CHILD OFFICE - Admin of parent office can assign the three officers and admin of the child office.
        if ($office->parent_office_id) {
            $parentOffice = $office->parent;
            if (!$parentOffice) {
                abort(403, 'Parent office not found.');
            }

            $parentAdmin = OfficeAssignment::where('office_id',$parentOffice->id)
                ->where('admin_user_id',$currentUser->id)
                ->exists();

            if (!$parentAdmin) {
                abort(403,'You are not authorized to assign this office.');
            }
            return;
        }

        //MINISTRY - Ministry has no parent. Therefore Ministry officers are assigned by Chief Secretary Admin.
        if ($office->type === 'Ministry') {
            if ($this->isPersonalTrainingAdmin($currentUser)) {
                return;
            }

            abort(403,'Only Chief Secretary Admin can assign Ministry officers.');
        }

        //CHIEF SECRETARY ADMIN - Its admin is assigned by the admin of Chief Secretary Personal & Training.
        if ($office->type === 'Chief Secretary Admin') {
            if ($this->isPersonalTrainingAdmin($currentUser)) {
                return;
            }

            abort(403,'Only Chief Secretary Personal and Training Admin can assign this office.');
        }

        //CHIEF SECRETARY PERSONAL & TRAINING - System Admin is handled at the beginning.
        if ($office->type === 'Chief Secretary Personal and Training') {
            abort(
                403,
                'You are not authorized to assign this office.'
            );
        }

        //DEFAULT
        abort(403,'You are not authorized to assign this office.');
    }

    // private function isChiefSecretaryAdmin(User $user): bool{
    //     // Implement according to your actual office/role structure.
    //     return OfficeAssignment::where('admin_user_id',$user->id)
    //         ->whereHas('office', function ($query) {
    //             $query->where('type', 'Chief Secretary Admin');
    //         })
    //         ->exists();
    // }

    private function isPersonalTrainingAdmin(User $user): bool{
        return OfficeAssignment::where('admin_user_id', $user->id)
            ->whereHas('office', function ($query) {
                $query->where('type','Chief Secretary Personal and Training');
            })
            ->exists();
    }

    public function assignableOffices(Request $request){
        $user = $request->user();

        //1. SYSTEM ADMIN
        if ($user->role?->role_name === 'System Admin') {
            $offices = Office::where('type','Chief Secretary Personal and Training')->where('status', 'Active')->orderBy('name')->get();
            return response()->json($offices);
        }


        //2. CHIEF SECRETARY PERSONAL & TRAINING ADMIN -  Can manage Chief Secretary Admin and ministries
        $specialOfficeIds = collect();
        $ministryIds = collect();

        $isChiefSecretaryPersonalTrainingAdmin = OfficeAssignment::where('admin_user_id',$user->id)
            ->whereHas('office', function ($query) {
                $query->where('type', 'Chief Secretary Personal and Training');
            })
            ->exists();

        if ($isChiefSecretaryPersonalTrainingAdmin) {
            // Can manage Chief Secretary Admin office
            $specialOfficeIds = Office::where('type', 'Chief Secretary Admin')
                ->where('status', 'Active')
                ->pluck('id');

            // Can manage all Ministries
            $ministryIds = Office::where('type', 'Ministry')
                ->where('status', 'Active')
                ->pluck('id');
        }

        // 4. NORMAL CHILD OFFICES - Parent office admin manages child offices.
        $managedOfficeIds = Office::whereHas('parent',function ($query) use ($user) {
                $query->whereHas(
                    'assignment',
                    function ($assignmentQuery) use ($user) {
                        $assignmentQuery->where(
                            'admin_user_id',
                            $user->id
                        );
                    }
                );
            }
        )->pluck('id');


        //COMBINE
        $officeIds = $managedOfficeIds
            ->merge($specialOfficeIds)
            ->merge($ministryIds)
            ->unique()
            ->values();


        
        //6. RETURN
        $offices = Office::whereIn('id',$officeIds)
            ->where(
                'status',
                'Active'
            )
            ->orderBy('name')
            ->get();

        return response()->json($offices);
    }

    public function myAdminOffices(Request $request){
        $user = $request->user();

        $offices = OfficeAssignment::with('office')
            ->where('admin_user_id', $user->id)
            ->get()
            ->map(function ($assignment) {
                return [
                    'id' => $assignment->office->id,
                    'name' => $assignment->office->name,
                    'type' => $assignment->office->type,
                ];
            });

        return response()->json([
            'is_admin' => $offices->isNotEmpty(),
            'offices' => $offices,
        ]);
    }
}