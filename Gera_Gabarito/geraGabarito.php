<?php
function geraGabarito($nomeAvaliacao,$num_questoes,$alternativas){
    $tamanho_imgs = 125;
    $im = imagecreatetruecolor( $tamanho_imgs * $alternativas + 170, $tamanho_imgs * $num_questoes + 200 );
    $background_color = imagecolorallocate($im, 255,255,255); 
    $preto = imagecolorallocate($im, 0,0,0); 
    imagefill($im, 0, 0, $background_color);

    $lim = imagecreatefrompng("alter.png");

    ImageFilledRectangle($im, 0, 0, $tamanho_imgs * $alternativas + 170, $tamanho_imgs * $num_questoes + 200, $preto);
    ImageFilledRectangle($im, 20, 20, $tamanho_imgs * $alternativas + 150, $tamanho_imgs * $num_questoes + 180, $background_color);

    $alternativasA = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

    $margemSuperior = 0;
    //cabeçalho alternativas
    for($alt = 1;$alt<=$alternativas;$alt++){
            $x = $alt*$tamanho_imgs;
            $nome = strtoupper($alternativasA[($alt-1)]);
            $letra = imagecreatefrompng($nome.".png");
            imagecopy( $im, $letra, $x + 10,$tamanho_imgs - 100, 0, 0, $tamanho_imgs, $tamanho_imgs ); 
        }

    //corpo gabarito
    for($question = 1;$question<=$num_questoes;$question++){
        $y = $question * $tamanho_imgs;

        if($question<10){    
            $num = imagecreatefrompng($question.".png"); 
            imagecopy( $im, $num ,20, $y + 20, 0, 0, $tamanho_imgs, $tamanho_imgs );

        }else{
            $numero = "".$question;
            $num1 = substr($numero,0,1);  
            $num2 = substr($numero,-1,1);  

            $num1Img = imagecreatefrompng($num1.".png"); 
            imagecopy( $im, $num1Img , -5, $y + 20, 0, 0, $tamanho_imgs, $tamanho_imgs );

            $num2Img = imagecreatefrompng($num2.".png"); 
            imagecopy( $im, $num2Img , 35, $y + 20, 0, 0, $tamanho_imgs, $tamanho_imgs );

        }

        for($alt = 1;$alt<=$alternativas;$alt++){
            $x = $alt*$tamanho_imgs;
            imagecopy( $im, $lim, $x + 10, $y + 20, 0, 0, $tamanho_imgs, $tamanho_imgs ); 
        }
    }

    imagedestroy( $lim );

     header("Content-Disposition: attachment; filename=\"".$nomeAvaliacao."_Gabarito.jpg\";");
        header('Content-Type: image/jpeg');
        imagejpeg($im);
        imageDestroy($im);

}

geraGabarito($_GET['nome'],$_GET['num_questoes'],$_GET['num_alternativas']);

?>