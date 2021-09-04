<? 

namespace App\Languages;

use Hive\LanguageInterface;

class PersianLanguage implements LanguageInterface
{
    public function phrases()
    {
        // $data[] = "";
        self::$data['hello-world'] = "سلام دنیا";
    }

    public function words()
    {
        self::$data['error'] = "خطا";
    }
}