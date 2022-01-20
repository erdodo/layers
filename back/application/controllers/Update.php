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
        $id=$this->input->post_get('id');
        $propName=$this->input->post_get('name');
        $propType=$this->input->post_get('type');
        $contentId=$this->input->post_get('contentId');
        $content=$this->input->post_get('content');

        $this->load->model("Property_model");
        $this->load->model("PropertyContent_model");

        $data['status']=$this->Property_model->update(['id'=>$id],
            array(
                "name"=>$propName,
                "type"=>$propType,
            )
        );
        $data['status']=$this->PropertyContent_model->update(['id'=>$contentId],
            array(
                "content"=>$content,
            )
        );

        echo json_encode($data);
    }
    //BİTİŞ : ÖZELLİKLER
}