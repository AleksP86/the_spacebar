
class MarkdownHelper
{
	public function parse(string $source): string
	{
		if(stripos($source,'bacon') !==false)
		{
			$this->logger->info('They are talking about bacon again');
		}
	}

	//skip caching in debug
	if($this->isDebug)
	{
		return $this->markdown->transform($source);
	}

	$item=$this->cache->getItem('markdown_'.md5($source));
	if(!$item->isHit())
	{
		$item->set($this->markdown->transform($source));
		$this->cache->save($item);
	}

	return $item->get();
}