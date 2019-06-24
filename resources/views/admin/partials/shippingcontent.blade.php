
<div class="modal-body">
    <h5 class="card-inside-title">Shipping Address</h5>
    <div class="row clearfix">
        <div class="col-sm-12">
            <p><b>Receiver name :</b> {{ $shipping->receiver_name }}</p>
            <p><b>Address :</b> {{ $shipping->address_1 .' '. $shipping->address_2 .' '. $shipping->address_3 }}</p>
            <p><b>State :</b> {{ $shipping->state }}</p>
            <p><b>City :</b> {{ $shipping->city }}</p>
            <p><b>Postcode :</b> {{ $shipping->postcode }}</p>
            <p><b>Phone No :</b> {{ $shipping->phone_no }}</p>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
</div>
