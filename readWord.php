<?php
    
    /**
     * Quelle: http://www.jackreichert.com/2012/11/09/how-to-convert-docx-to-html/
     * Quelle: http://webcheatsheet.com/php/reading_the_clean_text_from_docx_odt.php
     */
    
    /**
     * Quell-Datei
     */
    $xmlFile = "results/brief_beispiel_04-08-14-14-36-52.docx";
    
    /**
     * DOCX entpacken
     */
    function unzipDOCX($file){
        $zip = new ZipArchive;
        
        if($zip->open($file) === true){

            $index =  $zip->locateName("word/document.xml");

            if($index !== false){

                $data = $zip->getFromIndex($index);
                $zip->close();

            }

           return $data;

        } else {
            return 'Fehler beim öffnen!';
        }
    }
    
    $xmlString = unzipDOCX($xmlFile);
    echo $xmlString;
    
    
    


?>