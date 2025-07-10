<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Project extends Model
{
    // Proje yöneticisi
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // Proje ekip üyeleri
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
}
