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
        
    $post_data = filter_input_array(INPUT_POST);
    
    $xmlStr = docx2text("results/".$post_data['dat']);

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

    #echo $html;
    
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

                                </div>
                                <div class="navbar-collapse collapse">
                                        <form class="navbar-form navbar-right">
                                                <div class="form-group"></div>
                                                <button class="btn btn-default" id="close">Close</button>
                                        </form>
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
                        
                        <h2>Word-Dokument lesen</h2>  
                    
                    </div>
                    
                    <div class="col-sm-3">
                        
                        <form method="post">
                            <br />
                            <input class="form-control" name="dat" id="dat" value="" type="text" />
                            <button type="submit" class="btn btn-default" id="write" name="write">Dokument lesen</button>

                        </form>
                        
                    </div>
                    <div class="col-sm-12" style="background: #fff; margin-top:20px; border-radius: 10px; padding: 20px;">

                        <?php if(isset($post_data['dat'])) echo $html ?>
                    
                    </div>
                    
                    <div class="col-sm-12">
                        
                        <h2></h2>
                    
                    </div>
                    
                </div>

            </div>	

        </div>


        <!-- jQuery einbinden -->
        <script src="js/jquery/1.11.0/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="bootstrap-3.1.1/js/bootstrap.min.js"></script>
           <script>
            $(document).ready(function(){
                
              $(document).on('click', '#close', function(){
                    window.close();
                });
            });
        
        </script>


</body>
</html>
