<?php namespace App\Http\Controllers;

class TagsController extends Controller
{

	public function __construct()
	{
		$this->redis = new \Quip\Test('tcp://192.168.99.100:6379');
		$this->client = $this->redis->getRedisClient();
	}

	public function getTag($prefix)
	{
		$this->redis->setPrefix($prefix);
		$this->redis->setDataPool($this->getDataPool($prefix));
		$tag = $this->redis->getTag();
		return response()->json(['tags' => ['test' => $tag ]]);
	}

	public function get($prefix, $tag)
	{
		$this->redis->setPrefix($prefix);
		$stats = $this->redis->getStats();
		return response()->json(['cases' => $stats['cases'][$tag], 'tests_performed' => $stats['tests_performed']]);
	}

	public function post($prefix, $tag)
	{
		$this->redis->setPrefix($prefix);
		$this->redis->setDataPool($this->getDataPool($prefix));
		if ($this->redis->markSuccess($tag)) {
			return response()->json(['success' => true]);
		}
		throw new Exception('Tag does not exist');
	}

  public function create($prefix)
  {
    $tags = app('request')->input('campaigns.tags');
    foreach ($tags as $tag) {
      $this->client->set($prefix .':' . $tag . ':passes', 0);
    }
  }

	public function getDataPool($prefix)
	{
		$cases = [];
		foreach ($this->client->keys($prefix . ":*") as $redisPath) {
			$endOfPath = substr($redisPath, strrpos($redisPath, ':') + 1);
			$beginningOfPath = substr($redisPath, 0, strrpos($redisPath, ':'));
			$case = substr(strstr($beginningOfPath, ':', false), 1);
      if (is_string($case)) {
        $cases[$case] = $case;
      }
		}
		return array_keys($cases);
	}
}
