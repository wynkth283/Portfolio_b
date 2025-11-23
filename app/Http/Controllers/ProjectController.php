<?php

namespace App\Http\Controllers;

use App\Models\ProJect;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function projects() 
    {
        return response()->json(Project::with('project_links')->get());
    }

    public function create(Request $request)
    {
        $request->validate([
            'tenduan' => 'required|string|max:200',
            'kieuduan' => 'required|string|max:30',
            'vaitrotrongduan' => 'required|string|max:20',
            'motaduan' => 'required|string|max:1000',
            'thoigianthuchienduan' => 'required|string|max:20'
        ]);

        $project = Project::create([
            'project_name' => $request->tenduan,
            'project_type' => $request->kieuduan,
            'project_role' => $request->vaitrotrongduan,
            'project_description' => $request->motaduan,
            'project_date' => $request->thoigianthuchienduan,
            'status' => true
        ]);

        $project->load('project_links');
        
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function show($id)
    {
        $project = Project::with('project_links')->find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        return response()->json(
            $project, 200
        );
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        // if (Auth::id() !== $project->user_id && !Auth::user()->is_admin) { ... }

        $request->validate([
            'tenduan'               => 'sometimes|required|string|max:200',
            'kieuduan'              => 'sometimes|required|string|max:30',
            'vaitrotrongduan'       => 'sometimes|required|string|max:20',
            'motaduan'              => 'sometimes|required|string|max:1000',
            'thoigianthuchienduan'  => 'sometimes|required|string|max:20',
            'status'                => 'sometimes|boolean'
        ]);

        $project->update([
            'project_name'        => $request->tenduan,
            'project_type'        => $request->kieuduan,
            'project_role'        => $request->vaitrotrongduan,
            'project_description'=> $request->motaduan,
            'project_date'        => $request->thoigianthuchienduan,
            'status'              => $request->status,
        ]);

        $project->load('project_links');

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function delete($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $project->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function DataTable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->input('search.value');
        $status = $request->get('status');
        // $tieudekynang = $request->get('tieudekynang');

        // Query gốc với relationship
        $query = Project::with('project_links');

        // Lọc theo status (nếu có)
        if ($status !== null && $status !== '') {
            if ($status == '1') {
                $query->where('status', true);
            } elseif ($status == '0') {
                $query->where('status', false);
            }
        }

        // Lọc theo title_skill_id
        // if($tieudekynang !== null && $tieudekynang !== '') {
        //     $query->where('title_skill_id', $tieudekynang);
        // }
        
        // Lọc theo tìm kiếm
        if (!empty($searchValue)) {
            $query->where('project_name', 'like', '%' . $searchValue . '%');
        }

        $recordsTotal = Project::count();
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
