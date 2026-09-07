<x-app-layout>
    <div class="container-fluid px-4 py-3">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="fa-solid fa-file-invoice me-2 text-primary"></i>Template Approval
                </h4>
                <p class="text-muted small mb-0">Kelola dan buat kustomisasi template approval untuk berbagai kebutuhan proses SMT.</p>
            </div>
            <!-- Tombol Trigger Modal Tambah -->
            <button type="button" class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#createTemplateModal">
                <i class="fa-solid fa-plus me-1"></i> Buat Template Baru
            </button>
        </div>

        <!-- Alert Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Grid Daftar Template -->
        <div class="row g-3">
            @forelse($templates as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-3 hover-shadow transition">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="rounded-3 p-3 d-flex align-items-center justify-content-center" style="background-color: {{ $item->color ?? '#0984e3' }}15; width: 48px; height: 48px;">
                                    <i class="{{ $item->icon ?? 'fa-solid fa-file-invoice' }} fs-4" style="color: {{ $item->color ?? '#0984e3' }};"></i>
                                </div>
                                <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 11px;">{{ $item->code }}</span>
                            </div>
                            
                            <h5 class="fw-bold text-dark mb-1">{{ $item->name }}</h5>
                            <span class="badge bg-soft-primary text-primary mb-2 align-self-start" style="font-size: 10px;">{{ $item->category ?? 'General' }}</span>
                            <p class="text-muted small flex-grow-1">{{ $item->description ?? 'Tidak ada deskripsi.' }}</p>

                            <div class="pt-3 border-top mt-auto d-flex align-items-center justify-content-between">
                                <span class="badge {{ $item->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary' }}">
                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                
                                <div class="d-flex gap-2">
                                    <!-- TOMBOL PREVIEW VIA APPROVALCANVAS -->
                                    <a href="{{ route('approval-templates.preview', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" title="Preview Form Canvas">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <form action="{{ route('approval-templates.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus template ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3 p-5 text-center">
                        <i class="fa-solid fa-folder-open text-muted fs-1 mb-3"></i>
                        <h6 class="fw-bold text-secondary">Belum Ada Template Approval</h6>
                        <p class="text-muted small">Klik tombol "+ Buat Template Baru" untuk menambahkan template kustom pertamamu.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- MODAL TAMBAH TEMPLATE -->
    <div class="modal fade" id="createTemplateModal" tabindex="-1" aria-labelledby="createTemplateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="createTemplateModalLabel">Tambah Template Approval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('approval-templates.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kode Template</label>
                            <input type="text" name="code" class="form-control" placeholder="Contoh: TPL-SMT-001" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Template</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Screen Printing Approval Sheet" required>
                        </div>

                        <!-- PILIHAN LAYOUT BLADE DARI FOLDER approval-template/ -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Pilih Layout Blade Template</label>
                            <select name="blade_view" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Canvas Layout --</option>
                                <option value="template_printer">Screen Printer (template_printer.blade.php)</option>
                                <option value="template_spi">SPI (template_spi.blade.php)</option>
                                <option value="template_mounter">Mounter (template_mounter.blade.php)</option>
                                <option value="template_reflow">Reflow Oven (template_reflow.blade.php)</option>
                                <option value="template_aoi">AOI (template_aoi.blade.php)</option>
                                <option value="template_ict">ICT (template_ict.blade.php)</option>
                            </select>
                            <div class="form-text text-muted" style="font-size: 11px;">
                                File ini menginduk ke <code>approvalCanvas.blade.php</code> untuk preview tata letak.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kategori / Divisi</label>
                            <input type="text" name="category" class="form-control" placeholder="Contoh: SMT / Quality / Maintenance">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Icon (FontAwesome Class)</label>
                                <input type="text" name="icon" class="form-control" value="fa-solid fa-print" placeholder="fa-solid fa-print">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Warna Identitas</label>
                                <input type="color" name="color" class="form-control form-control-color w-100" value="#0984e3">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Deskripsi Pengecekan</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Tulis deskripsi singkat fungsi template ini..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan Template</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>