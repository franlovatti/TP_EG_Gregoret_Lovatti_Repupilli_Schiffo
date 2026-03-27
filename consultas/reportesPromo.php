<?php
require_once '../conexion.php';

$tipoUsuario = $_SESSION['tipoUsuario'];
$idUsuario = $_SESSION['idUsuario'];

function ejecutarBuscarPor($conexion, $query, $terminoBusqueda = null) {
  $stmt = mysqli_prepare($conexion, $query);

  if($terminoBusqueda !== null) {
    mysqli_stmt_bind_param($stmt, "s", $terminoBusqueda);
  }

  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if($result){
    $resultados = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $resultados[] = $row;
    }
    mysqli_free_result($result);
  } else{
    echo "Error en la consulta: " . mysqli_error($conexion);
  }

  return $resultados;
}

function ejecutarPorFiltro($conexion, $query) {
  $result = mysqli_query($conexion, $query);

  if($result){
    $resultados = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $resultados[] = $row;
    }
    mysqli_free_result($result);
  } else{
    echo "Error en la consulta: " . mysqli_error($conexion);
  }

  return $resultados;
}

// Filtro según tipo de usuario
$filtroDueno = "";
if ($tipoUsuario != 'administrador') {
    $filtroDueno = " AND l.id_usuario = $idUsuario ";
}

// BUSCAR
if(isset($_POST['buscar'])) {

    $buscarPor = $_POST['buscarPor'];

    if($buscarPor == 'buscarPorLocal') {

        $terminoBusqueda = '%'.$_POST['buscarPorLocal'].'%';

        $query = "SELECT l.id_local AS id_local, l.nombre_local, l.ubicacion, l.rubro,
                        p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria, 
                        count(up.fecha_uso) as cant_usos
                  FROM uso_promocion up
                  JOIN promocion p ON up.id_promocion = p.id_promocion
                  JOIN local l ON p.id_local = l.id_local
                  WHERE l.nombre_local LIKE ?
                  AND up.estado = 'aceptada'
                  AND p.estado != 'eliminada'
                  $filtroDueno
                  GROUP BY l.id_local, l.nombre_local, l.ubicacion, l.rubro, 
                           p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria";

        $resultados = ejecutarBuscarPor($conexion, $query, $terminoBusqueda); 

    } else {

        $terminoBusqueda ='%'.$_POST['buscarPorPromo'].'%';

        $query = "SELECT l.id_local, l.nombre_local, l.ubicacion, l.rubro,
                         p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria,
                         count(up.fecha_uso) as cant_usos
                  FROM uso_promocion up
                  JOIN promocion p ON up.id_promocion = p.id_promocion
                  JOIN local l ON p.id_local = l.id_local
                  WHERE p.descripcion LIKE ?
                  AND up.estado = 'aceptada'
                  AND p.estado != 'eliminada'
                  $filtroDueno
                  GROUP BY l.id_local, l.nombre_local, l.ubicacion, l.rubro, 
                           p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria";

        $resultados = ejecutarBuscarPor($conexion, $query, $terminoBusqueda);
    }

// FILTRAR POR FECHA
} elseif (isset($_POST['filtrar'])) {

    $fechaDesde = $_POST['fechaDesde'];
    $fechaHasta = $_POST['fechaHasta'];
    if(empty($fechaDesde) && empty($fechaHasta)){
        $plazo = "";
    } elseif(empty($fechaDesde)){
        $plazo = " AND up.fecha_uso <= '$fechaHasta'";
    } elseif(empty($fechaHasta)){
        $plazo = " AND up.fecha_uso >= '$fechaDesde'";
    } else {
        $plazo = " AND up.fecha_uso BETWEEN '$fechaDesde' AND '$fechaHasta'";
    }

    $query = "SELECT l.id_local, l.nombre_local, l.ubicacion, l.rubro,
                     p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria,
                     count(up.fecha_uso) as cant_usos
              FROM uso_promocion up
              JOIN promocion p ON up.id_promocion = p.id_promocion
              JOIN local l ON p.id_local = l.id_local
              WHERE up.estado = 'aceptada'
              AND p.estado != 'eliminada'
              $filtroDueno
              $plazo
              GROUP BY l.id_local, l.nombre_local, l.ubicacion, l.rubro, 
                       p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria";

    $resultados = ejecutarPorFiltro($conexion, $query);

// SIN FILTROS
} else {

    $query = "SELECT l.id_local, l.nombre_local, l.ubicacion, l.rubro,
                     p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria,
                     count(up.fecha_uso) as cant_usos
              FROM uso_promocion up
              JOIN promocion p ON up.id_promocion = p.id_promocion
              JOIN local l ON p.id_local = l.id_local
              WHERE up.estado = 'aceptada'
              AND p.estado != 'eliminada'
              $filtroDueno
              GROUP BY l.id_local, l.nombre_local, l.ubicacion, l.rubro, 
                       p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria";

    $resultados = ejecutarBuscarPor($conexion, $query, null);
}
?>