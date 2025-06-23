<?php

return [
    // Token de API da Iugu (pode ser definido via .env)
    'api_token' => env('IUGU_API_TOKEN', 'SEU_TOKEN_AQUI'),

    // URL base da API da Iugu
    'base_url' => env('IUGU_API_BASE_URL', 'https://api.iugu.com/v1/'),

    // Timeout das requisições (em segundos)
    'timeout' => env('IUGU_API_TIMEOUT', 10),

    // Outras opções customizáveis podem ser adicionadas aqui
]; 