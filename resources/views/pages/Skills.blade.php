@extends('layouts.Main')
@section('title', 'Skills - Admin')
@section('text-addButton', 'Add Skill')

@section('content')
    <div class="container mt-5 pt-4">
        <div class="card mb-2 shadow-sm border-0">
            <div class="card-header">
                @include('components.button-addModal')
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <select id="filterStatus" class="form-select">
                            <option value="">All status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filterSkillTitle" class="form-select tieudekynang">
                        </select>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="table-responsive card p-2 shadow-sm border-0">
            <table id="table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name skill</th>
                        <th scope="col">Title skill</th>
                        <th scope="col">Class icon</th>
                        <th class="col">Status</th>
                        <th class="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('components.skeleton-row')
                </tbody>
            </table>
        </div>
        <!-- Modal -->
            @include('modals.Skill-Modal')
        <!-- End Modal -->
    </div>
@endsection