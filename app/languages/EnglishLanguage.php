<?php

namespace App\Languages;

class EnglishLanguage implements LanguageInterface
{

    public function phrases()
    {
        // $data[] = "";
        self::$data['hello-world'] = "Hello World";
    }

    public function words()
    {
        // $data[] = "";
        self::$data['error'] = "error";
    }

}