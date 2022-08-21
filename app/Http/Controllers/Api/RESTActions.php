<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\Helpers\Utils;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ReflectionClass;
use Yajra\Datatables\Datatables;


trait RESTActions {
    protected int $page = 10 ;
    public function edit($id,Request $request){

        try {
            $state = intval($request->get('state'));
            $statut = intval($request->get('statut'));
            /**
             * On verifie l'existence de la variable `state` passée en variable dans le GET
             */
            if(isset($_GET['state']) ){
                /*
                 * la verifie la variable `state` est soit `0` soit `1`
                 */
                if($state !== 0 && $state !== 1){
                    return Utils::respond('not_valid',[],true) ;
                }
                /**
                 * On initialise la variable `MODEL` déclaré dans le controlleur courant
                 */
                $m = self::MODEL;
                $model = $m::find($id);
                if (is_null($model) ) {
                    return Utils::respond('not_found',[],true);
                }
                /*
                 * retourner 'state_not_allowed'|400 si la colonne `state` n'existe pas dans la table
                 */
                if(!array_key_exists('state',$model->getAttributes()) ){
                    return Utils::respond('state_not_allowed',[],true);
                }
                /**
                 * On change et persite le 'state' dans la base de donnees
                 */
                $model->state=$state;
                $model->save();
                return Utils::respond('statut', $model);//['state'=>$model->state]

            }
            /**
             * Dans le elseif c'est le même principe que dans le if
             */
            elseif (isset($_GET['statut']) ){

                /*
               * la verifie la variable `state` est soit `0` soit `1` soit `2`
               */
                if($statut !== 0 && $statut !== 1 && $statut !== 2){
                    return Utils::respond('not_valid',[],true) ;
                }


                /**
                 * On initialise la variable `MODEL` déclaré dans le controlleur courant
                 */
                $m = self::MODEL;
                $model = $m::find($id);
                if (is_null($model) ) {
                    return Utils::respond('not_found',[],true);
                }

                //  dd(array_key_exists('state',$model->gstatetributes()));die;
                if(!array_key_exists('statut',$model->getAttributes()) ){
                    return Utils::respond('status_not_allowed',[],true);
                }

                //$model->update(['statut'=>$statut]);
                $model->statut=$statut;
                $model->save();
                return Utils::respond('statut', $model);//['state'=>$model->state]

            }else{
                die('ol');
            }

        } catch (\Exception $e) {
            if(getenv('APP_DEBUG') == 'true'){
                return Utils::respond('not_valid', $e->getMessage(),true) ;
            }else{
                return Utils::respond('not_valid',[],true) ;
            }
        }
    }

    public function index(Request $request)
    {
        try {
            /*
            |--------------------------------------------------------------------------------------------\
            |                               INIT PARAMARS START                                           |
            |--------------------------------------------------------------------------------------------/
            */

            $m = self::MODEL;
            $model = $model = $m::where( (new $m())->getTable() .'.state','<>',2);
            /*
            |--------------------------------------------------------------------------------------------\
            |                               INIT PARAMARS END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               CLAUSE WHERE START                                           |
            |--------------------------------------------------------------------------------------------/
            */
            if($request->get('where')){
                $qyery = Utils::parseWhere($request->get('where'));
                foreach ($qyery as $on){
                    if($on[2] == "null")
                    {
                        $on[2] = null ;
                    }
                    if($on[1] == "in"){
                        $on[2] = explode('-',$on[2]) ;
                        $model =  $model->whereIn(@$on[0],@$on[2]);
                    }elseif ($on[1] == "l"){
                        $model =  $model->where(@$on[0],@Utils::getOperateur(@$on[1]),"%" . @$on[2] ."%");
                    }
                    else{
                        // dd(@Utils::getOperateur(@$on[2]));
                        $model =  $model->where(@$on[0],@Utils::getOperateur(@$on[1]),@$on[2]);
                    }
                }
            }
            /*
            |--------------------------------------------------------------------------------------------\
            |                               CLAUSE WHERE END                                           |
            |--------------------------------------------------------------------------------------------/
            */
            /*
        |--------------------------------------------------------------------------------------------\
        |                               CLAUSE WHERE OR START                                           |
        |--------------------------------------------------------------------------------------------/
        */
            if($request->get('where_or')){

                $qyery = Utils::parseWhere($request->get('where_or'));


                // dd(@Utils::getOperateur(@$on[2]));
                $model =  $model->where(function ($query)use($qyery){
                    foreach ($qyery as $on){
                        if($on[2] == "null")
                        {
                            $on[2] = null ;
                        }
                        if($on[1] == "in"){
                            $on[2] = explode('-',$on[2]) ;
                            $query->orWhereIn(@$on[0],@$on[2]);
                        }elseif ($on[1] == "l"){
                            $query->orWhere(@$on[0],@Utils::getOperateur(@$on[1]),"%" .@$on[2] ."%");
                        }
                        else{
                            // dd(@Utils::getOperateur(@$on[2]));
                            $query->orWhere(@$on[0],@Utils::getOperateur(@$on[1]),@$on[2]);

                        }
                    }
                });

            }
            //dd(dd($model->toSql()));
            /*
            |--------------------------------------------------------------------------------------------\
            |                               CLAUSE WHERE OR END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               CLAUSE WHERE CHILD START                                           |
            |--------------------------------------------------------------------------------------------/
            */
            $child_where = $request->get('child_where');
            if ($child_where){
                $qyery_where_child = Utils::parseWhereChild($child_where);
                foreach ($qyery_where_child as $on){
                    $child_on_child_where = @$on[0];
                    $model = $model->whereHas($child_on_child_where,function ($query) use ($on){
                        $field = @$on[1];
                        $operator = @$on[2];
                        $value = @$on[3] == "null" ? null : @$on[3];
                        if($operator == "in"){
                            $value = explode('-',$value) ;
                            $query->whereIn($field,$value);
                        }elseif ($operator == "l"){
                            $query->where($field,Utils::getOperateur($operator),"%".$value."%");
                        }
                        else{
                            $query->where($field,Utils::getOperateur($operator),$value);
                        }
                    });
                }
            }
            /*
            |--------------------------------------------------------------------------------------------\
            |                               CLAUSE WHERE CHILD END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
        |--------------------------------------------------------------------------------------------\
        |                               CLAUSE WHERE CHILD OR START                                           |
        |--------------------------------------------------------------------------------------------/
        */
            $child_where_or = $request->get('child_where_or');
            if ($child_where_or){
                $model =  $model->where(function ($query_) use ($child_where_or){
                    $qyery_where_child = Utils::parseWhereChild($child_where_or);
                    foreach ($qyery_where_child as $on){
                        $child_on_child_where = @$on[0];
                        $query_->orWhereHas($child_on_child_where,function ($query) use ($on){
                            $field = @$on[1];
                            $operator = @$on[2];
                            $value = @$on[3] == "null" ? null : @$on[3];
                            if($operator == "in"){
                                $value = explode('-',$value) ;
                                $query->whereIn($field,$value);
                            }elseif ($operator == "l"){
                                $query->where($field,Utils::getOperateur($operator),"%".$value ."%");
                            }
                            else{
                                $query->where($field,Utils::getOperateur($operator),$value);
                            }
                        });
                    }
                });

            }
            //dd(dd($model->toSql()));
            /*
            |--------------------------------------------------------------------------------------------\
            |                               CLAUSE WHERE CHILD OR END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               ORDER BY START                                           |
            |--------------------------------------------------------------------------------------------/
            */
            $sort=explode(',',$request->get("__order__"));
            if(@$sort[0] && in_array(@$sort[0],["asc","desc"])){
                $sort [1] = isset( $sort [1]) ?  $sort [1] : 'id' ;
                $model =   $model->orderBy(@$sort [1],@$sort [0]);
            }
            /*
            |--------------------------------------------------------------------------------------------\
            |                               ORDER BY END                                           |
            |--------------------------------------------------------------------------------------------/
            */
            /*
            |--------------------------------------------------------------------------------------------\
            |                               LIMIT START                                           |
            |--------------------------------------------------------------------------------------------/
            */
            $limit=$request->get("__limit__");
            if($limit){
                $model =   $model->limit((int)$limit);
            }
            /*
            |--------------------------------------------------------------------------------------------\
            |                               LIMIT END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               SELECT FILDS START                                           |
            |--------------------------------------------------------------------------------------------/
            */
            $field= $request->get('__field__');
            if($field){
                $field_map =explode(',',$field);
                $model =   $model->select($field_map);
            }
            /*
            |--------------------------------------------------------------------------------------------\
            |                               SELECT FILDS END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               PAGINATION START                                           |
            |--------------------------------------------------------------------------------------------/
            */
//            $page = $request->get('page');
//            if($page){
//                $model = $model->paginate($this->page);
//            }else{
//                //die("f");
//                $model = $model->get();
//            }
            /*
            |--------------------------------------------------------------------------------------------\
            |                               PAGINATION END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               SELECT DISTINCT START                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               SELECT DISTINCT END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               LEZY LOADING AND EAGGER  START                                           |
            |--------------------------------------------------------------------------------------------/
            */
            $activeEager = $request->get('eagger');
            $child =  explode(',',$request->get('child'));
            $class= self::MODEL;
            $definedRelations = Utils::definedRelations(new $class) ;
            if(count($child) ){
                if($child[0] == ""){
                    $child = null ;
                }
            }
            if($activeEager == 1 && count($definedRelations)){
                //dd($definedRelations);
                array_walk($definedRelations,function ($ch)use(&$model){
                    $model->with($ch);
                });
            } else if (is_array($child)){

                array_walk($child,function ($ch)use(&$model,$class,$definedRelations){
                    if(in_array(explode('.',$ch)[0],$definedRelations )){
                        $model->with($ch);
                    }
                });
            }
            /*
            |--------------------------------------------------------------------------------------------\
            |                               LEZY LOADING AND EAGGER  END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               PROCESSING RESPONSE  START                                           |
            |--------------------------------------------------------------------------------------------/
            */
            if($request->header('process')){
                return Datatables::of($model)->make(true);
            }

            /*
            |--------------------------------------------------------------------------------------------\
            |                               PROCESSING RESPONSE  END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               PAGINATION RESPONSE  START                                           |
            |--------------------------------------------------------------------------------------------/
            */

            $page = $request->get('page');
            if($page){
                return Utils::respond('done',  $model->paginate($request->get('size',10) ));
            }
            /*
            |--------------------------------------------------------------------------------------------\
            |                               PAGINATION RESPONSE  END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               OTHERS RESPONSE  START                                           |
            |--------------------------------------------------------------------------------------------/
            */
            return $model->get();
            return Utils::respond('done', $model->get());
            /*
            |--------------------------------------------------------------------------------------------\
            |                                OTHERS RESPONSE   END                                           |
            |--------------------------------------------------------------------------------------------/
            */


        } catch (\Exception $e) {
            if(getenv('APP_DEBUG') == 'true'){
                return Utils::respond('error', $e->getMessage(),true) ;
            }else{
                return Utils::respond('error',[],true) ;
            }

        }
    }

    public function show(Request $request,$id=null)
    {

        try {
            $activeEagger = $request->get('eagger');
            $child = $request->get('child');
            $child =  explode(',',$child);
            if(count($child) ){
                if(@$child[0] == ""){
                    $child = null ;
                }
            }
            $page = $request->get('page');
            $m = self::MODEL;
            $class = new ReflectionClass($m);
            $methods = $class->getMethods();
            $eager = [];
            $model= null;
            /*SEARCH BY COLUM NAME*/
            if($request->get('where')){
                $qyery = Utils::parseWhere($request->get('where'));
                $model_ =  $m::where("state","<>",2);
                foreach ($qyery as $on){
                    if($on[2] == "null")
                    {
                        $on[2] = null ;
                    }
                    if($on[1] == "in"){
                        $on[2] = explode('-',$on[2]) ;
                        $model_ =  $model_->whereIn(@$on[0],@$on[2]);
                    }else{
                        $model_ =  $model_->where(@$on[0],@Utils::getOperateur(@$on[1]),[@$on[2]]);
                    }

                }
                $model = $model_->get();

            }else{
                if($request->input('__attribute')){
                    try {
                        $model = $m::where($request->input('__attribute'), $id)->get();
                    } catch (\Exception $e) {
                        $model = $m::where($m->getKeyName(),$id)->get();
                    }
                }else{
                    $model = $m::where($m->getKeyName(),$id)->get();
                }
                if (count($model) ==0) {
                    return Utils::respond('not_found',[],true);
                }
                if (@$model[0]->state == 2) {

                    return Utils::respond('removed_allready',[],true);
                }
            }
            if (is_null($model)) {

                return Utils::respond('not_found',[],true);
            }
            if($activeEagger == 1){
                array_walk($methods,function ($value)use($m,$page,&$model){

                    if($m === $value->class ){
                        $child_=$value->name ;
                        if($page){
                            foreach ($model as &$eag){
                                $eag->$child_ = $eag->$child_()->where('state','<>',2)->paginate($this->page);
                            }

                        }else{
                            foreach ($model as &$eag){
                                $mdel__clone = (clone $eag)->$child_;
                                if(is_countable($mdel__clone) ==1){
                                    foreach ($mdel__clone as $key => &$m_clone)
                                        if($m_clone->state == 2)
                                            unset($mdel__clone[$key]);

                                    $eag->$child_ =  method_exists($mdel__clone,'values') ? $mdel__clone->values() : $mdel__clone;

                                }else{
                                    $eag->$child_ = $mdel__clone;
                                    // dd($mdel__clone);
                                    if(isset($mdel__clone->state))
                                        if($mdel__clone->state == 2)
                                            $eag->$child_ = null;
                                }

                            }

                        }
                    }
                });
            }else{
                if (is_array($child) && !$page){
                    array_walk($child,function ($ch)use(&$model){
                        $ch = explode('.',$ch);
                        $ch_1= @$ch[0];
                        $ch_2= @$ch[1];
                        foreach ($model as &$om){

                            $mdel__clone = (clone $om)->$ch_1;
                            // dd(is_countable($om));
                            if(is_countable($mdel__clone)){
                                //  die('oo');
                                foreach ($mdel__clone as $key => &$m_clone){
                                    if($m_clone->state == 2)
                                    {
                                        unset($mdel__clone[$key]);
                                    }
                                }
                                $om->$ch_1 = method_exists($mdel__clone,'values')? $mdel__clone->values() : $mdel__clone;
                                if($ch_2  && is_object($om->$ch_1) && !is_countable($om->$ch_1))
                                {
                                    $om->$ch_1->$ch_2 = ( clone $om->$ch_1)->$ch_2 ;
                                }
                                //new filter child
                                elseif($ch_2 && is_countable($om->$ch_1)){

                                    foreach ($om->$ch_1 as $child_1_item){
                                        $child_2_item= (clone $child_1_item)->$ch_2;
                                        if(is_countable($child_2_item)){
                                            foreach ($child_2_item as $key => $m_c_2){
                                                if($m_c_2->state == 2)
                                                    unset($child_2_item[$key]);
                                            }
                                            $child_1_item->$ch_2 = method_exists($child_2_item,'values') ? $child_2_item->values() : $child_2_item;
                                        }elseif(is_object($child_2_item) && !is_countable($child_2_item)){

                                            if($child_2_item->state == 2){
                                                $child_1_item->$ch_2 = null ;
                                            }else{
                                                $child_1_item->$ch_2 = $child_2_item ;
                                            }
                                        }

                                    }
                                }

                                //new child
                            }else{
                                $om->$ch_1 = $mdel__clone ;
                                if($ch_2 && is_object($om->$ch_1))
                                    $om->$ch_1->$ch_2 = ( clone $om->$ch_1)->$ch_2 ;
                                if(isset($mdel__clone->state))
                                    if($mdel__clone->state == 2)
                                        $om->$ch = null ;
                            }

                        }

                    });
                }elseif(is_array($child) && $page){
                    array_walk($child,function ($ch)use(&$model){
                        foreach ($model as &$om){
                            $om->$ch = $om->$ch()->where('state','<>',2)->paginate($this->page);
                        }

                    });
                }
            }

            if(!$request->get('where')){
                $model = $model[0];
            }
            return Utils::respond('done', $model);
        } catch (\Exception $e) {
            if(getenv('APP_DEBUG') == 'true'){
                return Utils::respond('error', $e->getMessage(),true) ;
            }else{
                return Utils::respond('error',[],true) ;
            }
        }
    }

    public function store(Request $request)
    {

        try{
            /*
            |--------------------------------------------------------------------------------------------\
            |                               INIT PARAMARS START                                           |
            |--------------------------------------------------------------------------------------------/
            */
            $m = self::MODEL;
            /*
            |--------------------------------------------------------------------------------------------\
            |                               INIT PARAMARS END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               STORE END                                           |
            |--------------------------------------------------------------------------------------------/
            */
            $table = (new $m())->getTable();
            $validator =  validator($request->all(),Utils::getRule($table));
            if($validator->fails())
            {
                return Utils::respond('not_valid', $validator->errors(),true) ;
            }
            $response = $m::create($request->except(['state','statut']));
            $response = $m::find($response->id);
            return Utils::respond('created',  $request->all());
            /*
            |--------------------------------------------------------------------------------------------\
            |                               STORE END                                           |
            |--------------------------------------------------------------------------------------------/
            */

        }catch (\Exception $e){
            if(getenv('APP_DEBUG') == 'true'){
                return Utils::respond('error', $e->getMessage(),true) ;
            }else{
                return Utils::respond('error',[],true) ;
            }
        }
    }

    public function update(Request $request, $id)
    {
        try {
            /*
            |--------------------------------------------------------------------------------------------\
            |                               INIT PARAMARS START                                           |
            |--------------------------------------------------------------------------------------------/
            */
            $m = self::MODEL;
            /*
            |--------------------------------------------------------------------------------------------\
            |                               INIT PARAMARS END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                               UPDATE BY ATTRIBE START                                           |
            |--------------------------------------------------------------------------------------------/
            */

            if($request->input('__attribute')){
                try {
                    $model = $m::where($request->input('__attribute'), $id)->first();
                    $id = $model->id ;
                } catch (\Exception $e) {
                    $model = $m::find($id);
                }
            }else{
                $model = $m::find($id);
            }

            /*
            |--------------------------------------------------------------------------------------------\
            |                               UPDATE BY ATTRIBE END                                           |
            |--------------------------------------------------------------------------------------------/
            */


            /*
            |--------------------------------------------------------------------------------------------\
            |                               UPDATE FILDS END                                             |
            |--------------------------------------------------------------------------------------------/
            */
            $table = (new $m())->getTable();
            $validator =  validator($request->all(),Utils::getRule($table,$id,$request->all()));
            if($validator->fails())
            {
                return Utils::respond('not_valid', $validator->errors(),true) ;
            }

            if (is_null($model)) {
                return Utils::respond('not_found',[],true);
            }
            if ($model->state == 2) {

                return Utils::respond('removed_allready',[],true);
            }
            $model->update($request->except('state','id','statut'));
            return Utils::respond('updated', $model);
            /*
            |--------------------------------------------------------------------------------------------\
            |                               UPDATE FILDS END                                             |
            |--------------------------------------------------------------------------------------------/
            */


        } catch (\Exception $e) {
            if(getenv('APP_DEBUG') == 'true'){
                return Utils::respond('error', $e->getMessage(),true) ;
            }else{
                return Utils::respond('error',[],true) ;
            }
        }
    }

    public function destroy($id,Request $request)
    {
        try {
            $m = self::MODEL;
            /*
            |--------------------------------------------------------------------------------------------\
            |                               DELETE BY ATTRIBUTE START                                           |
            |--------------------------------------------------------------------------------------------/
            */
            if($request->input('__attribute')){
                try {
                    $model = $m::where($request->input('__attribute'), $id)->first();
                    $id = $model->id ;
                } catch (\Exception $e) {
                    $model = $m::find($id);
                }
            }else{
                $model = $m::find($id);
            }
            /*
            |--------------------------------------------------------------------------------------------\
            |                               DELETE BY ATTRIBUTE END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            if (is_null($model)) {
                return Utils::respond('not_found',[],true);
            }
            if ($model->state == 2) {

                return Utils::respond('removed_allready',[],true);
            }
            /*
            |--------------------------------------------------------------------------------------------\
            |                               SIMULE DELETE END                                           |
            |--------------------------------------------------------------------------------------------/
            */
            $return = null;
            DB::transaction(function ()use($m,&$model,$id,&$return){
                try {
                    $m::destroy($id);
                    DB::rollBack();
                    $return= 1;
                } catch (\Exception $e) {
                    DB::rollBack();
                    $return = 2;
                }
            });
            /*
            |--------------------------------------------------------------------------------------------\
            |                              SIMULE DELETE END                                           |
            |--------------------------------------------------------------------------------------------/
            */

            /*
            |--------------------------------------------------------------------------------------------\
            |                              RETURN END                                           |
            |--------------------------------------------------------------------------------------------/
            */
            switch ($return){
                case 1 :
                    $model->state= 2;
                    $table = (new $m())->getTable();
                    if($table == 'sf_user' ){
                        $model->email = $model->id . "_" . $model->email;
                        $model->telephone = $model->id . "_" . $model->telephone;
                    }
                    $model->save();
                    return Utils::respond('removed');
                case 2 :
                    return Utils::respond('delete_revoq');
                default:
                    return Utils::respond('delete_revoq');
                    break;
            }
            /*
            |--------------------------------------------------------------------------------------------\
            |                              RETURN END                                           |
            |--------------------------------------------------------------------------------------------/
            */

        } catch (\Exception $e) {
            if(getenv('APP_DEBUG') == 'true'){
                return Utils::respond('error', $e->getMessage(),true) ;
            }else{
                return Utils::respond('error',[],true) ;
            }
        }
    }
}
