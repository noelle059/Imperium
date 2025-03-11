  <!-- Classroom Modal -->
  <div class="modal fade" id="add_classroom_modal" tabindex="-1" aria-labelledby="add_classroom_modal" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="add_classroom_modal">Add Classroom</h1>
              </div>

              <!-- ID in Form -->
              <form id="AddClassroomForm" action="{{ route('add_classroom') }}" method="POST">
                  @csrf
                  <div class="modal-body">

                      <div class="mb-3">
                          <label for="ClassName" class="form-label">Classroom Name</label>
                          <input type="text" name="classroom_name" class="form-control"
                              placeholder="Enter Classroom  name" required>
                      </div>

                      <div class="mb-3">
                          <label for="FloorName" class="form-label">Floor Level</label>
                          <select name="floor_id" class="form-control" required>
                              <option value="" disabled selected>Select Floor Level</option>
                              @foreach ($floors as $floor)
                                  <option value="{{ $floor->id }}">{{ $floor->floor_name }}</option>
                              @endforeach
                          </select>
                      </div>


                  </div>
              </form>
              {{-- Id in Button --}}
              <div class="modal-footer" style="padding: 10px;">
                  <button type="submit" class="btn gradient-button" id="AddClassroomButton">Add Classroom</button>
                  <button type="button" class="btn gradient-button" data-bs-dismiss="modal">Close</button>
              </div>

          </div>
      </div>
  </div>
