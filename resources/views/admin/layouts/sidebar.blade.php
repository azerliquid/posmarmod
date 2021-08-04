<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><span>Martabak Modern</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{Auth::user()->profile_photo_url}}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Selemat Datang,</span>
                <h2>{{ Auth::user()->employe->name }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-home"></i>Dashboard </a>
                  </li>
                  <li><a><i class="fa fa-edit"></i>Data Master <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('product.index') }}">Produk</a></li>
                      <li><a href="{{ route('catunit.index') }}">Kategori & Unit</a></li>
                    </ul>
                  </li>
                  <li><a href="{{ route('employe.index') }}"><i class="fa fa-user"></i>Karyawan</a>
                  </li>
                  <li><a href="{{ route('branchstore.index') }}"><i class="fa fa-map-marker"></i>Cabang</a>
                  </li>
                  <li><a href="{{ route('reporttransaction.index') }}"><i class="fa fa-bar-chart-o"></i>Laporan Transaksi</a>
                  </li>
                  <li><a href="{{ route('reportincome.index') }}"><i class="fa fa-money"></i>Laporan Pendapatan</a>
                  </li>
                  <li><a href="{{ route('reportoutcome.index') }}"><i class="fa fa-share-square-o"></i>Laporan Pengeluaran</a>
                  </li>
                </ul>
              </div>
              <!-- <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>                  
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div> -->

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
            <form method="POST" action="{{ route('logout') }}">
                  @csrf
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{route('logout')}}"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span></a>
            </form>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>