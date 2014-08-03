<?php
    // PHPWord einbinden
    include_once 'PHPWord/samples/Sample_Header.php';
    
    // Neues Word-Dokument
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $document = $phpWord->loadTemplate('vorlagen/brief_beispiel.docx');
    
    // Marker befüllen
    $document->setValue('Vorname','Sandro');
    $document->setValue('Name','Birke');
    $document->setValue('Strasse','Franz-Arnold-Str.');
    $document->setValue('Nummer','52');
    $document->setValue('PLZ','70736');
    $document->setValue('Ort','Fellbach');
    $document->setValue('Betreff','Testdokument');
    $document->setValue('Text','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi');
    $document->setValue('Grussformel','Mit freundlichen Grüßen');
    
    $name = 'brief_beispiel.docx';

    $document->saveAs($name);
    rename($name, "results/{$name}");
?>
