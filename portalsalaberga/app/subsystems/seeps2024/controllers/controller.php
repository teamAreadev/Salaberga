<?php
//cadastro

function virg($num)
{
    if (count(explode(',', $num)) > 0) {
        $num = str_replace(',', '.', $num);
    }
    return $num;
}

//Lógica para POST Pcd
if (!isset($_POST["pcd"])) {
    $pcd = 0;
} else {
    $pcd = $_POST["pcd"];
}

$c2 = 1;
$nome = $_POST['nome'];
$dn = $_POST['nasc'];

//Lógica para o Post Curso
switch ($_POST['curso']) {

    case 'Enfermagem':

        $c1 = 1;
        break;
    case 'Informatica':

        $c1 = 2;
        break;
    case 'Administracao':

        $c1 = 3;
        break;
    case 'Edificacoes':

        $c1 = 4;
        break;
};

//Lógica para o Post Escola
switch ($_POST['publica']) {

    case 'Escola Pública':

        $publica = 1;
        break;
    case 'Escola Privada':

        $publica = 0;
        break;
};


//Lógica para o Post de Bairros
switch ($_POST['bairro']) {

    case 'Outros Bairros':

        $bairro = 0;
        break;
    case 'Outra Banda':

        $bairro = 1;
        break;
};

$d = 4;
//6° ano

if (!empty($_POST['ef6'])) {
    $ef6 = $_POST['ef6'];
} else {
    $ef6 = 0;
    $d -= 1;
}
$lp6 = virg($_POST['lp6']);
$ar6 = virg($_POST['a6']);
$li6 = virg($_POST['i6']);
$ma6 = virg($_POST['m6']);
$ci6 = virg($_POST['c6']);
$ge6 = virg($_POST['g6']);
$hi6 = virg($_POST['h6']);
$re6 = virg($_POST['r6']);

//7° ano
if (!empty($_POST['ef7'])) {
    $ef7 = $_POST['ef7'];
} else {
    $ef7 = 0;
    $d -= 1;
}
$lp7 = virg($_POST['lp7']);
$ar7 = virg($_POST['a7']);
$li7 = virg($_POST['i7']);
$ma7 = virg($_POST['m7']);
$ci7 = virg($_POST['c7']);
$ge7 = virg($_POST['g7']);
$hi7 = virg($_POST['h7']);
$re7 = virg($_POST['r7']);

//8° ano

if (!empty($_POST['ef8'])) {
    $ef8 = $_POST['ef8'];
} else {
    $ef8 = 0;
    $d -= 1;
}
$lp8 = virg($_POST['lp8']);
$ar8 = virg($_POST['a8']);
$li8 = virg($_POST['i8']);
$ma8 = virg($_POST['m8']);
$ci8 = virg($_POST['c8']);
$ge8 = virg($_POST['g8']);
$hi8 = virg($_POST['h8']);
$re8 = virg($_POST['r8']);

//9° ano
$d9 = 4;
//1 bimestre
if (empty($_POST['ef9_1'])) {
    $ef9_1 = 0;
    $d9 -= 1;
} else {
    $ef9_1 = $_POST['ef9_1'];
}
$lp9_1 = virg($_POST['lp9_1']);
$m9_1 = virg($_POST['m9_1']);
$h9_1 = virg($_POST['h9_1']);
$g9_1 = virg($_POST['g9_1']);
$c9_1 = virg($_POST['c9_1']);
$i9_1 = virg($_POST['i9_1']);
$a9_1 = virg($_POST['a9_1']);
$r9_1 = virg($_POST['r9_1']);

//2 bimestre
if (empty($_POST['ef9_2'])) {
    $ef9_2 = 0;
    $d9 -= 1;
} else {
    $ef9_2 = $_POST['ef9_2'];
}
$lp9_2 = virg($_POST['lp9_2']);
$m9_2 = virg($_POST['m9_2']);
$h9_2 = virg($_POST['h9_2']);
$g9_2 = virg($_POST['g9_2']);
$c9_2 = virg($_POST['c9_2']);
$i9_2 = virg($_POST['i9_2']);
$a9_2 = virg($_POST['a9_2']);
$r9_2 = virg($_POST['r9_2']);

//3 bimestre
if (empty($_POST['ef9_3'])) {
    $ef9_3 = 0;
    $d9 -= 1;
} else {
    $ef9_3 = $_POST['ef9_3'];
}
$lp9_3 = virg($_POST['lp9_3']);
$m9_3 = virg($_POST['m9_3']);
$h9_3 = virg($_POST['h9_3']);
$g9_3 = virg($_POST['g9_3']);
$c9_3 = virg($_POST['c9_3']);
$i9_3 = virg($_POST['i9_3']);
$a9_3 = virg($_POST['a9_3']);
$r9_3 = virg($_POST['r9_3']);

$n9 = 4;
//4 bimestre
if (empty($_POST['ef9_4'])) {
    $ef9_4 = 0;
    $d9 -= 1;
} else {
    $ef9_4 = $_POST['ef9_4'];
}

if (isset($_POST['lp9_4']) && !empty($_POST['lp9_4'])) {
    $lp9_4 = virg($_POST['lp9_4']);
} else {
    // Ação caso 'lp9_4' não esteja definido ou esteja vazio
    $lp9_4 = 0;
    $n9 = 3;
}

if (isset($_POST['m9_4']) && !empty($_POST['m9_4'])) {
    $m9_4 = virg($_POST['m9_4']);
} else {
    // Ação caso 'm9_4' não esteja definido ou esteja vazio
    $m9_4 = 0;
}

if (isset($_POST['h9_4']) && !empty($_POST['h9_4'])) {
    $h9_4 = virg($_POST['h9_4']);
} else {
    // Ação caso 'h9_4' não esteja definido ou esteja vazio
    $h9_4 = 0;
}

if (isset($_POST['g9_4']) && !empty($_POST['g9_4'])) {
    $g9_4 = virg($_POST['g9_4']);
} else {
    // Ação caso 'g9_4' não esteja definido ou esteja vazio
    $g9_4 = 0;
}

if (isset($_POST['c9_4']) && !empty($_POST['c9_4'])) {
    $c9_4 = virg($_POST['c9_4']);
} else {
    // Ação caso 'c9_4' não esteja definido ou esteja vazio
    $c9_4 = 0;
}

if (isset($_POST['i9_4']) && !empty($_POST['i9_4'])) {
    $i9_4 = virg($_POST['i9_4']);
} else {
    // Ação caso 'i9_4' não esteja definido ou esteja vazio
    $i9_4 = 0;
}

if (isset($_POST['a9_4']) && !empty($_POST['a9_4'])) {
    $a9_4 = virg($_POST['a9_4']);
} else {
    // Ação caso 'a9_4' não esteja definido ou esteja vazio
    $a9_4 = 0;
}

if (isset($_POST['ef9_4']) && !empty($_POST['ef9_4'])) {
    $ef9_4 = virg($_POST['ef9_4']);
} else {
    // Ação caso 'ef9_4' não esteja definido ou esteja vazio
    $ef9_4 = 0;
}

if (isset($_POST['r9_4']) && !empty($_POST['r9_4'])) {
    $r9_4 = virg($_POST['r9_4']);
} else {
    $r9_4 = 0;
}

//media das materias do nono ano
if ($d9 == 0) {

    $ef9 = 1;
} else {

    $ef9 = ((float)$ef9_1 + (float)$ef9_2 + (float)$ef9_3 + (float)$ef9_4) / $d9;
}
$lp9 = ($lp9_1 + $lp9_2 + $lp9_3 + $lp9_4) / $n9;
$ma9 = ($m9_1 + $m9_2 + $m9_3 + $m9_4) / $n9;
$hi9 = ($h9_1 + $h9_2 + $h9_3 + $h9_4) / $n9;
$ge9 = ($g9_1 + $g9_2 + $g9_3 + $g9_4) / $n9;
$ci9 = ($c9_1 + $c9_2 + $c9_3 + $c9_4) / $n9;
$li9 = ($i9_1 + $i9_2 + $i9_3 + $i9_4) / $n9;
$ar9 = ($a9_1 + $a9_2 + $a9_3 + $a9_4) / $n9;
$re9 = ($r9_1 + $r9_2 + $r9_3 + $r9_4) / $n9;

//Média de todos os anos
$ef = ((float)$ef6 + (float)$ef7 + (float)$ef8 + (float)$ef9) / $d;
$lp = ($lp6 + $lp7 + $lp8 + $lp9) / 4;
$ar = ($ar6 + $ar7 + $ar8 + $ar9) / 4;
$li = ($li6 + $li7 + $li8 + $li9) / 4;
$ma = ($ma6 + $ma7 + $ma8 + $ma9) / 4;
$ci = ($ci6 + $ci7 + $ci8 + $ci9) / 4;
$ge = ($ge6 + $ge7 + $ge8 + $ge9) / 4;
$hi = ($hi6 + $hi7 + $hi8 + $hi9) / 4;
$re = ($re6 + $re7 + $re8 + $re9) / 4;

if ($ef == 0) {

    $media = ($lp + $ar + $li + $ma + $ci + $ge + $hi + $re) / 8;

    require_once('../models/model.php');
    $model = new model_usuario();
    $test = $model->cadastrar2($nome, $c1, $c2, $dn, $lp, $ar, $li, $ma, $ci, $ge, $hi, $re, $bairro, $publica, $pcd, $media);
} else {

    $media = ($lp + $ar + $ef + $li + $ma + $ci + $ge + $hi + $re) / 9;

    require_once('../models/model.php');
    $model = new model_usuario();
    $test = $model->cadastrar($nome, $c1, $c2, $dn, $lp, $ar, $ef, $li, $ma, $ci, $ge, $hi, $re, $bairro, $publica, $pcd, $media);
}

switch ($test) {
    case 'candidato cadastrado com sucesso':

        header('location:../views/success.php');
        break;

    case 'ERRO ao cadastrar a nota':

        header('location:../views/inicio.php?erro_nota');
        break;

    case 'ERRO ao cadastrar o candidato':

        header('location:../views/inicio.php?erro_candidato');
        break;
    default:

        header('location:../views/inicio.php');
        break;
}
