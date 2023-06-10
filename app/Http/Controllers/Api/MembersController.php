<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MembersController extends Controller
{
   public function getFamilyTree(){
      $tree = Member::selectRaw("id, level, parent_id, concat(first_name, family_name) as name, gender, is_alive")
         ->with('children')
         ->find(1);
      return response()->json($tree);
   }

   public function searchForUser(){
      $search_name = request()->query('name');
      $data = Member::selectRaw("id, concat(first_name, IFNULL(second_name, ''), IFNULL(third_name, ''), IFNULL(fourth_name, ''), family_name) as fullname")
      ->whereRaw("concat(first_name, IFNULL(second_name, ''), IFNULL(third_name, ''), IFNULL(fourth_name, ''), family_name) like '%$search_name%'")->get();
      $data->makeHidden(['attributes']);
      return response()->json(['data' => $data]);
   }

   public function getRelation(Request $request){
      $first_id = $request->first;
      $second_id = $request->second;

      $first = Member::find($first_id);
      $firstParentIds = $first->getAllParentIds();

      $second = Member::find($second_id);
      $secondParentIds = $second->getAllParentIds();

      $data = [];
      $commonIds = array_intersect($firstParentIds, $secondParentIds);
      if(!empty($commonIds)){
         $firstCommonId = current($commonIds);
         $data['firstCommonId'] = $firstCommonId;
         $data['firstDistance'] = array_search($firstCommonId, $firstParentIds) + 1;
         $data['secondDistance'] = array_search($firstCommonId, $secondParentIds) + 1;
      }

      return response()->json($data);
   }

   public function getProfileData(){
      $id = request()->query('id');
      $member = Member::selectRaw("id, concat(first_name, IFNULL(second_name, ''), IFNULL(third_name, ''), IFNULL(fourth_name, ''), family_name) as fullname, gender, is_alive, mobile, city, edu_degree, parent_id")
      ->with(['wives' => function($q) use($id){
         $q->with(['wifeChildren' => function ($query) use($id){
            $query->where('parent_id', $id);
         }]);
      }])
      ->find($id);
      $member->siblings =  $member->siblings();
      return response()->json($member);
   }
}
