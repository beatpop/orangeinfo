<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\Files;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    /**
     * 所有图片列表
     *
     * @return $this
     */
    public function index()
    {
        $files = $this->getAllFiles();
        return view('uploads.list')->with(['files' => $files]);
    }

    // 显示上传页面
    public function showUpload()
    {
        return view('uploads.upload');
    }

    // 上传图片
    public function upload(Request $request)
    {
        if ($request->isMethod('POST')){
            $file = $request->file('file');

            //判断文件是否上传成功
            if ($file->isValid()){
                //原文件名
                $originalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //MimeType
                $type = $file->getClientMimeType();

                $fileName = uniqid().'.'.$ext;

                if ($this->checkIfImage($ext)) {

                    $isSuccess = $file->move(storage_path('data'), $fileName);

                    //判断是否上传成功
                    if($isSuccess){
                        $files = new Files();
                        $files->name = $originalName;
                        $files->file_name = $fileName;
                        $files->file_path = storage_path('data') . "/" . $fileName;
                        $files->type = $type;
                        $files->save();
                        $files = $this->getAllFiles();

                        return redirect('file/list')->with([
                            'files' => $files
                        ]);
                    }else{
                        echo '上传失败！';
                    }
                }
            }
        }
        return view('uploads.upload');
    }

    /**
     * 显示图片
     *
     * @param $id
     * @return BinaryFileResponse
     */
    public function show($id)
    {
        $file = DB::table('files')->find($id);

        if (!$file) {
            return ;
        }

        $fileUrl = $file->file_path;
        $response = new BinaryFileResponse($fileUrl);

        return $response;
    }

    // 删除一张图
    public function delete($id)
    {
        $file = DB::table('files')->find($id);

        if (!$file) {
            return ;
        }

        $fileUrl = $file->file_path;
        $isDel = unlink($fileUrl);

        if ($isDel) {
            DB::table('files')->delete($id);
        }

        return redirect('file/list');
    }

    /**
     * 获取所有图片
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getAllFiles()
    {
        return DB::table('files')->orderBy('id', 'desc')->get();
    }

    /**
     * 判断是否为图片格式
     *
     * @param $extension
     * @return bool
     */
    protected function checkIfImage($extension)
    {
        if (!in_array($extension, [
            'jpg',
            'jpeg',
            'png',
            'bmp',
            'gif',
            'svg'
        ])) {
            return false;
        }

        return true;
    }
}
