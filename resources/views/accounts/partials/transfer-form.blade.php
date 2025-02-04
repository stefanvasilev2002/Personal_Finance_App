<div id="transfer-form-{{ $account->id }}" class="hidden mt-4 p-4 bg-gray-700 rounded">
    <form action="{{ route('transfers.store') }}" method="POST">
        @csrf
        <input type="hidden" name="from_account_id" value="{{ $account->id }}">
        <div class="space-y-3">
            <div>
                <label class="block text-sm text-gray-400">To Account</label>
                <select name="to_account_id" required
                        class="mt-1 block w-full rounded-md border-gray-600 bg-gray-800 text-gray-300">
                    @foreach(auth()->user()->accounts->where('id', '!=', $account->id) as $toAccount)
                        <option value="{{ $toAccount->id }}">{{ $toAccount->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-400">Amount</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">$</span>
                    </div>
                    <input type="number" name="amount" step="0.01" min="0.01" required
                           class="pl-7 block w-full rounded-md border-gray-600 bg-gray-800 text-gray-300">
                </div>
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                Transfer
            </button>
        </div>
    </form>
</div>
