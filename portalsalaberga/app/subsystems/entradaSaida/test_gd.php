<?php
if (function_exists('imagecreate')) {
    $imgW = 100;
    $imgH = 100;
    $base_image = imagecreate($imgW, $imgH);
    if ($base_image) {
        echo "Imagem criada com sucesso!";
        imagedestroy($base_image);
    } else {
        echo "Falha ao criar a imagem.";
    }
} else {
    echo "A função imagecreate() não está disponível.";
}
?>