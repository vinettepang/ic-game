<?php

namespace app\index\controller;

class Icebear extends Home{
    protected $ImagePath;
    protected $DataArray;
    protected $ImageSize;
    protected $data;
    protected $Keys;
    protected $NumStringArray;
    public function __construct(){
        parent::__construct();
        $this->Keys = array(
            '0'=>'011101000110001100011000110001100011000101110',
            '1'=>'001000110010100001000010000100001000010000100',
            '2'=>'011101000100001000010001000010001000100011111',
            '3'=>'011101000100001000010011000001000011000101110',
            '4'=>'000100011000110010100101010010111110001000010',
            '5'=>'011110100010000111101000100001000011000101110',
            '6'=>'011101000110000101101100110001100011000101110',
            '7'=>'111110000100010001000010000100010000100001000',
            '8'=>'011101000110001100010111010001100011000101110',
            '9'=>'011101000110001100011001101101000011000101110',
        );
    }
    public function setImage($Image)
    {
        $this->ImagePath = $Image;
    }
    public function getData()
    {
        return $data;
    }
    public function getResult()
    {
        return $DataArray;
    }
    public function getHec($type)
    {
        switch($type){
            case 'jpg':
                $res = imagecreatefromjpeg($this->ImagePath);
                break;
            case 'png':
                $res = imagecreatefrompng($this->ImagePath);
                break;
            case 'gif':
                $res = imagecreatefromgif($this->ImagePath);
                break;
            default:
                $res = imagecreatefrompng($this->ImagePath);
                break;
        }
        $size = getimagesize($this->ImagePath);
        $data = array();
        for($i=0; $i < $size[1]; ++$i){//echo "";
            for($j=0; $j < $size[0]; ++$j)
            {
                $rgb = imagecolorat($res,$j,$i);
                $rgbarray = imagecolorsforindex($res, $rgb);
                if($rgbarray['red'] < 125 || $rgbarray['green']<125
                    || $rgbarray['blue'] < 125)
                {
                    $data[$i][$j]=1;
                    //echo "1";
                }else{
                    $data[$i][$j]=0;
                    //echo "0";
                }
            }
        }
        //print_r($size);
        $this->DataArray = $data;
        $this->ImageSize = $size;
    }
    public function run(){
        $result="";
        // 查找4个数字
        $data = array("","","","");
        for($i=0;$i<4;++$i)
        {
            $x = ($i*(WORD_WIDTH+WORD_SPACING))+OFFSET_X;
            $y = OFFSET_Y;
            for($h = $y; $h < (OFFSET_Y+WORD_HIGHT); ++ $h)
            {
                for($w = $x; $w < ($x+WORD_WIDTH); ++$w)
                {
                    $data[$i].=$this->DataArray[$h][$w];
                }
            }
             
        }
    
        // 进行关键字匹配
        foreach($data as $numKey => $numString){
            $max=0.0;
            $num = 0;
            foreach($this->Keys as $key => $value){
                $percent=0.0;
                similar_text($value, $numString,$percent);
                if(intval($percent) > $max){
                    $max = $percent;
                    $num = $key;
                    if(intval($percent) > 95)
                        break;
                }
            }
            $result.=$num;
        }
        $this->data = $result;
        // 查找最佳匹配数字
        return $result;
    }
    
    public function Draw(){
        for($i=0; $i<$this->ImageSize[1]; ++$i){
            for($j=0; $j<$this->ImageSize[0]; ++$j){
                echo $this->DataArray[$i][$j];
            }
            echo "\n";
        }
    }
    public function get_verify(){
        $file = 'https://icebear.me/user/verify';
        $extension = $this->get_extension($file);//获取文件扩展名
        $this->setImage($file);
        $this->getHec($extension);
        $data = $this->run();
        echo $data;
    }
    public function get_extension($file){
        return pathinfo($file, PATHINFO_EXTENSION);
    }
    
}