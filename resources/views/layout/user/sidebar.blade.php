    <!-- Sidebar -->
    <div class="sidebar sidebar-style-2" id="sidebar">			
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <div class="user">
                    <div class="avatar-sm float-left mr-2">
                        <img src="../assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                            <span>
                                Budi Santoso
                                <span class="user-level">Member</span>
                                <span class="caret"></span>
                            </span>
                        </a>
                        <div class="clearfix"></div>
                        <div class="collapse in" id="collapseExample">
                            <ul class="nav">
                                <li>
                                    <a href="#profile">
                                        <span class="link-collapse">Aktifitas Saya</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#edit">
                                        <span class="link-collapse">Pengaturan</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#settings">
                                        <span class="link-collapse">Pengaturan</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-primary">
                    <li class="nav-item" id="search-nav">
                        <div class="input-group stylish-input-group">
                            <input type="text" placeholder="Cari..." class="form-control" id="searchInputSidebar">
                        </div>
                    </li>
                </ul>
                <ul class="nav nav-primary" id="sidebarMenu">
                    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}" data-name="Dashboard">
                        <a href="/dashboard">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('keuangan') ? 'active' : '' }}" data-name="Home">
                        <a href="/keuangan">
                            <i class="fas fa-piggy-bank"></i>
                            <p>Keuangan</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('jenis_in*') || request()->is('cash_in') ? 'active' : '' }}" data-name="Uang Masuk">
                        <a data-toggle="collapse" href="#submenuCashIn">
                            <i class="fas fa-layer-group"></i>
                            <p>Uang Masuk</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->is('jenis_in*') || request()->is('cash_in') ? 'show' : '' }}" id="submenuCashIn">
                            <ul class="nav nav-collapse">
                                <li data-name="cash_in" class="{{ request()->is('cash_in') ? 'active' : '' }}">
                                    <a href="/cash_in">
                                        <span class="sub-item">Uang Masuk</span>
                                    </a>
                                </li>
                                <li data-name="jenis_in" class="{{ request()->is('jenis_in') ? 'active' : '' }}">
                                    <a href="/jenis_in">
                                        <span class="sub-item">Jenis Uang Masuk</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ request()->is('jenis_out*') || request()->is('cash_out') ? 'active' : '' }}" data-name="Uang Keluar">
                        <a data-toggle="collapse" href="#submenuCashOut">
                            <i class="fas fa-layer-group"></i>
                            <p>Uang Keluar</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->is('jenis_out*') || request()->is('cash_out') ? 'show' : '' }}" id="submenuCashOut">
                            <ul class="nav nav-collapse">
                                <li data-name="cash_out" class="{{ request()->is('cash_out') ? 'active' : '' }}">
                                    <a href="/cash_out">
                                        <span class="sub-item">Uang Keluar</span>
                                    </a>
                                </li>
                                <li data-name="jenis_out" class="{{ request()->is('jenis_out') ? 'active' : '' }}">
                                    <a href="/jenis_out">
                                        <span class="sub-item">Jenis Uang Keluar</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ request()->is('tujuan') ? 'active' : '' }}" data-name="Target">
                        <a href="/tujuan">
                            <i class="fas fa-piggy-bank"></i>
                            <p>Target</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Sidebar -->