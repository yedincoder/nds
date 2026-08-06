<?php

namespace App\Modules\AdminArea\Controllers;

use App\Controllers\AdminBaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MediaController extends AdminBaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $media = $db->table('media')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();

        $data = [
            'title' => 'Media Manager',
            'page'  => 'admin/media',
            'media' => $media,
        ];

        return view('AdminArea/dashboard/media', $data);
    }

    public function upload(): ResponseInterface
    {
        $file = $this->request->getFile('file');

        if (!$file || !$file->isValid()) {
            return redirect()->back()
                ->with('error', 'Invalid file upload.');
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/media', $newName);

        $db = \Config\Database::connect();
        $db->table('media')->insert([
            'uuid' => $this->generateUuid(),
            'file_name' => $newName,
            'file_path' => 'uploads/media/' . $newName,
            'file_type' => $file->getClientMimeType() ?: $file->getExtension(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getClientMimeType(),
            'uploaded_by' => session()->get('user_id'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()
            ->with('success', 'File uploaded successfully.');
    }

    public function delete($id = null): ResponseInterface
    {
        $db = \Config\Database::connect();
        $media = $db->table('media')->where('id', $id)->get()->getRow();

        if ($media) {
            $filepath = WRITEPATH . $media->file_path;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            $db->table('media')->where('id', $id)->delete();
        }

        return redirect()->back()
            ->with('success', 'Media deleted successfully.');
    }

    private function generateUuid(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}