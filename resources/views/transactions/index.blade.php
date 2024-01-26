<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @can('add-transaction')
                        <div class="mb-4">
                            <a href="{{ route('transactions.create') }}" class="btn btn-primary">Create Transaction</a>
                        </div>
                    @endcan

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="py-2">ID</th>
                                <th class="py-2">Amount</th>
                                <th class="py-2">VAT</th>
                                <th class="py-2">Paid Amount</th>
                                <th class="py-2">Balance</th>
                                @role('Admin')
                                    <th class="py-2">Payer</th>
                                @endrole
                                <th class="py-2">Due On</th>
                                <th class="py-2">Status</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="py-2">{{ $transaction->transaction_id }}</td>
                                    <td class="py-2">{{ number_format($transaction->amount, 2) }}</td>
                                    <td class="py-2">{{ number_format($transaction->vat, 0) }}%</td>
                                    <td class="py-2">{{ number_format($transaction->paid_amount, 2) }}</td>
                                    <td class="py-2">{{ number_format($transaction->balance, 2) }}</td>
                                    @role('Admin')
                                        <td class="py-2">{{ $transaction->customer?->name }}</td>
                                    @endrole
                                    <td class="py-2">{{ $transaction->due_on }}</td>
                                    <td class="py-2">
                                        {!! $transaction->status_badge !!}
                                    </td>
                                    <td class="py-2">
                                        @can('add-payment')
                                            @if ($transaction->status !== 'Paid')
                                                <button class="btn btn-sm btn-secondary" data-toggle="modal"
                                                    onclick="addPayment({{ $transaction->id }})">
                                                    Enter Payment
                                                </button>
                                            @endif
                                        @endcan
                                        <a href="{{ route('transactions.show', $transaction) }}"
                                            class="btn btn-sm btn-success">
                                            View Detail
                                        </a>
                                    </td>
                                </tr>
                                <!-- End Payment Modal -->
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Payment Modal -->
                    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog"
                        aria-labelledby="paymentModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="paymentModalLabel">Enter Payment for Transaction</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="paymentForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="paymentAmount" class="form-label">Payment Amount</label>
                                            <input type="text" class="form-control" id="paymentAmount" name="amount"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="paid_on" class="form-label">Paid On</label>
                                            <input type="date" class="form-control" id="paid_on" name="paid_on"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="paymentDetails" class="form-label">Payment Details</label>
                                            <input type="text" class="form-control" id="paymentDetails"
                                                name="details">
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info text-black">Submit
                                                Payment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var transactionId;
        $(document).ready(function() {
            $("#paymentForm").on("submit", function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                // Assuming transactionId is set before this point
                var url =
                '{{ route('transactions.payments.store', ['transaction' => ':transactionId']) }}';

                // Replace ":transactionId" with the actual value
                url = url.replace(':transactionId', transactionId);
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#paymentModal').modal('hide');
                        // Show success toast
                        toastr.success(response.message, 'Success');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle validation errors
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;

                            // Display each validation error in a separate toast
                            $.each(errors, function(index, error) {
                                toastr.error("Validation Error: " + error, 'Error');
                            });
                        } else {
                            toastr.error(xhr.responseText);
                        }
                    }
                });
            });
        });


        function addPayment(id) {
            transactionId = id;
            $('#paymentModal').modal('show');
        }
    </script>
</x-app-layout>
