<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\Exceptions\HTTPException;
use App\Models\UserModel;

class Upload extends BaseController
{
    public function do_upload()
    {
        $file = $this->request->getFile('userfile');

        if ($file->isValid() && ! $file->hasMoved())
        {
            $newName = $file->getRandomName();
            $file->move('uploads', $newName);
            (new UserModel)->save(['image' => $newName]);
            echo 'The file was successfully uploaded.';
        }
        else
        {
            throw HTTPException::forbidden('Error uploading file');
        }
    }
}
