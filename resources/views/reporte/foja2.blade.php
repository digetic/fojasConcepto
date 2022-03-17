<?php
use Dompdf\Dompdf; //para incluir el namespace de la librería
 
 $dompdf = new Dompdf(); //crear el objeto de la clase Dompdf
//panorámico en A4
//$dompdf->setPaper('A4', 'landscape');
//$dompdf->setPaper( array(0, 0, 595.28, 841.89)); //x inicio, y inicio, ancho final, alto final
//$dompdf->setPaper(array(0, 0, 612.00, 935.433), 'landscape');
$dompdf->setPaper(array(0,0,612.00,1008.00), 'portrait');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <h1>Hola PDF</h1>
    {{-- @foreach ($notas as $item )
        <p> {{$item['pre']}}  // {{$item['n1']}}  // {{$item['n2']}} // {{$item['n3']}}</p> <br>
    @endforeach --}}
    {{-- @foreach ($n2 as $item )
    <p>{{$item}}</p> <br>
@endforeach --}}
    {{-- <p>{{$evalu}}</p> --}}
        <p>{{$conceptual2['literal']}}</p>

       
</body>
</html>