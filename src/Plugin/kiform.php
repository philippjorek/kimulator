<?php

namespace Drupal\kimulator\Plugin;


use Drupal\Core\Controller\ControllerBase;
/*use Drupal\Core\File\FileSystemInterface;
use Drupal\views\Views;
*/

//Drupal form:
//use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


use Drupal\Component\Utility\Html;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Site\Settings;

//Create Drupal Node: 
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
use Drupal\Core\Language\Language;


/**
 * 
 */
//class kiform extends ControllerBase {
class kiform extends Formbase  {





  public function getFormId() {
    return 'kiform1';
  }


	public function buildForm(array $form, FormStateInterface $form_state) {
// dump ($form);
		$form['field_title'] = [
      			'#type' => 'textfield',
      			'#title' => $this->t('Content Title:'),
    		]; 

		$form['gp'] = [
      			'#type' => 'textfield',
      			'#title' => $this->t('Prompt Text:'),
    		]; 

 		$form['option_contenttype'] = [
      			'#type' => 'select',
                '#options' => [
                'article' => $this->t('Article'),
                'page' => $this->t('Basic page'),
                ],
      			'#title' => $this->t('Content Type:'),
    		]; 

 		$form['option_aiapiurl'] = [
      			'#type' => 'select',
                '#options' => [
                'https://api.openai.com/v1/chat/completions' => $this->t('https://api.openai.com/v1/chat/completions'),
                ],
      			'#title' => $this->t('API:'),
    		]; 
		//'2' => $this->t('https://api.openai.com/v1/images'),

 		$form['option_aimodel'] = [
      			'#type' => 'select',
                '#options' => [
                'gpt-4.1-nano' => $this->t('gpt-4.1-nano'),
				'gpt-4.1-mini' => $this->t('gpt-4.1-mini'),
                ],
      			'#title' => $this->t('AI Model:'),
    		]; 

   		 $form['submit'] = [ 
      			'#type' => 'submit',
      			'#value' => $this->t('Create AI generated Content'),
	    	];
		return $form;
	}



	public function submitForm(array &$form, FormStateInterface $form_state) {
		

		$option_contenttype = $form_state->getValue('option_contenttype');
		$option_aiapiurl = $form_state->getValue('option_aiapiurl');
		$option_aimodel = $form_state->getValue('option_aimodel');
		$prompt = $form_state->getValue('gp');
	
		if($form_state->getValue('gp')) {




			$api_key = Settings::get('set_apikey_openai', NULL);
				
				if(!$prompt) 
					$prompt = 'Example prompt for Ai in Drupal';

				if (!empty($prompt) && $_POST['gp']) {
					$endpoint = "https://api.openai.com/v1/chat/completions"; 
					//$endpoint = "https://api.openai.com/v1/images"; 
		//			$response = getAPIResponse($prompt, $endpoint, $api_key, $option_aiapiurl, $option_aimodel);
          $response = 'gebe text zurueck';
					//echo "<h2>KI:</h2>";
						//$response = str_replace(' - ',  '<br /><br />- ', $response);
						//$response = str_replace('** *', '**<br /><br />*', $response);
						//$response = str_replace('* **', '*<br /><br />**', $response);

						for ($i = 1; $i <= 20; $i++) {
							$response = str_replace(' '.$i.'. **', '<br /><br /> '.$i.'. **', $response);
						}
						$response = str_replace('** ', '**<br /><br />', $response);
						$response = str_replace('###', '###<br /><br />', $response);





					$output.= $response;
				} else {
					$output.= '----';
				}



			/* speichere image 
			// $data='https://.de/sites/default/files/i/logo2.jpg';
			if (file_put_contents('public://ai.jpg', $output) === FALSE) {
				$output='error';
			}
			else 
				$output='OK';		
			*/
 

		
		
		}

		$field_title = $form_state->getValue('field_title');
		$prompt = $form_state->getValue('gp');

		if(!$prompt) $prompt ='prompt titel';
		if(!$field_title) $field_title ='field_title1';









            //Create Drupal Node and save
            $node = Node::create([
            'type' => $option_contenttype,
                'title' => $field_title,
                'uid' => 1, 
                'langcode' => Language::LANGCODE_NOT_SPECIFIED, 
            'status' => 0,
            'promote' => 0, 
            ]);
            $node->set('body', $output);
            //$node->set('title', $field_title);
			$node->set('field_prompttext', $prompt);
            $node->save();


			//Find last saved ID
			// devekopment depending
			$nids = \Drupal::entityQuery('node')
			->condition('type','article')
			->accessCheck(FALSE)
			->execute();
			$nodes = \Drupal\node\Entity\Node::loadMultiple($nids);

			$cn = 1;
			$last_node = 100;
			$cn_max = 90;
			while ($cn <= $cn_max) {
					if($nodes[$cn])
						$save_node_max = $cn;
				$cn++;
			}


    //$build['wrapper']['#markup'] ="STRING";
			//Show Messagebox after submission
			$this->messenger()->addStatus($this->t('Your Prompt: @gp', ['@gp' => $form_state->getValue('gp').$save_node_max.'<a href="/node/'.$save_node_max.'">Show Content</a>']));

            return $output;
            //    \Drupal::logger('rp-form')->notice('hello from validate');                   
	}









/* 
 	public function submitForm(array &$form, FormStateInterface $form_state) {
    	\Drupal::messenger()->addMessage(t("KI generierte Prompts und Daten: submitForm"));
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

