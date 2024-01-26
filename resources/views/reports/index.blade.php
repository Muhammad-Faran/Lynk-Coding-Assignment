<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monthly Financial Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Search Form Card -->
            <div class="mb-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <form action="{{ route('report') }}">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="startDate" class="form-label">Start Date:</label>
                                <input type="date" class="form-control" id="startDate" name="start_date"
                                    value="{{ request('start_date') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="endDate" class="form-label">End Date:</label>
                                <input type="date" class="form-control" id="endDate" name="end_date"
                                    value="{{ request('end_date') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">All</option>
                                    <option value="Paid" @selected(request('status') == 'Paid')>Paid</option>
                                    <option value="Outstanding" @selected(request('status') == 'Outstanding')>Outstanding</option>
                                    <option value="Overdue" @selected(request('status') == 'Overdue')>Overdue</option>
                                </select>
                            </div>
                        </div>
                        <a href="{{ route('report') }}" type="button" class="btn btn-danger text-black">Reset</a>
                        <button type="submit" class="btn btn-info text-black">Generate Report</button>
                    </form>
                </div>
            </div>

            <!-- Report Table Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Paid Amount</th>
                                    <th>Outstanding Amount</th>
                                    <th>Overdue Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reportData as $monthlyData)
                                    <tr>
                                        <td>{{ $monthlyData->month }}</td>
                                        <td>{{ $monthlyData->year }}</td>
                                        <td>{{ number_format($monthlyData->paid, 2) }}</td>
                                        <td>{{ number_format($monthlyData->outstanding, 2) }}</td>
                                        <td>{{ number_format($monthlyData->overdue, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <p class="text-danger text-center">No Record Found!</p>
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
