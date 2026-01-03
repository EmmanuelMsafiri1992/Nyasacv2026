<?php

namespace App\Http\Controllers;

use App\Library\Helper;
use App\User;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class InstallController extends Controller
{
    private $minPhpVersion = '7.1.5';
    

    private $permissions = [
        
        'bootstrap/cache'   => '0775',
        'storage'           => '0775',
        'storage/framework' => '0775',
        'storage/logs'      => '0775',
        'storage/app'       => '0775',
        
    ];

    private $extensions    = [
        'openssl',
        'pdo',
        'gd',
        'tokenizer',
        'JSON',
        'bcmath',
        'exif',
        'mbstring',
        'xml',
        'ctype',
        'cURL',
    ];

    public function installCheck(Request $request)
    {
        // Clear cache, routes, views
        Artisan::call('optimize:clear');

        $passed = true;

        // Permissions checker
        $results['permissions'] = [];
        foreach ($this->permissions as $folder => $permission) {
            $results['permissions'][] = [
                'folder'     => $folder,
                'permission' => substr(sprintf('%o', fileperms(base_path($folder))), -4),
                'required'   => $permission,
                'success'    => substr(sprintf('%o', fileperms(base_path($folder))), -4) >= $permission ? true : false,
            ];
        }

        // Extension checker
        $results['extensions'] = [];
        foreach ($this->extensions as $extension) {
            $results['extensions'][] = [
                'extension' => $extension,
                'success'   => extension_loaded($extension),
            ];
        }

        // PHP version
        $results['php'] = [
            'installed' => PHP_VERSION,
            'required'  => $this->minPhpVersion,
            'success'   => version_compare(PHP_VERSION, $this->minPhpVersion) >= 0 ? true : false,
        ];

        // Pass check
        foreach ($results['permissions'] as $permission) {
            if ($permission['success'] == false) {
                $passed = false;
                break;
            }
        }

        foreach ($results['extensions'] as $extension) {
            if ($extension['success'] == false) {
                $passed = false;
                break;
            }
        }

        if ($results['php']['success'] == false) {
            $passed = false;
        }
        return view('install.requirements', compact(
            'results',
            'passed'
        ));

    }
    public function installDB($passed){

        if($passed){
            return view('install.database', compact(
                'passed'
            ));
        }
        abort(404);
    }

    public function installDBPost(Request $request)
    {
        $request->validate([
            'APP_URL'     => 'required|url',
            'DB_HOST'     => 'required|string|max:50',
            'DB_PORT'     => 'required|numeric',
            'DB_DATABASE' => 'required|string|max:50',
            'DB_USERNAME' => 'required|string|max:50',
            'DB_PASSWORD' => 'nullable|string|max:50',
        ]);

        // Check DB connection
        try {

            $pdo = new \PDO(
                'mysql:host=' . $request->DB_HOST . ';port=' . $request->DB_PORT . ';dbname=' . $request->DB_DATABASE,
                $request->DB_USERNAME,
                $request->DB_PASSWORD, [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                ]
            );

        } catch (\PDOException $e) {

            return redirect()->back()
                ->with('error', 'Database connection failed: ' . $e->getMessage());

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Database error: ' . $e->getMessage());

        }

       
        try {

            Helper::setEnv([
                'APP_URL'     => $request->APP_URL,
                'APP_ENV'     => 'production',
                'APP_DEBUG'   => 'false',
                'DB_HOST'     => $request->DB_HOST,
                'DB_PORT'     => $request->DB_PORT,
                'DB_DATABASE' => $request->DB_DATABASE,
                'DB_USERNAME' => $request->DB_USERNAME,
                'DB_PASSWORD' => $request->DB_PASSWORD,
            ]);

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Can\'t save changes to .env file: ' . $e->getMessage());

        }

        return redirect()->route('install.setup');

    }

    public function setup()
    {
        // Application key
        try {

            Artisan::call('key:generate', ["--force" => true]);

        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()
                ->with('error', 'Can\'t generate application key: ' . $e->getMessage());

        }

        // Migrate
        try {

            Artisan::call('migrate', ["--force" => true]);

        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()
                ->with('error', 'Can\'t migrate database: ' . $e->getMessage());

        }

        return redirect()->route('install.administrator');
    }

    public function install_administrator()
    {
        return view('install.administrator');
    }

    public function install_finish(Request $request)
    {
        $request->validate([
            'name'     => [
                'required',
                'string',
                'max:30',
                'regex:/^[a-zA-Z\s\-\'\.]+$/',
                function ($attribute, $value, $fail) {
                    // Block URLs, links, and common spam patterns
                    if (preg_match('/(https?:\/\/|www\.|\.com|\.net|\.org|\.io|\.co|http)/i', $value)) {
                        $fail(__('The :attribute cannot contain URLs or links.'));
                    }
                    // Block common spam patterns
                    if (preg_match('/(\$\d+|\d+\$|payment|confirm|transaction|click here|hs=|xxx)/i', $value)) {
                        $fail(__('The :attribute contains invalid content.'));
                    }
                },
            ],
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|same:password_confirmation',
        ]);

        // Create admin account
        $user = User::create([
            'is_admin' => true,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // Default template
        $pathSeedSQL = database_path('seeds/default_template.sql');
            
        \DB::unprepared(file_get_contents($pathSeedSQL));

        // Create packages
        $packages = [
            [
                'title'       => 'Started',
                'price'       => 15.2,
                'interval'    => 'month',
                'interval_number' => '1',
                'settings'    => [
                    'export_pdf'=> 1,
                    'template_premium'=> 1,
                ],
                'is_featured' => false,
            ],
            [
                'title'       => 'Pro',
                'price'       => 30.95,
                'interval'    => 'month',
                'interval_number' => '3',
                'settings'    => [
                    'export_pdf'=> 1,
                    'template_premium'=> 1,
                ],
                'is_featured' => true,
            ],
            [
                'title'       => 'Super Pro',
                'price'       => 45.95,
                'interval'    => 'month',
                'interval_number' => '6',
                'settings'    => [
                    'export_pdf'=> 1,
                    'template_premium'=> 1,
                ],
                'is_featured' => false,
            ]

        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
        // Save installation
        touch(storage_path('installed'));
        

        return view('install.success');
        // return redirect()->route('landing')
        //     ->with('success', 'Installation finished successfully');

    }

    
}
