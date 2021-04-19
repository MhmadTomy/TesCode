<?php
    function terbilang( $num ,$dec=4){
    $stext = array(
        "Nol",
        "Satu",
        "Dua",
        "Tiga",
        "Empat",
        "Lima",
        "Enam",
        "Tujuh",
        "Delapan",
        "Sembilan",
        "Sepuluh",
        "Sebelas"
    );
    $say  = array(
        "Ribu",
        "Juta",
        "Milyar",
        "Triliun",
        "Biliun", // remember limitation of float
        "--apaan---" ///setelah biliun namanya apa?
    );
    $w = "";

    if ($num <0 ) {
        $w  = "Minus ";
        //make positive
        $num *= -1;
    }

    $snum = number_format($num,$dec,",",".");
    die($snum);
    $strnum =  explode(".",substr($snum,0,strrpos($snum,",")));
    //parse decimalnya
    $koma = substr($snum,strrpos($snum,",")+1);

    $isone = substr($num,0,1)  ==1;
    if (count($strnum)==1) {
        $num = $strnum[0];
        switch (strlen($num)) {
            case 1:
            case 2:
                if (!isset($stext[$strnum[0]])){
                    if($num<19){
                        $w .=$stext[substr($num,1)]." Belas";
                    }else{
                        $w .= $stext[substr($num,0,1)]." Puluh ".
                            (intval(substr($num,1))==0 ? "" : $stext[substr($num,1)]);
                    }
                }else{
                    $w .= $stext[$strnum[0]];
                }
                break;
            case 3:
                $w .=  ($isone ? "Seratus" : terbilang(substr($num,0,1)) .
                    " Ratus").
                    " ".(intval(substr($num,1))==0 ? "" : terbilang(substr($num,1)));
                break;
            case 4:
                $w .=  ($isone ? "Seribu" : terbilang(substr($num,0,1)) .
                    " Ribu").
                    " ".(intval(substr($num,1))==0 ? "" : terbilang(substr($num,1)));
                break;
            default:
                break;
        }
    }else{
        $text = $say[count($strnum)-2];
        $w = ($isone && strlen($strnum[0])==1 && count($strnum) <=3? "Se".strtolower($text) : terbilang($strnum[0]).' '.$text);
        array_shift($strnum);
        $i =count($strnum)-2;
        foreach ($strnum as $k=>$v) {
            if (intval($v)) {
                $w.= ' '.terbilang($v).' '.($i >=0 ? $say[$i] : "");
            }
            $i--;
        }
    }
    $w = trim($w);
    if ($dec = intval($koma)) {
        $w .= " Koma ". terbilang($koma);
    }
    return trim($w);
}

?>