<?php
    // PHPWord einbinden
    include_once 'PHPWord/samples/Sample_Header.php';
    
    // Neues Word-Dokument
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $document = $phpWord->loadTemplate('vorlagen/brief_beispiel.docx');
?>

<html>
    <head>
        <meta charset="utf-8" />
        <title>Word schreiben</title>
        
    </head>
    
    <body>
      
        <style>
        
            LABEL,INPUT{
                display: block;
            }
            
            DIV.formbox{
                float:left
            }
            
            INPUT.short{
                width: 60px;
            }
            
            .long{
                width:600px;
            }
            
        </style>
        
        <form id="wordform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            
            
            <label>Vorname:</label>
            <input name="vorname" id="vorname" value="" type="text" />
            
            <label>Name:</label>
            <input name="name" id="name" value="" type="text" />
            
            <div class="formbox">
                <label>Straße:</label>
                <input name="strasse" id="strasse" value="" type="text" />
            </div>
            <div class="formbox">
                <label>Nr:</label>
                <input class="short" name="hausnummer" id="hausnummer" value="" type="text" />
            </div><br clear="all" />
            <div class="formbox">
                <label>PLZ:</label>
                <input class="short" name="plz" id="plz" value="" type="text" />
            </div> 
            <div class="formbox">
                <label>Ort:</label>
                <input name="ort" id="ort" value="" type="text" />
            </div><br clear="all" />
            
            <label>Betreff:</label>
            <input class="long"  name="betreff" id="betreff" value="" type="text" />
            
            <label>Text:</label>
            <textarea  name="text" id="text" class="long" rows="10"></textarea>
            
            <label>Grußformel:</label>
            <input class="long"  name="gruesse" id="gruesse" value="" type="text" />
            
            <br />

            <input type="submit" id="write" name="write" value="Dokument erstellen" />
            
        </form>
        
    </body>
    
</html>

<?php

$post_data = filter_input_array(INPUT_POST);
$now =  date('d-m-y-H-i-s');

$section = $phpWord->addSection();

if($post_data['write']){
    
    $vorname = $post_data['vorname'];
    $name = $post_data['name'];
    $strasse = $post_data['strasse'];
    $hausnummer = $post_data['hausnummer'];
    $plz = $post_data['plz'];
    $ort = $post_data['ort'];
    $betreff = $post_data['betreff'];
    $text = $post_data['text'];
    $gruesse = $post_data['gruesse'];    
    
    // Marker befüllen
    $document->setValue('Vorname',$vorname);
    $document->setValue('Name',$name);
    $document->setValue('Strasse',$strasse);
    $document->setValue('Nummer',$hausnummer);
    $document->setValue('PLZ',$plz);
    $document->setValue('Ort',$ort);
    $document->setValue('Betreff',$betreff);
    $document->setValue('Text',$text);
    $document->setValue('Grussformel',$gruesse); 
    $name = 'brief_beispiel_'.$now.'.docx';

    $document->saveAs($name);
    rename($name, "results/{$name}");
}  
 
?>
