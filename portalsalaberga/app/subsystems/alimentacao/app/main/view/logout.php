<?php
require_once('../model/sessions.php');
$session = new sessions();
$session->quebra_session();
header('Location: ../../index.php');
exit();