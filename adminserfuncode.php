<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header('Content-Type: JSON');

function connect(){
$host_name = 'localhost';
$host_user = 'root';
$host_pass = '';
$host_dbas = 'landwayengineeringbilling';
$connect = mysqli_connect($host_name,$host_user,$host_pass,$host_dbas);
return $connect;

}

function dashboard($temgrade){
    $dsopts = array(111111=>"<div id='options' class='optone' ><ul><li id='view'>View</li><li id='addbill'>Add</li><li id='billmod'>Modify</li><li id='billdel'>Delete</li><li id='usrnew'>User</li><li id='usrfunc'>Other</li><li class='syslgout'>Log Out</li></ul></div>",
                    100=>"<div id='options' class='opttwo' ><ul><li id='view'>View</li><li class='syslgout'>Log Out</li></ul></div>",
                    010=>"<div id='options' class='optthr' ><ul><li id='addbill'>Add</li><li class='syslgout'>Log Out</li></ul></div>",
                    110=>"<div id='options' class='optfor' ><ul><li id='view'>View</li><li id='addbill'>Add</li><li class='syslgout'>Log Out</li></ul></div>",
                    111=>"<div id='options' class='optfve' ><ul><li id='view'>View</li><li id='addbill'>Add</li><li id='billmod'>Modify</li><li class='syslgout'>Log Out</li></ul></div>");
    $dash  = $dsopts[$temgrade];
    return $dash;
}

function template($optiontemplate){
    $newopt = $optiontemplate;
    $optionscr = array('view'=>'<div align="center" id="adblsecmn"><h2 align="center">VIEW BILLS</h2></div><div hidden="hidden" align="center" id="adblsecmnhidden"></div><table class="optadbl"><tr><td>Start Date</td><td><input type="text" id="vstbldte" placeholder="YYYY-MM-DD"/></td><td>Last Date</td><td><input type="text" placeholder="YYYY-MM-DD" id="vlstbldte"/></td></tr><tr><td colspan="4"><input type="submit" id="vbsubko" value="Display"/> <input type="submit" class="clear" value="Clear"/></td></tr></table>',
    'addbill'=>'<div align="center" id="adblsecmn"><h2 align="center">CREAT A NEW BILL</h2><div id="inputfrmz1" class="recordodd"><div class="rowseprate"><strong>No.<lable class="itemlabno" id="itemnoz1">1</lable></strong><input type="button" class="rmvinpfrm" id="rmvfrmz1" value="X"/></div><div class="rowseprate"><div class="row"><div class="lastrow">Item</div><div class="lastrow"><input type="text" style="text-transform: capitalize;" id="itemnamesz1" class="itemname"/></div></div><div class="row"><div class="lastrow">Qty</div><div class="lastrow"><input type="number" id="itemqtysz1" class="itemqty" min="0.01" step="0.01" value="00.00"/></div></div><div class="row"><div class="lastrow">Unit Price</div><div class="lastrow"><input type="number" id="itempricez1" class="itemunitprice" min="0.01" step="0.01" value="00.00"/></div></div><div class="row"><div class="lastrow">Total</div><div class="lastrow"><input type="text" disabled readonly="readonly" id="totalz1" class="itemtotal" min="0.01" step="0.01" value="00.00"/></div></div><div class="row"><div class="lastrow">Sum</div><div class="lastrow"><input type="text" disabled readonly="readonly" id="totalsumz1" class="itemtotalsum" min="0.01" step="0.01" value="00.00"/></div></div></div></div></div><table class="optadbl"><tr><td>Bill Name</td><td><input type="text" style="text-transform: capitalize;" id="billname"/></td><td>Bill Status</td><td><select id="blsts"><option>Select</option><option id="Unpaid">Unpaid</option><option id="Paid">Paid</option></select></td></tr><tr><td>Bill Date</td><td><input type="text" id="bldte" placeholder="YYYY-MM-DD"/></td><td>Effective Date</td><td><input type="text" readonly="readonly" id="bleffdte"/></td></tr><tr><td colspan="4"><input type="button" id="nwitrd" value="New Record"> <input type="submit" id="savallbl" value="Save Bill"/> <input type="submit" class="clear" value="Clear"/></td></tr></table>',
    'billmod'=>'<h2 style="color:blue; text-align:center;">Option Under Development Process.....</h2>',
    'billdel'=>'<h2 style="color:blue; text-align:center;">Option Under Development Process.....</h2>',
    'usrnew'=>'<div><h2 align="center">NEW USER CREATION</h2><table class="VSTB"><tr><td>Nic</td><td><input type="text" id="nucnic" style="text-transform: uppercase;"/></td></tr></tr><tr><td>First Name</td><td><input type="text" id="nucfname" style="text-transform: capitalize;"/></td></tr><tr><td>Last Name</td><td><input type="text" id="nuclname" style="text-transform: capitalize;"/></td></tr><tr><td>Functions</td><td><select id="nucwc"><option>Select</option><option value="100">View Only</option><option value="010">Add Only</option><option value="110">Both View & Add</option><option value="101">Both View & Modify</option><option value="111">View & Add & Modify</option></select></td></tr><tr><td><input type="submit" id="nucok" value="Create"/> <input type="submit" class="clear" value="Clear"/></td></tr></table></div>',
    'usrfunc'=>'',
    'inipcscr'=>'<div class="headerinfo"><h1>Landway Engineering - Billing System</h1><p align="center" id="clock"></p></div><h2 align="center">INITIAL PASSWORD CHANGE</h2><table><tr><td>Old Password</td><td><input type="password" id="ipcipass"/></td></tr><tr><td>New Password</td><td><input type="password" id="ipcnpass"/></td></tr><tr><td>New Password Again</td><td><input type="password" id="ipccfnpass"/></td></tr><tr><td><input type="submit" id="ipcsub" value="Change and Proceess to login"/></td></tr></table>');
	$template = $optionscr[$newopt];
    return $template;
}

function syslgin($connect){
$user = htmlentities($_POST['user']);
$pass = md5(htmlentities($_POST['pass']));

	if(empty($_COOKIE['usrtkn']) && empty($_COOKIE['tknpass']) && empty($_SESSION['dashbord'])){
		$query_login_process = "SELECT `idno`, `temgrade` FROM `users` WHERE `userid`='$user' AND `credential`='$pass'";
		
if($query_run = mysqli_query($connect,$query_login_process)){
                $query_num_rows = mysqli_num_rows($query_run);
                if($query_num_rows == 1){
                    
                    $attemptfind = "SELECT `status`, `lgtype`, `lgstatus`, `temgrade` FROM `users` WHERE `userid`='$user'";
                    $sta = mysqli_query($connect,$attemptfind);
                    $status = mysqli_fetch_assoc($sta);
                    
                    if($status['status'] == 1 && $status['lgstatus'] == 0 && $status['lgtype'] == 0){
                    $temgrade = $status['temgrade'];
                    $attempt = "UPDATE `users` SET `lgstatus`='1' WHERE `userid`='$user'";
                    mysqli_query($connect,$attempt);
                            
                    function tcreate(){
                            $i = array('+','A','@','^','B',8,'C','#','D',5,'E','$',4,'F','G',9,'-','H','I','J','_','!',1,'%','K',2,'L','&',3,'M','N',0,'O',6,'*','P',7,'Q','R','(','S',')','/','U','V','W','+','X','Y','Z');
                    
                            $a= 0;
                            while($a < 16){
                            $num[$a] = $i[rand(0,49)];
                            $a++;
                            }
                    $serial = $num[1].$num[2].$num[3].$num[4].$num[5].$num[6].$num[7].$num[8].$num[9].$num[10].$num[11].$num[12].$num[13].$num[14].$num[15];
                        return $serial;
                    }
                    
                    $usrtkn = tcreate();
                    $tknpass = tcreate();
                            
                    $uptdet = "UPDATE `users` SET `usrtkn`='$usrtkn',`tknpass`='$tknpass' WHERE `userid`='$user'";
                            mysqli_query($connect,$uptdet);
							setcookie('usrtkn',$usrtkn);
							setcookie('tknpass',$tknpass);
                            $_SESSION['dashbord']=dashboard($temgrade);
                            $data['msg'] = 0;
                    }else if($status['status'] == 0){
                         $data['msg'] = 3;
                    }else if($status['lgtype'] == 1 && $status['status'] == 1){
                        $_SESSION['dashbord'] = '';
                        $opt = "inipcscr";
                        $data['pcscr'] = template($opt);
                        setcookie('cdf93b48366f22f83063356ec3a18ab5',md5($user));
                        $data['msg'] = 4;
                    }else if($status['status'] == 0){
                        $data['msg'] = 5;
                    }else if($status['lgstatus'] == 1){
                        $data['msg'] = 2;
                    }
                }else if($query_num_rows == 0){
                        $data['msg'] = 1;
                }
}
	
}else{
	$data['msg'] = 101;
}
echo json_encode($data);
}

function lgout($connect){
    $usrtkn = $_COOKIE['usrtkn'];
    $tknpass = $_COOKIE['tknpass'];
    $access = "SELECT `userid` FROM `users` WHERE `usrtkn`='$usrtkn' AND `tknpass`='$tknpass'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $user = $output['userid'];
    $lgstatus = "UPDATE `users` SET `lgstatus`='0', `usrtkn`='', `tknpass`='' WHERE `userid`='$user'";
    mysqli_query($connect,$lgstatus);
	setcookie('usrtkn','',time()-3600);
	setcookie('tknpass','',time()-3600);
	setcookie('d8fcfbbe6d73da33246ff41850eb4d6e','',time()-3600);
	unset($_SESSION['dashbord']);
    $data['msg'] = 1;
    echo json_encode($data);
}

function autologout($connect){
$minpast = $_POST['minpast'];
 if($minpast > 200 & $minpast < 201 & $minpast != null){
    $usrtkn = $_COOKIE['usrtkn'];
    $tknpass = $_COOKIE['tknpass'];
    $access = "SELECT `userid` FROM `users` WHERE `usrtkn`='$usrtkn' AND `tknpass`='$tknpass'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $user = $output['userid'];
    $lgstatus = "UPDATE `users` SET `lgstatus`='0', `usrtkn`='', `tknpass`='' WHERE `userid`='$user'";
    mysqli_query($connect,$lgstatus);
	setcookie('usrtkn','',time()-3600);
	setcookie('tknpass','',time()-3600);
	setcookie('d8fcfbbe6d73da33246ff41850eb4d6e','',time()-3600);
	unset($_SESSION['dashbord']);
    $data['msg'] ='autosuccs';
	}else{
$data['msg'] ='none';
}
	
    echo json_encode($data);
}

function optionselect($connect){
    $usrtkn = $_COOKIE['usrtkn'];
    $tknpass = $_COOKIE['tknpass'];
    $access = "SELECT `temgrade` FROM `users` WHERE `usrtkn`='$usrtkn' AND `tknpass`='$tknpass'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $twc = $output['temgrade'];
    $chk_auth = array(111111=>array('view','addbill','billmod','billdel','usrnew','usrfunc'),
                     100=>array('view'),
                     010=>array('addbill'),
                     110=>array('view','addbill'),
                     111=>array('view','addbill','billmod'));
    $newopt = $_POST['newopt'];      
    $run = 0;
	$limit = count($chk_auth[$twc]);
	$exc = $limit -1;
	while($run < $limit){
		if($chk_auth[$twc][$run] == $newopt and $chk_auth[$twc][$run] !=''){
            $data['optionscr'] = template($newopt);
            $newopthash = md5($newopt);
            setcookie('d8fcfbbe6d73da33246ff41850eb4d6e',$newopthash);
            $data['msg']=1;
            break;
		}else if($run == $exc){
			$data['msg']=0;
		}
		$run++;
	}
	echo json_encode($data);
}

function svbl($connect){
$usrtkn = $_COOKIE['usrtkn'];
    $tknpass = $_COOKIE['tknpass'];
    $access = "SELECT `userid` FROM `users` WHERE `usrtkn`='$usrtkn' AND `tknpass`='$tknpass'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $cby = $output['userid'];    
    
$billdetails = $_POST['brrc'];
$billname = ucwords($_POST['bname']);
$billdate = $_POST['bdate'];
$billstatus = $_POST['bstatus'];
$total = 0;
$sum = 0;
$time = time();
$effdate = date('Y-m-d',$time);
    
$quer_find_lastbillno = "SELECT Max(billid) AS billid FROM `bills`";
$query_run = mysqli_query($connect,$quer_find_lastbillno);
$Query_final = mysqli_fetch_assoc($query_run);
$billid = $Query_final['billid'];

if($billid == 0 || $billid == null ){$newbillid = 1;}else{$newbillid = $billid+1;}  

$createbill = "INSERT INTO `bills` (billid,name,status,date,effdate,sum,cby,lmby) VALUES ('$newbillid','$billname','$billstatus','$billdate','$effdate','0','$cby','0')";

    if(mysqli_query($connect,$createbill)){
        for($i = 0; $i<count($billdetails); $i++){
        $name = $billdetails[$i]['name'];
        $qty = $billdetails[$i]['qty'];
        $price = $billdetails[$i]['price'];
        $no = $i+1;
        $total = $qty * $price;
        $sum = $sum + $total;
        $createrecord = "INSERT INTO `records` (billid,no,item,qty,price,total,sum,cby,lmby) VALUES ('$newbillid','$no','$name','$qty','$price','$total','$sum','$cby','0')";
        mysqli_query($connect,$createrecord);
        }
        
        $lupbill = "UPDATE `bills` SET `sum`='$sum' WHERE `billid`='$newbillid'";
        mysqli_query($connect,$lupbill);
        
        $data['msg']=1;
        $data['no']= $billname.' -> '.$newbillid;
    }else{
        $data['msg']=0;
    }
    
echo json_encode($data);
}

function fetchupdateadd($connect){
    $reqtypever = $_POST['reqtypever'];
    
    if($reqtypever == 'fetch'){
    $searchwith = $_POST['searchwith'];
    $Query_find = "SELECT `fullname`, `branch`, `Desig` FROM `employee` WHERE `nic`='$searchwith'";
    $Query_run = mysqli_query($connect,$Query_find);
        if($Query_ans = mysqli_fetch_assoc($Query_run)){
            $data['insertfullname'] = $Query_ans['fullname'];
            $data['insertbr'] = $Query_ans['branch'];
            $data['insertdes'] = $Query_ans['Desig'];
            $data['msg'] = 'succ';
        }else{
         $data['msg'] = 'unsucc';   
        }
    }else{
    $searchwith = $_POST['searchwith'];
    $insertfullname = $_POST['insertfullname'];
    $insertbr = $_POST['insertbr'];
    $insertdes = $_POST['insertdes'];
    $insertyear = $_POST['insertyear'];
    $insertmonth = $_POST['insertmonth'];
    $insertbasic = $_POST['insertbasic'];
    $insertot = $_POST['insertot'];
    $insertld = $_POST['insertld'];
    $insertfa = $_POST['insertfa'];
    $insertnp = $_POST['insertnp'];
        
        $Query_find = "SELECT `EmpNo` FROM `employee` WHERE `nic`='$searchwith'";
        $Query_run = mysqli_query($connect,$Query_find);
        if($Query_ans = mysqli_fetch_assoc($Query_run)){
            $decesion = $Query_ans['EmpNo'];
        }else{
            $decesion = '';
            $Query_find_Max = "SELECT Max(EmpNo) AS MaxEmpNo FROM `employee`";
            $Query_run_Max = mysqli_query($connect,$Query_find_Max);
            $Query_ans_Max = mysqli_fetch_assoc($Query_run_Max);
            $SetEmpNo = $Query_ans_Max['MaxEmpNo'];
            $SetEmpNo +=1;
        }
        
        if($decesion == ''){
            $query_add_New = "INSERT INTO `employee` (nic,fullname,EmpNo,Desig,branch) VALUES ('$searchwith','$insertfullname','$SetEmpNo','$insertdes','$insertbr')";
            mysqli_query($connect,$query_add_New);
        }else{
        $Query_find_sheet = "SELECT `EmpNo` FROM `sheets` WHERE `EffMonth`='$insertmonth' AND `EffYear`='$insertyear' AND `EmpNo`='$decesion'";
        $Query_run_sheet = mysqli_query($connect,$Query_find_sheet);
        if($Query_ans_sheet = mysqli_fetch_assoc($Query_run_sheet)){
            $data['msg'] = 'samesheet';
            $last = 'samesheet';
        }else{
            $last = '';
        }
        }
        
        if($last == '' & $decesion != ''){
        $Query_add = "INSERT INTO `sheets` (nic,EmpNo,EffMonth,EffYear,salary,overtime,loan,advance,leav) VALUES ('$searchwith','$decesion','$insertmonth','$insertyear','$insertbasic','$insertot','$insertld','$insertfa','$insertnp')";
            if(mysqli_query($connect,$Query_add)){
                $data['msg'] = 'succ';
            }else{
                $data['msg'] = 'unsucc';
            }
        }else if($decesion == '' & $last == ''){
            $Query_add = "INSERT INTO `sheets` (nic,EmpNo,EffMonth,EffYear,salary,overtime,loan,advance,leav) VALUES ('$searchwith','$SetEmpNo','$insertmonth','$insertyear','$insertbasic','$insertot','$insertld','$insertfa','$insertnp')";
            if(mysqli_query($connect,$Query_add)){
                $data['msg'] = 'succ';
            }else{
                $data['msg'] = 'unsucc';
            }
        }
    }
    echo json_encode($data);
}

function feclopstec($connect){
    $lastoptscr = $_COOKIE['d8fcfbbe6d73da33246ff41850eb4d6e'];
    $runcheck = array('view','addbill','billmod','billdel','usrnew','usrfunc','inipcscr');
    $c=0;
    while($c < count($runcheck)){
        if($lastoptscr == md5($runcheck[$c])){
            $lastoptscr = $runcheck[$c];
        break;
        }else{}
        $c++;
    }
    $data['optionscr'] = template($lastoptscr);
    $data['newopt'] = $lastoptscr;
    $data['msg'] = 'succ';
    echo json_encode($data);
}

function inipchgfl($connect){
    $user = $_COOKIE['cdf93b48366f22f83063356ec3a18ab5'];
    $userfind = 1000;
    while($userfind<9999){
        if($user == md5($userfind)){
            $userid = $userfind;
            break;
        }else{
            $userfind++;
        }
    }
    $op = $_POST['op'];
    $np = $_POST['np'];
    $ap = $_POST['ap'];
    $opp = md5(htmlentities($_POST['op']));
    $app = md5(htmlentities($_POST['ap']));
    
    if($op != $np && $op !='' && $np !='' && $ap !='' && $np == $ap){
        $access = "SELECT `credential` FROM `users` WHERE `userid`='$userid'";
        $run = mysqli_query($connect,$access);
        $output = mysqli_fetch_assoc($run);
        $credential = $output['credential'];
        if($credential == $opp){
            $pchng = "UPDATE `users` SET `lgtype`='0', `credential`='$app' WHERE `userid`='$userid'";
            mysqli_query($connect,$pchng);
	        setcookie('cdf93b48366f22f83063356ec3a18ab5','',time()-3600);
            $data['msg'] = 'succ';
        }else{
            $data['msg'] = 'pass';
        }
    }else{
        $data['msg'] = 'not';
    }
    echo json_encode($data);
}

function chknicusr($connect){
    $nic = $_POST['ic'];
    $access = "SELECT `userid` FROM `users` WHERE `nic`='$nic'";
        $run = mysqli_query($connect,$access);
        $output = mysqli_fetch_assoc($run);
        $userid = $output['userid'];
        if($userid == null){
            $data['msg'] = 'succ';
        }else{
            $data['user'] = $userid;
            $data['msg'] = 'find';
        }
echo json_encode($data);
}

function crnewusrfun($connect){
    $nic = $_POST['ic'];
    $fn = $_POST['fn'];
    $ln = $_POST['ln'];
    $wc = $_POST['wc'];
    $pss = md5('password');
    
    $quer_find_last = "SELECT Max(userid) AS usrid FROM `users`";
    $query_run = mysqli_query($connect,$quer_find_last);
    $Query_final = mysqli_fetch_assoc($query_run);
    $nusr = $Query_final['usrid'] + rand(1,6);
    
    $crusrquery = "INSERT INTO `users` (userid,fname,lname,nic,grade,temgrade,credential,status,lgstatus,lgtype) VALUES ('$nusr','$fn','$ln','$nic','$wc','$wc','$pss','1','0','1')";
     
    if(mysqli_query($connect,$crusrquery)){    
        $data['nuser'] = $nusr;
        $data['nupass'] = 'password';
        $data['msg'] = 'succ';
    }else{}
        
echo json_encode($data);
}

function vwbllsdet($connect){
$st_date = $_POST['sd'];
$lt_date = $_POST['ld'];

    $access = "SELECT Min(billid) AS minid, Max(billid) AS maxid FROM `bills` WHERE `bsts`='0' AND `effdate` BETWEEN '$st_date' AND '$lt_date'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $id_ft = $output['minid'];
    $id_lt = $output['maxid'];
    if($id_ft != null && $id_lt != null){
    $c= $id_ft;
    $i=0;
    while($c <= $id_lt){
        $fetch_details = "SELECT `name`, `status`, `date`, `effdate`, `sum` FROM `bills` WHERE `billid`='$c'";
        $fetch_run = mysqli_query($connect,$fetch_details);
        $details = mysqli_fetch_assoc($fetch_run);
        $data['name'][$i] = $details['name'];
        $data['status'][$i] = $details['status'];
        $data['date'][$i] = $details['date'];
        $data['effdate'][$i] = $details['effdate'];
        $data['sum'][$i] = $details['sum'];
        $data['id'][$i] = $c;
        $i++;
        $c++;
    }
    $data['hescr'] = '<h2 align="center">VIEW BILLS</h2><div class="vhead"><div class="vhsub1">No</div><div class="vhsub2">Bill Name</div><div class="vhsub3">Bill Status</div><div class="vhsub4">Date</div><div class="vhsub4">Effective Date</div><div class="vhsub5">Sum</div><div class="vhsub6">View</div>
</div>';
    $data['maxrun'] = $i--;
    $data['msg'] = 'succ';
    }else{
    $data['msg'] = 'no';
    }
    echo json_encode($data);
}

function vwflbldil($connect){
    $idno = $_POST['tgn'];
    
    $qnf = "SELECT `name` FROM `bills` WHERE `billid`='$idno'";
    $rqe = mysqli_query($connect,$qnf);
    $rlt = mysqli_fetch_assoc($rqe);
    $idname = $rlt['name'];
    
    $access = "SELECT Min(no) AS minid, Max(no) AS maxid FROM `records` WHERE `billid`='$idno'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $id_ft = $output['minid'];
    $id_lt = $output['maxid'];
    if($id_ft != null && $id_lt != null){
    $c= $id_ft;
    $i=0;
    while($c <= $id_lt){
        $fetch_details = "SELECT `item`, `qty`, `price`, `total`, `sum`, `cby` FROM `records` WHERE `billid`='$idno' AND `no`='$c'";
        $fetch_run = mysqli_query($connect,$fetch_details);
        $details = mysqli_fetch_assoc($fetch_run);
        $data['item'][$i] = $details['item'];
        $data['qty'][$i] = $details['qty'];
        $data['price'][$i] = $details['price'];
        $data['total'][$i] = $details['total'];
        $data['sum'][$i] = $details['sum'];
        $data['cby'][$i] = $details['cby'];
        $i++;
        $c++;
    }
        $data['hescr'] = '<h2 align="center">Bill : '.$idname.'</h2><h4><a id="billback" href"javascript:void(0);">Go Back</a></h4><div class="vhead"><div class="vhsub1">No</div><div class="vhsub2">Item Names</div><div class="vhsub3">Quantity</div><div class="vhsub4">Price</div><div class="vhsub4">Total</div><div class="vhsub5">Sum</div><div class="vhsub6">Creater</div>
</div>';
        
    $data['maxrun'] = $i--;
    $data['msg'] = 'succ';
    }else{
    $data['msg'] = 'no';
    }
    echo json_encode($data);
}

$connect = connect();
$_POST['routine']($connect);

?>
