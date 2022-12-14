{{-- New Laborer --}}
<div class="modal fade" id="edit_holiday{{$holiday_a->id}}" tabindex="-1" role="dialog" aria-labelledby="editHoliday" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='row'>
                    <div class='col-md-12'>
                        <h5 class="modal-title" id="editHoliday">Edit Holiday</h5>
                    </div>
                </div>
            </div>
            <form  method='POST' onsubmit='show()' action='edit-holiday/{{$holiday_a->id}}' >
                <div class="modal-body">
                    {{ csrf_field() }}
                    <label style="position:relative; top:7px;">Holiday Name:</label>
                    <input type="text" name="holiday_name" placeholder='' value='{{$holiday_a->holiday_name}}' class="form-control" required>
                    <label style="position:relative; top:7px;">Holiday Type:</label>
                    <select class='form-control' name = 'holiday_type' required>
                        <option ></option>
                        <option value = 'Regular Holiday' {{ $holiday_a->holiday_tyle = "Regular Holiday" ? "selected":"" }}>Legal Holiday</option>
                        <option value = 'Special Holiday' {{ $holiday_a->holiday_tyle = "Special Holiday" ? "selected":"" }}>Special Holiday</option>
                    </select>
                    <label style="position:relative; top:7px;">Holiday Date:</label>
                    <input type="date" name="holiday_date" placeholder='' value='{{$holiday_a->holiday_date}}' class="form-control" required>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit"  class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>