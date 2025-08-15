{{-- resources/views/filament/actions/pdf-preview.blade.php --}}
<div class="space-y-4">
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="text-lg font-semibold mb-2">{{ $record->title }}</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium">Perusahaan:</span>
                <span>{{ $record->company->name }}</span>
            </div>
            <div>
                <span class="font-medium">No. Rekening:</span>
                <span>{{ $record->company->account_number }}</span>
            </div>
            <div>
                <span class="font-medium">Tanggal:</span>
                <span>{{ $record->transaction_date->format('d/m/Y') }}</span>
            </div>
            <div>
                <span class="font-medium">Jumlah PDF:</span>
                <span>{{ count($record->pdf_files ?? []) }}</span>
            </div>
        </div>
        @if($record->notes)
            <div class="mt-2">
                <span class="font-medium">Catatan:</span>
                <p class="text-gray-600">{{ $record->notes }}</p>
            </div>
        @endif
    </div>

    @if($record->pdf_files && count($record->pdf_files) > 0)
        <div class="space-y-4">
            <h4 class="font-semibold">File PDF:</h4>
            <div class="grid gap-4">
                @foreach($record->pdf_files as $index => $pdfFile)
                    <div class="border rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h5 class="font-medium">{{ basename($pdfFile) }}</h5>
                            <div class="flex gap-2">
                                <a href="{{ asset('storage/' . $pdfFile) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat
                                </a>
                                <a href="{{ asset('storage/' . $pdfFile) }}"
                                   download
                                   class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-md text-sm hover:bg-green-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Unduh
                                </a>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded p-2">
                            <embed src="{{ asset('storage/' . $pdfFile) }}"
                                   type="application/pdf"
                                   width="100%"
                                   height="400px"
                                   class="rounded">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p>Tidak ada file PDF yang tersedia</p>
        </div>
    @endif
</div>
