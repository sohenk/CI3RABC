<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Tree {

  var $data = '',
      $html = '',
      $tmp = '';

  public function __construct($data){
    $this->data = $data;
  }

  private function build($extra=""){
    $top = array();
    $sub = array();
    $output = '';
    foreach($this->data as $k => $v){
      if(!$v['parentid'] ){
        $top[] = $v;
      }else{
        $sub[$v['parentid']][] = $v;
      }
    }

    foreach($top as $element){
        $this->display_element($element, $sub, $output,$extra);
    }

    $output = '<ul class="tto_sortable sortable ui-sortable">' . $output . '</ul>';

    return $output;
  }

  private function display_element($element, $child, &$output,$extra=""){
    if(!$element) return;

    $has_child = !empty($child[$element['id']]);
    $cb = array_merge(array(&$output, $element), array('has_child' => $has_child));
    $output .= '<li class="term_type_li" id="item_'.$cb[1]['id'].'">';
    $output .= '    <div class="item btn btn-default btn-sm" data-name="'.$cb[1]['name'].'" data-id="'.$cb[1]['id'].'">';
    $output .= '        <span>'.$cb[1]['name'].'&nbsp;(ID:'.$cb[1]['id'].')</span>';
    $output .= '        <span style="float:right;">';
    if($extra=="video"){
        $output .= '        <a target="_blank" href="'.site_url("video/editchannel?id=".$cb[1]['id']).'" type="button" class="btn btn-warning btn-xs">编辑</a>';
        $output .= '        <a   href="javascript:void(0)" onclick="commDel(\'yy_videotype\',\''.($cb[1]['id']).'\',\'video\',\'del\')"  type="button" class="btn btn-danger btn-xs">删除</a>';
        
    }
    else{
        if(isset($cb[1]['visible'])){
        if($cb[1]['visible']>0){
            $output .= '    <a class="btn btn-xs" style="background:#9be96a; color:#FFF;">显示</a>';
        }else{
            $output .= '    <a class="btn btn-xs" style="background:#CCC; color:#FFF;">隐藏</a>';            
        }}
        
        $output .= '        <a target="_blank" href="'.site_url("cms/editchannel?id=".$cb[1]['id']).'" type="button" class="btn btn-warning btn-xs">编辑</a>';
        $output .= '        <a   href="javascript:void(0)" onclick="cmsisdel(\'cms_channel\',\''.($cb[1]['id']).'\',\'delchannel\')"  type="button" class="btn btn-danger btn-xs">删除</a>';
        
    }
    $output .= '        </span>';
    $output .= '     </div>';

    if(isset($child[$element['id']])){
      
      foreach($child[$element['id']] as $c){

        if(!isset($newlevel)){
          $newlevel = true;
          $output .= "<ul class='children sortable'>";
        }

        $this->display_element($c, $child, $output,$extra);
      }

    unset($child[$element['id']]);

    }

    if (isset($newlevel) && $newlevel){
      $output .= '</ul>';
    }

    $output .= '</li>';
  }

  public function render($extra=""){
    return $this->build($extra);
  }

  public function getData(){
    $data = array();
    foreach($this->data as $k => $v){
      $data[$v['id']] = $v;
    }

    return json_encode($data);
  }

}

/* End of file Someclass.php */