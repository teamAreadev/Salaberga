<?php
if (isset($_POST['estante']) && isset($_POST['prateleira']) && !empty($_POST['estante']) && !empty($_POST['prateleira'])) {

    $estante = $_POST['estante'];
    $prateleira = $_POST['prateleira'];

    header('Location: ../views/QRCode/QRCodes.php?estante=' . $estante . '&prateleira=p' . $prateleira);
}

?>