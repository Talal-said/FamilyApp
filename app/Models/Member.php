<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Member extends Model
{
   use HasFactory;
   use softDeletes;

   protected $fillable = [
      'id', // must be removed after uploading from excel
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
      'husband_id',
      'is_husband_from_outside',
      'mobile',
      'city',
      'edu_degree'
   ];

//   protected $appends = ['attributes'];

   public function getAttributesAttribute()
   {
      return [
      'id' => $this->id,
      ];
   }

   public function directChildren()
   {
      return $this->hasMany(Member::class, 'parent_id')
      ->selectRaw("id, level, parent_id, concat(first_name, family_name) as name, gender, is_alive");
   }

   public function wifeChildren()
   {
      return $this->hasMany(Member::class, 'mother_id')
      ->selectRaw("id, first_name, gender, is_alive, mother_id");
   }

   public function children()
   {
      return $this->hasMany(Member::class, 'parent_id')
      ->selectRaw("id, level, parent_id, concat(first_name, family_name) as name, gender, is_alive")
      ->with('children');
   }

   public function parent(){
      return $this->belongsTo(Member::class, 'parent_id');
   }

   public function wives()
   {
      return $this->hasMany(Member::class, 'husband_id')
      ->selectRaw("id, concat(first_name, IFNULL(second_name, ''), IFNULL(third_name, ''), IFNULL(fourth_name, ''), family_name) as fullname, is_alive, husband_id");
   }

   public function siblings()
   {
      if ($this->parent_id) {
         return Member::select('id', 'first_name', 'gender', 'is_alive')
         ->where('parent_id', $this->parent_id)
//         ->where('mother_id', $this->mother->id)
         ->where('id', '!=', $this->id)
         ->orderBy('siblings_order')
         ->get();
      }
      return collect();
   }

   public function getAllParentIds()
   {
      $parentIds = [];
      $child = $this;

      while ($child->parent) {
         $parentIds[] = $child->parent->id;
         $child = $child->parent;
      }

      return $parentIds;
   }


}
