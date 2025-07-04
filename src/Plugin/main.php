<?php

namespace Drupal\kimulator\Plugin;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\File\FileSystemInterface;
use Drupal\views\Views;




/**
 * 
 */
class main extends ControllerBase {

	public function build() {

		$content = array(
      				'#type' => 'inline_template',
       				'#markup' => $this->t('AI: '),
       				'#template' => $showonsite.'<br /><br /><br />show content for AI',
    				);
		return $content;

	}
}


