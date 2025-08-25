@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Purchase Return</h4>
                <h6>Return items from purchase #{{ $purchase->id }}</h6>
            </div>
        </div>
        <div class="page-btn">
            <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back</a>
        </div>
    </div>

    <form action="{{ route('purchase.return.store', $purchase->id) }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Purchased Qty</th>
                                <th class="text-center">Return Qty</th>
                                <th class="text-end">Unit Cost</th>
                                <th class="text-end">Line Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchase->purchaseDetails as $detail)
                                <tr>
                                    <td>
                                        <input type="hidden" name="product_id[]" value="{{ $detail->product_id }}">
                                        <strong>{{ $detail->product->name ?? 'Product' }}</strong>
                                        @if($detail->product && $detail->product->sku)
                                            <div class="text-muted small">SKU: {{ $detail->product->sku }}</div>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ (float)$detail->quantity }}</td>
                                    <td class="text-center" style="max-width:140px;">
                                        <input type="number" name="return_quantity[]" class="form-control text-center" min="0" step="1" value="0" data-unit="{{ (float)$detail->purchase_price }}">
                                        <div class="form-text">Max: {{ (float)$detail->quantity }}</div>
                                    </td>
                                    <td class="text-end">{{ number_format((float)$detail->purchase_price, 2) }}</td>
                                    <td class="text-end line-total">0.00</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total Return Amount:</strong></td>
                                <td class="text-end"><strong id="return-total">0.00</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="col-md-8">
                        <div class="input-blocks">
                            <label>Reason (optional)</label>
                            <textarea name="reason" class="form-control" rows="2" placeholder="Add a reason for the return (optional)"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end justify-content-end">
                        <button type="submit" class="btn btn-primary"><i data-feather="rotate-ccw" class="me-2"></i>Process Return</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@section('js')
<script>
    (function($){
        $(document).on('input', 'input[name="return_quantity[]"]', function(){
            const row = $(this).closest('tr');
            const qty = parseFloat($(this).val() || 0);
            const unit = parseFloat($(this).data('unit') || 0);
            const purchased = parseFloat(row.find('td.text-center:first').text() || 0);

            // Cap to purchased quantity
            if (qty > purchased) {
                $(this).val(purchased);
            }

            const line = (parseFloat($(this).val() || 0) * unit).toFixed(2);
            row.find('.line-total').text(line);

            // Recalc total
            let total = 0;
            $('.line-total').each(function(){ total += parseFloat($(this).text() || 0); });
            $('#return-total').text(total.toFixed(2));
        });
    })(jQuery);
</script>
@endsection
