<?php namespace App\Http\Controllers;

class CampaignsController extends Controller
{

	public function __construct()
	{
		$this->redis = new \Quip\Test('tcp://192.168.99.100:6379');
		$this->client = $this->redis->getRedisClient();
	}

	public function index()
	{
		return response()->json(['campaigns' => array_map(function($value) { return rtrim($value, ':total'); }, $this->client->keys('*:total'))]);
	}


	public function get($prefix)
	{
		$this->redis->setPrefix($prefix);
		$stats = $this->redis->getStats();
		return response()->json($stats);
	}
}
