<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Layers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Layers_model");
    }
    public function index()
    {
        $segs = $this->uri->segment_array();
        print_r($segs);
    }
    public function list(){//gelen token bilgisine göre döndürülen katmanların listelenmesi
        $token=$this->input->post_get('token');
        $shareToken=$this->input->post_get('shareToken');
        $howMany=$this->input->post_get('howMany');
        $page=$this->input->post_get('page');
        $data=array();
        if($token){
            //üye kullanıcı verileri
            $this->load->model("User_model");
            $this->load->model("Access_model");
            $profile=$this->User_model->get(array("token"=>$token));//kullanıcı bilgileri
            if($profile==null){//kullanıcı yoksa
                $data["errorMessage"]="Kullanıcı bulunamadı";
                $data['status']='error';
                echo json_encode($data);
                return;
            }
            $access=$this->Access_model->getir($howMany,$page,[],array("userId"=>$profile->id , 'limitNo>'=>0));//kullanıcının yetkileri
            $data['profile']=$profile;
            $data['token']=$token;
            $data['access']=$access;
            foreach ($access as $key => $value) {//kullanıcının yetkilerine göre kullanıcının katmanlarını çek
                $data['access'][$key]=$value;
                $data['access'][$key]->layer=$this->Layers_model->get(array("id"=>$value->layerId));
            }
        }elseif($shareToken){
            //paylaşılmış katman verileri
            $this->load->model("Share_model");
            $access=$this->Share_model->getir($howMany,$page,[],array("token"=>$shareToken , 'limitNo>'=>0));//kullanıcının yetkileri
            if($access==null){//kullanıcı yoksa
                $data["errorMessage"]="Paylaşım bulunamadı";
                $data['status']='error';
                echo json_encode($data);
                return;
            }
            $data['shareToken']=$shareToken;
            $data['access']=$access;
            foreach ($access as $key => $value) {//kullanıcının yetkilerine göre kullanıcının katmanlarını çek
                $data['access'][$key]=$value;
                $data['access'][$key]->layer=$this->Layers_model->get(array("id"=>$value->layerId));
            }
        }else{
            //erişim yok
            $data['errorMessage']="Erişim Bulunamadı";
            $data['status']='error';
        }
        echo json_encode($data);
    }
    public function getAccess($val,$key)
    {
        $token=$this->input->post_get('token');
        $shareToken=$this->input->get('shareToken');
        $data=array();
        if($token){
            //üye kullanıcı verileri
            $this->load->model("User_model");
            $this->load->model("Access_model");
            $profile=$this->User_model->get(array("token"=>$token));//kullanıcı bilgileri
            if($profile==null){//kullanıcı yoksa
                $data["errorMessage"]="Kullanıcı bulunamadı";
                $data['status']='error';
                echo json_encode($data);
                return;
            }
            $id=$this->Layers_model->get_id(['url'=>$val]);
            if($id==null) return 0;
            else $id=$id->id;
            return $this->Access_model->get(array("userId"=>$profile->id ,'layerId'=>$id, 'limitNo>'=>0))==null? 0: 1;//kullanıcının yetkileri
        }elseif($shareToken){
            //paylaşılmış katman verileri
            $this->load->model("Share_model");
            $id=$this->Layers_model->get_id(['url'=>$val])->id;
            return $this->Access_model->get(array("userId"=>$profile->id ,'layerId'=>$id, 'limitNo>'=>0))==null? 0: 1;//kullanıcının yetkileri
        }else{
            //erişim yok
            return 0;
        }
    }
    public function getLayer()
    {
        $segs = $this->uri->segment_array();//url segmentleri
        if($segs[1]==""){
            $data['errorMessage']="Katman bulunamadı";
            $data['status']='error';
            echo json_encode($data);
            return;
        }elseif($segs[1]=='list'){
            $this->list();
            return;
        }

        $this->load->model("User_model");
        $this->load->model("Access_model");
        $this->load->model("Share_model");
        $this->load->model("Comment_model");
        $this->load->model("Log_model");
        $this->load->model("Content_model");
        $this->load->model("Property_model");
        $this->load->model("PropertyContent_model");

        $howManyAccess=$this->input->post_get('howManyAccess');
        $pageAccess=$this->input->post_get('pageAccess');

        $howManyComment=$this->input->post_get('howManyComment');
        $pageComment=$this->input->post_get('pageComment');

        $howManyLog=$this->input->post_get('howManyLog');
        $pageLog=$this->input->post_get('pageLog');

        $howManyChild=$this->input->post_get('howManyChild');
        $pageChild=$this->input->post_get('pageChild');

        $howManyProperty=$this->input->post_get('howManyProperty');
        $pageProperty=$this->input->post_get('pageProperty');

        $url=implode("/", $segs);//segmentleri veritabanındaki haline dönüştür (birleştir)
        if($this->getAccess('/'.$url,'url')!=1){//erişim yok
            $data['errorMessage']="Erişim Bulunamadı";
            $data['status']='error';
            echo json_encode($data);
            return;
        }
        $data['layer']=$this->Layers_model->get(array("url"=>'/'.$url));
        $accessList=$this->Access_model->getir($howManyAccess,$pageAccess,[],array("layerId"=>$data['layer']->id , 'limitNo>'=>0));
        foreach ($accessList as $key => $value) {
            $data['access'][$key]=$value;
            $data['access'][$key]->user=$this->User_model->get(array("id"=>$value->userId));
        }
        $data['share']=$this->Share_model->get(array("layerId"=>$data['layer']->id));
        $data['comment']=$this->Comment_model->getir($howManyComment,$pageComment,[],array("layerId"=>$data['layer']->id ));
        $data['log']=$this->Log_model->getir($howManyLog,$pageLog,[],array("layerId"=>$data['layer']->id ));
        $data['content']=$this->Content_model->get_all(array("layerId"=>$data['layer']->id));
        if($data['layer']->up!=0){
            $property=$this->Property_model->get_all(array("layerUpId"=>$data['layer']->up));
            foreach ($property as $key => $value) {
                $data['property'][$key]=$value;
                $data['property'][$key]->propertyContent=$this->PropertyContent_model->get_all(array("propertyId"=>$value->id));
            }
        }
        
        $allChild=$this->Layers_model->getir($howManyChild,$pageChild,[],array("up"=>$data['layer']->id));
        foreach ($allChild as $key => $value) {
            $data['child'][$key]=$value;
            $data['child'][$key]->property=$this->Property_model->get_all(array("layerUpId"=>$data['layer']->id));
            foreach ($data['child'][$key]->property as $key2 => $value2) {
                $data['child'][$key]->property[$key2]->propertyContent=$this->PropertyContent_model->get_all(array("propertyId"=>$value2->id));
            }
        }
        echo json_encode($data);
    }
}