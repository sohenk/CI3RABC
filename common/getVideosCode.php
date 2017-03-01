<?php 

if($_POST){
    
    $url=urldecode($_POST["dataurl"]);
        
    $callBackData=new stdClass();
    $callBackData->actionUrl=base64_encode($url);
    $callBackData->encryptionUrl=base64_encode('<iframe frameborder=0 width=100% height=500 marginheight=0 marginwidth=0 scrolling=no src="/common/videoAction.php?actionUrl='.$callBackData->actionUrl.'"></iframe>');

    //http://www.icourses.cn/jpk/viewCharacterDetail.action?sectionId=103284&courseId=4506
    
    echo json_encode($callBackData);
    
   // <iframe frameborder=0 width=170 height=100 marginheight=0 marginwidth=0 scrolling=no src="move-ad.htm"></iframe>
}else{
    $dd["ddd"]=base64_decode('PGlmcmFtZSBmcmFtZWJvcmRlcj0wIHdpZHRoPTEwMCUgaGVpZ2h0PTUwMCBtYXJnaW5oZWlnaHQ9MCBtYXJnaW53aWR0aD0wIHNjcm9sbGluZz1ubyBzcmM9Ii9jb21tb24vdmlkZW9BY3Rpb24ucGhwP2FjdGlvblVybD1hSFIwY0RvdkwzZDNkeTVwWTI5MWNuTmxjeTVqYmk5cWNHc3ZkbWxsZDBOb1lYSmhZM1JsY2tSbGRHRnBiQzVoWTNScGIyNC9jMlZqZEdsdmJrbGtQVEV3TXpJNE5DWmpiM1Z5YzJWSlpEMDBOVEEyIj48L2lmcmFtZT4=');
    
    var_dump($dd);
}

