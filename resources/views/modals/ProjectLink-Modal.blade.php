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
                    <label for="tenlink" class="col-form-label fw-bold">Link name</label>
                    <input type="text" class="form-control tenlink">
                </div>
                <div class="mb-3">
                    <label for="link" class="col-form-label fw-bold">Link</label>
                    <textarea class="form-control link" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="project" class="col-form-label fw-bold">Project</label>
                    <select class="form-control project" id="project">
                        <option value="">-- Choose project --</option>
                        <option value="1">Project 1</option>
                        <option value="2">Project 2</option>
                        <option value="3">Project 3</option>
                    </select>
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
                    <label for="tenlink" class="col-form-label fw-bold">Link name</label>
                    <input type="text" class="form-control tenlink">
                </div>
                <div class="mb-3">
                    <label for="link" class="col-form-label fw-bold">Link</label>
                    <textarea class="form-control link" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="project" class="col-form-label fw-bold">Project</label>
                    <select class="form-control project" id="project">
                    </select>
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
    $(document).ready(function() {
        $.ajax({
            url: "/api/projects",
            type: "GET",
            dataType: "json",
            success: function(data) {
                if(data) {
                    $('select.project').each(function() {
                        const $select = $(this);

                        const options = data.map(option => 
                            `
                               <option value="${option.id}">${option.project_name}</option>
                            `
                        );

                        $select.html(
                            `
                                 <option value=""> -- Choose project -- </option>
                                ${options.join('')}
                            `
                        )
                    });
                } else {
                    $("select.project").html('<option value=""> -- No data -- </option>');
                }
            },
            error: function() {
                $("select.project").html('<option value=""> -- Lỗi tải dữ liệu -- </option>');
            }
        });
    });
</script>
<script type="text/javascript">
    var PATH = "/api/project-links/";

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
                    data: 'link_name' 
                },
                { 
                    data: 'project',
                    render: function (data, type, row) {
                        return data && data.project_name ? data.project_name : '';
                    }
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
                $('td:eq(0)', row).replaceWith(`<th scope="row">${data.link_name}</th>`);
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
                    'tenlink': $('#addForm .tenlink').val(),
                    'link': $('#addForm .link').val(),
                    'project': $('#addForm .project').val()
                },
                dataType: "json",
                success: function (res) {
                    if (res.message === "success") {
                        $('#addForm .tenlink').val('');
                        $('#addForm .link').val('');
                        $('#addForm .project').val('');
                        $('#addForm').modal('hide');
                        showToast('success', 'Project link added successfully! Proceeding to reload...');
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
                        $('#editForm .tenlink').val(data.link_name);
                        $('#editForm .link').val(data.link);
                        $('#editForm .project').val(data.project_id);
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
                    'tenlink': $('#editForm .tenlink').val(),
                    'link': $('#editForm .link').val(),
                    'project': $('#editForm .project').val(),
                    'status': $('#editForm #status').val()
                },
                dataType: "json",
                success: function (res) {
                    if (res.message === "success") {
                        // Xóa nội dung input
                        $('#editForm .tenlink').val('');
                        $('#editForm .link').val('');
                        $('#editForm .project').val('');
                        // Ẩn modal
                        $('#editForm').modal('hide');
                        // Reload sau 3s
                        showToast('success', 'Project link updated successfully! Proceeding to reload...');
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