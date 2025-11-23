<div class="modal fade" id="addForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-1">
            <div class="modal-header bg-success text-white rounded-0">
                <h1 class="modal-title fs-5" id="addFormLabel">
                    <i class="fas fa-plus-circle"></i>
                    Add project
                </h1>
                <button type="button" class="btn-close btn-close-white text-bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                        <label for="tenduan" class="col-form-label fw-bold">Project name</label>
                        <input type="text" class="form-control tenduan">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kieuduan" class="col-form-label fw-bold">Project type</label>
                            <input type="text" class="form-control kieuduan">
                        </div>
                        <div class="col-md-6">
                            <label for="vaitrotrongduan" class="col-form-label fw-bold">Role in project</label>
                            <input type="text" class="form-control vaitrotrongduan">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="motaduan" class="col-form-label fw-bold">Project description</label>
                        <textarea class="form-control motaduan" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="thoigianthuchienduan" class="col-form-label fw-bold">Project date</label>
                        <input type="text" class="form-control thoigianthuchienduan">
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btnSave">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h1 class="modal-title fs-5" id="editFormLabel">
                    <i class="fas fa-edit me-2"></i>
                    Edit project
                </h1>
                <button type="button" class="btn-close btn-close-white text-bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                        <label for="tenduan" class="col-form-label fw-bold">Project name</label>
                        <input type="text" class="form-control tenduan">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kieuduan" class="col-form-label fw-bold">Project type</label>
                            <input type="text" class="form-control kieuduan">
                        </div>
                        <div class="col-md-6">
                            <label for="vaitrotrongduan" class="col-form-label fw-bold">Role in project</label>
                            <input type="text" class="form-control vaitrotrongduan">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="motaduan" class="col-form-label fw-bold">Project description</label>
                        <textarea class="form-control motaduan" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="thoigianthuchienduan" class="col-form-label fw-bold">Project date</label>
                        <input type="text" class="form-control thoigianthuchienduan">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="col-form-label fw-bold">Status</label>
                        <select class="form-select status" id="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success save-edit">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ----------------------------------------------------------------- Script ----------------------------------------------------------------- -->
<script type="text/javascript">
    var PATH = "/api/projects/";

    $(document).ready(function() {
        var table = $('#table').DataTable({
            "serverSide": true,
            "ajax": {
                "url": PATH + "DataTable",
                "type": "GET",
                "data": function (d) {
                    d.status = $('#filterStatus').val();
                }
            },
            columns: [
                { 
                    data: 'project_name' 
                },
                { 
                    data: 'status',
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
                $('td:eq(0)', row).replaceWith(`<th scope="row">${data.project_name}</th>`);
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
        
        $('#filterStatus, #filterSkillTitle').on('change', function() {
            table.ajax.reload();
        });

        $('.btnSave').on('click', function() {
            $.ajax({
                url: PATH,
                type: "POST",
                data: {
                    'tenduan': $('#addForm .tenduan').val(),
                    'kieuduan': $('#addForm .kieuduan').val(),
                    'vaitrotrongduan': $('#addForm .vaitrotrongduan').val(),
                    'motaduan': $('#addForm .motaduan').val(),
                    'thoigianthuchienduan': $('#addForm .thoigianthuchienduan').val()
                },
                dataType: "json",
                success: function (res) {
                    if (res.message === "success") {
                        $('#addForm .tenduan').val('');
                        $('#addForm .kieuduan').val('');
                        $('#addForm .vaitrotrongduan').val('');
                        $('#addForm .motaduan').val('');
                        $('#addForm .thoigianthuchienduan').val('');
                        $('#addForm').modal('hide');
                        showToast('success', 'Project added successfully! Proceeding to reload...');
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
                url: PATH + id,
                type: "GET",
                data: { id: id },
                dataType: "json",
                success: function (data) {
                    if (data) {
                        // Gán giá trị vào các phần tử trong modal
                        $('#editForm').find('.save-edit').attr('data-id', id);
                        $('#editForm .tenduan').val(data.project_name);
                        $('#editForm .kieuduan').val(data.project_type);
                        $('#editForm .vaitrotrongduan').val(data.project_role);
                        $('#editForm .motaduan').val(data.project_description);
                        $('#editForm .thoigianthuchienduan').val(data.project_date);
                        $('#editForm #status').val(data.status ? '1' : '0');
                        $('#editForm').modal('show');
                    } else {
                        showToast('error', 'Dữ liệu không tồn tại.');
                    }
                },
                error: function () {
                    showToast('error', 'Đã xảy ra lỗi khi lấy dữ liệu.');
                }
            });
        });

        $(document).on('click', '.save-edit', function() {
            let id = $(this).attr('data-id');

            $.ajax({
                url: PATH + id,
                type: "PUT",
                data: {
                    'tenduan': $('#editForm .tenduan').val(),
                    'kieuduan': $('#editForm .kieuduan').val(),
                    'vaitrotrongduan': $('#editForm .vaitrotrongduan').val(),
                    'motaduan': $('#editForm .motaduan').val(),
                    'thoigianthuchienduan': $('#editForm .thoigianthuchienduan').val(),
                    'status': $('#editForm #status').val()
                },
                dataType: "json",
                success: function (res) {
                    if (res.message === "success") {
                        // Xóa nội dung input
                        $('#editForm .tenduan').val('');
                        $('#editForm .kieuduan').val('');
                        $('#editForm .vaitrotrongduan').val('');
                        $('#editForm .motaduan').val('');
                        $('#editForm .thoigianthuchienduan').val('');
                        $('#editForm .tieudekynang').val('');
                        $('#editForm .class-icon').val('');
                        // Ẩn modal
                        $('#editForm').modal('hide');
                        // Reload sau 3s
                        showToast('success', 'Skill updated successfully! Proceeding to reload...');
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
                        url: PATH + id,
                        type: "DELETE",
                        data: { 'id': id },
                        dataType: "json",
                        success: function (res) {
                            if (res.message === "success") {
                                showToast('success', 'Title skill deleted successfully! Proceeding to reload...');
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