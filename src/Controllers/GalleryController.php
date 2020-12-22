<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\RedirectMiddleware;
use App\Models\Image;

class GalleryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->registerMiddleware(new RedirectMiddleware());
    }

    public function gallery($request, $response)
    {
        return $this->render("Gallery/gallery");
    }

    public function publicGallery($request, $response)
    {
        if ($request->isPost()) {
            $image = new Image();
            $records = $image->getAllPublic($request->getBody());
            $totalRecords = $image->getImagesCount(['column' => 'image_status', 'value' => Image::IMAGE_PUBLIC, 'type' => \PDO::PARAM_INT]);

            return $response->json([
                'page' => 'public',
                'records' => [
                    'page' => $this->app()->session->get('publicPage'),
                    'totalRecords' => $totalRecords,
                ],
                'view' => $this->renderView("Gallery/public", $records),
            ]);
        }
    }

    public function privateGallery($request, $response)
    {
        if ($request->isPost()) {
            $image = new Image();
            $records = $image->getAllPrivate($this->app()->session->get('user'), $request->getBody());
            $totalRecords = $image->getImagesCount(['column' => 'user_id', 'value' => intval($this->app()->session->get('user')['id']), 'type' => \PDO::PARAM_INT]);

            return $response->json([
                'page' => 'private',
                'records' => [
                    'page' => $this->app()->session->get('privatePage'),
                    'totalRecords' => $totalRecords,
                ],
                'view' => $this->renderView("Gallery/private", $records),
            ]);
        }
    }
}
