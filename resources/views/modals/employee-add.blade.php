<div class="modal fade" id="empModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <form id="empForm">

            <div class="row g-2">

                <div class="col">
                    <input type="text" id="emp_name" class="form-control" placeholder="Name">
                </div>

                <div class="col">
                    <input type="email" id="emp_email" class="form-control" placeholder="Email">
                </div>

                <div class="col">
                    <input type="text" id="emp_position" class="form-control" placeholder="Position">
                </div>

                <div class="col">
                    <select id="emp_department" class="form-control">
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <button type="submit" class="btn btn-success w-100 mt-3">
                Save Employee
            </button>

        </form>

      </div>

    </div>
  </div>
</div>