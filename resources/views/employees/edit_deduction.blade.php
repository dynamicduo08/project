{{-- New Laborer --}}
<div class="modal fade" id="edit_deduction{{$deduction->id}}" tabindex="-1" role="dialog" aria-labelledby="edit_deductionData" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='row'>
                    <div class='col-md-12'>
                        <h5 class="modal-title" id="edit_deductionData">Edit Deduction</h5>
                    </div>
                </div>
            </div>
            <form  method='POST' onsubmit='show();' action='edit-deduction/{{$deduction->id}}' >
                @csrf
                <div class="modal-body">
                    <label >Deduction: {{$deduction->deduction}}</label><Br>
                    <label >Amount</label>
                    <input type="number" name="amount" placeholder='' value='{{$deduction->amount}}' class="form-control" required>
                
                        <input class="form-check-input" type="checkbox" value="1"  name="percent" @if($deduction->percent) checked @endif id="percent">
                        <label class="form-check-label" for="percent">
                           &nbsp;  &nbsp; &nbsp;Percent
                        </label>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit"  class="btn btn-primary">Save</button>
                </div>
              
            </form>
        </div>
    </div>
</div>