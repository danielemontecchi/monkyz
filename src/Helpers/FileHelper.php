<?php
namespace Lab1353\Monkyz\Helpers;

use Cache;
use Storage;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;

class FileHelper
{
	protected $disk = 'local';
	protected $disk_params = [];

	public function __construct($disk='local')
	{
		$this->setDisk($disk);
	}

	private function setDisk($disknew)
	{
		$disk = config('filesystems.default');
		$disks = array_keys(config('filesystems.disks'));

		if (in_array($disknew, $disks)) {
			$disk = $disknew;
		}

		$this->disk = $disk;
		$this->disk_params = config('filesystems.disks.'.$disk);
		if (empty($this->disk_params['driver'])) $this->disk_params['driver'] = '';
	}

	public function getUrlFileTypeIcon($file_name)
	{
		if (empty($file_name)) {
			return '';
		} else {
			$path = 'vendor/monkyz/images/ext/';
			$icon = strtolower(pathinfo($file_name, PATHINFO_EXTENSION)).'.png';

			return asset($path.$icon);
		}
	}

	public function getUrlFromParams($params, $file)
	{
		$path = $params['image']['path'];

		$disk = $params['image']['disk'];
		$this->setDisk($disk);

		return $this->generateUrl($path, $file);
	}

	public function generateUrl($path, $file_name)
	{
		$url = '';
		if (!empty($file_name)) {
			$disk = $this->disk;
			$driver = $this->disk_params['driver'];
			$path = str_finish($path, '/');

			$cache_key = 'monkyz-images-url_'.$disk.'_'.str_slug($path).'_'.str_slug($file_name);

			if (Cache::has($cache_key)) {
				$url = Cache::get($cache_key);
			} else {
				if ($driver=='local') {
					$url = Storage::disk($disk)->url($path.$file_name);
					$url = str_replace('/storage', '', $url);
					$url = asset($url);
				} else {
					$adapter = Storage::disk($disk)->getAdapter();
					if (!empty($adapter)) {
						$client = $adapter->getClient();
						if (!empty($client)) {
							if (!starts_with($path, '/')) $path = '/'.$path;
							$url = $client->createTemporaryDirectLink($path.$file_name);
							if (is_array($url)) $url = $url[0];
						}
					}
				}

				Cache::put($cache_key, $url, (int)config('monkyz.cache_minutes', 60));
			}
		}

		return $url;
	}
}