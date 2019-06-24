<form method="post" action="{{ route('admin.orders.tracker.submit') }}">
    @csrf
    @method('post')
    <div class="modal-body">
        <h5 class="card-inside-title">Pos Malaysia Tracking no:</h5>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group form-group-lg">
                    <div class="form-line">
                        <input type="text" class="form-control" name="tracking_no" placeholder="" value="{{ $parentOrder->tracking }}" />
                        <input type="hidden" class="form-control"  name="parent_id" placeholder=""  value="{{ $parentOrder->id }}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-link waves-effect">SAVE CHANGES</button>
        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>