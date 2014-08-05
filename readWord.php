<?php
    // http://blogs.msdn.com/b/brian_jones/archive/2005/07/05/intro-to-word-xml-part-1-simple-word-document.aspx
    // http://www.data2type.de/xml-xslt-xslfo/wordml/wordml-einfuehrung/inzeilige-elemente/

    function docx2text($filename) {
        return readZippedXML($filename, "word/document.xml");
    }

    function readZippedXML($archiveFile, $dataFile) {
        // Create new ZIP archive
        $zip = new ZipArchive;

        // Open received archive file
        if (true === $zip->open($archiveFile)) {
            // If done, search for the data file in the archive
            if (($index = $zip->locateName($dataFile)) !== false) {
                // If found, read it to the string
                $data = $zip->getFromIndex($index);
                $xml = $zip->getFromName("word/document.xml");
                // Close archive file
                $zip->close();
                // Load XML from a string
                // Skip errors and warnings
                # $xml = DOMDocument::loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                // Return data without XML formatting tags
                return $xml;
                }
            $zip->close();
            }

            // In case of failure return empty string
            return "Fehler";
        }
        
        
    $xmlStr = docx2text("results/brief_beispiel_04-08-14-20-56-00.docx");

    $parser = xml_parser_create();
    xml_parse_into_struct($parser, $xmlStr, $values, $index);
    xml_parser_free($parser);

    $html = '';
    $format = false;

    function openFormat($fmt){
        switch($fmt){

            case "W:B";
                return '<strong>';
                break;
            default:
                return false;
        }
    }

    foreach($values as $value){

        // öffnenden Paragraf finden
        if($value['tag'] == 'W:P' && $value['type'] == 'open'){
            $html .= '<p>';
        }

        // Format öffnen
        if($value['tag'] == 'W:B' && $value['type'] == 'complete' && $format === false){
            $html .= openFormat($value['tag']);
            $closeTag = '</strong>';
            $format = true;
        }

        // Textinhalt finden und schreiben
        if($value['tag'] == 'W:T'){

            // Prüfen ob tatsächlich ein Textinhalt existiert
            if(array_key_exists('value',$value)){
                $html .= $value['value'];
                } else {
                    $html .= '';
                }

            // Format schließen
            if($format === true){
                $html .= $closeTag;
                $format = false;
            }
        }

        // Line-Brak finden
        if($value['tag'] == 'W:P' && $value['type'] == 'close'){
            $html .= '</p>'."\n";
        }

        // schließenden Paragraf finden
        if($value['tag'] == 'W:BR' && $value['type'] == 'complete'){
            $html .= '</br>'."\n";
        }   

        #echo '<pre>';
        #print_r($value);
        #echo '</pre><hr />';  
    }

    echo $html;
    
?>