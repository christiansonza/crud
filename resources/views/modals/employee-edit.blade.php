<div class="modal fade" id="editEmpModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Edit Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <input type="hidden" id="edit_emp_id">

        <div class="row g-2">

            <div class="col">
                <input type="text" id="edit_emp_name" class="form-control">
            </div>

            <div class="col">
                <input type="email" id="edit_emp_email" class="form-control">
            </div>

            <div class="col">
                <input type="text" id="edit_emp_position" class="form-control">
            </div>

            <div class="col">
                <select id="edit_emp_department" class="form-control">
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <button type="button" id="updateEmpBtn" class="btn btn-warning w-100 mt-3">
            Update Employee
        </button>

      </div>

    </div>
  </div>
</div>