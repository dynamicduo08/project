{{-- New Laborer --}}
<div class="modal fade" id="new_holiday" tabindex="-1" role="dialog" aria-labelledby="holiday" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='row'>
                    <div class='col-md-12'>
                        <h5 class="modal-title" id="holiday">New Holiday</h5>
                    </div>
                </div>
            </div>
            <form  method='POST' action='new-holiday' onsubmit='show()' >
                <div class="modal-body">
                    {{ csrf_field() }}
                    <label>Holiday Name:</label>
                    <input type="text" name="holiday_name" placeholder='' value='' class="form-control" required>
                    <label >Holiday Type:</label>
                    <select class='form-control' name = 'holiday_type' required>
                        <option ></option>
                        <option value = 'Regular Holiday'>Legal Holiday</option>
                        <option value = 'Special Holiday'>Special Holiday</option>
                    </select>
                    <label >Holiday Date:</label>
                    <input type="date" name="holiday_date" placeholder='' value='' class="form-control" required>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id='submit1' class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>