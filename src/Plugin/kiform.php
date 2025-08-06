<?php

namespace Drupal\kimulator\Plugin;

/*
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\File\FileSystemInterface;
use Drupal\views\Views;
*/

//Drupal form:
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;



/**
 * 
 */
//class main extends ControllerBase {
class kiform extends FormBase {





//  public function getFormId() {
//    return 'kiform1';
//  }


//	public function buildForm(array $form, FormStateInterface $form_state) {
	//        $form['kiform'] = [ '#type' => 'textfield', '#title' => t('writeprompt'), '#required' => TRUE, '#attributes' => [ 'class' => ['custom-field'], 'style' => 'width: 50%;',  ], ];
       // 	return $form;
//	}






        public function build() {

                $content = array(
                                '#type' => 'inline_template',
                                '#markup' => $this->t('AI: '),
                                '#template' => $showonsite.'<br /><br /><br />show content for AI',
                                );
                return $content;
        }


/*  	public function submitForm(array &$form, FormStateInterface $form_state) {
    		\Drupal::messenger()->addMessage(t("KI generierte Prompts und Daten:"));
		foreach ($form_state->getValues() as $key => $value) {
		  \Drupal::messenger()->addMessage($key . ': ' . $value);
    		}
  	}
*/



}





//class main extends FormBase {
//        public function buildForm(array $form, FormStateInterface $form_state) {
//        $form['kitext'] = [ '#type' => 'textfield', '#title' => t('writeprompt'), '#required' => TRUE, '#attributes' => [ 'class' => ['custom-field'], 'style' => 'width: 50%;',  ], ];
//        return $form;

//        }
//}


