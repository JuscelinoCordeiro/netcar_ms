<?php
require_once __DIR__ .'/vendor/autoload.php';

if(isset($_POST)){
    $conteudo = $_POST['conteudo'];
}
$mpdf = new \Mpdf\Mpdf();
//$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->WriteHTML($conteudo);
return $mpdf->Output();
