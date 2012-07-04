<?php

class SimpleTalk {
    public $sMongo = "";
    public $sDbName = "";
    public $sTbName = "";
    public $requestHandler;

    public function __construct()
    {
        session_start();
        $this->sMongo = new Mongo();
        $this->sDbName = $this->sMongo->selectDB("db_simpleTalk"); 
        $this->sTbName_chat = $this->sDbName->selectCollection("tb_simpleTalk_chat");

        $this->requestHandler();
    }
    
    public function requestHandler()
    {
        switch ($_POST['action']) {
            case 'saveMsg':
                $this->acceptMessages();
                break;  
            case 'loadMsg' : 
                $this->loadMessages();
                break;
            case 'userLogin' : 
                $this->doLogin();
                break;
            case 'registerMe' : 
                $this->registerMe();
                break;
            
        }
    }
    public function registerMe()
    {
        if($_POST['fFname'] != "" || $_POST['fLname'] != "" || $_POST['user_name'] != "" || $_POST['password'] != ""){
            $aInserts = array(
                            'fFname' => trim(ucwords($_POST['fFname'])),
                            'fLname' => trim(ucwords($_POST['fLname'])),
                            'fusername' => trim($_POST["user_name"]),
                            'fpassword' => md5($_POST["password"]),
                            'fmessage' => htmlentities(strip_tags($_POST['usermsg'])),
                            'fipaddress' => $_SERVER["REMOTE_ADDR"],
                            'fdateCreate' => time()
                            );
            return $this->sTbName_chat->insert($aInserts);
        }
        
    }
    
    public function doLogin()
    {

        if($_POST['signin'] == "Sign in"){
           
            if($_POST['email'] != "" || $_POST['pword'] != ""){
                
                $user = $this->sTbName_chat->findOne(
                    array(
                            'fusername' => trim($_POST['email']),
                            'fpassword' => md5($_POST['pword'])
                    )
                );
                echo json_encode($user);
                $_SESSION['uname'] = $user['fusername'];
                $_SESSION['password'] = $user['fpassword'];
                
            }
        }
        if($_POST['signin'] == "Sign out"){
            session_destroy();

        }
    }
    
    public function loadMessages()
    {
        /** latest post**/
        $aList = explode(",", $_REQUEST['idxList']);
        $sWhere = array("fipaddress" => $_SERVER["REMOTE_ADDR"]);
        $sOrderBy = array("fdateCreate" => -1);
        $aUsermsg = $this->sTbName_chat->find($sWhere)->sort($sOrderBy)->limit(1);
        $aData1 = "";
        while ($aUsermsg->hasNext()) 
        { 
            $details = $aUsermsg->getNext(); 
            $aData1 = $details['fdateCreate'];
        }
        /** all post **/
        if($_REQUEST['bLive'] == "true"){
            $aAllusermsg = $this->sTbName_chat->find(array('fdateCreate' => array('$lt' => $aData1)));
        }else{
            
            $aAllusermsg = $this->sTbName_chat->find(array('fdateCreate' => array('$gt' => (time() - 10))));
        }
       
        while($aAllusermsg->hasNext()) 
        { 
            $details_1 = $aAllusermsg->getNext();  
                if (in_array($details_1['_id'], $aList)) continue;
                $aResult[] = array(
                        'idx'=> new MongoId(trim($details_1['_id'])),
                        'fmessage'=>$this->smileys($details_1['fmessage']),
                        'fusername'=>  ucfirst($details_1['fusername']),
                        'fipaddress'=>$details_1['fipaddress'],
                        'fdateCreate'=>date("y-m-d h:i:s",$details_1['fdateCreate'])
                );
        }      
   
        echo json_encode($aResult);
       
    }
    
    public function acceptMessages()
    {            
        
        if(strlen($_POST['usermsg']) < 1)
        {                  
            echo "You did not input a message";
        }   
        else{
           // $message = $this->smileys($_POST['usermsg']);
            $aInserts = array(
				'fusername' => $_SESSION['uname'],
				'fpassword' => $_SESSION['password'],
				'fmessage' => htmlentities(strip_tags($_POST['usermsg'])),
                                'fipaddress' => $_SERVER["REMOTE_ADDR"],
				'fdateCreate' => time()
			 );
            $result_insert = $this->sTbName_chat->insert($aInserts);
            if($result_insert){
                $latest_result = $this->sTbName_chat->find();
                $filter_result = $latest_result->sort(array('_id' => -1))->limit(1);
                while ($latest_result->hasNext()) 
                { 
                    $details = $latest_result->getNext(); 
                    echo json_encode($details);
                }
                    
            }
        }
    }
    
    public function smileys($sReplace)
    {
        
        $sImageUrl = "./smileys/";
        
        $sReplace = str_replace('^#(^','<img src="'.$sImageUrl.'114.gif"/>', $sReplace);
        $sReplace = str_replace(':-bd','<img src="'.$sImageUrl.'113.gif"/>', $sReplace);
        $sReplace = str_replace(':-q','<img src="'.$sImageUrl.'112.gif"/>', $sReplace); 
        $sReplace = str_replace('\m/','<img src="'.$sImageUrl.'111.gif"/>', $sReplace);
        $sReplace = str_replace(':!!','<img src="'.$sImageUrl.'110.gif"/>', $sReplace);
        $sReplace = str_replace('x_x','<img src="'.$sImageUrl.'109.gif"/>', $sReplace);
        $sReplace = str_replace('8->','<img src="'.$sImageUrl.'105.gif"/>', $sReplace);
        $sReplace = str_replace(':-t','<img src="'.$sImageUrl.'104.gif"/>', $sReplace);
        $sReplace = str_replace(':-h','<img src="'.$sImageUrl.'103.gif"/>', $sReplace);
        $sReplace = str_replace('~x(','<img src="'.$sImageUrl.'102.gif"/>', $sReplace);
        $sReplace = str_replace(':-c','<img src="'.$sImageUrl.'101.gif"/>', $sReplace); 
        $sReplace = str_replace(':)]','<img src="'.$sImageUrl.'100.gif"/>', $sReplace);
        $sReplace = str_replace('<):)','<img src="'.$sImageUrl.'48.gif"/>', $sReplace);
        $sReplace = str_replace('>:p','<img src="'.$sImageUrl.'47.gif"/>', $sReplace);
        $sReplace = str_replace(':-<','<img src="'.$sImageUrl.'46.gif"/>', $sReplace);
        $sReplace = str_replace(':-w','<img src="'.$sImageUrl.'45.gif"/>', $sReplace);
        $sReplace = str_replace(':^o','<img src="'.$sImageUrl.'44.gif"/>', $sReplace);
        $sReplace = str_replace('@-)','<img src="'.$sImageUrl.'43.gif"/>', $sReplace); 
        $sReplace = str_replace(':-ss','<img src="'.$sImageUrl.'42.gif"/>', $sReplace);
        $sReplace = str_replace('#-o','<img src="'.$sImageUrl.'40.gif"/>', $sReplace);
        $sReplace = str_replace('=d>','<img src="'.$sImageUrl.'41.gif"/>', $sReplace);
        $sReplace = str_replace(':-?','<img src="'.$sImageUrl.'39.gif"/>', $sReplace); 
        $sReplace = str_replace('=p~','<img src="'.$sImageUrl.'38.gif"/>', $sReplace);
        $sReplace = str_replace('(:|','<img src="'.$sImageUrl.'37.gif"/>', $sReplace);
        $sReplace = str_replace('<:-p','<img src="'.$sImageUrl.'36.gif"/>', $sReplace); 
        $sReplace = str_replace('8-}','<img src="'.$sImageUrl.'35.gif"/>', $sReplace);
        $sReplace = str_replace(':o)','<img src="'.$sImageUrl.'34.gif"/>', $sReplace);
        $sReplace = str_replace('[-(','<img src="'.$sImageUrl.'33.gif"/>', $sReplace);
        $sReplace = str_replace(':-$','<img src="'.$sImageUrl.'32.gif"/>', $sReplace); 
        $sReplace = str_replace(':-&','<img src="'.$sImageUrl.'31.gif"/>', $sReplace);
        $sReplace = str_replace('l-)','<img src="'.$sImageUrl.'30.gif"/>', $sReplace);
        $sReplace = str_replace('8-|','<img src="'.$sImageUrl.'29.gif"/>', $sReplace);
        $sReplace = str_replace('i-)','<img src="'.$sImageUrl.'28.gif"/>', $sReplace);
        $sReplace = str_replace('=;','<img src="'.$sImageUrl.'27.gif"/>', $sReplace);  
        $sReplace = str_replace(':-b','<img src="'.$sImageUrl.'26.gif"/>', $sReplace);
        $sReplace = str_replace('o:-)','<img src="'.$sImageUrl.'25.gif"/>', $sReplace);
        $sReplace = str_replace('=))','<img src="'.$sImageUrl.'24.gif"/>', $sReplace);
        $sReplace = str_replace('/:)','<img src="'.$sImageUrl.'23.gif"/>', $sReplace);
        $sReplace = str_replace(':|','<img src="'.$sImageUrl.'22.gif"/>', $sReplace);
        $sReplace = str_replace(':))','<img src="'.$sImageUrl.'21.gif"/>', $sReplace);
        $sReplace = str_replace(':((','<img src="'.$sImageUrl.'20.gif"/>', $sReplace);
        $sReplace = str_replace('>:)','<img src="'.$sImageUrl.'19.gif"/>', $sReplace);
        $sReplace = str_replace('#:-s','<img src="'.$sImageUrl.'18.gif"/>', $sReplace); 
        $sReplace = str_replace(':-s','<img src="'.$sImageUrl.'17.gif"/>', $sReplace);
        $sReplace = str_replace('b-)','<img src="'.$sImageUrl.'16.gif"/>', $sReplace);  
        $sReplace = str_replace(':->','<img src="'.$sImageUrl.'15.gif"/>', $sReplace);
        $sReplace = str_replace('x-(','<img src="'.$sImageUrl.'14.gif"/>', $sReplace);
        $sReplace = str_replace(':-o','<img src="'.$sImageUrl.'13.gif"/>', $sReplace);
        $sReplace = str_replace('=((','<img src="'.$sImageUrl.'12.gif"/>', $sReplace);
        $sReplace = str_replace(':-*','<img src="'.$sImageUrl.'11.gif"/>', $sReplace); 
        $sReplace = str_replace(':-p','<img src="'.$sImageUrl.'10.gif"/>', $sReplace); 
        $sReplace = str_replace(':">','<img src="'.$sImageUrl.'9.gif"/>', $sReplace);  
        $sReplace = str_replace(':x','<img src="'.$sImageUrl.'8.gif"/>', $sReplace);
        $sReplace = str_replace(':-/','<img src="'.$sImageUrl.'7.gif"/>', $sReplace);
        $sReplace = str_replace('>:d<','<img src="'.$sImageUrl.'6.gif"/>', $sReplace);
        $sReplace = str_replace(';;)','<img src="'.$sImageUrl.'5.gif"/>', $sReplace); 
        $sReplace = str_replace(':d','<img src="'.$sImageUrl.'4.gif"/>', $sReplace);
        $sReplace = str_replace(';)','<img src="'.$sImageUrl.'3.gif"/>', $sReplace);
        $sReplace = str_replace(':(','<img src="'.$sImageUrl.'2.gif"/>', $sReplace);
        $sReplace = str_replace(':)','<img src="'.$sImageUrl.'1.gif"/>', $sReplace);
        
        return $sReplace;
    }
    
    
}

$simpleTalk = new SimpleTalk();
?>
