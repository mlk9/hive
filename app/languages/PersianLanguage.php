<?php

namespace App\Languages;

use Hive\Language\LanguageInterface;

class PersianLanguage implements LanguageInterface
{
    public $phrases = [];
    public $words = [];

    public function phrases()
    {
        // $data[] = "";
        $this->phrases['hello_world'] = "سلام دنیا";
        $this->phrases['github'] = "گیت هاب";
    }

    public function words()
    {
        $this->words['error'] = "خطا";
    }
}