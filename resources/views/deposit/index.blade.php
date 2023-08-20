<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Deposit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-5">
                        <a class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 mb-10 p-10 rounded">
                            Add New Deposit
                        </a>
                    </div>



                    <div class="bg-white text-black rounded-lg shadow-md p-4">
                        <table class="min-w-full">
                            <thead>
                            <tr class="border-b">
                                <th class="py-2 text-left">Transaction ID</th>
                                <th class="py-2 text-left">Date</th>
                                <th class="py-2 text-left">Amount</th>
                                <th class="py-2 text-left">Fee</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($deposits))
                                @forelse($deposits as $deposit)
                                    <tr class="border-b">
                                        <td class="py-2">{{$deposit->id ?? ''}}</td>
                                        <td class="py-2">{{$deposit->date ?? ''}}</td>
                                        <td class="py-2">{{$deposit->amount ?? ''}}</td>
                                        <td class="py-2">{{$deposit->fee ?? ''}}</td>
                                    </tr>
                                @empty
                                    <tr class="border-b text-center">
                                        <td class="py-2" colspan="4">No deposits found.</td>
                                    </tr>
                                @endforelse
                           @endif

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
