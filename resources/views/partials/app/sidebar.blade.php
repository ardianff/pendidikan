 <!-- Page Sidebar Start-->
 <div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
     <div>
         <div class="logo-wrapper">
             <a href="index.html"><img class="img-fluid for-light" src="{{ url('assets/images/logo/logo.png') }}"
                     alt="" /><img class="img-fluid for-dark" src="{{ url('assets/images/logo/logo_dark.png') }}"
                     alt="" /></a>
             <div class="back-btn"><i class="fa-solid fa-angle-left"></i></div>
             <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
         </div>
         <div class="logo-icon-wrapper">
             <a href="{{ url('/') }}"><img class="img-fluid" src="{{ url('assets/images/logo/logo-icon.png') }}"
                     alt="" /></a>
         </div>
         <nav class="sidebar-main">
             <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
             <div id="sidebar-menu">
                 <ul class="sidebar-links" id="simple-bar">
                     <li class="back-btn">
                         <a href="{{ url('/') }}"><img class="img-fluid"
                                 src="{{ url('assets/images/logo/logo-icon.png') }}" alt="" /></a>
                         <div class="mobile-back text-end"><span>Back</span><i class="fa-solid fa-angle-right ps-2"
                                 aria-hidden="true"></i></div>
                     </li>
                     <li class="pin-title sidebar-main-title">
                         <div>
                             <h6>Pinned</h6>
                         </div>
                     </li>
                     {{-- Superadmin bisa semua --}}
                     @hasanyrole('superadmin')
                         @include('partials.app.sidebar.general')
                         @include('partials.app.sidebar.kelembagaan')
                         @include('partials.app.sidebar.prestasi')
                         @include('partials.app.sidebar.madrasah')
                         @include('partials.app.sidebar.import')
                         @include('partials.app.sidebar.setting')
                     @endhasanyrole

                     {{-- Admin hanya laporan & setting --}}
                     @hasanyrole('admin')
                         @include('partials.app.sidebar.laporan')
                         @include('partials.app.sidebar.setting')
                     @endhasanyrole

                     {{-- Pendaftaran --}}
                     @hasanyrole('pendaftaran')
                         @include('partials.app.sidebar.pendaftaran')
                     @endhasanyrole

                     {{-- Farmasi --}}
                     @hasanyrole('farmasi')
                         @include('partials.app.sidebar.farmasi')
                     @endhasanyrole

                     {{-- Rawat Jalan --}}
                     @hasanyrole('rajal')
                         @include('partials.app.sidebar.rajal')
                     @endhasanyrole

                     {{-- Rawat Inap --}}
                     @hasanyrole('ranap')
                         @include('partials.app.sidebar.ranap')
                     @endhasanyrole

                     {{-- IGD --}}
                     @hasanyrole('igd')
                         @include('partials.app.sidebar.igd')
                     @endhasanyrole

                     {{-- Radiologi --}}
                     @hasanyrole('radiologi')
                         @include('partials.app.sidebar.radiologi')
                     @endhasanyrole

                     {{-- Laboratorium --}}
                     @hasanyrole('laboratorium')
                         @include('partials.app.sidebar.laboratorium')
                     @endhasanyrole

                     {{-- Gizi --}}
                     @hasanyrole('gizi')
                         @include('partials.app.sidebar.gizi')
                     @endhasanyrole

                     {{-- Kasir --}}
                     @hasanyrole('kasir')
                         @include('partials.app.sidebar.kasir')
                     @endhasanyrole

                 </ul>
             </div>
             <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
         </nav>
     </div>
 </div>
 <!-- Page Sidebar Ends-->
