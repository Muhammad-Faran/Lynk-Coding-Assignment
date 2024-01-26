<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="payer" class="form-label">Payer</label>
                            <select class="form-select" id="payer" name="payer" required>
                                <option value="" disabled selected>Select Payer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('payer') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="due_on" class="form-label">Due On</label>
                            <input type="date" class="form-control" id="due_on" name="due_on" value="{{ old('due_on') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="vat" class="form-label">VAT</label>
                            <input type="text" class="form-control" id="vat" name="vat" value="{{ old('vat') }}" required>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_vat_inclusive"
                                    name="is_vat_inclusive" {{ old('is_vat_inclusive') ? 'checked' : '' }} value="1">
                                <label class="form-check-label" for="is_vat_inclusive">Is VAT Inclusive?</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary text-black">Create Transaction</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>