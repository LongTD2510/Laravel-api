<?php
namespace App\Http\Services;

use App\Consts;
use App\Models\Title;

class TitleService
{
    public function getTitle()
    {
        return Title::paginate(Consts::PAGINATE_PAGE);
    }
}
