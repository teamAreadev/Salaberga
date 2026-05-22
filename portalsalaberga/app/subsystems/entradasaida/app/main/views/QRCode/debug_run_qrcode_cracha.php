<?php
/**
 * Runner CLI para debug — não usar em produção.
 * Uso: php debug_run_qrcode_cracha.php [turma_id]
 */
define('QR_DEBUG_CLI', true);
$_POST['turma'] = $argv[1] ?? '9';

require __DIR__ . '/qrcode_cracha.php';
