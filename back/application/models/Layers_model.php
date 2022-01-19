<?php

class Layers_model extends CI_Model
{
    public $tableName = "layers";

    public function __construct()
    {
        parent::__construct();
    }

    public function get($where = array(), $order = "id ASC")
    {
        return $this->db->where($where)->order_by($order)->get($this->tableName)->row();
    }
    public function get_id($where = array(), $order = "id ASC")
    {
        return $this->db->select('id')->where($where)->order_by($order)->get($this->tableName)->row();
    }

    //###########################################

    public function sayi($like=[],$where=[])
    {
        return $this->db->like($like)->where($where)->get($this->tableName)->num_rows();
    }
    public function getir($howMany,$page,$like=[],$where=[])
    {
        return $this->db->like($like)->where($where)->get($this->tableName,$howMany,$page-1)->result();//kaç tane kaçıncı sıradan
    }

    //###########################################
    public function get_all($where = array(), $order = "id ASC")
    {
        return $this->db->where($where)->order_by($order)->get($this->tableName)->result();
    }

    public function get_comment($where = array(), $order = "id ASC")
    {
        return $this->db->where($where)->order_by($order)->get('layer_comment')->result();
    }
    public function get_property($where = array(), $order = "id ASC")
    {
        return $this->db->where($where)->order_by($order)->get('layer_property')->result();
    }

    public function add($data = array())
    {
        return $this->db->insert($this->tableName, $data);
    }

    public function update($where = array(), $data = array())
    {
        return $this->db->where($where)->update($this->tableName, $data);
    }

    public function delete($where = array())
    {
        return $this->db->where($where)->delete($this->tableName);
    }
}

