<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MembersController extends Controller
{
   public function getFamilyTree(){
      $tree = Member::selectRaw("id, member_id, level, parent_id, concat(first_name, ' ', family_name) as name, gender, is_alive")
      ->with('children')
      ->find(1);
      return response()->json($tree);
   }
}
