<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?=base_url()?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Perpustakaan - <?=$this->e($title)?></title>

    <!-- Custom fonts for this template-->
    <link href="<?=base_url('assets/vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet" type="text/css">
    <!-- <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet"> -->

    <!-- Custom styles for this template-->
    <link href="<?=base_url('assets/css/sb-admin-2.min.css')?>" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css')?>" rel="stylesheet">
    <style>
    .btn-circle {
        width: 38px;
        height: 38px;
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
    }

    #welcome-loader {
        position: fixed;
        z-index: 500;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
        transform: scaleY(1);
    }

    #welcome-loader.hide {
        transform: scaleY(0);
        height: 0px !important;
        transition: transform 300ms linear;
    }

    #welcome-content {
        width: 140px;
        height: 140px;
        perspective: 1000px;
        animation: logoSpin 3s linear infinite;
        transform: rotateY(360deg);
    }

    #welcome-content  img {
        filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, .40));
    }

    @keyframes logoSpin {
        from {
            transform: rotateY(0deg);
        }
        to {
            transform: rotateY(360deg);
        }
    }
    </style>

    

    <?=$this->section('css')?>

	<?php $CI =& get_instance(); ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
				
                <div class="sidebar-brand-text mx-3">Perpustakaan</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li
                class="nav-item <?=$CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == 'dashboard' ? 'active' : '' ?>">
                <a class="nav-link" href="<?=base_url('admin/dashboard')?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Master
            </div> -->

            <!-- Nav Item - Pages Collapse Menu Pendaftaran-->
            <li class="nav-item <?=$CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == 'member' ? 'active' : '' ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBooks"
                    aria-expanded="true" aria-controls="collapseBooks">
                    <i class="fa-solid fa fa-user-plus"></i>
                    <span>Pendaftaran</span>
                </a>
                <div id="collapseBooks" class="collapse <?=$CI->uri->segment(1) == 'admin' && ($CI->uri->segment(2) == 'member' || $CI->uri->segment(2) == 'publisher' || $CI->uri->segment(2) == 'kategori' || $CI->uri->segment(2) == 'user') ? 'show' : '' ?>" 
					aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Custom Components:</h6> -->

                        <a class="collapse-item <?=$CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == 'member' ? 'active bg-dark-2 text-light' : '' ?>" href="<?=base_url('admin/member')?>">
							<i class="fa fa-users" aria-hidden="true"> </i>
							<span>Member</span>
						</a>

                        <a class="collapse-item <?=$CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == 'publisher' ? 'active bg-dark-2 text-light' : '' ?>" href="<?=base_url('admin/publisher')?>">
							<i class="fa fa-building" aria-hidden="true"></i>
							<span>Penerbit</span>
						</a>

						<a class="collapse-item <?=$CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == 'kategori' ? 'active bg-dark-2 text-light' : '' ?>" href="<?=base_url('admin/kategori')?>">
							<i class="fas fa-tags"></i>
							<span>Kategori</span>
						</a>

						<a class="collapse-item <?=$CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == 'user' ? 'active bg-dark-2 text-light' : '' ?>" href="<?=base_url('admin/user')?>">
							<i class="fas fa-users"></i>
							<span>User</span>
						</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Book -->
            <li class="nav-item <?=$CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == 'book' ? 'active bg-dark-2' : '' ?>">
                <a class="nav-link" href="<?=base_url('admin/book')?>">
                    <i class="fa fa-book" aria-hidden="true"></i>
                    <span>Buku</span></a>
            </li>

			<!-- Nav Item - Peminjaman buku harian -->
			<li class="nav-item <?=($CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == 'order' && $CI->uri->segment(3) == 'daily_order') ? 'active bg-dark-2' : '' ?>">
                <a class="nav-link" href="<?=base_url('admin/order/daily_order')?>">
                    <i class="fa fa-clipboard-list" aria-hidden="true"></i>
                    <span>Peminjaman Buku Harian</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            


			<!-- Nav Item - Pages Collapse Menu Laporan-->
            <li class="nav-item <?=$CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == 'report' ? 'active' : '' ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
                    aria-expanded="true" aria-controls="collapseLaporan">
                    <i class="fa fa-file" aria-hidden="true"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseLaporan" class="collapse <?=($CI->uri->segment(1) == 'report') ? 'show' : '' ?>" 
					aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Custom Components:</h6> -->

                        <a class="collapse-item <?=$CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == '' ? 'active bg-dark-2 text-light' : '' ?>" href="<?=base_url('admin/report')?>">
							<i class="fa fa-file-alt" aria-hidden="true"> </i>
							<span>Peminjaman</span>
						</a>
                        
						<a class="collapse-item <?=($CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == 'report' && $CI->uri->segment(3) == 'book') ? 'active bg-dark-2 text-light' : '' ?>" href="<?=base_url('admin/report/book')?>">
							<i class="fa fa-file-alt" aria-hidden="true"> </i>
							<span>Buku</span>
						</a>

                    </div>
                </div>
            </li>


			<!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-dark bg-info topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>





                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-white small"><?=$_SESSION['user']['full_name'] ?? NULL?></span>
                                <img class="img-profile rounded-circle" src="assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="<?=base_url('admin/setting/loan')?>">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <?=$this->section('contents')?>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white mt-3">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; PT. HIT International 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?=base_url('user/logout')?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php if(empty($_SESSION['error']) && empty($_SESSION['success'])): ?>

    <div id="welcome-loader" class="bg-primary">
        <div id="welcome-content">
            <img src="<?=$this->e(base_url('assets/img/w logo.svg'))?>" height="100%">
        </div>
    </div>

    <script defer>
        window.addEventListener('DOMContentLoaded', e => {
            e.preventDefault();
            setTimeout(() => {
                document.querySelector('#welcome-loader').classList.add('hide');
            }, 1200);
        });
    </script>

    <?php endif ?>

    <!-- Bootstrap core JavaScript-->
    <script src="<?=base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
    <script src="<?=base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=base_url('assets/vendor/jquery-easing/jquery.easing.min.js')?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=base_url('assets/js/sb-admin-2.min.js')?>"></script>

    <!-- Page level plugins -->
    <!-- <script src="<? // =base_url('assets/vendor/chart.js/Chart.min.js')?>"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="<? // =base_url('assets/js/demo/chart-area-demo.js')?>"></script>
<script src="<? // =base_url('assets/js/demo/chart-pie-demo.js')?>"></script> -->

    <!-- Page level plugins -->
    <script src="<?=base_url('assets/vendor/datatables/jquery.dataTables.min.js')?>"></script>
    <script src="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>

    <script>
    const BASE_URL = "<?=base_url()?>";
    const SETTINGS = Object.assign(<?=json_encode($settings)?>, {});
    </script>

    <?=$this->section('js')?>

  
</body>

</html>
