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
        return $this->render("Gallery/gallery");
    }

    public function upload($request, $response)
    {
        if ($request->isPost()) {
            $image = new Image([
                'user' => $this->app()->session->get('user'),
                'body' => $request->getBody(),
                'file' => $request->getFile('file'),
            ]);

            if ($image->validateModelData(['file']) && $image->insert()) {
                return $response->json([
                    'msg' => "File {$image->file['name']} successfully uploaded",
                ]);
            }

            return $response->json([
                'errors' => $image->errors,
            ]);
        }

        return $response->json([
            'page' => 'upload',
            'view' => file_get_contents(Application::$ROOT_DIR . "/src/Views/Gallery/upload.php"),
        ]);
    }

    public function publicGallery($request, $response)
    {
        if ($request->isGet()) {
            $image = new Image();
            $records = $image->getAll();

            return $response->json([
                'page' => 'public',
                'view' => $this->renderView("Gallery/public", $records),
            ]);
        }
    }

    public function privateGallery($request, $response)
    {
        if ($request->isGet()) {

            return $response->json([
                'page' => 'private',
                'view' => $this->renderView("Gallery/private"),
            ]);
        }
    }
}
