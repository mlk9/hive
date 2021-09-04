<?php

namespace App\Languages;

use Hive\Language\LanguageInterface;

class EnglishLanguage implements LanguageInterface
{

    public $phrases = [];
    public $words = [];

    public function phrases()
    {
        // $data[] = "";
        $this->phrases['hello_world'] = "Hello World";
        $this->phrases['github'] = "Github";
    }

    public function words()
    {
        $this->words['error'] = "error";
    }

}