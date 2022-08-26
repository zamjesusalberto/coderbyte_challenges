<?php
/*
* Coderbyte
* Strinng Challenge Alphabet Run Encryption 
* Autor Jesus Zambrano
* 26 de Agosto de 2022
* Email zamjesusalberto@gmail.com
*/
class AlphabetRunEncryption
{
    public $right = 'R';
    public $left = 'L';
    public $zero = 'S';
    public $en = 'N';
    public $specials = " RLSN";
    public $alphabet_min ="abcdefghijklmnopqrstuvwxyz";
    public $input="";

    public function __construct($input)
    {
        $this->input = $input;
    }
    public function findSegment($start)
    {
        //$str es el string no el arreglo
        $str = $this->input;
        $piece="";
        $ascending = ord($str[$start])<ord($str[$start-1]);
           
        for ($i= $start; $i >= 0; $i--) {
            $c = $str[$i];
            
            if (strpos($this->specials,$c)==true && strlen($piece) == 0) {
                if ($c == $this->right || $c == $this->left || $c == $this->en) {
                    return $str[$start-1].$str[$start];
                } 
                if ($c == $this->zero) {
                    return substr($str,$start-2, 3);
                }
            }
                        
            if ($i == $start) {
                $piece = $c;
                continue;
            }
            
            $prevC = $str[$i+1];
            
            $posPrevC = strpos($str,$prevC);
            
            if($ascending && $c == $str[$posPrevC+1]){
                $piece = $c.$piece;
            }else if(!$ascending && $c == $str[$posPrevC-1]){
                $piece = $c.$piece;
            }else{
                break;
            }
           
        }

        return $piece;
    }

    
    
    public function exec(){
        
        $result="";
        $str=$this->input;                  
        $chars = str_split($str);
        
        for($i=(count($chars)-1);$i>=0;$i--)
        {
            $piece = $this->findSegment($i);
            
            $decrypt = $this->decrypt($piece);
            
            if($i !=  (count($chars)-1) &&  $result[0] == $decrypt[(strlen($decrypt)- 1)]) {
                $result=substr($decrypt,0, (strlen($decrypt)- 1)).$result;
            } else {
                $result= $decrypt.$result;//result.insert(0, decryption);
            }
           
            $i -=  (strlen($piece) - 1);
            
        }
        return $result;
            
    }

    
    public function decrypt($piece){
        
        if (strpos($piece,$this->right)==true) {
            $c = $piece[0];
            return $this->beforeLetter($c).$this->afterLetter($c);
        }
        if (strpos($piece,$this->left)==true) {
            $c = $piece[0];
            return $this->afterLetter($c).$this->beforeLetter($c);
        }
        if (strpos($piece,$this->zero)==true) {
            return substr($piece,0,2);
        }
        if (strpos($piece,$this->en)==true) {
            $c = substr($piece,0,1);
            return $c.$c;
        }

        $start = $piece[0];
      
        $end = $piece[strlen($piece) - 1];
        
        if (ord($start) > ord($end)) {
            return $this->afterLetter($start).$this->beforeLetter($end);
        }
        return $this->beforeLetter($start). $this->afterLetter($end);
        
    }


    function beforeLetter($letter)
    {
        $pos=strpos($this->alphabet_min,$letter);
        return substr($this->alphabet_min,$pos-1,1);
    }
    function afterLetter($letter)
    {
        $pos=strpos($this->alphabet_min,$letter);
        return substr($this->alphabet_min,$pos+1,1);
    }

   
}

///////// Invocation

function StringChallenge($str){

    $pro = new AlphabetRunEncryption($str);
    
    return $pro->exec();

}

// inputs

//option A
$inputA="bcdefghijklmnopqrstN"; //return att

//option B
$inputB="abSbaSaNbR"; // return abaac



echo StringChallenge($inputA);

//original 
//echo StringChallenge(fgets(fopen('php://stdin','r')));


