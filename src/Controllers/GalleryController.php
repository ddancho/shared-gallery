<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Models\Image;

class GalleryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function gallery($request, $response)
    {
        if ($request->isPost()) {
            $page = $request->getBody()['page'];
            if (\file_exists(Application::$ROOT_DIR . "/src/Views/Gallery/{$page}.php")) {
                $gallery_content = \file_get_contents(Application::$ROOT_DIR . "/src/Views/Gallery/{$page}.php");
                return $response->json([
                    'page' => $page,
                    'actionAttr' => Application::$base . '/' . $page,
                    'content' => $gallery_content,
                ]);
            }

            return $response->json([
                'page' => '',
                'content' => '<div class="container"><h2 class="container__title">Page unavailable</h2></div>',
            ]);
        }

        return $this->render("Gallery/gallery");
    }

    public function upload($request, $response)
    {
        if ($request->isPost()) {
            $status = $request->getBody()['visibility'] === 'public' ? 0 : 1;
            $image = new Image($this->app()->session->get('user'), $status, $request->getFile('file'));

            if ($image->validateModelData(['file']) && $image->insert()) {
                return $response->json([
                    'msg' => "File {$image->file['name']} successfully uploaded",
                ]);
            }

            return $response->json([
                'errors' => $image->errors,
            ]);

        }
    }
}
