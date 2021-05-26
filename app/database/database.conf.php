<?php
# Configuração dos bancos de dados suportados no PDO
global $databases;
$databases = array(
    # MYSQL
    'default' => array
        (
        'driver' => 'mysql',
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'smafisio_cielo',
        'user' => 'smafisio_fluxsho',
        'password' => 'U_lU-3eEJjmV',
        'limite_produto' => 15000, //limite de produtos cadastrados
        'emailAdmin' => 'admin@gmail.com'
    )
);
/* end file */
