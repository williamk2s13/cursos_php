<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    // Certifique-se de que as rotas de API estão incluídas aqui
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // Permite GET, POST, PUT, DELETE, etc.

    // Aqui é o pulo do gato: coloque a URL exata do seu Vue
    'allowed_origins' => ['http://localhost:5173'], 
    // Dica: em ambiente local, se quiser liberar para tudo temporariamente, use ['*']

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Permite todos os cabeçalhos

    'exposed_headers' => [],

    'max_age' => 0,

    // Se você estiver usando autenticação (como Laravel Sanctum) e enviando cookies, mude para true
    'supports_credentials' => false, 

];