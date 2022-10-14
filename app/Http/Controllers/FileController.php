<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Auth;
use Session;
use DB;
use File;
use Jenssegers\Agent\Facades\Agent;

class FileController extends Controller
{

    /** * Save File to Disk
        *
        *  @param  $uploadUrlSegment:string, $moduleName:string, $input:input object
        *  @return int $url
        */
    public function saveFile($uploadUrlSegment, $moduleName, $input)
    {
        try {
            $url = null;
            $creatorId = Session('creator_id'); // Premise Id

            Log::info('FileController|saveFile(Input) : ' . print_r($input, true));


            if($input && $input != null && $input != 'null' ){

                $tempPath = $creatorId.DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR.$uploadUrlSegment;
                $relativePath = DIRECTORY_SEPARATOR.$tempPath;


                // creating an abosolute path
                $fileLocation = env('UPLOAD_PATH') . $relativePath;

                Log::info('FileController|saveFile(fileLocation) : ' . print_r($fileLocation, true));

                // if the path does not exist, creating
                if (!file_exists($fileLocation)){
                    $old = umask(0);
                    mkdir($fileLocation,0777, true);
                    umask($old);
                }

                $fileLocation = $fileLocation . DIRECTORY_SEPARATOR;

                // file with the absolute path
                $target_file = $fileLocation . $input->getClientOriginalName(); // original name that it was uploaded with

                // move the file to target
                if (move_uploaded_file($input, $target_file)) {
                    $url = $tempPath . DIRECTORY_SEPARATOR . $input->getClientOriginalName();
                }
            }

            return $url;
        } catch (Exception $e) {
            report($e);
        }
    }

     /** * Save base64 image
    *
    *  @param  $uploadUrlSegment:string, $moduleName:string, $input:input object
    *  @return int $url
    */
    public function saveImageBase64($uploadUrlSegment, $moduleName, $imageEncodedInput){
        try{
            $url = null;
            $creatorId = Session('creator_id'); // Premise Id

            // Log::info('FileController|saveFile(Input) : '.print_r($input,true));

            $image     = $imageEncodedInput; // image base64 encoded
            preg_match("/data:image\/(.*?);/", $image, $image_extension); // extract the image extension
            $image     = preg_replace('/data:image\/(.*?);base64,/', '', $image); // remove the type part
            $image     = str_replace(' ', '+', $image);

            $pathImage = null;

            if ($image_extension)
            {
                $imageName = 'image_' . time() . '.' . $image_extension[1]; //generating unique file name;

                $tempPath = $creatorId.DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR.$uploadUrlSegment; // khkma_1/moc/...
                $relativePath = DIRECTORY_SEPARATOR.$tempPath; // /khkma_1/moc/...

                // constructing folder path for image .....
                $fileLocation = env('UPLOAD_PATH').$relativePath;

                //  Create that folder in public directory if not exist .....
                // if(! file_exists($fileLocation)){
                //     File::makeDirectory($fileLocation);
                // }

                // if the path does not exist, creating
                if(!file_exists($fileLocation))
                        mkdir($fileLocation,0777,true);

                $fileLocation=$fileLocation.DIRECTORY_SEPARATOR;

                // build image path for save  .....
                $pathImage = $fileLocation . $imageName;

                // put that image inside the path .....
                file_put_contents($pathImage, base64_decode($image));

                $url=$tempPath.DIRECTORY_SEPARATOR.$imageName;
            }

            return $url;
        }
        catch(Exception $e){
            report($e);
        }
     }

    /** * Get base64 image
        *
        *  @param  $imgPath:string
        *  @return int $imageData
        */
    public function getImageBase64($imgPath){
        try {

            // Log::info("getImageBase64 : ".print_r($imgPath, true));

            // Constructing image absolute path
            $imagePath = env('UPLOAD_PATH').DIRECTORY_SEPARATOR.$imgPath ;

            $type = pathinfo($imagePath, PATHINFO_EXTENSION);

            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );

            $avatarData = file_get_contents($imagePath, false, stream_context_create($arrContextOptions));
            $avatarBase64Data = base64_encode($avatarData);
            $imageData = 'data:image/' . $type . ';base64,' . $avatarBase64Data;

            return $imageData;
        } catch (Exception $e) {
            report($e);
        }
    }

    /** * Get File
        *
        *  @param  $imgPath:string
        *  @return int $imageData
        */
    public function getFile(Request $r){
        try {

            Log::debug("=========== GET FILE ===========");
            Log::debug(print_r($r->path, true));
            $imgPath = $r->path;
            Log::info(print_r($imgPath, true));
            $imgPath = env('UPLOAD_PATH').DIRECTORY_SEPARATOR.($imgPath);
            return response()->file($imgPath);

        } catch (Exception $e) {
            report($e);
        }
    }



    /** * Download files
        *
        *  @param  $imgPath:string
        *  @return int $imageData
        */
    public function downloadFile($relativePathSegment){

        $fileLocation = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . $relativePathSegment;

        if (file_exists($fileLocation))
            return  response()->download($fileLocation);
        else
            return null;
    }


    public function downloadFileByQstring(Request $r)
    {
        $relativePathSegment = $r->path;
        $fileLocation = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . $relativePathSegment;

        if (file_exists($fileLocation))
            return  response()->download($fileLocation);
        else
            return null;
    }
}
