@auth
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
        <div class="flex items-center justify-end mt-4">
            <p class="px-4 py-1.5 bg-green-700 text-white shadow-sm sm:rounded-md  hover:text-white hover:bg-green-400">
                @php
                $balance = 0;
                @endphp

                @foreach($transCalcs as $transCalc)
                @php
                $balance += ($transCalc->oldactype_id == 1) ? $transCalc->amount : -($transCalc->amount);
                @endphp
                @endforeach
                {{ __('Current Balance: ') }} <strong>{{ $balance }}</strong>
            </p>
            <a href="{{ route('oldVouchers.create') }}">
                <x-primary-button class="ms-4 text-sm text-white-600 bg-neutral-700 hover:text-green-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Add New Voucher') }}
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="p-10">
        <div class="max-w-7xl mx-auto px-6 py-2 sm:px-2 lg:px-4">
            <!-- Transaction History Form START -->
            <div class="p-5 bg-neutral-700 rounded-lg">
                <form method="GET" action="{{ route('oldTransactions.show') }}">
                    @csrf

                    <div class="flex">
                        <!-- Transaction Start Date -->
                        <div>
                            <x-text-input id="startDate" class="voucher_at block mt-1 w-full" type="date" name="startDate" :value="old('startDate')" placeholder="Date From" required autofocus autocomplete="startDate" />
                            <x-input-error :messages="$errors->get('startDate')" class="mt-2" />
                        </div>

                        <!-- Transaction End Date -->
                        <div class="ml-4">
                            <x-text-input id="endDate" class="voucher_at block mt-1 w-full" type="date" name="endDate" :value="old('endDate')" placeholder="Date To" required autofocus autocomplete="endDate" />
                            <x-input-error :messages="$errors->get('endDate')" class="mt-2" />
                        </div>

                        <!-- Submit Button -->
                        <div class="ml-4 mt-1">
                            <button type="submit" class="bg-white text-green-700 rounded-md items-center px-6 py-3 border border-transparent font-semibold text-xs uppercase tracking-widest  hover:text-white hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Show Report') }}
                                <button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Transaction History Form END -->
            <!-- Table START -->
            <div class="mt-2 p-5 bg-neutral-700 rounded-lg text-white">
                <table class="w-full min-w-min bg-center border-collapse border-b border-white">
                    <thead class="text-xs uppercase">
                        <tr class="border-b border-solid border-0.5 border-white">
                            <th class="border-b border-solid border-0.5 border-white">Post Date</th>
                            <th class="border-b border-solid border-0.5 border-white">Vou. Date</th>
                            <th class="border-b border-solid border-0.5 border-white">Trans. No</th>
                            <th class="border-b border-solid border-0.5 border-white">A/C Name</th>
                            <th class="border-b border-solid border-0.5 border-white">Details</th>
                            <th class="border-b border-solid border-0.5 border-white">Debit (Tk)</th>
                            <th class="border-b border-solid border-0.5 border-white">Credit (Tk)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td class="px-6 py-4 border-b border-solid border-0.5 border-white text-nowrap">
                                {{ $transaction->created_at->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4 border-b border-solid border-0.5 border-white text-nowrap">
                                {{ \Carbon\Carbon::parse($transaction->voucher_at)->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4 border-b border-solid border-0.5 border-white">
                                <a href="{{ route('oldVouchers.show', ['transaction' => $transaction->id]) }}">{{ $transaction->id }}</a>
                            </td>
                            <td class="px-6 py-4 border-b border-solid border-0.5 border-white">
                                {{ $transaction->oldacname->name }}
                            </td>
                            <td class="px-6 py-4 border-b border-solid border-0.5 border-white text-sm">
                                {{ $transaction->details }}
                            </td>
                            <td class="px-6 py-4 border-b border-solid border-0.5 border-white text-right">
                                {{ ($transaction->oldactype_id == 1) ? $transaction->amount : 0 }}
                            </td>
                            <td class="px-6 py-4 border-b border-solid border-0.5 border-white text-right">
                                {{ ($transaction->oldactype_id == 2) ? $transaction->amount : 0 }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Table END -->
            <!-- Pagination -->
            <div class="mt-2 px-2 py-2 bg-neutral-700 rounded-lg">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    flatpickr(".voucher_at", {
        dateFormat: "d-m-Y"
    });
</script>
@endauth