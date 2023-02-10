<?php

namespace App\Controllers;
use App\Models\UserModel;
class Home extends BaseController
{

    public function __construct() {
        helper(['url']);
        $this->user = new UserModel();
    }
    public function index()
    {
        echo view('/inc/header');
        $data['users'] = $this->user->orderby( 'id', 'DESC')->paginate(3,'group1');
        $data['pager'] = $this->user->pager;
        echo view('home' , $data);
        echo view('/inc/footer');
    }

    // add user data
    public function saveUser() {
        $username = $this->request->getVar('username');
        $email = $this->request->getVar('email');
        $file = $this->request->getFile('userfile');
        $newName = $file->getRandomName();
        $file->move('uploads', $newName);
        $this->user->save(["username" => $username 
        , "email" => $email
        , "image" => $newName
    ]);
        session()->setFlashdata("success" , "Data inserted successfully");
        return redirect()->to(base_url());
    }
    // get user data
    public function getSingleUser($id) {
        $data = $this->user->where("id" , $id)->first();
        echo json_encode($data);
    }
    // update user dâta
    public function updateUser() {
        $id = $this->request->getVar('updateId');
        $username = $this->request->getVar('username');
        $email = $this->request->getVar('password');

        $data['username'] = $username;
        $data['email'] = $email;

        $this->user->update($id, $data);
        return redirect()->to(base_url("/"));

    }
    public function deleteUser() {
        $id = $this->request->getVar('id');
        $this->user->where('id', $id)->delete();
        return redirect()->to(base_url('/'));
    }
    public function do_upload($file)
    {
  

        if ($file->isValid() && ! $file->hasMoved())
        {
            $newName = $file->getRandomName();
            $file->move('uploads', $newName);
            echo 'The file was successfully uploaded.';
        }
        else
        {
            throw HTTPException::forbidden('Error uploading file');
        }
    }

}
