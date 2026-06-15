<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Donasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('donation.update', $donation) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Campaign -->
                        <div>
                            <label for="campaign_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Kampanye <span class="text-red-500">*</span>
                            </label>
                            <select id="campaign_id" name="campaign_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                disabled>
                                <option value="{{ $donation->campaign_id }}" selected>
                                    {{ $donation->campaign->judul }}
                                </option>
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Kampanye tidak dapat diubah</p>
                        </div>

                        <!-- Donor Name -->
                        <div>
                            <label for="donor_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="donor_name" name="donor_name" value="{{ old('donor_name', $donation->donor_name) }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan nama Anda" required>
                            @error('donor_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Donor Email -->
                        <div>
                            <label for="donor_email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="donor_email" name="donor_email" value="{{ old('donor_email', $donation->donor_email) }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan email Anda" required>
                            @error('donor_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Donor Phone -->
                        <div>
                            <label for="donor_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                Nomor Telepon
                            </label>
                            <input type="tel" id="donor_phone" name="donor_phone" value="{{ old('donor_phone', $donation->donor_phone) }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan nomor telepon (opsional)">
                            @error('donor_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                                Jumlah Donasi (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="amount" name="amount" value="{{ old('amount', $donation->amount) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Contoh: 100000" min="10000" required>
                            <p class="text-sm text-gray-500 mt-1">Minimum donasi: Rp 10.000</p>
                            @error('amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">
                                Metode Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <select id="payment_method" name="payment_method" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="">Pilih Metode</option>
                                <option value="Transfer Bank" {{ old('payment_method', $donation->payment_method) === 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="E-Wallet" {{ old('payment_method', $donation->payment_method) === 'E-Wallet' ? 'selected' : '' }}>E-Wallet (GCash, Dana, OVO)</option>
                                <option value="Kartu Kredit" {{ old('payment_method', $donation->payment_method) === 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                                <option value="Cicilan" {{ old('payment_method', $donation->payment_method) === 'Cicilan' ? 'selected' : '' }}>Cicilan</option>
                            </select>
                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="pending" {{ old('status', $donation->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ old('status', $donation->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ old('status', $donation->status) === 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                Pesan/Catatan (Opsional)
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Tulis pesan atau doa Anda di sini">{{ old('notes', $donation->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 justify-end">
                            <a href="{{ route('donation.show', $donation) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
