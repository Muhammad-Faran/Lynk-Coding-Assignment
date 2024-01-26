<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('transactions.index') }}" class="btn btn-primary">Back to Transactions</a>
                    </div>

                    <div class="mb-4">
                        <strong>Transaction ID:</strong> {{ $transaction->id }}
                    </div>

                    <div class="mb-4">
                        <strong>Amount:</strong> {{ $transaction->amount }}
                    </div>

                    <div class="mb-4">
                        <strong>Paid Amount:</strong> {{ $transaction->paid_amount }}
                    </div>

                    <div class="mb-4">
                        <strong>Balance:</strong> {{ $transaction->balance }}
                    </div>

                    <div class="mb-4">
                        <strong>Payer:</strong> {{ $transaction->payer }}
                    </div>

                    <div class="mb-4">
                        <strong>Due On:</strong> {{ $transaction->due_on }}
                    </div>

                    <div class="mb-4">
                        <strong>Status:</strong>

                        {!! $transaction->status_badge !!}

                    </div>

                    <div class="mb-4">
                        <h4 class="mb-2">Payment Details:</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>Paid On</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaction->payments as $key => $payment)
                                    <tr>
                                        <td>{{ $key = $key + 1 }}</td>
                                        <td>{{ $payment->amount }}</td>
                                        <td>{{ $payment->paid_on }}</td>
                                        <td>{{ $payment->details }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <p class="text-danger text-center">No payments made for this transaction.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
