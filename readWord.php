<?php
    // PHPWord einbinden
    include_once 'PHPWord/samples/Sample_Header.php';

    // Read contents

    $source = "results/brief_beispiel.docx";

    echo date('H:i:s'), " Reading contents from `{$source}`", EOL;
    $phpWord = \PhpOffice\PhpWord\IOFactory::load($source);
    var_dump($phpWord);
    // Save file
    #echo write($phpWord, basename(__FILE__, '.php'), $writers);
    if (!CLI) {
        #include_once 'Sample_Footer.php';
    }
?>