<?php

namespace Din\SocialAuth\Google;

class Scope {

	private $_scope = array();

	public function setYouTube()
	{
		$this->_scope[] = 'https://www.googleapis.com/auth/youtube';
	}
	
	public function setAnalytcs()
	{
		$this->_scope[] = 'https://www.googleapis.com/auth/analytics.readonly';
	}

	public function getScope()
	{
		return $this->_scope;
	}

}