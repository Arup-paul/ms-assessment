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
                        <a href="{{route('deposit.index')}}" class="bg-green-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 mb-10 p-10 rounded">
                           Back
                        </a>
                    </div>

                    <div class="bg-white text-black rounded-lg shadow-md p-4">

                        <h1 class="text-xl font-bold mb-4">Add New Deposit</h1>
                        <form action="{{route('deposit.store')}}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="text-xl text-black  ">Date</label><br>
                                <input type="date" name="date" class="border-2 border-gray-300 p-2 w-full" value="{{old('date')}}">
                                @error('date')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="text-xl text-gray-600 dark:text-gray-200">Amount</label><br>
                                <input type="number" name="amount" class="border-2 border-gray-300 p-2 w-full" value="{{old('amount')}}">
                                @error('amount')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded">
                                    Add Deposit
                                </button>
                            </div>


                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
