<!-- ----------------------------------------------------------------- Create Modal ----------------------------------------------------------------- -->
<div class="modal fade" id="addForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h1 class="modal-title fs-5" id="addFormLabel">
                    <i class="fas fa-plus-circle"></i>
                    Add user
                </h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="name" class="col-form-label fw-bold">User name</label>
                        <input type="text" id="name" class="form-control name" placeholder="Enter name title skill">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="email" class="col-form-label fw-bold">Email</label>
                        <input type="text" id="email" class="form-control email" placeholder="Enter name title skill">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="password" class="col-form-label fw-bold">Password</label>
                        <input type="text" id="password" class="form-control password" placeholder="Enter name title skill">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="role" class="col-form-label fw-bold">Role</label>
                        <select class="form-control role" name="role" id="role">
                            <option value="">-- Choose role --</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm shadow-sm-success btnSave">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ----------------------------------------------------------------- Update Modal ----------------------------------------------------------------- -->
<div class="modal fade" id="editForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h1 class="modal-title fs-5" id="editFormLabel">
                    <i class="fas fa-edit me-2"></i>
                    Edit user
                </h1>
                <button type="button" class="btn-close btn-close-white text-bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="name" class="col-form-label fw-bold">User name</label>
                        <input type="text" id="name" class="form-control name" placeholder="Enter name title skill">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="email" class="col-form-label fw-bold">Email</label>
                        <input type="text" id="email" class="form-control email" placeholder="Enter name title skill">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="role" class="col-form-label fw-bold">Role</label>
                        <select class="form-control role" name="role" id="role">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="status" class="col-form-label fw-bold">Status</label>
                        <select class="form-control status" name="status" id="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option> 
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success shadow-sm-success save-edit">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ----------------------------------------------------------------- Script ----------------------------------------------------------------- -->
<script type="text/javascript">
    var PATH_ID = "/api/users/";

    $(document).ready(function() {
        var table = $('#table').DataTable({
            "serverSide": true,
            "ajax": {
                "url": "api/users/DataTableGetAll",
                "type": "GET",
                "data": function (d) {
                    d.status = $('#filterStatus').val();
                }
            },
            columns: [
                { 
                    data: 'name'
                },
                { 
                    data: 'email'
                },
                { 
                    data: 'role'
                },
                { 
                    data: 'StatusUser',
                    render: function (data, type, row) {
                        return data 
                            ? `@include('components.bagde-success')` 
                            : `@include('components.bagde-danger')`;
                    }
                },
                { 
                    render: function (type, row) {
                        return `
                            @include('components.button-editModal')
                            @include('components.button-delete')
                        `;
                    }
                }
            ],
            createdRow: function (row, data) {
                $(row).attr('data-id', data.id);
                $('td:eq(0)', row).replaceWith(`<th scope="row">${data.name}</th>`);
            },
            "processing": true,
            "responsive": true,
            "language": {
                "search": "",
                "searchPlaceholder": "Search with data in table ...",
                // "lengthMenu": "Hiển thị _MENU_ dòng",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "<i class='fas fa-chevron-right'></i>",
                    "previous": "<i class='fas fa-chevron-left'></i>",
                },
                "zeroRecords": "Không tìm thấy kết quả phù hợp"
            },
            "info": false,
        });
        
        $('#filterStatus').on('change', function() {
            table.ajax.reload();
        });

        $('.btnSave').on('click', function() {
            $.ajax({
                url: PATH_ID,
                type: "POST",
                data: {
                    'name': $('.name').val(),
                    'email': $('.email').val(),
                    'password': $('.password').val(),
                    'role': $('.role').val()
                },
                dataType: "json",
                success: function (res) {
                    if (res.message === "success") {
                        // Xóa nội dung input
                        $('.nameTitleSkill').val('');
                        // Ẩn modal
                        $('#addForm').modal('hide');
                        // Reload sau 3s
                        showToast('success', 'User added successfully! Proceeding to reload...');
                        $('#table').DataTable().ajax.reload(null, false);

                    } else {
                        showToast('error', res.message);
                    }
                },
                error: function (xhr) {
                    showToast('error', xhr.responseJSON.message);
                }
            });
        });

        $(document).on('click', '.itemedit', function() {
            let id = $(this).closest("tr").data("id");

            if (!id) {
                showToast('error', 'ID không hợp lệ.');
                return;
            }

            $.ajax({
                url: PATH_ID + id,
                type: "GET",
                data: { id: id },
                dataType: "json",
                success: function (data) {
                    if (data) {
                        // Gán giá trị vào các phần tử trong modal
                        $('.save-edit').attr('data-id', id);
                        $('#editForm #name').val(data.name);
                        $('#editForm #email').val(data.email);
                        $('#editForm #role').val(data.role);
                        $('#editForm #status').val(data.StatusUser ? '1' : '0');
                    } else {
                        showToast('error', 'Dữ liệu không tồn tại.');
                    }
                },
                error: function () {
                    showToast('error', 'Đã xảy ra lỗi khi lấy dữ liệu.');
                }
            });
        });

        $('.save-edit').on('click', function() {
            let id = $(this).attr('data-id');

            $.ajax({
                url: PATH_ID + id,
                type: "PUT",
                data: {
                    'name': $('#editForm .name').val(),
                    'email': $('#editForm .email').val(),
                    'role': $('#editForm .role').val(),
                    'status': $('#editForm .status').val(),
                },
                dataType: "json",
                success: function (res) {
                    if (res.message === "success") {
                        $('#editForm .name').val('');
                        $('#editForm .email').val('');
                        $('#editForm .role').val('');
                        $('#editForm .status').val('');
                        // Ẩn modal
                        $('#editForm').modal('hide');
                        // Reload sau 3s
                        showToast('success', 'User updated successfully! Proceeding to reload...');
                        $('#table').DataTable().ajax.reload(null, false);
                    } else {
                        showToast('error', res.message);
                    }
                },
                error: function (xhr) {
                    showToast('error', xhr.responseJSON.message);
                }
            });
        });

        $(document).on('click', '.itemdelete', function() {
            let id = $(this).closest("tr").data("id");

            if (!id) {
                showToast('error', 'ID không hợp lệ.');
                return;
            }
            Swal.fire({
                title: "Confirm",
                text: "Are you sure you want to delete? The data will not be recovered!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete now!",
                cancelButtonText: "Cancel"
            }).then((res) => {
                if(res.isConfirmed) {
                    $.ajax({
                        url: PATH_ID + id,
                        type: "DELETE",
                        data: { 'id': id },
                        dataType: "json",
                        success: function (res) {
                            if (res.message === "success") {
                                showToast('success', 'User deleted successfully! Proceeding to reload...');
                                $('#table').DataTable().ajax.reload(null, false);
                            } else {
                                showToast('error', res.message);
                            }
                        },
                        error: function (xhr) {
                            showToast('error', xhr.res.message);
                        }
                    });
                }
            });
        });

    });
</script>