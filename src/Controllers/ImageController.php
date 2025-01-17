<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Middlewares\RedirectMiddleware;
use App\Models\Image;

class ImageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->registerMiddleware(new RedirectMiddleware());
    }

    public function uploadImageView($request, $response)
    {
        if ($request->isPost()) {
            return $response->json([
                'page' => 'upload',
                'records' => null,
                'view' => file_get_contents(Application::$ROOT_DIR . "/src/Views/Gallery/upload.php"),
            ]);
        }
    }

    public function uploadImage($request, $response)
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
    }

    public function getImage($request, $response)
    {
        if ($request->isPost()) {
            $image = new Image();
            $record = $image->getImage(intval($request->getBody()['id']));

            return $response->json([
                'src' => $record,
            ]);
        }
    }

    public function updateImageView($request, $response)
    {
        if ($request->isPost()) {
            $id = intval($request->getBody()['id']);
            $image = new Image();
            $record = $image->getImage($id, true);

            return $response->json([
                'id' => $id,
                'updateImg' => $this->renderView("Gallery/update", $record),
            ]);
        }
    }

    public function updateImage($request, $response)
    {
        if ($request->isPost()) {
            $image = new Image();
            $isUpdated = $image->updateImage($request->getBody());

            return $response->json([
                'isUpdated' => $isUpdated,
            ]);
        }
    }

    public function deleteImageView($request, $response)
    {
        if ($request->isPost()) {
            return $response->json([
                'id' => intval($request->getBody()['id']),
                'deleteImg' => $this->renderView("Gallery/deleteImage", ['action' => Application::$base . '/deleteImage']),
            ]);
        }
    }

    public function deleteImage($request, $response)
    {
        if ($request->isPost()) {
            $image = new Image();
            $isDeleted = $image->deleteImage(intval($request->getBody()['id']));

            return $response->json([
                'isDeleted' => $isDeleted,
            ]);
        }
    }
}
