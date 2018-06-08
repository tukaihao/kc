<?php
namespace app\index\controller;

use think\Request;
use think\Validate;
use think\Cookie;
use think\Session;
use think\Loader;
use think\Url;


class Fileupload extends Common
{
	public $_check_login = false;//是否检查登陆
	
	/*
	public function md5check(){

		//sleep(2);
		$md5 =  Request::instance()->param('md5','');
		$op =  Request::instance()->param('op','');//只能英文 数据 下划线

		if(!$op or !preg_match("/^[a-zA-Z0-9_]+$/",$op)) $op = 'default';
		
	
		$model = Loader::model('attachment');
		$map = array(
			'md5'=>$md5,
			'status'=>1,
			'is_del'=>0,
		);
		$one = $model->field('id,md5,file_size,yst_size')->where($map)->find();
		if(!$one)
		{

			return Response::create(array(
						'status'=>0,
						'md5'=>'',
						'msg'=>'',
					),'json');

		}
		

		return Response::create(array(
					'status'=>1,
					'md5'=>$one['md5'],
					'msg'=>'',
				),'json');


	}*/


	public function index(){
		//sleep(2);

		// Make sure file is not cached (as it happens for example on iOS devices)
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		$op =  Request::instance()->param('op','');//只能英文 数据 下划线
		if(!$op or !preg_match("/^[a-zA-Z0-9_]+$/",$op)) $op = 'default';

		// Support CORS
		// header("Access-Control-Allow-Origin: *");
		// other CORS headers if any...
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			exit; // finish preflight CORS requests here
		}


		if ( !empty($_REQUEST[ 'debug' ]) ) {
			$random = rand(0, intval($_REQUEST[ 'debug' ]) );
			if ( $random === 0 ) {
				header("HTTP/1.0 500 Internal Server Error");
				exit;
			}
		}

		// header("HTTP/1.0 500 Internal Server Error");
		// exit;


		// 5 minutes execution time
		@set_time_limit(300);

		// Uncomment this one to fake upload time
		// usleep(5000);

		// Settings
		// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
		$targetDir = SITE_DIR.'/uploads/webuploader/upload_tmp';
        $uploadDir = SITE_DIR.'/uploads/webuploader';

		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds


		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

		// Create target dir
		if (!file_exists($uploadDir)) {
			@mkdir($uploadDir);
		}

        // Get a file name
        if (isset($_REQUEST["name"])) {
			$fileName =  Request::instance()->request('name','');
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $ext = '.'. get_extension($fileName);
	
        if(!in_array($ext,array('.jpg','.jpeg','.gif','.png')))
        {
            $ext = '.attach';
        }

        $ymd_dir = '/'.$op.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
        
        leipi_mkdirs( $targetDir . $ymd_dir);
        leipi_mkdirs( $uploadDir . $ymd_dir);
        
		//分片的
        $filePath = $targetDir . $ymd_dir . md5($fileName);
		
		//真正保存的
		$save_fileName = date('YmdHis').rand(1000,9999).leipi_rand_string().$ext;
        $uploadPath = $uploadDir . $ymd_dir . $save_fileName;
        $uploadUrl = '/uploads/webuploader' . $ymd_dir . $save_fileName;//保存数据库的



		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


		// Remove old temp files
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "0"}');
			}

			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
					continue;
				}

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}


		// Open temp file
		if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "0"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "0"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "0"}');
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "0"}');
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

		$index = 0;
		$done = true;
		for( $index = 0; $index < $chunks; $index++ ) {
			
			if ( !file_exists("{$filePath}_{$index}.part") ) {
				$done = false;
				break;
			}
		}
		if ( $done ) {
			if (!$out = @fopen($uploadPath, "wb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "0"}');
			}

			if ( flock($out, LOCK_EX) ) {
				for( $index = 0; $index < $chunks; $index++ ) {
					if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
						break;
					}

					while ($buff = fread($in, 4096)) {
						fwrite($out, $buff);
					}

					@fclose($in);
					@unlink("{$filePath}_{$index}.part");
				}

				flock($out, LOCK_UN);
			}
			@fclose($out);
		
			//处理成功
			if($ext != '.attach'){
				//检查图片 
				$is_img = is_img($uploadPath);
				if(!$is_img){
					die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "is not images."}, "id" : "0"}');
				}
			}
			
			if ( !file_exists($uploadPath) ) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 104, "message": "save error !"}, "id" : "0"}');
			}
			
		
			$file_size =  Request::instance()->request('filesize','','floatval');
			$file_size = round($file_size/1024,2);//kb
			
			$md5 =  Request::instance()->param('md5','');

			//保存到数据库
			$data = array(
				//'uid'=>$this->_user_id,
				'md5'=>$md5,
				'file_path'=>$uploadUrl,
				'file_type'=>$_FILES["file"]["type"],
				'file_size'=>$file_size,
				'file_name'=>$_FILES["file"]["name"],
				'att_type'=>$op,
				'dateline'=>$this->_timestamp,
			);
			//print_R($data);exit;

			$model = Loader::model('attachment');
			$id = $model->insertGetId($data);
			if($id <= 0)
			{
				die('{"jsonrpc" : "2.0", "error" : {"code": 104, "message": "save error."}, "id" : "0"}');
			}

			// Return Success JSON-RPC response
			die('{"jsonrpc" : "2.0", "result" : "","file_size":"'.$file_size.'","file_path":"'.$uploadUrl.'", "id" : "'.$id.'","md5":"'.$md5.'"}');
		}

		die('{"jsonrpc" : "2.0", "result" : "'.$chunk.'", "id" : "0"}');

	}

    


}
