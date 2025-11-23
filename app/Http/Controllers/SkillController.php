<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function getAll() {
        return response()->json(Skill::with('titleSkill')->get());
    }

    public function create(Request $request) {
        $request->validate([
            'NameSkill' => 'string|required|max:225',
            'TitleSkill' => 'integer|required', 
            'ClassIcon'=> 'string|required|max:30',
        ]);

        Skill::create([
            'NameSkill' => $request->NameSkill,
            'title_skill_id' => $request->TitleSkill, 
            'ClassIcon'=> $request->ClassIcon, 
            'StatusSkill' => true,
        ]);

        return response()->json([
            'message' => 'success'
        ], 201);
    }

    public function show($id) {
        $skill = Skill::with('titleSkill')->find($id);

        if(!$skill) { return response()->json([ 'message' => 'Skill not found.' ], 404); }

        return response()->json($skill, 200);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'NameSkill' => 'string|required|max:225',
            'TitleSkill' => 'integer|required', 
            'ClassIcon'=> 'string|required|max:50', 
            'StatusSkill' => 'required|boolean'
        ]);

        $skill = Skill::findOrFail($id)->update([
            'NameSkill' => $request->NameSkill,
            'title_skill_id' => $request->TitleSkill, 
            'ClassIcon'=> $request->ClassIcon, 
            'StatusSkill' => $request->StatusSkill,
        ]);

        if(!$skill) { return response()->json([ 'message' => 'Skill not found.' ], 404); }

        return response()->json([
            'message' => 'success'
        ], 201);
    }

    public function delete($id) {
        $skill = Skill::findOrFail($id)->delete();
        if(!$skill) { return response()->json([ 'message' => 'Skill not found.' ], 404); }
        return response()->json([ 'message' => 'success'], 201);
    }

    public function DataTableGetAll(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->input('search.value');
        $status = $request->get('status');
        $tieudekynang = $request->get('tieudekynang');

        // Query gốc với relationship
        $query = Skill::with('titleSkill');

        // Lọc theo status (nếu có)
        if ($status !== null && $status !== '') {
            if ($status == '1') {
                $query->where('StatusSkill', true);
            } elseif ($status == '0') {
                $query->where('StatusSkill', false);
            }
        }

        // Lọc theo title_skill_id
        if($tieudekynang !== null && $tieudekynang !== '') {
            $query->where('title_skill_id', $tieudekynang);
        }
        
        // Lọc theo tìm kiếm
        if (!empty($searchValue)) {
            $query->where('NameSkill', 'like', '%' . $searchValue . '%');
        }

        $recordsTotal = Skill::count();
        $recordsFiltered = $query->count();

        // Phân trang
        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            "draw" => intval($draw),
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ]);
    }
}
