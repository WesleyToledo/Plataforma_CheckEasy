<?php
header("Content-type: image/jpeg"); //Informa ao browser que o arquivo é uma imagem no formato JPG

$num_questoes = 10;
$alternativas = 5;
$tamanho_imgs = 500;
$im = imagecreatetruecolor( $tamanho_imgs * $alternativas + 1100, $tamanho_imgs * $num_questoes + 1200 );
$background_color = imagecolorallocate($im, 255,255,255); 
$preto = imagecolorallocate($im, 0,0,0); 
imagefill($im, 0, 0, $background_color);
    
$lim = imagecreatefrompng("circle.png");
$letra = imagecreatefrompng("A.png");

ImageFilledRectangle($im, 0, 0, $tamanho_imgs * $alternativas + 1100, $tamanho_imgs * $num_questoes + 1200, $preto);
ImageFilledRectangle($im, 100, 100, $tamanho_imgs * $alternativas + 1000, $tamanho_imgs * $num_questoes + 1100, $background_color);

//$alternativas = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

$margemSuperior = 0;
//cabeçalho alternativas
for($alt = 1;$alt<=$alternativas;$alt++){
        $x = $alt*$tamanho_imgs;
        imagecopy( $im, $letra, $x + 400,250, 0, 0, $tamanho_imgs, $tamanho_imgs ); 
    }
//corpo gabarito
for($question = 1;$question<=$num_questoes;$question++){
    $y = $question * $tamanho_imgs;
    
    imagecopy( $im, $letra, 200, $y + 400, 0, 0, $tamanho_imgs, $tamanho_imgs );
    for($alt = 1;$alt<=$alternativas;$alt++){
        $x = $alt*$tamanho_imgs;
        imagecopy( $im, $lim, $x + 400, $y + 400, 0, 0, $tamanho_imgs, $tamanho_imgs ); 
    }
}

imagedestroy( $lim );
header('Content-Type: image/jpeg');

imagejpeg($im); //Converte a imagem para um JPEG e a envia para o browser
ImageDestroy($imagem); //Destrói a memória alocada para a construção da imagem JEPG
?>