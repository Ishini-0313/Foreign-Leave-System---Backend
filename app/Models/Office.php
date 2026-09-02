<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Application;
use App\Models\UserOfficeRole;
use App\Models\OfficeAssignment;

class Office extends Model{
    protected $fillable = ['name', 'type', 'parent_office_id', 'status'];

    public function application(){
        return $this->hasMany(Application::class);
    }

    public function parent(){
        return $this->belongsTo(Office::class, 'parent_office_id');
    }

    // Direct child offices
    public function children(){
        return $this->hasMany(Office::class, 'parent_office_id');
    }

    public function users(){
        return $this->hasMany(User::class,'office_id');
    }

    public function userOfficeRoles(){
        return $this->hasMany(UserOfficeRole::class);
    }

    public function getAllDescendantIds(){
        $ids = [$this->id];

        foreach ($this->children as $child) {
            $ids = array_merge(
                $ids,
                $child->getAllDescendantIds()
            );
        }

        return $ids;
    }

    public function assignment(){
        return $this->hasOne(OfficeAssignment::class);
    }
}
