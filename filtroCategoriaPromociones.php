<?php

function obtenerCategoriasPermitidasPorSesion() {
    $tipoUsuario = $_SESSION['tipoUsuario'] ?? null;
    $categoriaUsuario = $_SESSION['categoria'] ?? null;

    // La restriccion aplica a clientes logueados con categoria valida.
    if ($tipoUsuario !== 'cliente') {
        return [];
    }

    if ($categoriaUsuario === 'inicial') {
        return ['inicial'];
    }

    if ($categoriaUsuario === 'medium') {
        return ['inicial', 'medium'];
    }

    if ($categoriaUsuario === 'premium') {
        return ['inicial', 'medium', 'premium'];
    }

    // Si no hay categoria valida, no aplicar filtro por seguridad de compatibilidad.
    return [];
}

function obtenerFiltroSqlCategoriaPromocion($alias = 'p') {
    $categoriasPermitidas = obtenerCategoriasPermitidasPorSesion();

    if (empty($categoriasPermitidas)) {
        return '';
    }

    $categoriasSql = array_map(function ($categoria) {
        return "'" . $categoria . "'";
    }, $categoriasPermitidas);

    return " AND " . $alias . ".categoria IN (" . implode(', ', $categoriasSql) . ")";
}
