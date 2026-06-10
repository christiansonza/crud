<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

@include('components.navbar')

<div class="container mt-4">

    <!-- DEPARTMENTS -->
    <table class="table table-bordered mb-5" id="deptTable">

        <thead class="table-light">
            <tr>
                <th colspan="2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-5">Departments</span>

                        <button class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deptModal">
                            Add Department
                        </button>
                    </div>
                </th>
            </tr>

            <tr>
                <th>Name</th>
                <th style="width: 160px;"></th>
            </tr>
        </thead>

        <tbody>
            @foreach($departments as $dept)
            <tr id="dept-{{ $dept->id }}">
                <td>{{ $dept->name }}</td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="btn btn-warning btn-sm editDept"
                                data-id="{{ $dept->id }}"
                                data-name="{{ $dept->name }}">
                            Edit
                        </button>

                        <button class="btn btn-danger btn-sm deleteDept"
                                data-id="{{ $dept->id }}">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

    <!-- EMPLOYEES -->
    <table class="table table-bordered" id="employeeTable">

        <thead class="table-light">
            <tr>
                <th colspan="5">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-5">Employees</span>

                        <button class="btn btn-success btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#empModal">
                            Add Employee
                        </button>
                    </div>
                </th>
            </tr>

            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Department</th>
                <th style="width: 160px;"></th>
            </tr>
        </thead>

        <tbody>
            @foreach($employees as $emp)
            <tr id="row-{{ $emp->id }}">
                <td>{{ $emp->name }}</td>
                <td>{{ $emp->email }}</td>
                <td>{{ $emp->position }}</td>
                <td>{{ $emp->department?->name ?? '' }}</td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="btn btn-warning btn-sm editEmp"
                                data-id="{{ $emp->id }}"
                                data-name="{{ $emp->name }}"
                                data-email="{{ $emp->email }}"
                                data-position="{{ $emp->position }}"
                                data-dept="{{ $emp->department_id }}">
                            Edit
                        </button>

                        <button class="btn btn-danger btn-sm deleteBtn"
                                data-id="{{ $emp->id }}">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>

<!-- MODALS -->

@include('modals.department-add')
@include('modals.department-edit')
@include('modals.employee-add')
@include('modals.employee-edit')


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    let token = $('meta[name="csrf-token"]').attr('content');

    function alertSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
            timer: 1500,
            showConfirmButton: false
        });
    }

    // ADD DEPARTMENT
    $('#deptForm').submit(function(e){
        e.preventDefault();

        $.post('/department/store', {
            _token: token,
            name: $('#dept_name').val()
        }, function(res){

            $('#deptTable tbody').append(`
                <tr id="dept-${res.id}">
                    <td>${res.name}</td>
                    <td>
                        <div class="d-flex gap-1">

                            <button class="btn btn-warning btn-sm editDept"
                                data-id="${res.id}"
                                data-name="${res.name}">
                                Edit
                            </button>

                            <button class="btn btn-danger btn-sm deleteDept"
                                data-id="${res.id}">
                                Delete
                            </button>

                        </div>
                    </td>
                </tr>
            `);

            $('#emp_department').append(`
                <option value="${res.id}">
                    ${res.name}
                </option>
            `);

            $('#dept_name').val('');

            bootstrap.Modal.getInstance(
                document.getElementById('deptModal')
            ).hide();

            alertSuccess('Department created successfully!');
        });
    });

    // ADD EMPLOYEE
    $('#empForm').submit(function(e){
        e.preventDefault();

        $.post('/employee/store', {
            _token: token,
            name: $('#emp_name').val(),
            email: $('#emp_email').val(),
            position: $('#emp_position').val(),
            department_id: $('#emp_department').val()
        }, function(res){

            let deptText =
                $("#emp_department option:selected").text();

           $('#employeeTable tbody').append(`
                <tr id="row-${res.id}">
                    <td>${res.name}</td>
                    <td>${res.email}</td>
                    <td>${res.position}</td>
                    <td>${deptText}</td>
                    <td>
                        <div class="d-flex gap-1">

                            <button class="btn btn-warning btn-sm editEmp"
                                data-id="${res.id}"
                                data-name="${res.name}"
                                data-email="${res.email}"
                                data-position="${res.position}"
                                data-dept="${res.department_id}">
                                Edit
                            </button>

                            <button class="btn btn-danger btn-sm deleteBtn"
                                data-id="${res.id}">
                                Delete
                            </button>

                        </div>
                    </td>
                </tr>
            `);

            $('#empForm')[0].reset();

            bootstrap.Modal.getInstance(
                document.getElementById('empModal')
            ).hide();

            alertSuccess('Employee created successfully!');
        });
    });

    // DELETE EMPLOYEE
    $(document).on('click', '.deleteBtn', function () {

        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete Employee?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {

            if(result.isConfirmed){

                $.post('/employee/delete/' + id, {
                    _method: 'DELETE',
                    _token: token
                }, function(res){

                    if(res.status === 'success'){
                        $('#row-' + id).remove();

                        alertSuccess(
                            'Employee deleted successfully!'
                        );
                    }

                });

            }

        });

    });

    // DELETE DEPARTMENT
    $(document).on('click', '.deleteDept', function () {

        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete Department?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {

            if(result.isConfirmed){

                $.post('/department/delete/' + id, {
                    _method: 'DELETE',
                    _token: token
                }, function(res){

                    if(res.status === 'success'){

                        $('#dept-' + id).remove();

                        $('#emp_department option[value="'+id+'"]')
                            .remove();

                        alertSuccess(
                            'Department deleted successfully!'
                        );
                    }

                });

            }

        });

    });

    // OPEN EDIT DEPARTMENT
    $(document).on('click', '.editDept', function () {

    $('#edit_dept_id').val($(this).attr('data-id'));

    $('#edit_dept_name').val(
        $(this).attr('data-name')
    );

        new bootstrap.Modal(
            document.getElementById('editDeptModal')
        ).show();

    });

    // UPDATE DEPARTMENT
    $('#updateDeptBtn').click(function () {

        let id = $('#edit_dept_id').val();

        $.post('/department/update/' + id, {
            _method: 'PUT',
            _token: token,
            name: $('#edit_dept_name').val()
        }, function(res){

            let newName = res.name;

            $('#dept-' + id + ' td:first')
                .text(newName);

            $('#dept-' + id)
                .find('.editDept')
                .attr('data-name', newName);

            $('#emp_department option[value="'+id+'"]')
                .text(newName);

            bootstrap.Modal.getInstance(
                document.getElementById('editDeptModal')
            ).hide();

            alertSuccess(
                'Department updated successfully!'
            );
        });

    });

    // OPEN EDIT EMPLOYEE
    $(document).on('click', '.editEmp', function () {

        $('#edit_emp_id').val($(this).data('id'));

        $('#edit_emp_name').val($(this).attr('data-name'));
        $('#edit_emp_email').val($(this).attr('data-email'));
        $('#edit_emp_position').val($(this).attr('data-position'));
        $('#edit_emp_department').val($(this).attr('data-dept'));

        new bootstrap.Modal(
            document.getElementById('editEmpModal')
        ).show();

    });

    // UPDATE EMPLOYEE
    $('#updateEmpBtn').click(function () {

        let id = $('#edit_emp_id').val();

        let deptText =
            $("#edit_emp_department option:selected").text();

        $.post('/employee/update/' + id, {
            _method: 'PUT',
            _token: token,
            name: $('#edit_emp_name').val(),
            email: $('#edit_emp_email').val(),
            position: $('#edit_emp_position').val(),
            department_id: $('#edit_emp_department').val()
        }, function(res){

         let row = $('#row-' + id);

            row.find('td:nth-child(1)').text(res.name);
            row.find('td:nth-child(2)').text(res.email);
            row.find('td:nth-child(3)').text(res.position);
            row.find('td:nth-child(4)').text(deptText);

            let editBtn = row.find('.editEmp');

            editBtn.attr('data-name', res.name);
            editBtn.attr('data-email', res.email);
            editBtn.attr('data-position', res.position);
            editBtn.attr('data-dept', res.department_id);

            bootstrap.Modal.getInstance(
                document.getElementById('editEmpModal')
            ).hide();

            alertSuccess(
                'Employee updated successfully!'
            );

        });

    });

});
</script>

</body>
</html>