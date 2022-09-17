    <?php

        function left($str, $n){

            $strleft = substr($str,0,  $n);

            return $strleft;
        }

        function right($str, $n){

            $n = $n * (-1);
            $strright = substr($str, $n);

            return $strright;
        }


        $cpf=  $_POST['ncpf'];

        echo "CPF informado: " . $cpf;

        echo "<br><br>";

        $i = 0;            /* utilizada nos laços For */
        $strcampo = '';    /* armazena do CPF que será utilizada para o cálculo */
        $strCaracter = ''; /* armazena os digitos do CPF da direita para a esquerda */
        $intNumero = 0;    /* armazena o digito separado para cálculo (uma a um) */
        $intMais = 0;      /* armazena o digito específico multiplicado pela sua base */
        $lngSoma = 0;      /* armazena a soma dos digitos multiplicados pela sua base(intmais) */
        $dblDivisao = 0;   /* armazena a divisão dos digitos*base por 11 */
        $lngInteiro = 0;   /* armazena inteiro da divisão */
        $intResto = 0;     /* armazena o resto */
        $intDig1 = 0;      /* armazena o 1º digito verificador */
        $intDig2 = 0;      /* armazena o 2º digito verificador */
        $strConf = 0;      /* armazena o digito verificador */

        $cpf = $cpf . ''; //certifica-se ser string

        //Retira caracteres não numéricos
        $cpf = preg_replace("/[^0-9]/","", $cpf); //preg_replace — Realiza uma pesquisa por uma expressão regular e a substitui
        echo "&nbsp;&nbsp;&nbsp;&nbsp;CPF (Parte numérica): " . $cpf; 

        if(strlen($cpf) != 11)
            {
                echo "<div  style='background:red;color:white;'>";
                    echo "<br><p  style='margin:15px;'><strong>Documento NÃO atende aos critérios de validação.</strong></p><br>";
                echo"</div>";   
            }
        else{
            /*Inicia cálculos do 1º dígito*/
            $strcampo = left($cpf, 9);
            for($i=2;$i < 11;$i++){
                $strCaracter = right($strcampo, $i - 1);
                $intNumero = intval(left($strCaracter, 1));
                $intMais = $intNumero * $i;
                $lngSoma = $lngSoma + $intMais;
            }
    
            $dblDivisao = $lngSoma / 11;
            //Tem também as funções ceil() e floor() que arredondam um número sempre para cima e sempre para baixo, 
            $lngInteiro = floor($dblDivisao) * 11;
            $intResto = $lngSoma - $lngInteiro;

            if ($intResto == 0 || $intResto == 1)
                {$intDig1 = 0;}
            else
                {$intDig1 = 11 - $intResto;}

            $strcampo = $strcampo . $intDig1 . '';   /*concatena o CPF com o primeiro digito verificador */

            $intDig1 = $intDig1 . "";

            //echo "<br>";
            //echo "&nbsp;&nbsp;&nbsp;&nbsp;O primeiro dígito precisa ser: " . $intDig1;

            /*Inicia cálculos do 2º dígito*/
            $lngSoma = 0;
            $intNumero = 0;
            $intMais = 0;
              
            for($i=2; $i < 12; $i++){
                $strCaracter = right($strcampo, $i - 1);
                $intNumero =left($strCaracter, 1);
                $intMais = $intNumero * $i;
                $lngSoma = $lngSoma + $intMais;
            }

            $dblDivisao = $lngSoma / 11;
            $lngInteiro = floor($dblDivisao) * 11;
            $intResto = $lngSoma - $lngInteiro;
            if ($intResto == 0 || $intResto == 1){
                $intDig2 = '0';
            }
            else{
                $intDig2 = 11 - $intResto;
                $intDig2 = $intDig2 . '';
            }

            //echo "<br>";
            //echo "&nbsp;&nbsp;&nbsp;&nbsp;O segundo dígito precisa ser: " . $intDig2;

            /*Concatena o 1º dígito e o 2º dígito*/                       
            $strConf = $intDig1 . $intDig2 . '';

            echo "<br>";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;O dígito verificador precisa ser: " . $strConf;

            $strDig = right($cpf, 2) . '';

            echo "<br><br>";
            if ($strConf == $strDig){
                echo "<div  style='background:lightgreen;'>";
                    echo "<br><p  style='margin:15px;'><strong>Documento ATENDE aos critérios de validação.</strong></p><br>";

                echo"</div>";
            }
            else
            {
                echo "<div  style='background:red;color:white;'>";
                    echo "<br><p  style='margin:15px;'><strong>Documento NÃO atende aos critérios de validação.</strong></p><br>";
                echo"</div>";                
            }
        }

    ?>