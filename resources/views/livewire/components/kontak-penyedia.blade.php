<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
    <div class="card bg-light d-flex flex-fill">
        <div class="card-header text-muted border-bottom-0">
            {{ $penyedia->jenis_usaha ?? 'Penyedia' }}
        </div>
        <div class="pt-0 card-body">
            <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>{{ $penyedia->nama_perusahaan }}</b></h2>
                    <p class="text-sm text-muted">
                        <b>Direktur: </b> {{ $penyedia->nama_direktur }} <br>
                        <b>Usaha: </b> {{ $penyedia->klasifikasi }} / {{ $penyedia->kualifikasi }}
                    </p>
                    <ul class="mb-0 ml-4 fa-ul text-muted">
                        <li class="small">
                            <span class="fa-li"><i class="fas fa-lg fa-building"></i></span>
                            {{ $penyedia->alamat }}, {{ $penyedia->kabupaten }}, {{ $penyedia->provinsi }}
                            {{ $penyedia->kode_pos }}
                        </li>
                        <li class="small">
                            <span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                            {{ $penyedia->telepon ?? '-' }}
                        </li>
                    </ul>
                </div>
                <div class="text-center col-5">
                    <img src="{{ asset('images/default-avatar.png') }}" alt="user-avatar" class="img-circle img-fluid">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <a href="mailto:{{ $penyedia->email }}" class="btn btn-sm bg-teal">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> Profil
                </a>
            </div>
        </div>
    </div>
</div>
