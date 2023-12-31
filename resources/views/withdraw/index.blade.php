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
                        <a href="{{route('withdraw.create')}}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 mb-10 p-10 rounded">
                            Withdraw Amount
                        </a>
                    </div>



                    <div class="bg-white text-black rounded-lg shadow-md p-4">
                        @if(session('success'))
                            <div class="bg-green-500 p-4 rounded-lg mb-6 text-white text-center">
                                {{session('success')}}
                            </div>
                        @endif
                        <h1 class="text-xl font-bold mb-4">  Withdraw Transaction  List</h1>

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
                            @if(isset($withdraws))
                                @forelse($withdraws as $withdraw)
                                    <tr class="border-b">
                                        <td class="py-2">{{$withdraw->id ?? ''}}</td>
                                        <td class="py-2">{{$withdraw->date ?? ''}}</td>
                                        <td class="py-2">{{$withdraw->amount ?? ''}}</td>
                                        <td class="py-2">{{$withdraw->fee ?? ''}}</td>
                                    </tr>
                                @empty
                                    <tr class="border-b text-center">
                                        <td class="py-2" colspan="4">No withdraw found.</td>
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
