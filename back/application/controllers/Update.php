<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');

class Update extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Layers_model");
    }
    public function index()
    {
        echo 'update';
    }
    public function nameGenerator($text)
    {
        $text = trim($text);
        $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ','.');
        $replace = array('c','c','g','g','i','i','o','o','s','s','u','u','_','_');
        $new_text = str_replace($search,$replace,$text);
        $kontrol=$this->Layers_model->get(['name'=>$new_text]);
        if($kontrol){
            $new_text=$new_text.'_'.rand(1,100);
            $this->nameGenerator($new_text);
        }else{
            return $new_text;
        }
    }
    // BAŞLANGIÇ : SİTE HARİTASI

    public function getBreadcrumb()
    {
        $url=$this->input->post_get('url');
        $urlArray=explode("/",$url);
        $layerUrl=[];
        for($i=1;$i<count($urlArray);$i++){
            if($i==1){
                $layerUrl[$i]= '/'.$urlArray[$i];
            }elseif($i>1){
                $degisken='';
                for($j=1;$j<=$i;$j++){
                    $degisken= $degisken. '/'.$urlArray[$j];
                }
                $layerUrl[$i]= $degisken;
            }
        }
        $data['breadcrumb']=$layerUrl;
        $data['length']=count($layerUrl);
        foreach ($layerUrl as $key => $value) {
            $data['data'][$key]=$this->Layers_model->get(array("url"=>$value));
        }
        echo json_encode($data);
        return;
    }
    // BİTİŞ : SİTE HARİTASI
    //BAŞLANGIÇ : ÖZELLİKLER
    public function propertyAdd()
    {
        $propName=$this->input->post_get('name');
        $propType=$this->input->post_get('type');
        $url=$this->input->post_get('url');
        $parentId=$this->Layers_model->get(array("url"=>$url))->up;

        $this->load->model("Property_model");

        $data['status']=$this->Property_model->add(
            array(
                "name"=>$propName,
                "type"=>$propType,
                "layerUpId"=>$parentId
            )
        );
        echo json_encode($data);
    }
    public function propertyUpdate()
    {
        $prop=json_decode($this->input->post_get('prop'));
        $this->load->model("Property_model");
        $this->load->model("PropertyContent_model");
        $data['propStatus']=$this->Property_model->update(
            ['id'=>$prop->id],
            array(
                "name"=>$prop->name,
                "type"=>$prop->type
            )
        );
        if($prop->propertyContent->id==null){
            $data['contentStatus']=$this->PropertyContent_model->add(
                array(
                    "content"=>$prop->propertyContent->content,
                    'layerId'=>$prop->layerId,
                    "propertyId"=>$prop->id
                )
            );
        }else{
            $data['contentStatus']=$this->PropertyContent_model->update(
                ['id'=>$prop->propertyContent->id],
                array(
                    "content"=>$prop->propertyContent->content
                )
            );
        }

        echo json_encode($data);
    }
    //BİTİŞ : ÖZELLİKLER
    //BAŞLANGIÇ : KATMAN
    public function layerAdd()
    {
        $this->load->model('Property_model');
        $this->load->model('Access_model');
        $this->load->model('User_model');
        $this->load->model('PropertyContent_model');

        $name=$this->input->post_get('name');
        $url=$this->input->post_get('url');
        $detail=$this->input->post_get('detail');
        $icon=$this->input->post_get('icon');
        $parentId=$this->Layers_model->get(array("url"=>$url))->id;
        $token=$this->input->post_get('token');
        $name=$this->nameGenerator($name);
        $userId=$this->User_model->get(array("token"=>$token))->id;

        $data['layerAddControl']=$this->Layers_model->add(
            array(
                "name"=>$name,
                "url"=>$url.'/'.$name,
                "detail"=>$detail,
                "icon"=>$icon,
                "up"=>$parentId
            )
        );
        $data['accesAddControl']=$this->Access_model->add(
            array(
                "layerId"=>$this->Layers_model->get_id(['url'=>$url.'/'.$name])->id,
                "userId"=>$userId,
                "limitNo"=>2,
            )
        );
        $propControl=$this->Property_model->get(array("layerUpId"=>$parentId));
        if(!empty($propControl)){
            foreach ($propControl as $key => $value) {
                $data['propertyAddControl'][$key]=$this->PropertyContent_model->add(
                    array(
                        "content"=>"",
                        "layerId"=>$data['layerAddControl'],
                        "propertyId"=>$value->id
                    )
                );
            }
        }
        echo json_encode($data);
    }
}