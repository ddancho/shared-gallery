<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Models\Image;

class GalleryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->registerMiddleware(new AuthMiddleware());
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
            'records' => null,
            'view' => file_get_contents(Application::$ROOT_DIR . "/src/Views/Gallery/upload.php"),
        ]);
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
