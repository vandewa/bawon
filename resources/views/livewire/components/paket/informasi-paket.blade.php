<div class="border-0 shadow-sm card">
    <div class="text-white card-header bg-primary">
        <h5 class="mb-0">
            <i class="mr-2 fas fa-info-circle"></i> Informasi Paket
        </h5>
    </div>

    <div class="card-body">
        <table class="table align-middle table-sm table-borderless">
            <tbody>
                <tr>
                    <th class="text-muted" style="width: 220px;">Nama Paket</th>
                    <td class="text-dark font-weight-medium">: {{ $paket->nama_kegiatan }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Desa</th>
                    <td class="text-dark">: {{ $paket->desa->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Tahun</th>
                    <td class="text-dark">: {{ $paket->tahun }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Sumber Dana</th>
                    <td class="text-dark">: {{ $paket->sumberdana }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Kode Anggaran</th>
                    <td class="text-dark">: {{ $paket->kd_keg }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Nama PPTK</th>
                    <td class="text-dark">: {{ $paket->nm_pptkd }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Jabatan PPTK</th>
                    <td class="text-dark">: {{ $paket->jbt_pptkd }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Bidang</th>
                    <td class="text-dark">: {{ $paket->nama_bidang }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Sub Bidang</th>
                    <td class="text-dark">: {{ $paket->nama_subbidang }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Pagu Paket</th>
                    <td>
                        : <span class="font-weight-bold text-success">Rp
                            {{ number_format($paket->pagu_pak, 0, ',', '.') }}</span>
                    </td>
                </tr>

                <tr>
                    <th class="text-muted">Sisa Paket</th>
                    <td>
                        : <span class="font-weight-bold text-primary">
                            Rp {{ number_format($sisaPagu, 0, ',', '.') }}
                        </span>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
