<?php
// Configurações gerais do sistema
define('SISTEMA_NOME', 'Copa Grêmio 2025');
define('SISTEMA_VERSAO', '1.0.0');

// Configurações de pagamento
define('PIX_CHAVE', '09593342389'); // CPF do beneficiário
define('PIX_NOME', 'Matheus Lima de Araujo');
define('PIX_CIDADE', 'Fortaleza');
define('PIX_VALOR_BASE', 5.00); // Valor base por modalidade
define('PIX_VALOR_DESCONTO', 3.00); // Valor com desconto (3+ modalidades)

// Configurações de contato
define('WHATSAPP_NUMERO', '558598530920'); // Número para envio do comprovante
define('EMAIL_CONTATO', 'gremio@escola.edu.br');

// Configurações de sessão
define('SESSAO_TIMEOUT', 1800); // 30 minutos em segundos

// Configurações de upload
define('UPLOAD_MAX_SIZE', 5242880); // 5MB em bytes
define('UPLOAD_TIPOS_PERMITIDOS', ['image/jpeg', 'image/png', 'application/pdf']);
define('UPLOAD_DIR', __DIR__ . '/../uploads/');

// Configurações de modalidades
$MODALIDADES = [
    'futsal' => [
        'nome' => 'Futsal',
        'limite_jogadores' => 12,
        'categorias' => ['masculino', 'feminino']
    ],
    'volei' => [
        'nome' => 'Vôlei',
        'limite_jogadores' => 12,
        'categorias' => ['masculino', 'feminino', 'misto']
    ],
    'basquete' => [
        'nome' => 'Basquete',
        'limite_jogadores' => 12,
        'categorias' => ['masculino', 'feminino']
    ],
    'handebol' => [
        'nome' => 'Handebol',
        'limite_jogadores' => 14,
        'categorias' => ['masculino', 'feminino']
    ],
    'queimada' => [
        'nome' => 'Queimada',
        'limite_jogadores' => 12,
        'categorias' => ['misto']
    ],
    'futmesa' => [
        'nome' => 'Futmesa',
        'limite_jogadores' => 2,
        'categorias' => ['masculino', 'feminino']
    ],
    'teqball' => [
        'nome' => 'Teqball',
        'limite_jogadores' => 2,
        'categorias' => ['masculino', 'feminino']
    ],
    'teqvolei' => [
        'nome' => 'Teqvôlei',
        'limite_jogadores' => 2,
        'categorias' => ['misto']
    ],
    'beach_tenis' => [
        'nome' => 'Beach Tennis',
        'limite_jogadores' => 2,
        'categorias' => ['masculino', 'feminino', 'misto']
    ],
    'volei_de_praia' => [
        'nome' => 'Vôlei de Praia',
        'limite_jogadores' => 2,
        'categorias' => ['masculino', 'feminino', 'misto']
    ],
    'tenis_de_mesa' => [
        'nome' => 'Tênis de Mesa',
        'limite_jogadores' => 1,
        'categorias' => ['masculino', 'feminino']
    ],
    'dama' => [
        'nome' => 'Dama',
        'limite_jogadores' => 1,
        'categorias' => ['misto']
    ],
    'xadrez' => [
        'nome' => 'Xadrez',
        'limite_jogadores' => 1,
        'categorias' => ['misto']
    ],
    'x2' => [
        'nome' => 'X2',
        'limite_jogadores' => 3,
        'categorias' => ['masculino', 'feminino', 'misto']
    ],
    'jiu-jitsu' => [
        'nome' => 'Jiu-Jitsu',
        'limite_jogadores' => 1,
        'categorias' => ['masculino', 'feminino']
    ]
];

// Função para gerar código PIX
function gerarCodigoPix($valor) {
    // Dados do PIX
    $pixData = [
        '00' => '01', // Payload Format Indicator
        '26' => [
            '00' => 'BR.GOV.BCB.PIX',
            '01' => PIX_CHAVE
        ],
        '52' => '0000', // Merchant Category Code
        '53' => '986', // Transaction Currency (BRL)
        '54' => number_format($valor, 2, '.', ''), // Transaction Amount
        '58' => 'BR',
        '59' => PIX_NOME,
        '60' => PIX_CIDADE,
        '62' => [
            '05' => '***'
        ]
    ];
    
    // Montar código PIX
    $codigoPix = '';
    
    foreach ($pixData as $id => $valor) {
        if (is_array($valor)) {
            $subCodigo = '';
            foreach ($valor as $subId => $subValor) {
                $subCodigo .= $subId . str_pad(strlen($subValor), 2, '0', STR_PAD_LEFT) . $subValor;
            }
            $codigoPix .= $id . str_pad(strlen($subCodigo), 2, '0', STR_PAD_LEFT) . $subCodigo;
        } else {
            $codigoPix .= $id . str_pad(strlen($valor), 2, '0', STR_PAD_LEFT) . $valor;
        }
    }
    
    // Adicionar CRC16
    $codigoPix .= '6304';
    $crc = crc16($codigoPix);
    $codigoPix .= strtoupper(dechex($crc));
    
    return $codigoPix;
}

// Função para calcular CRC16
function crc16($str) {
    $crc = 0xFFFF;
    $strlen = strlen($str);
    
    for($c = 0; $c < $strlen; $c++) {
        $crc ^= ord(substr($str, $c, 1)) << 8;
        for($i = 0; $i < 8; $i++) {
            if($crc & 0x8000) {
                $crc = ($crc << 1) ^ 0x1021;
            } else {
                $crc = $crc << 1;
            }
            $crc &= 0xFFFF;
        }
    }
    
    return $crc;
}
?> 