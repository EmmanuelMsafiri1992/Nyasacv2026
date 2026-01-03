<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Resume;
use App\Models\ResumeTemplate;

class Billing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        
        if (!$user->can('admin')) {

                $requestInfo = $request->getPathInfo();
            

                if(strpos($requestInfo, 'createresume') == true) {

                    $data = ResumeTemplate::find($request->template);

                    $is_premium = $data->is_premium;

                    if($is_premium)
                    {
                        if( $user->subscribed() && isset($user->package->template_premium) && $user->package->template_premium == 1){
                            return $next($request);
                        }
                        return redirect()->route('billing.index')
                        ->with('error', __('This is a <b>Premium Template</b>. Please subscribe to a plan that includes premium templates to use this design.'));
                    }
                    else{
                        return $next($request);
                    }
                    
                }
                        
        }

        return $next($request);
    }
    
    private function checkTemplatePremium($template){
        // Get templates

        $config = array();
        
        $template_path = 'resume_resume_template/' . $template;

        if (\Storage::disk('public_resume')->exists($template_path . '/config.php')) {

            $path = "".$template_path;
            $config =  include($path . '/config.php');

            if(isset($config['type']) && $config['type'] == "premium"){
                return true;
            }
            else{
                return false;
            }

        }
        abort(404);

    }
}
