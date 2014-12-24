<?php

namespace Din\SocialAuth\Google\Services;

use Din\SocialAuth\Google\Auth;
use Google_Service_YouTube_VideoSnippet;
use Google_Service_YouTube_Video;
use Google_Service_YouTube_VideoStatus;
use Google_Service_YouTube;
use Google_Service_Exception;

class YouTube {

	private $_youtube;
	private $_snippet;
	private $_status;
	private $_video;

	public function __construct(Auth $auth)
	{
    	$this->_youtube = new Google_Service_YouTube($auth->getClient());
    	$this->_snippet = new Google_Service_YouTube_VideoSnippet;
	    $this->_status = new Google_Service_YouTube_VideoStatus;
		$this->_video = new Google_Service_YouTube_Video;

	}

	public function setTitle($title)
	{
		$this->_snippet->setTitle($title);

	}

	public function setDescription($description)
	{
		$this->_snippet->setDescription($description);

	}

	public function setTags($tags)
	{
		if ( is_array($tags) ) {
	  		$this->_snippet->setTags($tags);
		}

	}

	public function setPrivacy($privacy)
	{
	    $this->_status->privacyStatus = $privacy;

	}

	public function insert ($file)
  	{
		$this->_video->setSnippet($this->_snippet);
		$this->_video->setStatus($this->_status);

		if ( !is_file($file) )
			throw new \Exception('Problema com o caminho do arquivo');

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime_type = finfo_file($finfo, $file);

		try {
			$obj = $this->_youtube->videos->insert(
				"status,snippet", $this->_video, array(
				"data" => file_get_contents($file),
				"mimeType" => $mime_type,
				'uploadType' => 'multipart'
				)
			);

			return $obj->id;
		} catch (Google_Service_Exception $e) {
			var_dump($e->getMessage());
		}

  }

  public function delete ( $id )
  {
    try {
      $this->_youtube->videos->delete($id);
      return true;
    } catch (\Exception $e) {
      return false;
    }

  }

}