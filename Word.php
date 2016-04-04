<?php

namespace Word;

class Word
{
    public static $instance;

    public $headers = array(
        'Content-Description' => 'File Transfer',
        'Content-Disposition' => 'attachment; filename=',
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'Content-Transfer-Encoding' => 'binary',
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
        'Expires' => '0',
    );

    public $fileName = 'file';

    public $fileExtension = 'docx';

    public $style = '';

    public $br = '<br style="page-break-before:always" />';

    public $content = '';

    public $space = '&nbsp;';

    public $replacedSpace = '&#32;';

    public static function getInstance() {

        if(empty(self::$instance))
            self::$instance = new Word();

        return self::$instance;
    }

    public function sendHeaders() {

        foreach($this->headers as $header => $value) {

            //set file name
            switch($header) {
                case 'Content-Disposition' :
                    header($header . ': ' . $value . '"' . $this->fileName . '.' . $this->fileExtension . '"');
                    break;
                default:
                    header($header . ': ' . $value );
                    break;
            }
        }
    }

    public function setList() {

        if(is_array($this->content)) {

            $lists = '';
            foreach($this->content as $list)
                $lists .= $list . $this->br;

            $this->content = $lists;
        }
    }

    public function replaceSpace() {

        $this->content = str_replace($this->space, $this->replacedSpace, $this->content);
    }

    public function send($content = '') {

        try {

            $this->sendHeaders();

            if(!empty($content))
                $this->content = $content;

            //if content is array
            $this->setList();

            $this->replaceSpace();

            echo '<style type="text/css">' . $this->style . '</style>' . $this->content;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}