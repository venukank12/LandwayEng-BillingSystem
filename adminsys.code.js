 $(document).mousemove(function(){
        var timestamp = new Date();
        var runok = sessionStorage.getItem('lasttimestamp');
        if(runok != null){
        sessionStorage.setItem('lasttimestamp',timestamp);
        }else{}
    });

$(function(){
    function timerunner(){
        setInterval(function(){
            var tim = new Date();
            $("#clock").text(tim);
			var flgout = sessionStorage.getItem('lasttimestamp');
			contacting(flgout);
        },300);
    }
    
    function contacting(flgout){
		var currenttime = new Date();
        var pasttime = new Date(flgout);
        var minpast = ((currenttime.getTime() - pasttime.getTime())/1000);
		
        var routine = "autologout";
    $.ajax({
            url:"adminserfuncode.php",
            method:"POST",
            data:{routine:routine,minpast:minpast},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 'autosuccs'){
					sessionStorage.removeItem('lasttimestamp');
                    location.reload();
					alert('Time Out, You Have Sucessfully Logged Out!!');
				}else{}
            }
    });
    }
    
   
     timerunner();
});

function refresh(){
    var routine = "feclopstec";
        $.ajax({
            url:"adminserfuncode.php",
            method:"POST",
            data:{routine:routine},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 'succ'){
                    $('#targetscreen').empty();
                    $('#targetscreen').append(data.optionscr);
                    var newopt = data.newopt;
                    if(newopt == 'addbill'){
                        var d = new Date();
                        var y = d.getFullYear(); 
                        var m = d.getMonth();
                        var d = d.getDate();
                        if(d<10){d='0'+d;}else{}
                        if(m<10){m='0'+(m+1);}else{}
                        $("#bleffdte").val(y+'-'+m+'-'+d);
                       }else if(newopt == 'view'){
                        var d = new Date();
                        var y = d.getFullYear(); 
                        var m = d.getMonth();
                        var d = d.getDate();
                        if(d<10){d='0'+d;}else{}
                        if(m<10){m='0'+(m+1);}else{}
                        $("#vstbldte").val(y+'-'+m+'-'+d);
                        $("#vlstbldte").val(y+'-'+m+'-'+d);
                       }else{}
                }else{
                    alert('Try Again');
                }
            }
        });
}

function chngnofmt(n){
var num = n.toString();
var fnum='';
var nu;
var i = num.indexOf('.');
var dec='.00';
if(i == -1){
var d = num.length;
}else{
dec = num.slice(i,num.length);
num = num.slice(0,i);
var d = num.length;
}
var r = d % 3;
var c = (d-r)/3;
if(r == 0){c-=1;}else{}
while(c>0){
nu = num.slice(d-3,d);
fnum=','+nu+fnum;
num = num.slice(0,d-3);
d-=3;
c--;
}
fnum = num+fnum+dec;
return fnum;
}

function revchngnofmt(rn){
    var i = rn.indexOf('.');
    if(i=-1){
        var dec = '';
        var num = rn;
    }else{
        var dec = rn.slice(i,rn.length);
        var num = rn.slice(0,i);
    }
    var fnum='';
    for(var a=0; a<num.length; a++){
        if(num[a] != ','){
            fnum = fnum+num[a];
        }else{}
    }
    fnum = fnum+dec;
    fnum = parseFloat(fnum);
    return fnum;
}

function cal(){
    var itemqty = [];    
    var itemunitprice = [];    
    var itemtotal = [];    
    var itemtotalsum = [];    
$('.itemqty').each(function(){
   itemqty.push(this.id);
});
$('.itemunitprice').each(function(){
   itemunitprice.push(this.id);
});
$('.itemtotal').each(function(){
   itemtotal.push(this.id);
});
$('.itemtotalsum').each(function(){
   itemtotalsum.push(this.id);
});
        
var r = 0;
    var t=0;
while(r < itemqty.length){
    var id = itemqty[r];
    var f = id.indexOf('z') + 1;
    var c = id.slice(f);
    var tgn = 'itemqtysz'+c;
    var idz = itemunitprice[r];
    var fz = idz.indexOf('z') + 1;
    var cz = idz.slice(fz);
    var tgnz= 'itempricez'+cz;
    
    var a = $('#'+tgn).val();
    var b = $('#'+tgnz).val();
    var c =a*b;
    var d =chngnofmt(a*b);
    t+=c;
    $('#'+itemtotal[r]).val(d);
    $('#'+itemtotalsum[r]).val(chngnofmt(t));
    r++;
}
}
    
function cteinpfrm(){
    var itemcount = [];    
$('.recordodd,.recordeven').each(function(){
   itemcount.push(this.id);
});
    if(itemcount.length != 0 && itemcount.length < 50){
    var t = itemcount[(itemcount.length-1)];
    var f = t.indexOf('z') + 1;
    var c = parseInt(t.slice(f))+1;
    var tgn = 'inputfrmz'+(c-1);
    var odev = $("#"+tgn).attr('class');
        ode = odev.indexOf('d')+1;
        od = odev.slice(ode);
        if(od == 'odd'){odev = 'even';}else{odev = 'odd';}
    $('#adblsecmn').append('<div id="inputfrmz'+c+'" class="record'+odev+'"><div class="rowseprate"><strong>No.<lable id="itemnoz'+c+'">'+(itemcount.length+1)+'</lable></strong><input type="button" class="rmvinpfrm" id="rmvfrmz'+c+'" value="X"/></div><div class="rowseprate"><div class="row"><div class="lastrow">Item</div><div class="lastrow"><input type="text" style="text-transform: capitalize;" id="itemnamesz'+c+'" class="itemname"/></div></div><div class="row"><div class="lastrow">Qty</div><div class="lastrow"><input type="number" id="itemqtysz'+c+'" class="itemqty" min="0.01" step="0.01" value="00.00"/></div></div><div class="row"><div class="lastrow">Unit Price</div><div class="lastrow"><input type="number" id="itempricez'+c+'" class="itemunitprice" min="0.01" step="0.01" value="00.00"/></div></div><div class="row"><div class="lastrow">Total</div><div class="lastrow"><input type="text" disabled readonly="readonly" id="totalz'+c+'" class="itemtotal" min="0.01" step="0.01" value="00.00"/></div></div><div class="row"><div class="lastrow">Sum</div><div class="lastrow"><input type="text" disabled readonly="readonly" id="totalsumz'+c+'" class="itemtotalsum" min="0.01" step="0.01" value="00.00"/></div></div></div></div>');
    }else if(itemcount.length == 0){
        var c = 1;
        $('#adblsecmn').append('<div id="inputfrmz'+c+'" class="recordodd"><div class="rowseprate"><strong>No.<lable id="itemnoz'+c+'">'+(itemcount.length+1)+'</lable></strong><input type="button" class="rmvinpfrm" id="rmvfrmz'+c+'" value="X"/></div><div class="rowseprate"><div class="row"><div class="lastrow">Item</div><div class="lastrow"><input type="text" style="text-transform: capitalize;" id="itemnamesz'+c+'" class="itemname"/></div></div><div class="row"><div class="lastrow">Qty</div><div class="lastrow"><input type="number" id="itemqtysz'+c+'" class="itemqty" min="0.01" step="0.01" value="00.00"/></div></div><div class="row"><div class="lastrow">Unit Price</div><div class="lastrow"><input type="number" id="itempricez'+c+'" class="itemunitprice" min="0.01" step="0.01" value="00.00"/></div></div><div class="row"><div class="lastrow">Total</div><div class="lastrow"><input type="text" disabled readonly="readonly" id="totalz'+c+'" class="itemtotal" min="0.01" step="0.01" value="00.00"/></div></div><div class="row"><div class="lastrow">Sum</div><div class="lastrow"><input type="text" disabled readonly="readonly" id="totalsumz'+c+'" class="itemtotalsum" min="0.01" step="0.01" value="00.00"/></div></div></div></div>');
    }else{
        alert('Maximum Record is limited to 50');
    }
}

$("#lwelgsubmit").click(function(){
    $("#loading-overlay").show();
    var user = $("#lwelguser").val();
    var pass = $("#lwelgpass").val();
	
    if(user != '' & pass != ''){
        var routine = "syslgin";
        $.ajax({
            url:"adminserfuncode.php",
            method:"POST",
            data:{user:user,pass:pass,routine:routine},
            dataType:"JSON",
            success:function(data)
            {
                $("#loading-overlay").hide();
                if(data.msg == 0){
                    alert("Welcome");
                    location.reload();
                    var timestamp = new Date();
                    sessionStorage.setItem('lasttimestamp',timestamp);
                }else if(data.msg == 1){
                    alert('Please Give Correct User and Password!');
                }else if(data.msg == 2){
                    alert('You already Logged In!');     
                }else if(data.msg == 3){
                    alert('You username is in Inactive status');     
                }else if(data.msg == 4){
                    alert('Please change your Credentials and Re LogIn to the system');
                    $('#mainsysscrlogin').empty();
                    $('#mainsysscrlogin').append(data.pcscr);
                }else if(data.msg == 5){
                    alert('Your user id is in Inactive status');
                }else{
                    alert('You are Not properly Logged out, Please press Ctr + Shift + Del and clear the cookies data and Retry');
                }
            }
        });
    }else{
        $("#loading-overlay").hide();
        alert("Please Give Both User and Password!");
    }
    
});

$(".syslgout").click(function(){
    $("#loading-overlay").show();
	sessionStorage.removeItem('lasttimestamp');
    var routine = "lgout";
        $.ajax({
            url:"adminserfuncode.php",
            method:"POST",
            data:{routine:routine},
            dataType:"JSON",
            success:function(data)
            {
                $("#loading-overlay").hide();
                if(data.msg == 1){
                    alert('You Successfuly Logout From Admin System');
                    location.reload();
                   }else{
					alert('Something went wrong while logout');   
				   }
            }
        });
});

$("#mainsysscr ul li").click(function(){
    $("#loading-overlay").show();
    var newopt = $(this).attr('id');
    var routine = "optionselect";
        $.ajax({
            url:"adminserfuncode.php",
            method:"POST",
            data:{newopt:newopt,routine:routine},
            dataType:"JSON",
            success:function(data)
            {
                
                if(data.msg == 1){
                    $('#targetscreen').empty();
                    $('#targetscreen').append(data.optionscr);
                    if(newopt == 'addbill'){
                        var d = new Date();
                        var y = d.getFullYear(); 
                        var m = d.getMonth();
                        var d = d.getDate();
                        if(d<10){d='0'+d;}else{}
                        if(m<10){m='0'+(m+1);}else{}
                        $("#bleffdte").val(y+'-'+m+'-'+d);
                       }else if(newopt == 'view'){
                        var d = new Date();
                        var y = d.getFullYear(); 
                        var m = d.getMonth();
                        var d = d.getDate();
                        if(d<10){d='0'+d;}else{}
                        if(m<10){m='0'+(m+1);}else{}
                        $("#vstbldte").val(y+'-'+m+'-'+d);
                        $("#vlstbldte").val(y+'-'+m+'-'+d);
                       }else{}
                    $("#loading-overlay").hide();
                }else{
                    alert('You Are Not Authorize to this option');
                }
            }
        });
});

$("#targetscreen").on('click','.clear',function(){
    refresh();
});
    
$('#targetscreen').on('change','.itemqty,.itemunitprice',function(){
    cal();    
});

$('#targetscreen').on('click','#nwitrd',function(){
    cteinpfrm();    
});
    
$("#targetscreen").on('click','.rmvinpfrm',function(){
    var t = this.id;
    var f = t.indexOf('z') + 1;
    var c = t.slice(f);
    var tgn = 'inputfrmz'+c;
    $('#'+tgn).remove();
        
var itemcount = [];    
$('.recordodd,.recordeven').each(function(){
   itemcount.push(this.id);
});
        
var r = 0;
while(r < itemcount.length){
    var id = itemcount[r];
    var f = id.indexOf('z') + 1;
    var c = id.slice(f);
    var tgn = 'itemnoz'+c;
    var tgnn = 'inputfrmz'+c;
    var chk = r+1;
        if(chk%2 == 1){
            var odev = 'odd';
        }else{
            var odev = 'even';
        }
    
    $('#'+tgnn).removeAttr('class');
    $('#'+tgnn).attr('class','record'+odev);
    $('#'+tgn).text(r+1);
    r++;
}
    cal();
});

$("#targetscreen").on('click','#savallbl',function(){
    cal();
        
    var subrow = ['i','q','p'];
    var itmct = [];
    var ufd = [];
    while(itmct.length>0){itmct.pop();}
    while(ufd.length>0){ufd.pop();}
    $('.recordodd,.recordeven').each(function(){
        itmct.push(this.id);
    });
    
    var itmidnam = ['#itemnamesz','#itemqtysz','#itempricez'];
    var chknam = '';
    var latno = '';
    var tgid = '';
    for(var a=0;a<itmct.length; a++){
        chknam = itmct[a];
        lstno = chknam.indexOf('z') + 1;
        lstno = chknam.slice(lstno);
        for(var b=0; b<itmidnam.length; b++){
            tgid = itmidnam[b]+lstno;
            if($(tgid).val() == null || $(tgid).val() == 0){
                ufd.push(tgid);
                $(tgid).css('border','');
            }else{
                $(tgid).css('border','');
            }
        }
    }
    
    if(ufd.length == 0){
        var bname = $("#billname").val();
        var bstatus = $("#blsts").val();
        var bdate = $("#bldte").val();
        if(bname != '' && bstatus != 'Select' && bdate != ''){
        var itname = '';
        var itqty = '';
        var itpre = '';
        var brrc = [];
        function rcd(i,q,p){
        this.name = i;
        this.qty = q;
        this.price = p;
        }
        var lst;
       for(var f=0; f<itmct.length; f++){
           chknam = itmct[f];
           lstno = chknam.indexOf('z') + 1;
           lstno = parseInt(chknam.slice(lstno));
           itname = $("#itemnamesz"+lstno).val();
           itqty = $("#itemqtysz"+lstno).val();
           itpre = $("#itempricez"+lstno).val();
           brrc[f] = new rcd(itname,itqty,itpre);
           
       }
           var routine = "svbl";
           $.ajax({
            url:"adminserfuncode.php",
            method:"POST",
            data:{brrc:brrc,bname:bname,bstatus:bstatus,bdate:bdate,routine:routine},
            dataType:"JSON",
            success:function(data){
                if(data.msg == 1){
                   alert('Successfully Bill '+data.no+' Saved');
                    refresh();
                }else{
                   alert('NOT SUCCESS Try Again');
                }
            }
           });
    }else{
        var suma = ['#billname','#blsts','#bldte'];
        alert('Fill the details which is/are marked in red colour');
        for(var s=0; s<suma.length; s++){
            if($(suma[s]).val() == '' || $(suma[s]).val() == 'Select'){
            $(suma[s]).css('border','2px solid red');
            }else{
            $(suma[s]).css('border','');    
            }
        }
    }
        
    }else{
       alert('Fill the details which is/are marked in red colour');
        for(var c=0; c<ufd.length; c++){
            $(ufd[c]).css('border','2px solid red');
        }
    }
    
});

$("#mainsysscrlogin").on('click','#ipcsub',function(){
    var op = $('#ipcipass').val();
    var np = $('#ipcnpass').val();
    var ap = $('#ipccfnpass').val();
    
   if(op != '' && np != '' && ap != '' && np == ap && op != np){
       var routine = "inipchgfl";
        $.ajax({
            url:"adminserfuncode.php",
            method:"POST",
            data:{routine:routine,op:op,np:np,ap:ap},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 'succ'){
                    alert('Successfully changed, proceed with new password');
                    location.reload();
                }else if(data.msg == 'pass'){
                    alert('Old password is wrong provide correct');
                }else{
                    alert('Try again Something gone wrong');
                }
            }
        });
   }else if(ap != np){
    alert('Both new password and Again new password mismatch');
   }else if(op == np && op != ''){
    alert('New password and old password can not be the same');
   }else{
    alert('Fill all details');
   }
});

$("#targetscreen").on('change','#nucnic',function(){
    var ic = $("#nucnic").val();
    var routine = "chknicusr";
        $.ajax({
            url:"adminserfuncode.php",
            method:"POST",
            data:{routine:routine,ic:ic},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 'find'){
                    alert('Already user '+data.user+' found for this NIC');
                    refresh();
                }else{}
            }
        });
});

$("#targetscreen").on('click','#nucok',function(){
   var ic = $("#nucnic").val();
   var fn = $("#nucfname").val();
   var ln = $("#nuclname").val();
   var wc = $("#nucwc").val();
   var routine = "crnewusrfun";
   $.ajax({
   url:"adminserfuncode.php",
   method:"POST",
   data:{routine:routine,ic:ic,fn:fn,ln:ln,wc:wc},
   dataType:"JSON",
   success:function(data)
     {
       if(data.msg == 'succ'){
        alert('New user id : `'+data.nuser+'` Password :`'+data.nupass+'` created for this NIC');
        refresh();
       }else{}
     }
   });
});

$("#targetscreen").on('click','#vbsubko',function(){
    var sd = $("#vstbldte").val();
    var ld = $("#vlstbldte").val();
    var routine = "vwbllsdet";
        $.ajax({
            url:"adminserfuncode.php",
            method:"POST",
            data:{routine:routine,sd:sd,ld:ld},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 'succ'){
                    $('#adblsecmn').empty();
                    $('#adblsecmn').append(data.hescr);
                    var r = 0;
                    var odev = 'Even'; 
                    while(r<data.maxrun){
                    if(odev == 'odd'){odev = 'even';}else{odev = 'odd';}
                    $('#adblsecmn').append('<div class="vrecz'+odev+'"><div class="vrecsub1">'+(r+1)+'</div><div class="vrecsub2">'+data.name[r]+'</div><div class="vrecsub3">'+data.status[r]+'</div><div class="vrecsub4">'+data.date[r]+'</div><div class="vrecsub4">'+data.effdate[r]+'</div><div class="vrecsub5">'+chngnofmt(data.sum[r])+'</div><div class="vrecsub6"><input type="submit" value="View" class="vrecbutt" id="'+data.id[r]+'"/></div></div>');
                    r++;
                    }
                }else{
                    alert('No Bill found between given two dates');
                }
            }
        });
});

$("#targetscreen").on('click','.vrecbutt',function(){
    var tgn = $(this).attr('id');
    var routine = "vwflbldil";
        $.ajax({
            url:"adminserfuncode.php",
            method:"POST",
            data:{routine:routine,tgn:tgn},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 'succ'){
                    $('#adblsecmn').toggle();
                    $('.optadbl').toggle();
                    $('#adblsecmnhidden').toggle();
                    $('#adblsecmnhidden').empty();
                    $('#adblsecmnhidden').append(data.hescr);
                    var r = 0;
                    var odev = 'Even'; 
                    while(r<data.maxrun){
                    if(odev == 'odd'){odev = 'even';}else{odev = 'odd';}
                    $('#adblsecmnhidden').append('<div class="vrecz'+odev+'"><div class="vdetsub1">'+(r+1)+'</div><div class="vdetsub2">'+data.item[r]+'</div><div class="vdetsub3">'+data.qty[r]+'</div><div class="vdetsub4">'+chngnofmt(data.price[r])+'</div><div class="vdetsub4">'+chngnofmt(data.total[r])+'</div><div class="vdetsub5">'+chngnofmt(data.sum[r])+'</div><div class="vdetsub6">'+data.cby[r]+'</div></div>');
                    r++;
                    }
                }else{
                    alert('Something Gone Wrong, Try Again');
                }
            }
        });
});

$("#targetscreen").on('click','#billback',function(){
    $('#adblsecmn').toggle();
    $('.optadbl').toggle();
    $('#adblsecmnhidden').toggle();
});