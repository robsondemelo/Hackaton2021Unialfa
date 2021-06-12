<?php
    if ( ! isset ( $_SESSION['cherrymotors']['id'] ) ) exit;
?>
<!-- Page Wrapper -->
    <div id="wrapper" style="background-color:#000000">

        <!-- Sidebar -->
        <ul class="navbar-nav  sidebar sidebar-dark accordion"  id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="http://localhost:8080/">
                	
                <img src="images/logo2.jpg" alt="Cherry Motors"  height="80px" width="80px">

            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="\concessionaria\admin\paginas\home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Cadastros</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <?php
                            include "libs/docs.php";

                            $sql = "select * from menu where submenu = 'C' 
                                order by nome";
                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

                                $acesso = acesso($pdo, $dados->tabela);
                                if ( $acesso == "S" ) {
                                ?>
                                <a class="collapse-item" href="<?=$dados->url?>"><i class="<?=$dados->icone?>"></i> <?=$dados->nome?></a>
                                <?php
                                }

                            }
                        ?>
                    </div>
                </div>
            </li>

           

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="sair.php">
                    <i class="fas fa-fw fa-power-off"></i>
                    <span>Sair</span></a>
            </li>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow" style="background:#352e2e">

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
                        </li>

                        <!-- Nav Item - Alerts -->
                        

                        

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                        
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">

                                	<?=$_SESSION['cherrymotors']['nome']?>
                                   <p > &bull;online</p>
                                    
                                </span>
                                
                                <img class="img-profile rounded-circle"
                                    src="<?="../arquivos/".$_SESSION['cherrymotors']['foto']."p.jpg"?>">
                                   
                            </a>
                            
                            
                            
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Seus Dados
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Mudar Senha
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="sair.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">