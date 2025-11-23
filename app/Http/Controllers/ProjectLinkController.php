<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ProjectLink;

class ProjectLinkController extends Controller
{
    public function project_links()
    {
        return response()->json(ProjectLink::with('project:id,project_name')->get());
    }

    public function create(Request $request)
    {
        $request->validate([
            'tenlink' => 'required|string|max:200',
            'link' => 'required|string|max:1000',
            'project' => 'required|integer',
        ]);

        $project_link = ProjectLink::create([
            'link_name' => $request->tenlink,
            'link' => $request->link,
            'status' => true,
            'project_id' => $request->project,
        ]);

        return response()->json([
            'message' => 'success'
        ], 201);
    }

    public function show($id)
    {
        $project_link = ProjectLink::with('project')->find($id);
        if (!$project_link) {
            return response()->json(['message' => 'Project link not found'], 404);
        }
        return response()->json($project_link, 200);
    }

    public function update(Request $request, $id)
    {
        $project_link = ProjectLink::find($id);
        if (!$project_link) {
            return response()->json(['message' => 'Project link not found'], 404);
        }
        
        $request->validate([
            'tenlink' => 'required|string|max:200',
            'link' => 'required|string|max:1000',
            'project' => 'required|exists:projects,id',
            'status' => 'required|boolean',
        ]);

        $project_link->update([
            'link_name' => $request->tenlink,
            'link' => $request->link,
            'project_id' => $request->project,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function delete($id)
    {
        $project_link = ProjectLink::find($id);
        if (!$project_link) {
            return response()->json(['message' => 'Project link not found'], 404);
        }
        $project_link->delete();
        return response()->json([
            'message' => 'success'
        ], 200);
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
        $query = ProjectLink::with('project');

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
            $query->where('link_name', 'like', '%' . $searchValue . '%');
        }

        $recordsTotal = ProjectLink::count();
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
