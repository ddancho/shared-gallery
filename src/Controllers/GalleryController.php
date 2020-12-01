<?php

namespace App\Controllers;

use App\Core\Controller;

class GalleryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function gallery()
    {
        return $this->render("Gallery/gallery");
    }
}
