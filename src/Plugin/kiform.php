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
class kiform extends Formbase {





  public function getFormId() {
    return 'kiform1';
  }


	public function buildForm(array $form, FormStateInterface $form_state) {
	      //  $form['kiform'] = [ '#type' => 'textfield', '#title' => t('writeprompt'), '#required' => TRUE, '#attributes' => [ 'class' => ['custom-field'], 'style' => 'width: 50%;',  ], ];
        	
		$form['gp'] = [
      			'#type' => 'textfield',
      			'#title' => $this->t('Prompt'),
    		]; 

   		 $form['submit'] = [ 
      			'#type' => 'submit',
      			'#value' => $this->t('Erzeuge einen Artikel-Text'),
	    	];
		return $form;
	}



  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('Dein Prompt @gp', ['@gp' => $form_state->getValue('gp')]));

	
		if($form_state->getValue('gp')) {




			$api_key = Settings::get('set_apikey_openai', NULL);
				$prompt = $_POST['gp'];

				if (!empty($prompt) && $_POST['gp']) {
					$endpoint = "https://api.openai.com/v1/chat/completions"; 
					//$endpoint = "https://api.openai.com/v1/images"; 
					$response = getAPIResponse($prompt, $endpoint, $api_key);
					//echo "<h2>KI:</h2>";
						//$response = str_replace(' - ',  '<br /><br />- ', $response);
						//$response = str_replace('** *', '**<br /><br />*', $response);
						//$response = str_replace('* **', '*<br /><br />**', $response);

						//$response = str_replace(' **', '**<br /><br />', $response);
						//$response = str_replace('###', '###<br /><br />', $response);




					$output.= $response;
				} else {
					$output.= '';
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

			



            //Create Drupal Node and save
            $node = Node::create([
            'type' => 'article',
                'title' => $prompt,
                'uid' => 1, // Replace with the user ID
                'langcode' => Language::LANGCODE_NOT_SPECIFIED, // Or the appropriate language code
            'status' => 0, // Published
            'promote' => 0, // Promoted to front page
            ]);
            $node->set('body', $output);
            $node->save();
        
             //print Ki text
			 \Drupal::messenger()->addMessage($output);
             


		}








/*
        public function build() {

                $content = array(
                                '#type' => 'inline_template',
                                '#markup' => $this->t('AI: test '),
                                '#template' => $showonsite.'<br /><br /><br />2show content for AI',
                                );
                return $content;
        }
*/

/*  	public function submitForm(array &$form, FormStateInterface $form_state) {
    		\Drupal::messenger()->addMessage(t("KI generierte Prompts und Daten:"));
		foreach ($form_state->getValues() as $key => $value) {
		  \Drupal::messenger()->addMessage($key . ': ' . $value);
    		}
  	}
*/

















    function getAPIResponse($prompt, $endpoint, $api_key) {
        // Initialisiere die cURL-Sitzung
        $ch = curl_init($endpoint);

        // Setze cURL-Optionen
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $api_key",
            "Content-Type: application/json"
        ));

        // Nutzlast für den Chat-Eingang unter Verwendung der Nachrichtenstruktur
        // gpt-4o-mini
        // billig: gpt-4.1-nano
        $data = array(
            'model' => 'gpt-4.1-mini',            
            'messages' => array(
                array('role' => 'system', 'content' => 'Sie sind ein hilfreicher A.'),
                array('role' => 'user', 'content' => $prompt)
            )
            /*
            'input' => 'porttraitfoto von klimaforscher, comic art',
            'tools' => array(
                array('type' => 'image_generation')
            )
            */
        );



        $data_string = json_encode($data);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Führe die cURL-Sitzung aus
        $response = curl_exec($ch);

        // Überprüfe auf cURL-Fehler
        if(curl_errno($ch)){
            echo 'Curl-Fehler: ' . curl_error($ch);
            exit;
        }

        // Dekodiere die Antwort
        $response_data = json_decode($response, true);

        // Überprüfe, ob der Schlüssel 'choices' in der Antwort vorhanden ist und ob der Nachrichteninhalt vorhanden ist
        if (!isset($response_data['choices']) || !isset($response_data['choices'][0]['message']['content'])) {
            echo "Fehler: Unerwartete API-Antwort.<br>";
            echo "Vollständige Antwort:<br>";
            print_r($response_data);
            exit;
        }

        // Hole die Antwort aus der API-Antwort
        $answer = $response_data['choices'][0]['message']['content'].'test';

        // Schließe die cURL-Sitzung
        curl_close($ch);



/*
        //Show Last NodeID
        $node_count = db_result(db_query("SELECT COUNT(*) FROM {node}"));
        $topics_count = db_result(db_query("SELECT COUNT(*) FROM {node} WHERE type = 'article'"));
        $users_count = db_result(db_query("SELECT COUNT(*) FROM {users}"));
        $answer.= "Node count = $node_count<br />\nTopics count = $topics_count<br />\nUsers count = $users_count<br />\n";

        $query = \Drupal::entityQuery('node');
        $query->accessCheck(FALSE)
        ->condition('type', 'article')
        ->sort('changed', 'DESC')
        ->range(0, 9);

        $nids = $query->execute();
*/
        return $answer.$nids; 
    } 



}





//class main extends FormBase {
//        public function buildForm(array $form, FormStateInterface $form_state) {
//        $form['kitext'] = [ '#type' => 'textfield', '#title' => t('writeprompt'), '#required' => TRUE, '#attributes' => [ 'class' => ['custom-field'], 'style' => 'width: 50%;',  ], ];
//        return $form;

//        }
//}


