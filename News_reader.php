<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_reader {
	protected $CI;
	protected $api_key;
	protected $error;
	protected $result;
	public function __construct($param=null){
		$this->CI =& get_instance();

		if($param&&isset($param['api_key'])){
			$this->api_key=$param['api_key'];
		}elseif($this->CI->config->item('api_key')) {
			$this->api_key=$this->CI->config->item('api_key');
		}
	}

	public function setApi($api_key){
		$this->api_key=$api_key;
	}

	public function getApiKey(){
		return $this->api_key;
	}

	public function error(){
		return $this->error;
	}

	public function getNews($filter='everything',$parameter){
		$url="https://newsapi.org/v2/$filter?";
		if(!isset($parameter['apiKey'])){
			$parameter['apiKey']=$this->api_key;
		}
		$url.=http_build_query($parameter);
		$curl = curl_init();
		curl_setopt_array($curl, [
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url
		]);
		$resp = curl_exec($curl);
		curl_close($curl);
		return $this->buildResult($resp);
	}

	public function buildResult($data){
		if($data){
			$arr=json_decode($data,TRUE);
			if($arr){
				if(strtolower($arr['status'])=='ok'){
					$this->error=array();
					$this->result=$arr;
					unset($this->result['status']);
					return $this->results();
				}else{
					$this->error=$arr;
					unset($this->error['status']);
					return False;
				}
			}else{
				$this->error=array(
					'code'=>'jsonDecodingFailed',
					'message'=>'Failed decode json string.'
				);
				return False;
			}
		}elseif(!$data){
			$this->error=array(
				'code'=>'loadUrlFailed',
				'message'=>'Failed load url. Please check that cUrl is working properly.'
			);
			return False;
		}
	}
	public function results(){
		return $this->result;
	}

	public function articles(){
		if($this->result&&isset($this->result['articles'])){
			return $this->result['articles'];
		}else{
			return array();
		}
	}

	public function totalResults(){
		if($this->result&&isset($this->result['totalResults'])){
			return $this->result['totalResults'];
		}else{
			return 0;
		}
	}

	public function clear(){
		$this->result=array();
		$this->error=array();
	}
}