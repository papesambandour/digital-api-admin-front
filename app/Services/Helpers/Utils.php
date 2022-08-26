<?php


/**
 * Created by PhpStorm.
 * User: PAPE SAMBA NDOUR
 * Date: 2019-05-12
 * Time: 15:38
 */

namespace App\Services\Helpers;

use App\Models\Action;
use App\Models\ActionProfil;
use App\Models\KYCStatus;
use App\Models\LogUser;
use App\Models\SousModule;
use App\Models\StatusFolder;
use App\Models\Subscription;
use App\Models\TypeAction;
use App\Models\User;
use App\Services\Helpers\subscription\KYCStatusServices;
use App\Services\Helpers\subscription\SubscriptionLogsServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;
use App\Models\Attachment;
use phpDocumentor\Reflection\Types\Integer;

class Utils
{
    const CONSTANTES_KEY_API = [
        "MS_PROXY_KEY"=>"123456789098765432112345678"
    ];


    #[ArrayShape(["code_srt" => "string", "code" => "string"])] static public function getCodeConfirm(): array
    {
        $_1 = random_int(100, 999);
        $_2 = random_int(100, 999);
        $_3 = random_int(100, 999);
        return [
            "code_srt" => $_1 . "-" . $_2 . "-" . $_3,
            "code" => $_1 . "" . $_2 . "" . $_3,
        ];

    }

    public static function valdatePassword($password = ''): ?\Illuminate\Support\MessageBag
    {
        $val = validator(['password' => $password], ["password" => "required|max:255|min:2"]);
        //regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/
        if ($val->fails()) {
            return $val->errors();
        } else {
            return null;
        }
    }

    public static function getId_code($code): string
    {
        $query = "SELECT COUNT(a.id) as id FROM action a JOIN sous_module sm on a.sous_module_id = sm.id where sm.code = '" . $code . "' ";
        $res = DB::select($query);
        $id = @$res[0]->id ?: 0;
        return $code . '_' . ++$id;
    }

    public static function can($route): bool
    {
        try {
            $_ = [];
            $_['action'] = json_decode(@$route->action['as'], true);
            $_['uri'] = $route->uri();
            $_['method'] = @$route->methods()[0];
            if (substr($route->uri(), 0, 1) !== "_" && $_['action']) {

                if ($_['action']['authorize'] === true) {
                    return true;
                } else {
                    $user = auth()->user();
                    $action = Action::where('url', $_['uri'])->where('method', strtoupper($_['method']))->first();
                    $isAllow = ActionProfil::where('profil_id', $user->profil_id)
                        ->where('action_id', @$action->id ?: null)->first();
                    if ($isAllow && @$isAllow->state === 1) {
//                        if ($isAllow->state === 1) {
//                            return true;
//                        } else {
//                            return false;
//                        }
                        return true;
                    } else {
                        //sss
                        $includeLow = @$_['action']['include'] == false ? false : @$_['action']['include'];

                        if ($includeLow == false) {
                            return false;
                        } else {
                            //  dd($includeLow);
                            $isInclude = false;
                            $includeLow = array_map(function ($value) use ($_, &$isInclude, $user) {
                                $action = explode('|', $value);
                                $actionFinded = Action::where('url', @$action[0])->where('method', strtoupper(@$action[1]))->first();
                                $affected = ActionProfil::where('profil_id', $user->profil_id)
                                    ->where('action_id', @$actionFinded->id ?: null)->first();
                                // dd($affected);
                                if ($affected) {
                                    if ($affected->state == 1) {
                                        $isInclude = true;
                                    } /*else {
                                        $isInclude = false;
                                    }*/
                                } /*else {
                                    $isInclude = false;
                                }*/
                            }, $includeLow);
                            return $isInclude;
                        }
                        //sss
                    }
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //  dd($e->getMessage());
            return false;
        }
    }

    public static function generateActions(): JsonResponse|array
    {
        try {

            $routes = Route::getRoutes()->getRoutes();
            $carry = [];
            foreach ($routes as $route) {
                $_ = [];
                $_['action'] = json_decode(@$route->action['as'], true);
                $_['uri'] = $route->uri();
                $_['method'] = @$route->methods()[0];
                if (substr($route->uri(), 0, 1) !== "_" && $_['action'] && $_['action']['authorize'] == false /*&& $_['action']['include'] == false*/ && $_['action']['code_sm']) {
                    $carry [] = $_;
                    $type_action = TypeAction::where('code', $_['action']['type'])->first();
                    $sous_module = SousModule::where('code', $_['action']['code_sm'])->first();
                    if (!$sous_module) {
                        throw new \Exception("Sous Module non trouver CODE = " . $_['action']['code_sm']);
                    }
                    if (!$type_action) {
                        throw new \Exception("Type action non trouver CODE = " . $_['action']['type']);
                    }
                    $data[] = ['name' => $_['action']['name'],
                        // 'code' => base64_encode($_['uri'] . strtoupper($_['method'])),
                        // 'code' => $sous_module->code.'-'. static::toNum($_['uri'] . strtoupper($_['method'])) ,
                        'code' => $sous_module->code,
                        'method' => strtoupper($_['method']),
                        'url' => $_['uri'],
                        "type_action_id" => $type_action->id,
                        "sous_module_id" => $sous_module->id,
                        "code_plateforme" => $sous_module->code_plateforme,
                    ];
                }
            }
            DB::beginTransaction();
            $table_action = (new Action())->getTable();
            $table_affectation = (new ActionProfil())->getTable();
            DB::select("SET FOREIGN_KEY_CHECKS = 0");
            DB::select("TRUNCATE table " . $table_affectation);
            DB::select("TRUNCATE table " . $table_action);
            DB::select("SET FOREIGN_KEY_CHECKS = 1");
            // $res =   Action::insert($data);
            foreach ($data as &$a) {
                $a['code'] = static::getId_code($a['code']);
                $res[] = $a_ = Action::create($a);
            }
            DB::commit();
            return Utils::respond('done', $res);
        } catch (\Exception $e) {
            DB::rollBack();
            return Utils::respond('error', $e->getMessage(), true);
        }

    }

    public static function appendActions(): JsonResponse|array
    {
        try {

            $routes = Route::getRoutes()->getRoutes();
            $carry = [];
            foreach ($routes as $route) {
                $_ = [];
                $_['action'] = json_decode(@$route->action['as'], true);
                $_['uri'] = $route->uri();
                $_['method'] = @$route->methods()[0];
                if (substr($route->uri(), 0, 1) !== "_" && $_['action'] && $_['action']['authorize'] == false /*&& $_['action']['include'] == false*/) {
                    $carry [] = $_;
                    $type_action = TypeAction::where('code', $_['action']['type'])->first();
                    $sous_module = SousModule::where('code', $_['action']['code_sm'])->first();
                    if (!$sous_module) {
                        throw new \Exception("Sous Module non trouver");
                    }
                    if (!$type_action) {
                        throw new \Exception("Type action non trouver");
                    }
                    $data[] = ['name' => $_['action']['name'],
                        //   'code' => base64_encode($_['uri'] . strtoupper($_['method'])),
                        'code' => $sous_module->code,
                        'method' => strtoupper($_['method']),
                        'url' => $_['uri'],
                        "type_action_id" => $type_action->id,
                        "sous_module_id" => $sous_module->id,
                        "code_plateforme" => $sous_module->code_plateforme,
                    ];
                }
            }
            DB::beginTransaction();
            $res = [];
            foreach ($data as $a) {


                $_ = $action = Action::where(['url' => $a['url'], 'method' => $a['method']])->first();
                //  dd($action);
                if (isset($action->id)) {
                    unset($a['code']);
                    $action->update($a);
                } else {
                    $a['code'] = static::getId_code($a['code']);
                    $_ = Action::create($a);
                }
                $res[] = $_;

            }
            DB::commit();
            return Utils::respond('done', $res);
        } catch (\Exception $e) {
            DB::rollBack();
            return Utils::respond('error', $e->getMessage(), true);
        }

    }

    public static function routeinfos($data): bool|string
    {
        if (!isset($data['authorize'])) {
            $data['authorize'] = false;
        }
        if (!isset($data['name'])) {
            $data['name'] = "nom generique";
        }
        if (!isset($data['code_sm'])) {
            $data['code_sm'] = null;
        }
        if (!isset($data['include'])) {
            $data['include'] = false;
        }
        if (!isset($data['description'])) {
            $data['description'] = null;
        }
        if (!isset($data['type'])) {
            $data['type'] = [env('CODE_ACTION_LINK')];
        }
        return json_encode($data);
    }

    public static function autoload(): void
    {
        if (getenv('APP_ENV') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');

        }
        chdir(__DIR__ . '/../../routes/proxy');
        $route = __DIR__ . '/../../routes/proxy';
        $allFileRoute = [];
        Utils::getDirContents($route, $allFileRoute);
        array_map(function ($item) {
            if (preg_match('/\.php/', $item)) {
                require $item;
            }
        }, $allFileRoute);

    }

    public static function getDirContents($dir, &$results = array())
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                Utils::getDirContents($path, $results);
                $results[] = $path;
            }
        }

        return $results;
    }

    public static function includeDirectoryRecursive($path): bool
    {
        if (is_dir($path)) {
            if ($path !== '.' && $path !== '..') {
                // chdir($path);
                //  echo "Dire parent : " . $path . '<br>';
                //  dd(scandir($path) );
                foreach (scandir($path) as $pathchild) {
                    if (is_dir($pathchild)) {
                        if ($pathchild !== '.' && $pathchild !== '..')
                            return static::includeDirectoryRecursive($path . '/' . $pathchild);
                    } else {
                        // echo "file : " . realpath($path.'/'.$pathchild) . '<br>';
                        dump($pathchild);
                        if (preg_match('/\.php/', $pathchild))
                            require_once realpath($path . '/' . $pathchild);
                    }

                }

            }
        } else {
            // echo "file : " .  realpath($path) . '<br>';
            dump($path);
            if (preg_match('/\.php/', $path))
                require_once realpath($path);
        }
        return true;
    }

    public static function streamFile($attachment_location, $mimeType): void
    {
        $res = "data:$mimeType;base64," . base64_encode(file_get_contents($attachment_location));
        exec("rm -rf " . $attachment_location);
        exec("rm -rf " . substr($attachment_location, 0, strlen($attachment_location) - 4));
        echo $res;
    }

    public static function validatorImage($extension): bool
    {
        $allowedExtension = [
            "ase",
            "art",
            "bmp",
            "blp",
            "cd5",
            "cit",
            "cpt",
            "cr2",
            "cut",
            "dds",
            "dib",
            "djvu",
            "egt",
            "exif",
            "gif",
            "gpl",
            "grf",
            "icns",
            "ico",
            "iff",
            "jng",
            "jpeg",
            "jpg",
            "jfif",
            "jp2",
            "jps",
            "lbm",
            "max",
            "miff",
            "mng",
            "msp",
            "nitf",
            "ota",
            "pbm",
            "pc1",
            "pc2",
            "pc3",
            "pcf",
            "pcx",
            "pdn",
            "pgm",
            "PI1",
            "PI2",
            "PI3",
            "pict",
            "pct",
            "pnm",
            "pns",
            "ppm",
            "psb",
            "psd",
            "pdd",
            "psp",
            "px",
            "pxm",
            "pxr",
            "qfx",
            "raw",
            "rle",
            "sct",
            "sgi",
            "rgb",
            "int",
            "bw",
            "tga",
            "tiff",
            "tif",
            "vtf",
            "xbm",
            "xcf",
            "xpm",
            "3dv",
            "amf",
            "ai",
            "awg",
            "cgm",
            "cdr",
            "cmx",
            "dxf",
            "e2d",
            "egt",
            "eps",
            "fs",
            "gbr",
            "odg",
            "svg",
            "stl",
            "vrml",
            "x3d",
            "sxd",
            "v2d",
            "vnd",
            "wmf",
            "emf",
            "art",
            "xar",
            "png",
            "webp",
            "jxr",
            "hdp",
            "wdp",
            "cur",
            "ecw",
            "iff",
            "lbm",
            "liff",
            "nrrd",
            "pam",
            "pcx",
            "pgf",
            "sgi",
            "rgb",
            "rgba",
            "bw",
            "int",
            "inta",
            "sid",
            "ras",
            "sun",
            "tga"
        ];
        if (in_array($extension, $allowedExtension)) {
            return true;
        } else {
            return false;
        }
    }

    public static array $statusCodes = [
        'done' => [
            'code' => 200
        ],
        'created' => [
            'code' => 201
        ],
        'updated' => [
            'code' => 201
        ],
        'updated_revoq' => [
            'code' => 205
        ],
        'delete_revoq' => [
            'code' => 205
        ],
        'etat' => [
            'code' => 201
        ],
        'statut' => [
            'code' => 201
        ],
        'removed' => [
            'code' => 204
        ],
        'removed_allready' => [
            'code' => 404
        ],
        'deleted' => [
            'code' => 205
        ],
        'not_valid' => [
            'code' => 400
        ],
        'abonnement_exced' => [
            'code' => 400
        ],
        'valid' => [
            'code' => 200
        ],
        'table_empty' => [
            'code' => 410
        ],
        'not_found' => [
            'code' => 404
        ],
        'conflict' => [
            'code' => 409
        ],
        'permissions' => [
            'code' => 503
        ],
        'token_notfound' => [
            'code' => 401
        ],
        'token_expired' => [
            'code' => 401
        ],
        'token_no_valide' => [
            'code' => 401
        ],
        'token_login_no_valide' => [
            'code' => 403
        ],
        'error' => [
            'code' => 500
        ],
        'state_not_allowed' => [
            'code' => 500
        ],
        'status_not_allowed' => [
            'code' => 500
        ],
        'file_format_not_aloowed' => [
            'code' => 400
        ],
        'format_password_no_valide' => [
            'code' => 400
        ],
        'file_save_success' => [
            'code' => 201
        ],
        'server_disabled' => [
            'code' => 901
        ],
        'server_not_allowed' => [
            'code' => 902
        ],
        'server_not_register' => [
            'code' => 900
        ],
        'server_ip_not_in_way' => [
            'code' => 903
        ],
        'server_domaine_not_in_way' => [
            'code' => 904
        ],
        'disbled' => [
            'code' => 333
        ],
        'loginSucces' => [
            'code' => 200
        ],
        'errrorPaasword' => [
            'code' => 500
        ],
        'plateform_no_allow' => [
            'code' => 403
        ],
        'user_no_existe' => [
            'code' => 404
        ],
        'done_reset' => [
            'code' => 200
        ],
        'not_found_reset' => [
            'code' => 404
        ],
        'code_verify_notwork' => [
            'code' => 403
        ]
    ];

    public static function getContentRule($table): array
    {
        $rules = file_get_contents(__DIR__ . '/rules.json');
        $rules = json_decode($rules);
        return (array)@$rules->$table;
    }

    public static function getRule($table, $id = false, $input = []): array
    {
        $rule_key = static::getContentRule($table);
        if ($id) {
            array_walk($rule_key, function ($value, $key) use (&$rule_key, $id, $table, $input) {
                if (isset($input[$key])) {
                    if (preg_match("/(\|)?unique([^|])*(\|)?/", $rule_key[$key])) {

                        $rule_key[$key] = preg_replace("/(\|)?unique([^|])*(\|)?/", "|unique:$table,$key,$id", $rule_key[$key]);

                    }
                } else {
                    unset($rule_key[$key]);
                }

            });
        }
        return $rule_key;
    }
    public static function getRuleModel($model, $id = false, $input = []): array
    {
        $table = $model->getTable();
        $rule_key = static::getContentRule($table);
        if ($id) {
            array_walk($rule_key, function ($value, $key) use (&$rule_key, $id, $table, $input) {
                if (isset($input[$key])) {
                    if (preg_match("/(\|)?unique([^|])*(\|)?/", $rule_key[$key])) {

                        $rule_key[$key] = preg_replace("/(\|)?unique([^|])*(\|)?/", "|unique:$table,$key,$id", $rule_key[$key]);

                    }
                } else {
                    unset($rule_key[$key]);
                }

            });
        }
        return $rule_key;
    }

    public static function respond($status, $data = [], $error = false, $json = true): JsonResponse|array
    {
        if ($json) {
            return response()->json([
                "code" => @self::$statusCodes[$status]['code'] ?: $status,
                "error" => $error,
                "msg" => @__("resapi." . $status) ?: $status,
                "data" => $data,
                'from' => env('APP_NAME')

            ], 200);
        } else {
            return [
                "code" => @self::$statusCodes[$status]['code'] ?: $status,
                "error" => $error,
                "msg" => @__("resapi." . $status) ?: $status,
                "data" => $data,
                'from' => env('APP_NAME')

            ];
        }


    }

    public static function respondRaw($code, $msg, $data = [], $error = false, $json = true): JsonResponse|array
    {
        if ($json) {
            return response()->json([
                "code" => $code,
                "error" => $error,
                "msg" => $msg,
                "data" => $data,
                'from' => env('APP_NAME')

            ], 200);
        }
        return [
            "code" => $code,
            "error" => $error,
            "msg" => $msg,
            "data" => $data,
            'from' => env('APP_NAME')

        ];


    }

    #[ArrayShape(["error" => "false|mixed", "data" => ""])] public static function res($data, $error = false): array
    {
        return [
            "error" => $error,
            "data" => $data,

        ];

    }

    public static function parseWhere($query): array
    {
        $query = explode(',', $query);
        $query_ = [];
        foreach ($query as &$one) {
            if (count(explode('|', $one)) === 3) {
                $query_[] = explode('|', $one);
            }
        }
        //dd($query_);
        return $query_;
    }

    public static function getOperateur($op): string
    {
        return @self::$tab_operateur[$op];
    }

    public static array $tab_operateur = ["e" => "=", "s" => ">", "i" => "<", "se" => ">=", "ie" => "<=", "d" => "<>", "n" => "null", "l" => "like", "in" => "in", "ni" => "not in"];

    public static function parseWhereChild($query): array
    {
        $query = explode(',', $query);
        $query_ = [];
        foreach ($query as &$one) {
            if (count(explode('|', $one)) === 4) {
                $query_[] = explode('|', $one);
            }
        }
        //dd($query_);
        return $query_;
    }

    public static function getClasseName($table_name): string
    {
        $classe = explode('_', $table_name);
        $model = '';
        foreach ($classe as $item) {
            $model .= ucfirst($item);
        }
        return $model;
    }

    public static function getPathModuleController($name): string
    {
        $classe = explode(' ', $name);
        $model = '';
        foreach ($classe as $item) {
            $model .= ucfirst($item);
        }
        return $model;
    }

    public static function getPathModuleRoute($name): string
    {
        $classe = explode(' ', $name);
        $model = '';

        foreach ($classe as $item) {
            $model .= strtolower($item) . "-";
        }
        return substr($model,0, strlen($model) - 1);
    }

    public static function updateFileFromBase64($fileBase64, $previewFileName, $espaceFolder): int|string
    {
        $base64_image = $fileBase64;
        $extension = static::getExtensionFrom64($base64_image);
        if (strlen($fileBase64) > 100 && static::validatorImage($extension)) {
            $image_decoded = static::getFileFromText64($base64_image);
            $date = (new \DateTime())->format('Y-m-d');
            $Newpath = $espaceFolder . '/' . $date . "/" . uniqid() . '.' . $extension;
            $res = Storage::disk('public')->put($Newpath, $image_decoded);
            if ($res) {
                $previewImgPath = @explode('storage', $previewFileName)[1];
                Storage::delete($previewImgPath);
                return asset('storage/' . $Newpath);
            } else {
                return 2;//Utils::respond('not_valid',['no save update img'],true) ;
            }

        } else {
            return 3;
        }
    }

    public static function saveFileBase64($fileBase64, $espaceFolder): int|string
    {
        $base64_image = $fileBase64;
        $extension = static::getExtensionFrom64($base64_image);
        if (strlen($fileBase64) < 100 || !static::validatorImage($extension)) {
            return 1;//return Utils::respond('not_valid', $validator->errors(),true) ;
        }
        $image_decoded = static::getFileFromText64($base64_image);
        $date = (new \DateTime())->format('Y-m-d');
        $path = $espaceFolder . '/' . $date . "/" . uniqid() . '.' . $extension;
        $res = Storage::disk('public')->put($path, $image_decoded);
        if ($res) {
            return asset('storage/' . $path);
        } else {
            return 2;//Utils::respond('not_valid',['no save update img'],true) ;
        }
    }

    private static function getExtensionFrom64($dateFile64): ?string
    {
        $pos = strpos($dateFile64, ';');
        $type = explode(':', substr($dateFile64, 0, $pos));
        $type = explode('/', @$type[1]);
        return @$type[1];

    }

    private static function getFileFromText64($fileBase64): bool|string
    {
        $pos = strpos($fileBase64, ",", 11);
        $base64_image = substr($fileBase64, $pos, strlen($fileBase64));
        return base64_decode($base64_image);

    }

    #[ArrayShape(['password' => "string", "hash" => "string"])] public static function generatePassword(): array
    {
        $minuscule = 'abcdefghijklmnopqrstuvwxyz';
        $spacial = '#$@';
        $majuscule = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $number = "0123456789";
        $pass = str_shuffle(substr(str_shuffle($minuscule), 0, 3) . substr(str_shuffle($majuscule), 0, 3) . str_shuffle($number)[0] . str_shuffle($spacial)[0]);
        return ['password' => $pass, "hash" => Hash::make($pass)];
    }

    public static function generateUsername($firstName, $lastName, $index = ""): string
    {
        $username = str_replace(" ", '', strtolower($firstName)) . "." .
            str_replace(" ", '', strtolower($lastName));
        if ($index) {
            return $username . "-" . $index;
        }
        return $username;
    }


    public static function split_name($name): array
    {
        $name = trim($name);
        $last_name = (!str_contains($name, ' ')) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));
        return array($first_name, $last_name);
    }

    public static function GUID(): string
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function addFileContent($desPath, $content): void
    {
        $dirname = dirname($desPath);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0777, true);
        }
        clearstatcache();
//        $fp_open = fopen($desPath, "w+");
//        fwrite($fp_open, $content);
//        fclose($fp_open);
        file_put_contents($desPath,$content);
    }

    public static function arrayExclude($array, array $excludeKeys)
    {
        foreach ($excludeKeys as $key) {
            unset($array[$key]);
        }
        return $array;
    }

    #[ArrayShape(['password' => "string", "hash" => "string"])] public static function generateKey(): array
    {
        //$minuscule = 'abcdefghijklmnopqrstuvwxyz';
        $minuscule = '2345689';
        //$spacial = '#$@';
        $spacial = '12345689';
        $majuscule = "2345689234568923456892345689";
        $number = "2345689";
        $pass = str_shuffle(substr(str_shuffle($minuscule), 0, 3) . substr(str_shuffle($majuscule), 0, 3) . str_shuffle($number)[0] . str_shuffle($spacial)[0]);
        return ['password' => $pass, "hash" => Hash::make($pass)];
    }

    public static function encrypt_decrypt($string, $action = 'encrypt'): bool|string
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = env('JWT_SECRET'); // user define private key
        $secret_iv = env('APP_KEY'); // user define secret key
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
        $output='';
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
    public static function sanitize($string): array|string|null
    {
        $string = strtolower(preg_replace('/\s+/', '', $string));
        return preg_replace('/[^a-z]/', '', $string);
    }


    public static function getPseudo($nom, $prenom): string
    {
//        if (empty($nom) || empty($prenom)){
//            throw new \Exception("Le nom et le prenom ne peuvent pas être vide");
//        }
        $nom = Utils::sanitize($nom);
        $prenom = Utils::sanitize($prenom);
        $pseudo = $prenom.'.'.$nom;
        // $pseudo = 'pedro';
        $users = User::where('pseudo',$pseudo)->first();
        $i=1;
        $pseudoNew = $pseudo;
        while ($users) {
            $pseudoNew = $pseudo.$i;
            $users = User::where('pseudo',$pseudoNew)->first();
            $i++;
        }
        return $pseudoNew;
    }
    public static function generateCode($name,$model): string
    {
        $code = strtoupper(\Illuminate\Support\Str::slug($name));
        $item = $model::where('code',$code)->first();
        $i=1;
        $pseudoNew = $code;
        while ($item) {
            $pseudoNew = $code.'-'.$i;
            $item = $model::where('code',$pseudoNew)->first();
            $i++;
        }
        return $pseudoNew;
    }

    public static function random_color_part(): string
    {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    public static function random_color(): string
    {
        return '#' . self::random_color_part() . self::random_color_part() . self::random_color_part();
    }
    public static function finishUserLog($model =null,$type=null,?string $status='SUCCESS',?string $errorMessage=''): void
    {
        $logUser = LogUser::find(request()->get('_logUser_'));
        try {
            if($model){
                $logUser->id_line =  $model[$model->getKeyName()];
                $logUser->table_name = $model->getTable();
            }
            if($type){
                $logUser->type_action = $type;
            }

            $logUser->status_action =$status;
            $logUser->error_message =$errorMessage;
            $logUser->save();
        } catch (\Exception $e) {
            $logUser->status_action ='FAILED';
            $logUser->error_message =json_encode(['message'=>$e->getMessage(),'content'=>$e->getTrace()]);
            $logUser->save();
            //Log::error(json_encode(['message'=>"Failed finish log User",'content'=>$e->getTrace()]));
        }
    }
    public static array $TYPE_ACTION = [
        'ADD'=>'ADD',
        'UPDATE'=>'UPDATE',
        'LISTE'=>'LISTE',
        'DELETE'=>'DELETE',
        'SHOW'=>'SHOW',
        'STATE'=>'STATE',
        'STATE_ACTIVE'=>'STATE_ACTIVE',
        'STATE_DISABLED'=>'STATE_DISABLED',
        'STATUS'=>'STATUS',
    ];

    public static function saveImageInRetouch(string $fileBase64 ,string $path): bool|string
    {
        $base64_image = $fileBase64;
        $extension = static::getExtensionFrom64($base64_image);
        if (strlen($fileBase64) < 100 || !static::validatorImage($extension)) {
            return false;
        }
        $image_decoded = static::getFileFromText64($base64_image);
        $date = (new \DateTime())->format('Y-m-d');
        $path = dirname($path) . '/' . $date . "-" . uniqid() . '.' . $extension;
        self::addFileContent($path, $image_decoded);
        return $path;
    }

    public static function definedRelations($object): array
    {
        $reflector = new \ReflectionClass(get_class($object));
        return collect($reflector->getMethods())
            ->filter(
                fn($method) => !empty($method->class) &&
                    str_contains(
                        $method->class,
                        'App\Models'
                    ) &&
                    str_contains(
                        $method->getFileName(),
                        'app/Models'
                    )&&
                    !str_contains(
                        $method->name,
                        'boot'
                    )
            )
            ->pluck('name')
            ->all();
    }

}
