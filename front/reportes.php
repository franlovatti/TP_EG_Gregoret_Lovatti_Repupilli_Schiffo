<?php include '../sesion.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="estilos/global.css" />
</head>

<body class="d-flex flex-column min-vh-100">

    <header class="p-3 text-bg-dark">
        <?php include '../header.php'; ?>
    </header>

    <?php
    $tipoUsuario = $_SESSION['tipoUsuario'] ?? null;
    ?>

    <div class="container py-5">

        <!-- FILTROS -->

        <div class="filtros-box mb-4">
            <h5 class="mb-2">
                Reportes de promociones
            </h5>
            <div class="row gy-2">

                <?php
                if ($tipoUsuario == 'administrador') {
                    $buscarPor = 'buscarPorLocal';
                    $placeholder = 'Buscar por local';
                } else {
                    $buscarPor = 'buscarPorPromo';
                    $placeholder = 'Buscar por promoción';
                }
                ?>

                <!-- Busqueda por local o promocion -->
                <div class="col-lg-4 col-12">
                    
                    <label class="form-label">&nbsp;</label>
                    <form class="d-flex" method="post" action="">
                        <div class="input-group">
                            
                            <input type="hidden" name="buscarPor" value="<?= $buscarPor ?>" />
                            
                            <input
                            type="text"
                            placeholder="<?= $placeholder ?>"
                            class="form-control"
                            name="<?= $buscarPor ?>" />
                            
                            <button class="btn btn-primary" type="submit" name="buscar">
                                <i class="bi bi-search"></i>
                            </button>

                        </div>
                    </form>

                </div>

                <!-- Filtros por fecha -->
                <div class="col-lg-8 col-12">

                    <form class="row g-2" method="post" action="">

                        <div class="col-md-4">
                            <label class="form-label">Fecha desde</label>
                            <input type="date" class="form-control" name="fechaDesde" id="fechaDesde"/>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha hasta</label>
                            <input type="date" class="form-control" name="fechaHasta" id="fechaHasta"/>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <button class="btn btn-primary w-100" type="submit" name="filtrar">
                                Filtrar
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

        <?php
        //incluyo el archivo con las consultas
        include '../consultas/reportesPromo.php';

        //armo array para mostrar resultados agrupados por local
        $locales = [];

        if (isset($resultados) && !empty($resultados)) {

            foreach ($resultados as $fila) {

                $id_local = $fila['id_local'];

                if (!isset($locales[$id_local])) {

                    $locales[$id_local] = [
                        'nombre_local' => $fila['nombre_local'],
                        'ubicacion' => $fila['ubicacion'],
                        'rubro' => $fila['rubro'],
                        'promociones' => []
                    ];
                }

                $locales[$id_local]['promociones'][] = [
                    'descripcion' => $fila['descripcion'],
                    'cant_usos' => $fila['cant_usos'],
                    'fecha_desde' => $fila['fecha_desde'],
                    'fecha_hasta' => $fila['fecha_hasta'],
                    'categoria' => $fila['categoria']
                ];
            }
        }
        ?>

        <?php if (empty($locales)) { ?>

            <div class='alert alert-info text-center'>
                Aún no hay reportes para la búsqueda solicitada.
            </div>

        <?php } else { ?>

            <!-- TABLAS CON LOS REPORTES -->
            <div class="scrollable-box">

                <?php foreach ($locales as $local) { ?>

                    <div class="card mb-4">

                        <div class="card-body">

                            <div class="row local-header mb-3">

                                <div class="col-md-5">
                                    <strong>LOCAL:</strong> <?= $local['nombre_local'] ?>
                                </div>

                                <div class="col-md-4">
                                    <strong>UBICACIÓN:</strong> <?= $local['ubicacion'] ?>
                                </div>

                                <div class="col-md-3">
                                    <strong>RUBRO:</strong> <?= $local['rubro'] ?>
                                </div>

                            </div>

                            <div class="border-top pt-2">

                                <?php foreach ($local['promociones'] as $promo) { ?>

                                    <div class="row promo-row">

                                        <div class="col-md-4">
                                            <strong>Promo:</strong> <?= $promo['descripcion'] ?>
                                        </div>

                                        <div class="col-md-2">
                                            <strong>usos totales:</strong> <?= $promo['cant_usos'] ?>
                                        </div>

                                        <div class="col-md-6">
                                            <strong>Última fecha vigente:</strong>
                                            Desde: <?= $promo['fecha_desde'] ?>
                                            Hasta: <?= $promo['fecha_hasta'] ?>
                                        </div>

                                        <div class="col-md-3">
                                            <span class="badge badge-categoria">
                                                <?= $promo['categoria'] ?>
                                            </span>
                                        </div>

                                    </div>

                                <?php } ?>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>

        <?php } ?>

    </div>

    <footer class="footer mt-auto py-3 bg-body-tertiary">
        <?php include '../footer.php'; ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>