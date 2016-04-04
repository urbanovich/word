
    module_load_include('php', 'word', 'libs/Word/bootstrap');

    $word = new \Word\Word();
    $word->fileName = $node->title;
    $word->style = '* {font-family: Arial; font-size: 10pt;}
                a.NoteRef {text-decoration: none;}
                hr {height: 1px; padding: 0; margin: 1em 0; border: 0; border-top: 1px solid #CCC;}
                table {border: 1px solid black; border-spacing: 0px; width: 100%;}
                td {border: 1px solid black;}
                .rtecenter {
                    text-align: center;
                }';

    foreach($node as $field => $text) {
        if(strpos($field, 'field_') === 0) {
            if(isset($text['und'][0]['value'])) {
                $word->content[] = token_replace($text['und'][0]['value'], array('node' => $node));
            }
        }
    }

    $word->send();