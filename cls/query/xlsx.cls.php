<?php
class query_xlsx_cls extends query_cls {
   
    public function config($allAssoc = false, $title = "Untitled" ,$filename = "Untitled" , $fieltype = "csv") {
       
        header('Content-Type: text/html; charset=utf-8'); 
        header("Content-Disposition: attachment; filename=$filename.$fieltype");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
       
        //define separator (defines columns in excel & tabs in word)
        $sep = ($fieltype == "csv") ? "\t" : "\t\t\t";
        $newline = "\n";

        echo $sep;
        echo $title;
        echo $newline;
        
        //start of printing column names 
        foreach ($allAssoc[0] as $key => $value) {
            print(($key));
            echo  $sep;
        }
        print($newline); 

        foreach ($allAssoc as $key => $value) {
            if(is_array($value)){

                foreach ($value as $k => $v) {
                        print(($v) . $sep);
                }
                print $newline;
            }
        }
        print $newline;
        exit();
    }
}
?>