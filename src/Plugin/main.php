<?php

namespace Drupal\kimulator\Plugin;

use Drupal\Core\Controller\ControllerBase;
//use Drupal\Core\File\FileSystemInterface;
//use Drupal\views\Views;

//Drupal form:
//use Drupal\Core\Form\FormBase;
//use Drupal\Core\Form\FormStateInterface;



/**
 * 
 */
class main extends ControllerBase {
//class main extends FormBase {

	public function build() {

		$content = array(
      				'#type' => 'inline_template',
       				'#markup' => $this->t('AI: '),
       				'#template' => $showonsite.'<br /><br /><br />show content for AI main.php:',
    				);
		return $content;
	}

/*

  public function getFormId() {
    return 'form1';
  }
	public function buildForm(array $form, FormStateInterface $form_state) {
        $form['kitext'] = [ '#type' => 'textfield', '#title' => t('writeprompt'), '#required' => TRUE, '#attributes' => [ 'class' => ['custom-field'], 'style' => 'width: 50%;',  ], ];
        return $form;
	}
}



*/

//class main extends FormBase {
//        public function buildForm(array $form, FormStateInterface $form_state) {
//        $form['kitext'] = [ '#type' => 'textfield', '#title' => t('writeprompt'), '#required' => TRUE, '#attributes' => [ 'class' => ['custom-field'], 'style' => 'width: 50%;',  ], ];
//        return $form;

//        }


}


