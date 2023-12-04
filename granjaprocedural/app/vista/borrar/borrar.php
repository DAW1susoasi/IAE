<?php
require_once(RUTA_APP . "/vista/includes/head.php");
?>
<script src="<?php echo RUTA_URL; ?>/scripts/borrar.js"></script>
</head>
<body>
    <div class="d-flex align-items-stretch">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <ul class="list-unstyled components">
                <li>
                    <a href="<?php echo RUTA_URL; ?>">Inicio</a>
                </li>
                <li>
                    <a href="#insertar" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">Insertar</a>
                    <ul class="collapse list-unstyled" id="insertar">
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/animal/insertar">Animal</a>
                        </li>
                        <li>
                            <a href="">Alimento</a>
                        </li>
                        <li>
                            <a href="">Dieta</a>
                        </li>
                        <li>
                            <a href="">Nutriente</a>
                        </li>
                        <li>
                            <a href="">Toma</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#modificar" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Modificar</a>
                    <ul class="collapse list-unstyled" id="modificar">
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/animal/modificar">Animal</a>
                        </li>
                        <li>
                            <a href="">Alimento</a>
                        </li>
                        <li>
                            <a href="">Dieta</a>
                        </li>
                        <li>
                            <a href="">Nutriente</a>
                        </li>
                        <li>
                            <a href="">Toma</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#consultar" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Consultar</a>
                    <ul class="collapse list-unstyled" id="consultar">
                        <li>
                            <a href="#animal" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Animal</a>
                            <ul class="collapse list-unstyled" id="animal">
                                <li>
                                    <a href="<?php echo RUTA_URL; ?>/animal/consultar_todos">Todos</a>
                                </li>
                                <li>
                                    <a href="<?php echo RUTA_URL; ?>/animal/consultar_codigo">Por código</a>
                                </li>
                                <li>
                                    <a href="<?php echo RUTA_URL; ?>/animal/consultar_tipo">Por tipo</a>
                                </li>
                                <li>
                                    <a href="<?php echo RUTA_URL; ?>/animal/consultar_utilidad">Por utilidad</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="">Alimento</a>
                        </li>
                        <li>
                            <a href="">Dieta</a>
                        </li>
                        <li>
                            <a href="">Nutriente</a>
                        </li>
                        <li>
                            <a href="">Toma</a>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#borrar" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Borrar</a>
                    <ul class="collapse list-unstyled show" id="borrar">
                        <li class="active">
                            <a href="<?php echo RUTA_URL; ?>/animal/borrar">Animal</a>
                        </li>
                        <li>
                            <a href="">Alimento</a>
                        </li>
                        <li>
                            <a href="">Dieta</a>
                        </li>
                        <li>
                            <a href="">Nutriente</a>
                        </li>
                        <li>
                            <a href="">Toma</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#dietaanimal" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Dieta animal</a>
                    <ul class="collapse list-unstyled" id="dietaanimal">
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/dietaanimal/crud">CRUD</a>
                        </li>
                    </ul>
                </li>
            </ul>
<?php
require_once(RUTA_APP . "/vista/includes/footer.php");
?>  
        </nav>
        <!-- Page Content  -->
        <div id="content">
            <button type="button" id="sidebarCollapse" class="btn btn-dark">
                <i class="fa fa-bars"></i>
            </button>
            <form method="POST" action="">
                <div class="table-responsive">
                  <table id="dinamico" class="table table-bordered table-hover mx-auto w-auto"></table>
                 </div>
            </form>
        </div>
    </div>
<script>
    document.getElementById('sidebarCollapse').addEventListener("click", function() {
      document.getElementById('sidebar').classList.toggle('contraer');
    });
</script>
</body>
</html>