<!-- ----------------------------------------------------------------- Create Modal ----------------------------------------------------------------- -->
<div class="modal fade" id="addForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h1 class="modal-title fs-5" id="addFormLabel">
                    <i class="fas fa-plus-circle"></i>
                    Add Skill title
                </h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="name-skill" class="col-form-label fw-bold">Skill Title</label>
                        <input type="text" class="form-control tieudekynang" placeholder="Enter name title skill">
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
                    Edit skill
                </h1>
                <button type="button" class="btn-close btn-close-white text-bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="name-skill" class="col-form-label fw-bold">Skill title</label>
                        <input type="text" class="form-control" id="name-skill" placeholder="Enter skill title">
                    </div>
                    <div class="mb-3">
                        <label for="status-skill" class="col-form-label fw-bold">Status</label>
                        <select class="form-select" id="status-skill">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div id="error"></div>
                </form>
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
    var PATH_ID = "/api/title-skills/";

    $(document).ready(function() {
        var table = $('#table').DataTable({
            "serverSide": true,
            "ajax": {
                "url": "api/title-skills/DataTableGetAll",
                "type": "GET",
                "data": function (d) {
                    d.status = $('#filterStatus').val();
                }
            },
            columns: [
                { 
                    data: 'TitleSkill'
                },
                { 
                    data: 'StatusTK',
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
                $('td:eq(0)', row).replaceWith(`<th scope="row">${data.TitleSkill}</th>`);
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
                    'TitleSkill': $('.tieudekynang').val(),
                    'StatusTK': 1
                },
                dataType: "json",
                success: function (res) {
                    if (res.message === "success") {
                        // Xóa nội dung input
                        $('.nameTitleSkill').val('');
                        // Ẩn modal
                        $('#addForm').modal('hide');
                        // Reload sau 3s
                        showToast('success', 'Title skill added successfully! Proceeding to reload...');
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
                        $('#editForm #name-skill').val(data.TitleSkill);
                        $('#editForm #status-skill').val(data.StatusTK ? '1' : '0');
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
                    'TitleSkill': $('#editForm #name-skill').val(),
                    'StatusTK': $('#editForm #status-skill').val() === '1' ? true : false
                },
                dataType: "json",
                success: function (res) {
                    if (res.message === "success") {
                        // Xóa nội dung input
                        $('#editForm #name-skill').val('');
                        // Ẩn modal
                        $('#editForm').modal('hide');
                        // Reload sau 3s
                        showToast('success', 'Title skill updated successfully! Proceeding to reload...');
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