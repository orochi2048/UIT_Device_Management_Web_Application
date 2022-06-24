<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_storage(){
		$_POST['description'] = htmlentities($_POST['description']);
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($ID)){
			$sql = "INSERT INTO `thiet_bi_uit` set {$data} ";
		}else{
			$sql = "UPDATE `thiet_bi_uit` set {$data} where ID = '{$ID}' ";
		}
		$check = $this->conn->query("SELECT * FROM `thiet_bi_uit` where `Ten_thiet_bi`='$Ten_thiet_bi' ".($ID > 0 ? " and ID != '{$ID}'" : ""))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Tên thiết bị đã tồn tại.";
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$sid = !empty($ID) ? $ID : $this->conn->insert_id;
				$resp['status'] = 'success';
				if(empty($ID))
					$resp['msg'] = "Thiết bị được thêm thành công.";
				else
					$resp['msg'] = "Thông tin thiết bị được cập nhật thành công.";

				if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
					$fname = 'uploads/storages/'.$sid.'.png';
					$dir_path =base_app. $fname;
					$upload = $_FILES['img']['tmp_name'];
					$type = mime_content_type($upload);
					$allowed = array('image/png','image/jpeg');
					if(!in_array($type,$allowed)){
						$resp['msg'].="Định dạng hình ảnh không hợp lệ.";
					}else{
						$new_height = 500; 
						$new_width = 600;  
				
						list($width, $height) = getimagesize($upload);
						$t_image = imagecreatetruecolor($new_width, $new_height);
						imagealphablending( $t_image, false );
						imagesavealpha( $t_image, true );
						$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if($gdImg){
								if(is_file($dir_path))
								unlink($dir_path);
								$uploaded_img = imagepng($t_image,$dir_path);
								imagedestroy($gdImg);
								imagedestroy($t_image);
							if($uploaded_img){
								$this->conn->query("UPDATE `thiet_bi_uit` set thumbnail_path = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$sid}' ");
							}
						}else{
						$resp['msg'].="Không thể đăng hình ảnh lên.";
						}
					}
				}
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_storage(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `thiet_bi_uit` where ID = '{$ID}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Thiết bị đã bị xóa.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_booking(){
		if(empty($_POST['id'])){
			$alpha = range("A","Z");
			shuffle($alpha);
			$prefix = (substr(implode("",$alpha),0,3))."-".(date('Ymd'));
			$code = sprintf("%'.04d",1);
			while(true){
				$check = $this->conn->query("SELECT * FROM booking_list where `book_code` = '{$prefix}{$code}' ")->num_rows;
				if($check > 0){
					$code = sprintf("%'.04d",ceil($code)+1);
				}else{
					break;
				}
			}
			$_POST['book_code'] = "{$prefix}{$code}";
		}
		$_POST['client_name'] = "{$_POST['fullname']}";
		$_POST['student_id'] = "{$_POST['MSSV']}";
		$_POST['amount'] = "{$_POST['quantity']}";
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(in_array($k,array('book_code','student_id','client_name','amount','date_from','date_to','storage_id','status'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `booking_list` set {$data} ";
		}else{
			$sql = "UPDATE `booking_list` set {$data} where id = '{$id}' ";
		}
		
		$save = $this->conn->query($sql);
		if($save){
			$eid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Yêu cầu mượn thiết bị đã được gửi. Mã yêu cầu của bạn là <b>{$book_code}</b>.";
			else
				$resp['msg'] = "Yêu cầu mượn thiết bị đã được cập nhật.";
				$data = "";
				foreach($_POST as $k =>$v){
					if(!in_array($k,array('id','book_code','student_id','client_name','amount','date_from','date_to','storage_id','status'))){
						if(!is_numeric($v))
							$v = $this->conn->real_escape_string($v);
						if(!empty($data)) $data .=",";
						$data .= " ('{$eid}', '{$k}', '{$v}')";
					}
				}
				if(!empty($data)){
					$sql2 = "INSERT INTO `booking_details` (`booking_id`,`meta_field`,`meta_value`) VALUES {$data}";
					$this->conn->query("DELETE FROM `booking_details` where booking_id = '{$eid}'");
					$save_meta = $this->conn->query($sql2);
					if($save_meta){
						$resp['status'] = 'success';
					}else{
						$this->conn->query("DELETE FROM `booking_list` where id = '{$eid}'");
						$resp['status'] = 'failed';
						$resp['msg'] = "An error occurred while saving the data. Error: ".$this->conn->error;
					}
				}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success' && !empty($id))
		$this->settings->set_flashdata('success',$resp['msg']);
		if($resp['status'] =='success' && empty($id))
		$this->settings->set_flashdata('pop_msg',$resp['msg']);
		return json_encode($resp);
	}
	function delete_booking(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `booking_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Yêu cầu mượn đã bị xóa.");
			$this->conn->query("DELETE FROM `booking_details` FROM where booking_id = '{$id}'");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_message(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `message_list` set {$data} ";
		}else{
			$sql = "UPDATE `message_list` set {$data} where id = '{$id}' ";
		}
		
		$save = $this->conn->query($sql);
		if($save){
			$eid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Phản hồi của bạn đã được gửi.";
			else
				$resp['msg'] = "Phản hồi của bạn đã được cập nhật.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success' && !empty($id))
		$this->settings->set_flashdata('success',$resp['msg']);
		if($resp['status'] =='success' && empty($id))
		$this->settings->set_flashdata('pop_msg',$resp['msg']);
		return json_encode($resp);
	}
	function delete_message(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `message_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Phản hồi đã bị xóa.");

		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function update_status(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `booking_list` set status  = '{$status}' where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = "Trạng thái của yêu cầu đã được cập nhật.";
			$this->conn->query("DELETE FROM `booking_details` where booking_id = '{$id}' and meta_field='remarks' ");
			$this->conn->query("INSERT `booking_details` set booking_id = '{$id}', meta_field='remarks', meta_value='{$remarks}' ");
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occurred. Error: " .$this->conn->error;
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_storage':
		echo $Master->save_storage();
	break;
	case 'delete_storage':
		echo $Master->delete_storage();
	break;
	case 'save_booking':
		echo $Master->save_booking();
	break;
	case 'delete_booking':
		echo $Master->delete_booking();
	break;
	case 'save_message':
		echo $Master->save_message();
	break;
	case 'delete_message':
		echo $Master->delete_message();
	break;
	case 'update_status':
		echo $Master->update_status();
	break;
	default:
		// echo $sysset->index();
		break;
}