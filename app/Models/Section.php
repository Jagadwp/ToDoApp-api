<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Checklist;

class Section extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function checklist(){
        return $this->hasMany(Checklist::class, 'section_id');
    }

}
