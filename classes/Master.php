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
	function save_entry(){
		if(empty($_POST['id'])){
			$prefix = "BIMS-".(date('Ym'));
			$code = sprintf("%'.04d",1);
			while(true){
				$check = $this->conn->query("SELECT * FROM baptismal_list where `code` = '{$prefix}{$code}' ")->num_rows;
				if($check > 0){
					$code = sprintf("%'.04d",ceil($code)+1);
				}else{
					break;
				}
			}
			$_POST['code'] = "{$prefix}{$code}";
		}
		$_POST['fullname'] = "{$_POST['lastname']}, {$_POST['firstname']} {$_POST['middlename']}";
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(in_array($k,array('code','fullname','date','status')) && !is_array($_POST[$k])){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `baptismal_list` set {$data} ";
		}else{
			$sql = "UPDATE `baptismal_list` set {$data} where id = '{$id}' ";
		}
		
		$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['id'] = $bid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Baptismal Entry Details has successfully submitted.</b>.";
			else
				$resp['msg'] = "Baptismal Details has been updated successfully.";
				$data = "";
				foreach($_POST as $k =>$v){
					if(!in_array($k,array('id','code','fullname','date','status')) && !is_array($_POST[$k])){
						if(!is_numeric($v))
							$v = $this->conn->real_escape_string($v);
						if(!empty($data)) $data .=",";
						$data .= " ('{$bid}', '{$k}', '{$v}')";
					}
				}
				if(!empty($data)){
					$sql2 = "INSERT INTO `baptismal_details` (`baptismal_id`,`meta_field`,`meta_value`) VALUES {$data}";
					$this->conn->query("DELETE FROM `baptismal_details` where baptismal_id = '{$bid}'");
					$save_meta = $this->conn->query($sql2);
					if($save_meta){
						$resp['status'] = 'success';
					}else{
						$this->conn->query("DELETE FROM `baptismal_list` where id = '{$bid}'");
						$resp['status'] = 'failed';
						$resp['msg'] = "An error occurred while saving the data. Error: ".$this->conn->error;
					}
				}
				if(isset($witness_name) && $witness_name > 0){
					$data = "";
					foreach($witness_name as $k => $v){
						$name = $this->conn->real_escape_string($v);
						$address = $this->conn->real_escape_string($witness_address[$k]);
						if(empty($name))
						continue;
						if(!empty($data)) $data .=",";
						$data .= " ('{$bid}', '{$name}', '{$address}')";
					}
					if(!empty($data)){
						$sql3 = "INSERT INTO `witness_list` (`baptismal_id`,`fullname`,`address`) VALUES {$data}";
						$this->conn->query("DELETE FROM `witness_list` where baptismal_id = '{$bid}'");
						$witness = $this->conn->query($sql3);	
						if($witness){
							$resp['status'] = 'success';
						}else{
							$this->conn->query("DELETE FROM `baptismal_list` where id = '{$bid}'");
							$resp['status'] = 'failed';
							$resp['msg'] = "An error occurred while saving the data. Error: ".$this->conn->error;
						}
					}
				}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_entry(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `baptismal_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Entry has been deleted successfully.");
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
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Your message has successfully sent.";
			else
				$resp['msg'] = "Message details has been updated successfully.";
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
			$this->settings->set_flashdata('success',"Message has been deleted successfully.");

		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
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
	case 'save_entry':
		echo $Master->save_entry();
	break;
	case 'delete_entry':
		echo $Master->delete_entry();
	break;
	case 'save_message':
		echo $Master->save_message();
	break;
	case 'delete_message':
		echo $Master->delete_message();
	break;
	default:
		// echo $sysset->index();
		break;
}