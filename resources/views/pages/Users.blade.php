@extends('layouts.Main')
@section('title', 'Users - Admin')
@section('text-addButton', 'Add User')

@section('idFilterSelect', 'filterStatus')
@section('options')
    <option value="">All status</option>
    <option value="1">Active</option>
    <option value="0">Inactive</option>
@endsection

@section('content')
    <div class="container mt-5 pt-4">
        <div class="card mb-2 shadow-sm border-0">
            <div class="card-body d-flex justify-content-between ">

                @include('components.SelectFilter')
                @include('components.button-addModal')
            </div>
        </div>
        <div class="table-responsive card p-2 shadow-sm border-0">
            <table id="table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">User name</th>
                        <th class="col">Email</th>
                        <th class="col">Role</th>
                        <th class="col">Status</th>
                        <th class="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="skeleton-row">
                        <td><div class="skeleton skeleton-text"></div></td>
                        <td><div class="skeleton skeleton-text"></div></td>
                        <td><div class="skeleton skeleton-text"></div></td>
                        <td><div class="skeleton skeleton-badge"></div></td>
                        <td class="actions">
                            <div class="skeleton skeleton-btn"></div>
                            <div class="skeleton skeleton-btn"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Modal -->
            @include('modals.User-Modal')
        <!-- End Modal -->
    </div>
@endsection