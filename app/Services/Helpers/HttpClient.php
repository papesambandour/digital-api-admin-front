<?php
/**
 * Created by PhpStorm.
 * User: PAPE SAMBA NDOUR
 * Date: 2022-05-18
 * Time: 11:02
 */

namespace App\Services\Helpers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Http\Message\StreamInterface;

class HttpClient
{
    private static $httpClient;
    private static function getHttpClient() : Client{
        if(static::$httpClient === null)
        {
            self::$httpClient = new Client([
                'curl' => [
                    'body_as_string' => true,
                ],
                'allow_redirects' => true,
                'verify' => false
            ]);
        }
        return self::$httpClient  ;
    }
    public static function get($url,$options = ['data'=>[],'headers'=> [] ],$jsonResponseOnerror=false){
        return static::precess($url,$options,'get',true);
    }
    public static function post($url,$options = ['data'=>[],'headers'=> [] ],$jsonResponseOnerror=false){

        return static::precess($url,$options,'post',false,$jsonResponseOnerror);
    }
    public static function put($url,$options = ['data'=>[],'headers'=> [] ],$jsonResponseOnerror=false){

        return static::precess($url,$options,'put',false,$jsonResponseOnerror);
    }
    public static function delete($url,$options = ['data'=>[],'headers'=> [] ],$jsonResponseOnerror=false){

        return static::precess($url,$options,'delete',true,$jsonResponseOnerror);
    }
    private static function setDefault($options,$get = false){

        if(!isset($options['headers']['Content-Type'])){
            $options['headers']['Content-Type'] = 'application/json';
        }
        $options['headers'][env('SECURITY_SERVER_NAME')] = env('MS_CRUD_KEY');
        if(!isset($options['headers']['Accept'])){
            $options['headers']['Accept'] = 'application/json';
        }
        if($get === true){
            return [
                RequestOptions::HEADERS =>$options['headers'],
                'query' => $options['data']
            ];
        }

        if(str_contains($options['headers']['Content-Type'],'application/json') ){
            return [
                RequestOptions::HEADERS =>$options['headers'],
                RequestOptions::JSON => $options['data']
            ];
        }else{
            return [
                RequestOptions::HEADERS =>$options['headers'],
                RequestOptions::FORM_PARAMS => $options['data']
            ];
        }



    }
    #[ArrayShape(['query' => "mixed"])] private static function setDefaultSoap($options, ): array
    {

            return [
                'query' => $options['data']
            ];


    }
  #[ArrayShape([RequestOptions::HEADERS => "string[]", RequestOptions::BODY => "mixed"])] private static function setDefaultSoapPost($options, ): array
    {

            return [
                RequestOptions::HEADERS =>[
                    'Content-Type' => 'text/xml; charset=UTF8',
                ],
                RequestOptions::BODY => $options['data']
            ];


    }
    public static function precess($url,$options,$methode,$isGet= false,$jsonResponseOnerror=false){
        try{
            $response =static::getHttpClient()->$methode( $url,static::setDefault($options,$isGet));
           /* if($response->getStatusCode() === 200)
            {
                $responseBody = \GuzzleHttp\json_decode($response->getBody());
                return HttpClient::object_to_array($responseBody);
            }else{
                return Utils::respond('error',$response->getBody(),true);
            }*/
            $responseBody = \GuzzleHttp\json_decode($response->getBody());
          //  $responseBody['statusCodeHttp']=$response->getStatusCode() ;
            return HttpClient::object_to_array($responseBody);
        }catch (\Exception $exception){
            return Utils::respondRaw($exception->getCode(),$exception->getMessage(),[],true,$jsonResponseOnerror);
        }
    }
    private static function object_to_array($obj) {
        //only process if it's an object or array being passed to the function
        if(is_object($obj) || is_array($obj)) {
            $ret = (array) $obj;
            foreach($ret as &$item) {
                //recursively process EACH element regardless of type
                $item =HttpClient::object_to_array($item);
            }
            return $ret;
        }
        //otherwise (i.e. for scalar values) return without modification
        else {
            return $obj;
        }
    }
    public static function getOptions($request){
        $headers = [];
        foreach ((array)$request->headers as $headers_){
            $headers = $headers_ ;
            break;
        }
        $data = (array)$request->all();
        $h = [];
        array_walk($headers,function ($value,$key)use(&$headers,&$h){
            $_ = explode('-',$key);
            $_ = ucfirst(@$_[1]) ?  ucfirst(@$_[0]) .'-'. ucfirst(@$_[1]) : ucfirst(@$_[0]);
            if(strtolower($key) !=='host')
                $h[$_]= @$value[0];
        });
        //  dd( $h);

        return ['data'=>$data,"headers"=>$h] ;
    }
    public static function overiteParams($option,$newData){
        //overide the first array |
        $option['data'] = array_merge($option['data']?:[],$newData) ;
        return $option;
    }
    public static function concate($option,$newData){
        foreach ($newData as $key=> $itemData){
            if(@$option['data'][$key]){
                $option['data'][$key] = $option['data'][$key] . ','.$itemData;
            }else{
                $option['data'][$key] = $itemData;
            }
        }
        return $option;
    }

    /**
     * @throws GuzzleException
     */
    public static function soap(string $url,$data)
    {
        $response =static::getHttpClient()->get( $url,static::setDefaultSoap($data));
        return $response->getBody();
    }
    /**
     * @throws GuzzleException
     */
    public static function soapPost(string $url,$data): StreamInterface
    {
        $response =static::getHttpClient()->post( $url,static::setDefaultSoapPost($data));
        return $response->getBody();
    }
}
