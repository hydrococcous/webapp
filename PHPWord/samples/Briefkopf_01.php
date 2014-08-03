<?php
include_once 'Sample_Header.php';

// New Word document
//echo date('H:i:s') , " Create new PhpWord object" , EOL;
$phpWord = new \PhpOffice\PhpWord\PhpWord();

$document = $phpWord->loadTemplate('resources/Briefkopf_01.docx');

$foobar = $_GET['foobar'];

$document->setValue('Vorname', $foobar);
$document->setValue('Name', 'Birke');
$document->setValue('Strasse', 'Franz-Arnold-Strasse');
$document->setValue('Nummer', '52');
$document->setValue('PLZ', '70736');
$document->setValue('Ort', 'Fellbach');

$name = 'Briefkopf_01.docx';
//echo date('H:i:s'), " Write to Word2007 format", EOL;
$document->saveAs($name);
rename($name, "results/{$name}");

//echo getEndingNotes(array('Word2007' => 'docx'));
if (!CLI) {
    #include_once 'Sample_Footer.php';
}
