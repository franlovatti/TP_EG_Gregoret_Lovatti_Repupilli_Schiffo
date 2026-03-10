<?php
require_once '../conexion.php';

function ejecutarBuscarPor($conexion, $query, $terminoBusqueda = null) {
  //preparo la consulta
  $stmt = mysqli_prepare($conexion, $query);
  mysqli_stmt_bind_param($stmt, "s", $terminoBusqueda);
  //ejecuto la consulta
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  //armo array con resultados
  if($result){
      $resultados = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $resultados[] = $row;
    }
    //libero memoria
    mysqli_free_result($result);
  } else{
    echo "Error en la consulta: " . mysqli_error($conexion);
  }
  return $resultados;
}

function ejecutarPorFiltro($conexion, $query, $fechaDesde, $fechaHasta) {
  //preparo la consulta
  $stmt = mysqli_prepare($conexion, $query);
  mysqli_stmt_bind_param($stmt, "ss", $fechaDesde, $fechaHasta);
  //ejecuto la consulta
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  //armo array con resultados
  if($result){
      $resultados = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $resultados[] = $row;
    }
    //libero memoria
    mysqli_free_result($result);
  } else{
    echo "Error en la consulta: " . mysqli_error($conexion);
  }
  return $resultados;
}
if(isset($_POST['buscar'])) {
    $buscarPor = $_POST['buscarPor'];
    if($buscarPor == 'buscarPorLocal') {
        $terminoBusqueda = '%'.$_POST['buscarPorLocal'].'%';
      //armo la query para buscar por local
$query = "SELECT l.id_local AS id_local, l.nombre_local, l.ubicacion, l.rubro,
	            p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria, 
                count(up.fecha_uso) as cant_usos
                FROM uso_promocion up
                JOIN promocion p ON up.id_promocion = p.id_promocion
                JOIN local l ON p.id_local = l.id_local
                WHERE (l.nombre_local LIKE ?) and up.estado = 'aceptada'
                GROUP BY l.id_local, l.nombre_local, l.ubicacion, l.rubro, 
		            p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria";
      $resultados = ejecutarBuscarPor($conexion, $query, $terminoBusqueda); 
    } else {
        $terminoBusqueda ='%'.$_POST['buscarPorPromo'].'%';
        //armo la query para buscar por promocion
        $query = "SELECT l.id_local, l.nombre_local, l.ubicacion, l.rubro,
                         p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria,
                         count(up.fecha_uso) as cant_usos
                  FROM uso_promocion up
                  JOIN promocion p ON up.id_promocion = p.id_promocion
                  JOIN local l ON p.id_local = l.id_local
                  WHERE p.descripcion LIKE ? and up.estado = 'aceptada'
                  GROUP BY l.id_local, l.nombre_local, l.ubicacion, l.rubro, 
                           p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria";
        //ejecuto la consulta
       $resultados = ejecutarBuscarPor($conexion, $query, $terminoBusqueda);
    }
    
} elseif (isset($_POST['filtrar'])) {
    $fechaDesde = $_POST['fechaDesde'];
    $fechaHasta = $_POST['fechaHasta'];

    $query = "SELECT l.id_local, l.nombre_local, l.ubicacion, l.rubro,
                     p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria,
                     count(up.fecha_uso) as cant_usos
              FROM uso_promocion up
              JOIN promocion p ON up.id_promocion = p.id_promocion
              JOIN local l ON p.id_local = l.id_local
              WHERE up.fecha_uso BETWEEN ? AND ?
              GROUP BY l.id_local, l.nombre_local, l.ubicacion, l.rubro, 
                       p.descripcion, p.fecha_desde, p.fecha_hasta, p.categoria ";
    //preparo la consulta
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ss", $fechaDesde, $fechaHasta);
    //ejecuto la consulta
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    //armo array con resultados
    if($result){
        $resultados = [];
      while ($row = mysqli_fetch_assoc($result)) {
          $resultados[] = $row;
      }
      //libero memoria
      mysqli_free_result($result);
    } else{
      echo "Error en la consulta: " . mysqli_error($conexion);
    }
}
?>