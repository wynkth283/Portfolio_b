<?php

namespace App\Http\Controllers;

use App\Models\TitleSkill;
use Illuminate\Http\Request;

class TitleSkillController extends Controller
{
    public function index()
    {
        // Lấy toàn bộ dữ liệu từ bảng title_skills
        $titleSkills = TitleSkill::all();

        // Truyền dữ liệu sang view
        return view('pages.SkillsTitle', compact('titleSkills'));
    }

    public function getAll() {
        return response()->json(TitleSkill::with('skills')->get());
    }

    public function show($id)
    {
        $titleSkill = TitleSkill::find($id);
        
        if (!$titleSkill) {
            return response()->json(['message' => 'TitleSkill not found'], 404);
        }

        return response()->json($titleSkill);
    }

    public function create(Request $request)
    {
        $request->validate([
            'TitleSkill' => 'required|string|max:255',
            'StatusTK' => 'required|boolean',
        ]);

        TitleSkill::create(
            [
                'TitleSkill' => $request->TitleSkill,
                'StatusTK' => $request->StatusTK,
            ]
        );

        return response()->json([
            'message' => 'success'
        ], 201);

    }


    public function update(Request $request, $id) 
    {
        $request->validate([
            'TitleSkill' => 'required|string|max:255',
        ]);

        TitleSkill::findOrFail($id)->update
        ([
            'TitleSkill' => $request->TitleSkill,
            'StatusTK' => $request->StatusTK,
        ]);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function delete($id) 
    {
        TitleSkill::findOrFail($id)->delete();

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function DataTableGetAll(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->input('search.value');
        $status = $request->get('status');

        // Query gốc
        $query = TitleSkill::query();

        // Lọc theo status (nếu có)
        if ($status !== null && $status !== '') {
            if ($status == '1') {
                $query->where('StatusTK', true);
            } elseif ($status == '0') {
                $query->where('StatusTK', false);
            }
        }

        // Lọc theo tìm kiếm
        if (!empty($searchValue)) {
            $query->where('TitleSkill', 'like', '%' . $searchValue . '%');
        }

        $recordsTotal = TitleSkill::count();
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
