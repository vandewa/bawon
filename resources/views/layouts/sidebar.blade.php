      <!-- Preloader --> {{-- <div class="preloader flex-column justify-content-center align-items-center">
          <img class="animation__shake" src="{{ asset('AdminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
              height="60" width="60">
      </div> --}}

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
              </li>
          </ul>

          <!-- Right navbar links -->
          <ul class="ml-auto navbar-nav">
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('logout') }}"
                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <div class="d-flex align-items-center">
                          <div class="ms-3"><i class="mr-2 fas fa-sign-out-alt"></i></i>Keluar</div>
                      </div>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </a>
              </li>
          </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-light-info elevation-4">
          <!-- Brand Logo -->
          <a href="{{ route('dashboard') }}" class="brand-link">
              <img src="{{ asset('logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                  style="opacity: .8">
              <span class="brand-text font-weight-light">Ruang Desa</span>
          </a>

          <!-- Sidebar -->
          <div class="sidebar">
              <!-- Sidebar user panel (optional) -->
              <div class="pb-3 mt-3 mb-3 user-panel d-flex">
                  <div class="image">
                      <img src="{{ asset('soul.png') }}" class="img-circle elevation-2" alt="User Image">
                  </div>
                  <div class="info">
                      <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                  </div>
              </div>

              <!-- Sidebar Menu -->
              <nav class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                      data-accordion="false">
                      @role(['superadministrator', 'desa', 'dinsos'])
                          <li class="nav-item">
                              <a href="{{ route('dashboard') }}"
                                  class="nav-link  {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}{{ Request::segment(1) == '' ? 'active' : '' }}">
                                  <i class="nav-icon fas fa-home"></i>
                                  <p>
                                      Dashboard
                                  </p>
                              </a>
                          </li>
                      @endrole


                      @role(['superadministrator'])
                          <li
                              class="nav-item
                                {{ Request::segment(2) == 'permission' ? 'menu-is-opening menu-open' : '' }}
                                {{ Request::segment(2) == 'user' ? 'menu-is-opening menu-open' : '' }}
                              {{ Request::segment(2) == 'role' ? 'menu-is-opening menu-open' : '' }}
                              {{ Request::segment(2) == 'role-index' ? 'menu-is-opening menu-open' : '' }}
                              {{ Request::segment(2) == 'user-index' ? 'menu-is-opening menu-open' : '' }}
                            ">
                              <a href="#"
                                  class="nav-link
                                    {{ Request::segment(2) == 'permission' ? 'active' : '' }}
                                    {{ Request::segment(2) == 'role' ? 'active' : '' }}
                                    {{ Request::segment(2) == 'role-index' ? 'active' : '' }}
                                    {{ Request::segment(2) == 'user-index' ? 'active' : '' }}
                                    {{ Request::segment(2) == 'user' ? 'active' : '' }}
                                   ">
                                  <i class="nav-icon fa-solid fas fa-database"></i>
                                  <p>
                                      Master
                                      <i class="fas fa-angle-left right"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                      <a href="{{ route('master.user-index') }}"
                                          class="nav-link
                                            {{ Request::segment(2) == 'user-index' ? 'active' : '' }}
                                            {{ Request::segment(2) == 'user' ? 'active' : '' }}
                                        ">
                                          @if (Request::segment(2) == 'user-index')
                                              <i class="ml-2 far fa-dot-circle nav-icon"></i>
                                          @elseif(Request::segment(2) == 'user')
                                              <i class="ml-2 far fa-dot-circle nav-icon"></i>
                                          @else
                                              <i class="ml-2 far fa-circle nav-icon"></i>
                                          @endif
                                          <p>User</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('master.role.index') }}"
                                          class="nav-link
                                            {{ Request::segment(2) == 'role-index' ? 'active' : '' }}
                                            {{ Request::segment(2) == 'role' ? 'active' : '' }}
                                        ">
                                          @if (Request::segment(2) == 'role-index')
                                              <i class="ml-2 far fa-dot-circle nav-icon"></i>
                                          @elseif(Request::segment(2) == 'role')
                                              <i class="ml-2 far fa-dot-circle nav-icon"></i>
                                          @else
                                              <i class="ml-2 far fa-circle nav-icon"></i>
                                          @endif
                                          <p>Role</p>
                                      </a>
                                  </li>

                              </ul>
                          </li>
                          <li
                              class="nav-item
                                {{ Request::segment(2) == 'permission' ? 'menu-is-opening menu-open' : '' }}
                                {{ Request::segment(2) == 'user' ? 'menu-is-opening menu-open' : '' }}
                                {{ Request::segment(1) == 'desa' ? 'menu-is-opening menu-open' : '' }}
                            ">
                              <a href="#"
                                  class="nav-link
                                    {{ Request::segment(1) == 'desa' ? 'active' : '' }}
                                ">
                                  <i class="nav-icon fa-solid fas fa-database"></i>
                                  <p>
                                      Desa
                                      <i class="fas fa-angle-left right"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                      <a href="{{ route('desa.desa-index') }}"
                                          class="nav-link
                                            {{ Request::segment(2) == 'desa-index' ? 'active' : '' }}
                                        ">
                                          @if (Request::segment(2) == 'desa-index')
                                              <i class="ml-2 far fa-dot-circle nav-icon"></i>
                                          @else
                                              <i class="ml-2 far fa-circle nav-icon"></i>
                                          @endif
                                          <p>List Desa</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('desa.paket-pekerjaan-index') }}"
                                          class="nav-link
                                            {{ Request::segment(2) == 'paket-pekerjaan-index' ? 'active' : '' }}
                                             ">
                                          @if (Request::segment(2) == 'paket-pekerjaan-index')
                                              <i class="ml-2 far fa-dot-circle nav-icon"></i>
                                          @else
                                              <i class="ml-2 far fa-circle nav-icon"></i>
                                          @endif
                                          <p>Perencanaan</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('desa.penawaran.pelaksanaan.index') }}"
                                          class="nav-link
                                             {{ Request::segment(2) == 'pelaksanaan-index' ? 'active' : '' }}
                                         ">
                                          @if (Request::segment(2) == 'pelaksanaan-index')
                                              <i class="ml-2 far fa-dot-circle nav-icon"></i>
                                          @else
                                              <i class="ml-2 far fa-circle nav-icon"></i>
                                          @endif
                                          <p>Pelaksanaan</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('desa.pelaporan.index') }}"
                                          class="nav-link
                                            {{ Request::segment(2) == 'pealporan-index' ? 'active' : '' }}
                                        ">
                                          @if (Request::segment(2) == 'pelaporan-index')
                                              <i class="ml-2 far fa-dot-circle nav-icon"></i>
                                          @else
                                              <i class="ml-2 far fa-circle nav-icon"></i>
                                          @endif
                                          <p>Pelaporan</p>
                                      </a>
                                  </li>

                              </ul>
                          </li>
                          <li
                              class="nav-item
                                {{ Request::segment(1) == 'penyedia' ? 'menu-is-opening menu-open' : '' }}
                            ">

                              <a href="#"
                                  class="nav-link
                                {{ Request::segment(2) == 'vendor-index' ? 'active' : '' }}
                            ">
                                  <i class="nav-icon fa-solid fas fa-database"></i>
                                  <p>
                                      Penyedia
                                      <i class="fas fa-angle-left right"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                      <a href="{{ route('penyedia.vendor-index') }}"
                                          class="nav-link
                                        {{ Request::segment(2) == 'vendor-index' ? 'active' : '' }}
                                    ">
                                          @if (Request::segment(2) == 'vendor-index')
                                              <i class="ml-2 far fa-dot-circle nav-icon"></i>
                                          @else
                                              <i class="ml-2 far fa-circle nav-icon"></i>
                                          @endif
                                          <p>Penyedia</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('penyedia.penawaran-index') }}"
                                          class="nav-link
                                        {{ Request::segment(2) == 'penawaran-index' ? 'active' : '' }}
                                    ">
                                          @if (Request::segment(2) == 'penawaran-index')
                                              <i class="ml-2 far fa-dot-circle nav-icon"></i>
                                          @else
                                              <i class="ml-2 far fa-circle nav-icon"></i>
                                          @endif
                                          <p>Penawaran</p>
                                      </a>
                                  </li>
                              </ul>
                          </li>
                      @endrole


                      {{-- Misal ini variabel jumlahnya kamu passing dari controller atau Livewire --}}
                      @php
                          $jumlahPerencanaan = 5;
                          $jumlahPelaksanaan = 0;
                          $jumlahPelaporan = 3;
                          $jumlahProfil = 1;
                          $jumlahPenawaran = 2;
                          $jumlahLelang = 0;
                      @endphp

                      {{-- ROLE DESA --}}
                      @role(['desa'])
                          <li class="nav-item">
                              <a href="{{ route('desa.paket-pekerjaan-index') }}"
                                  class="nav-link {{ Request::segment(2) == 'paket-pekerjaan-index' ? 'active' : '' }}">
                                  <i class="nav-icon fas fa-project-diagram"></i>
                                  <p>
                                      Perencanaan
                                      {{-- <span
                                          class="badge badge-{{ $jumlahPerencanaan > 0 ? 'danger' : 'secondary' }} ml-2">
                                          {{ $jumlahPerencanaan }}
                                      </span> --}}
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('desa.penawaran.pelaksanaan.index') }}"
                                  class="nav-link {{ Request::segment(2) == 'pelaksanaan-index' ? 'active' : '' }}">
                                  <i class="nav-icon fas fa-tasks"></i>
                                  <p>
                                      Pelaksanaan
                                      <span
                                          class="badge badge-{{ $jumlahPelaksanaan > 0 ? 'danger' : 'secondary' }} ml-2">
                                          {{ $jumlahPelaksanaan }}
                                      </span>
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('desa.pelaporan.index') }}"
                                  class="nav-link {{ Request::segment(2) == 'pelaporan-index' ? 'active' : '' }}">
                                  <i class="nav-icon fas fa-file-alt"></i>
                                  <p>
                                      Pelaporan
                                      <span class="badge badge-{{ $jumlahPelaporan > 0 ? 'danger' : 'secondary' }} ml-2">
                                          {{ $jumlahPelaporan }}
                                      </span>
                                  </p>
                              </a>
                          </li>
                      @endrole

                      {{-- ROLE PENYEDIA --}}
                      @role(['vendor'])
                          <li class="nav-item">
                              <a href="{{ route('penyedia.vendor-profile', auth()->user()->vendor_id ?? null) }}"
                                  class="nav-link {{ Request::segment(2) == 'vendor-profile' ? 'active' : '' }}">
                                  <i class="nav-icon fas fa-id-badge"></i>
                                  <p>
                                      Profil
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('penyedia.penawaran-index') }}"
                                  class="nav-link {{ Request::segment(2) == 'penawaran-index' ? 'active' : '' }}">
                                  <i class="nav-icon fas fa-file-signature"></i>
                                  <p>
                                      Penawaran
                                      <span class="badge badge-{{ $jumlahPenawaran > 0 ? 'danger' : 'secondary' }} ml-2">
                                          {{ $jumlahPenawaran }}
                                      </span>
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('desa.penawaran.pelaksanaan.index') }}"
                                  class="nav-link {{ Request::segment(2) == 'pelaksanaan-index' ? 'active' : '' }}">
                                  <i class="nav-icon fas fa-gavel"></i>
                                  <p>
                                      Lelang
                                      <span class="badge badge-{{ $jumlahLelang > 0 ? 'danger' : 'secondary' }} ml-2">
                                          {{ $jumlahLelang }}
                                      </span>
                                  </p>
                              </a>
                          </li>
                      @endrole



                  </ul>

              </nav>
              <!-- /.sidebar-menu -->
          </div>
          <!-- /.sidebar -->
      </aside>
