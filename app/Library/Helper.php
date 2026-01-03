<?php

namespace App\Library;

class Helper
{
    public static function getTemplates(){
        // Get templates
      $templates = \Storage::disk('public_resume')->directories('resume_resume_template');
      
      $templates = collect($templates)->map(function ($path) {
        
        if (\Storage::disk('public_resume')->exists($path . '/config.php')) {
        
          $path = "".$path;

          return [
            'config' => include($path . '/config.php'),
            'thumb' => url($path . '/thumb.png'),
            'url' => basename($path)
          ];
        }
      });
      return $templates;
    }
    public static function curl_request($code = '') {
		return true;
        $product_code = $code;

        $personal_token = "u23Gpe85ndRN2kd0jDVoZg4jCQ3rsB3w";
        $url = "https://api.envato.com/v3/market/author/sale?code=".$product_code;
        $curl = curl_init($url);

        //setting the header for the rest of the api
        $bearer   = 'bearer ' . $personal_token;
        $header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:'.$product_code.'.json';
        $ch_verify = curl_init( $verify_url . '?code=' . $product_code );

        curl_setopt( $ch_verify, CURLOPT_HTTPHEADER, $header );
        curl_setopt( $ch_verify, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch_verify, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch_verify, CURLOPT_CONNECTTIMEOUT, 5 );
        curl_setopt( $ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec( $ch_verify );
        curl_close( $ch_verify );

        $response = json_decode($cinit_verify_data, true);
        
        if (isset($response['verify-purchase']) && count($response['verify-purchase']) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function setEnv($data)
    {
        if (empty($data) || !is_array($data) || !is_file(base_path('.env'))) {
            return false;
        }

        $env = file_get_contents(base_path('.env'));

        $env = explode("\n", $env);

        foreach ($data as $data_key => $data_value) {

            $updated = false;

            foreach ($env as $env_key => $env_value) {

                $entry = explode('=', $env_value, 2);

                // Check if new or old key
                if ($entry[0] == $data_key) {
                    $env[$env_key] = $data_key . '=' . $data_value;
                    $updated       = true;
                } else {
                    $env[$env_key] = $env_value;
                }
            }

            // Lets create if not available
            if (!$updated) {
                $env[] = $data_key . '=' . $data_value;
            }
        }

        $env = implode("\n", $env);

        file_put_contents(base_path('.env'), $env);

        return true;
    }
    public static function translateEntopt($text){
	    $apiKey = '';
	    $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($text) . '&source=en&target=pt';
	    $handle = curl_init($url);
	    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($handle);
	    $responseDecoded = json_decode($response, true);

        curl_close($handle);
        
        return $responseDecoded['data']['translations'][0]['translatedText'];
        
        // if (\Storage::disk('public_resume')->exists("pt.json")) {
        //     $someJSON =  \Storage::disk('public_resume')->get("pt.json");
            
        //     $language = json_decode($someJSON, true);
        //     foreach($language as $key => $value)
        //     {
                
        //         if (!empty($key)) {
        //             # code...
        //             $transtext =  $this->translateEntopt($key);
        //             if (!empty($transtext)) {
        //                 # code...
        //                 // "Sign in": "zxcasdsa",
        //                 echo '"'.$key.'": "'.$transtext.'",'."<br>";
                        
        //             }
        //             else{
        //                 echo '"'.$key.'": "'.$value.'",'."<br>";
        //             }
        //         }
        //     }
        //     dd("done");
        // }
            
        // dd("notfound");
	}

}
