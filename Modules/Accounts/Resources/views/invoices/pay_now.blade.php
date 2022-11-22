<form action="">

    <div class="row">
        <div class="col-md-7">
            <input min="1" max="{{$invoice->amount}}" id="" class="form-control form-control-sm" required="" placeholder="Pay Now" title="Pay Now" name="amt_paid" type="number">
        </div>
        <div class="col-md-5">
            <button data-text="Pay" class="btn btn-danger btn-sm" type="submit">Pay <i class="icon-paperplane ml-2"></i></button>
        </div>
    </div>
</form>


{{-- 


input.attr('max', bal);
        bal < 1 ? $('#'+form_id).fadeOut('slow').remove() : ''; --}}