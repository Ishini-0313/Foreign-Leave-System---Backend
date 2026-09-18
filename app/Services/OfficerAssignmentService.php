<?php

namespace App\Services;

use App\Models\Office;
use App\Models\User;
use App\Models\Role;
use App\Models\UserOfficeRole;
use Illuminate\Support\Facades\DB;
use Exception;

class OfficerAssignmentService{
    
    //Roles that can be assigned to an office.
    private array $allowedOfficerRoles = [
        'Subject Officer',
        'Check Officer',
        'Recommended Officer',
    ];

    //Check whether the logged-in user can manage officers of this office.
    public function canManage(User $user,Office $institute): bool {
        //Only Office Admin or Admin can manage officer assignments.
        $roleName = $user->role?->role_name;

        if (!in_array($roleName, ['Office Admin','Admin'])) {
            return false;
        }

        //If office has a parent, parent office manages it.
        if ($institute->parent_office_id !== null) {
            return $user->office_id === $institute->parent_office_id;
        }

        //No parent: Chief Secretary Office Admin manages it.
        return $this->isChiefSecretaryOffice($user->office);
    }

    //Check whether the office is Chief Secretary Office.
    private function isChiefSecretaryOffice(?Office $office): bool {
        if (!$office) {
            return false;
        }
        return $office->name === "දකුණු පළාත් ප්‍රධාන ලේකම් කාර්යාලය";
    }

    //Assign officers to an office.
    public function assign(User $manager,Office $institute,array $assignments): void {
        //Authorization
        if (!$this->canManage($manager,$institute)) {
            throw new Exception(
                'You are not authorized to assign officers for this institute.'
            );
        }

        //Make sure this is actually an institute.
        // if (strtolower($institute->type) !== strtolower('Institute')) {
        //     throw new Exception(
        //         'Officers can only be assigned to an institute.'
        //     );
        // }


        // Required roles.
        $requiredRoles = ['Subject Officer','Check Officer','Recommended Officer',];
        foreach ($requiredRoles as $roleName) {
            if (!isset($assignments[$roleName])) {
                throw new Exception(
                    "{$roleName} is required."
                );
            }
        }

        //Prevent same user from being assigned multiple roles.
        $userIds = array_values($assignments);

        if (count($userIds) !== count(array_unique($userIds))) {
            throw new Exception(
                'The same user cannot be assigned to multiple officer roles.'
            );
        }

        // Get role IDs.
        $roles = Role::whereIn('role_name',$requiredRoles)->get()->keyBy('role_name');

        foreach ($requiredRoles as $roleName) {
            if (!isset($roles[$roleName])) {
                throw new Exception(
                    "Role '{$roleName}' does not exist."
                );
            }
        }

        //Get selected users.
        $users = User::whereIn('id',$userIds)->get()->keyBy('id');

        //Make sure all users exist.
        if ($users->count() !== count($userIds)) {
            throw new Exception(
                'One or more selected users do not exist.'
            );
        }

        //Users must belong to the institute itself.
        foreach ($users as $user) {
            if ((int) $user->office_id !== (int) $institute->id) {
                throw new Exception(
                    "User '{$user->name}' does not belong to this institute."
                );
            }
        }

        //Save assignments inside transaction.
        DB::transaction(function () use (
            $institute,
            $assignments,
            $roles
        ) {
            //Remove existing assignments for these officer roles.
            UserOfficeRole::where('office_id',$institute->id)->whereIn('role_id',$roles->pluck('id'))->delete();

            //Insert new assignments.
            foreach ($assignments as $roleName => $userId) {
                UserOfficeRole::create([
                    'user_id' => $userId,
                    'office_id' => $institute->id,
                    'role_id' => $roles[$roleName]->id,
                ]);
            }
        });
    }


    //Get current officers of an institute.
    public function getAssignments( Office $institute) {
        return UserOfficeRole::with(['user','role'])->where('office_id',$institute->id)->whereHas('role', function ($query) {
            $query->whereIn(
                'role_name',
                $this->allowedOfficerRoles
            );
        })->get();
    }
}