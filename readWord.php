<?php
    // http://blogs.msdn.com/b/brian_jones/archive/2005/07/05/intro-to-word-xml-part-1-simple-word-document.aspx

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
        
        
    $xmlStr = docx2text("results/brief_beispiel_04-08-14-20-56-00.docx"); // Save this contents to file
    
//    $tmpFile = tempnam('results/','tmp_');
//    $handle = fopen($tmpFile,'w');
//    fwrite($handle, $xmlStr);
//    fclose($handle);
//    rename($tmpFile,$tmpFile.'.xml');
//    
//    $xml = simplexml_load_file($tmpFile.'.xml');
//    var_dump($xml);
    

$p = xml_parser_create();
xml_parse_into_struct($p, $xmlStr, $vals, $index);
xml_parser_free($p);
echo '<pre>';
echo "Index array\n";
print_r($index);
echo "\nVals array\n";
print_r($vals);
echo '</pre>';
    
?>