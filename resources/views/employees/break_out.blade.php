 <div class="modal fade" id="break_out" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Break Out</h4>
        </div>
        <form method="POST" action="{{ route('break-out') }}" onsubmit="show()"  enctype="multipart/form-data">
            @csrf
        <div class="modal-body">
            Reason : <textarea class='form-control' placeholder="breaktime / lunchbreak / emergency / etc." name='reason' required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" >Submit</button>
          <button type="buttom" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>