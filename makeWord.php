<?php
    
    // PHPWord einbinden
    include_once 'PHPWord/samples/Sample_Header.php';
    
    // Neues Word-Dokument
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $document = $phpWord->loadTemplate('vorlagen/brief_beispiel.docx');
?>

<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$post_data = filter_input_array(INPUT_POST);
$now =  date('d-m-y-H-i-s');

$section = $phpWord->addSection();



if(isset($post_data['write'])){
    //var_dump($post_data);
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
    $datname = 'brief_beispiel_'.$now.'.docx';

    $document->saveAs($datname);
    rename($datname, "results/{$datname}");
}  
 
?>

<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <!--<meta name="viewport" content="width=device-width; initial-scale=1"/>-->
        <title>Präsentation WebApp</title>

        <!-- Bootstrap einbinden -->
        <link href="bootstrap-3.1.1/css/bootstrap.min.css" rel="stylesheet" />

        <!-- HTML5 Shim und Respond.js einbinden -->
        <!-- HTML5 und Responive-Unterstützung für Internetexplorer kleiner als IE9 -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Custom StyleSheet -->
<link href="css/fonts.css" rel="stylesheet" />
<link href="css/custom.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>
<body class="index">

        <div class="navbar-wrapper">
                <div class="container">
                <!-- Navigation - START -->
                <nav class="navbar navbar-inverse" role="navigation">
                        <div class="container-fluid">
                                <div class="navbar-header">
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                                <span class="sr-only">Navigation</span>	
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                        </button>
                                        <a href="/webapp" class="navbar-brand">Einleitung</a>
                                </div>
                                <div class="navbar-collapse collapse">
                                        <ul class="nav navbar-nav navbar-left">
                                                <li><a href="moeglichkeiten.html">Möglichkeiten</a></li>
                                                <li><a href="#">Link</a></li>
                                                <li><a href="#">Link</a></li>
                                        </ul>
                                </div>
                        </div>
                </nav>
                <!-- Navigation - ENDE -->
        </div>
        </div>

        <div class="container">

            <div class="jumbotron margTop">
                
                <div class="row">
                    
                    <div class="col-sm-7">
                        
                        <h2>Word-Dokument erstellen</h2>  
                    
                    </div>
                    
                    <div class="col-sm-3">
                        
                        <h2>
                            <?php if(isset($name)){ ?><a class="btn btn-lg btn-primary" href="<?php  echo 'results/'.$datname; ?>"><?php echo $datname; ?></a></h2><span><?php echo $datname ?></span><?php }?>
                        
                        
                    </div>
                    
                </div>
                

                
                <form id="wordform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    
                    <div class="row">
                        
                        <div class="col-sm-3">
                            <label>Vorname:</label>
                            <input class="form-control" name="vorname" id="vorname" value="<?php echo $vorname ?>" type="text" />
                        </div>
                        <div class="col-sm-3">
                            <label>Name:</label>
                            <input class="form-control" name="name" id="name" value="<?php echo $name ?>" type="text" />
                        </div>
                        
                    </div>
                        
                    <div class="row">
                        
                        <div class="col-sm-5">
                            <label>Straße:</label>
                            <input class="form-control" name="strasse" id="strasse" value="<?php echo $strasse ?>" type="text" />  
                        </div>
                        <div class="col-sm-1">
                           <label>Nr:</label>
                            <input class="form-control" name="hausnummer" id="hausnummer" value="<?php echo $hausnummer ?>" type="text" /> 
                        </div>
                        
                    </div> 
                    
                    <div class="row">
                        
                        <div class="col-sm-2">
                            <label>PLZ:</label>
                            <input class="form-control" name="plz" id="plz" value="<?php echo $plz ?>" type="text" />   
                        </div>
                        <div class="col-sm-4">
                            <label>Ort:</label>
                            <input class="form-control" name="ort" id="ort" value="<?php echo $ort ?>" type="text" /> 
                        </div>
                        
                    </div> 

                    <div class="row">
                        
                        <div class="col-sm-6">
                            <label>Betreff:</label>
                            <input class="form-control"  name="betreff" id="betreff" value="<?php echo $betreff ?>" type="text" />   
                        </div>
                        
                    </div> 
                    
                    <div class="row">

                        <div class="col-sm-8">
                            <label>Text:</label>
                            <textarea class="form-control"  name="text" id="text" rows="10"><?php echo $text ?></textarea>
                        </div>
                        
                    </div> 
                        
                    <div class="row">

                        <div class="col-sm-8">
                            <label>Grußformel:</label>
                            <input class="form-control"  name="gruesse" id="gruesse" value="<?php echo $gruesse ?>" type="text" />
                        </div>
                        
                    </div>
                    
                    
                    <div class="row">

                        <div class="col-sm-8">
                            <br />
                            <button type="submit" class="btn btn-default" id="write" name="write">Dokument erstellen</button>
                            <br />
                            <br />
                        </div>
                        
                    </div>    

                </form>
            </div>	

        </div>


        <!-- jQuery einbinden -->
        <script src="js/jquery/1.11.0/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="bootstrap-3.1.1/js/bootstrap.min.js"></script>


</body>
</html>
