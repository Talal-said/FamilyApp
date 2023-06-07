<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
   use HasFactory;
   use softDeletes;
   protected $fillable = [
   'member_id',
   'level',
   'first_name',
   'second_name',
   'third_name',
   'fourth_name',
   'family_name',
   'gender',
   'is_alive',
   'parent_id',
   'mother_id',
   'siblings_order',
   ];

   protected $appends = ['attributes'];

   public function getAttributesAttribute()
   {
      return [
      'id' => $this->id,
      ];
   }

   public function profile(){
      return $this->hasOne(Profile::class, 'member_id');
   }

   public function children()
   {
      return $this->hasMany(Member::class, 'parent_id', 'member_id')
      ->selectRaw("id, member_id, level, parent_id, concat(first_name, ' ', family_name) as name, gender, is_alive")->with('children');
   }

   public function descendants()
   {
      return $this->children()->with('descendants');
   }

   public function recursiveDescendants()
   {
      return $this->descendants()->with('recursiveDescendants');
   }
}
