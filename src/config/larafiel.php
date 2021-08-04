<?php
/**
 * Retorna la configuración de Larafiel necesaria para instanciar la API de Mifiel.
 */
return [
    // Visualizar https://sandbox.mifiel.com/access_tokens para más información de los tokens.

    /**
     * APP_ID
     */
    'app_id' => env('MIFIEL_APP_ID', false),

    /**
     * APP_SECRET
     */
    'app_secret' => env('MIFIEL_APP_SECRET', false),

    /**
     * URL de la API que quieres utilizar en tu aplicación
     */
    'api_url' => env('MIFIEL_API_URL', 'https://sandbox.mifiel.com/api/v1/')
];