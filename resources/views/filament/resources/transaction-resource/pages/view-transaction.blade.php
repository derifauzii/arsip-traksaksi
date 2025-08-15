<x-filament-panels::page>
    <div class="space-y-8">
        {{-- Transaction Info --}}
        <section class="bg-blue-50 border border-blue-200 rounded-2xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-blue-500 mb-4">Informasi Transaksi</h2>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-blue-900">Perusahaan</dt>
                    <dd class="text-base font-semibold text-blue-500 mt-1">{{ $record->company->name }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-[#475569]">Kode Kegiatan</dt>
                    <dd class="text-base font-semibold text-blue-500 mt-1">{{ $record->kode_kegiatan }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-[#475569]">Judul Transaksi</dt>
                    <dd class="text-base font-semibold text-blue-500 mt-1">{{ $record->title }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-[#475569]">Tanggal Faktur</dt>
                    <dd class="text-base font-semibold text-blue-500 mt-1">{{ $record->tanggal_faktur->format('d/m/Y') }}</dd>
                </div>

                @if($record->notes)
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-[#475569]">Catatan</dt>
                        <dd class="text-base text-blue-500 mt-1">{{ $record->notes }}</dd>
                    </div>
                @endif
            </dl>
        </section>

        {{-- PDF Files --}}
        <section class="bg-[#f0f7ff] border border-[#cfe2ff] rounded-2xl p-6 shadow-sm md-8">
            <h2 class="text-lg font-semibold text-blue-500 mb-4">
                File PDF ({{ count($record->pdf_files ?? []) }} file)
            </h2>

            @if($record->pdf_files && count($record->pdf_files) > 0)
                <div class="space-y-6">
                    @foreach($record->pdf_files as $index => $pdfFile)
                        <div class="border border-[#cfe2ff] rounded-xl p-4 bg-white hover:bg-[#e8f2ff] transition">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-sm font-semibold text-[#1e3a8a]">
                                        {{ basename($pdfFile) }}
                                    </h3>
                                    <p class="text-xs text-[#64748b]">File {{ $index + 1 }} dari {{ count($record->pdf_files) }}</p>
                                </div>

                                <div class="flex gap-2">
                                    {{-- View Button --}}
                                    <a href="{{ asset('storage/' . $pdfFile) }}" target="_blank"
                                        class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-black bg-[#93c5fd] hover:bg-[#60a5fa] rounded-md">
                                        <svg class="w-5 h-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat
                                    </a>

                                    {{-- Download Button --}}
                                    <a href="{{ asset('storage/' . $pdfFile) }}" download
                                        class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-[#1e3a8a] bg-[#e0f2fe] border border-[#cfe2ff] hover:bg-[#dbeafe] rounded-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 12l-4-4m4 4l4-4M4 20h16"/>
                                        </svg>
                                        Unduh
                                    </a>
                                </div>
                            </div>

                            {{-- PDF Preview --}}
                            <div class="rounded-lg overflow-hidden border border-[#e2e8f0]">
                                <embed src="{{ asset('storage/' . $pdfFile) }}" type="application/pdf"
                                    width="100%" height="400px" />
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 text-[#64748b]">
                    <svg class="mx-auto h-10 w-10 mb-4 text-[#93c5fd]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M4 6h16M4 6v12a2 2 0 002 2h12a2 2 0 002-2V6"/>
                    </svg>
                    <h3 class="text-sm font-medium">Tidak ada file PDF</h3>
                    <p class="text-sm mt-1">Belum ada file PDF yang diupload untuk transaksi ini.</p>
                </div>
            @endif
        </section>
    </div>
</x-filament-panels::page>
