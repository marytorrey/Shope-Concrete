#!/usr/bin/perl

use CGI::Carp qw(fatalsToBrowser);
use strict;
use vars qw($submissionsperpage $entriesperpage $query $mailserver $attachments $htmlurl $htmlpath $iconurl $fhu $finaluploaddata $sendmail $formpath $formdir $formurl $admin $namelimit $postlimit $allowhtml $rootpath $rooturl $datapath $flock %in %tmpfld @fldorder %cookie $basepath $cgipath $cgiurl $htmlpath $htmlurl $imageurl $imagepath $username $password $houroffset $page $lpage $npages);
alarm(30);

#####################################################################
# csFormbuilder - 1.2 - 10/30/2006
#
#####################################################################
#                                                                   #
#    Copyright © 1999-2005 CGISCRIPT.NET - All Rights Reserved      #
#                                                                   #
#####################################################################
#                                                                   #
#          THIS COPYRIGHT INFORMATION MUST REMAIN INTACT            #
#                AND MAY NOT BE MODIFIED IN ANY WAY                 #
#                                                                   #
#####################################################################
#
# When you downloaded this script you agreed to accept the terms 
# of this Agreement. This Agreement is a legal contract, which 
# specifies the terms of the license and warranty limitation between 
# you and CGISCRIPT.NET. You should carefully read the following 
# terms and conditions before installing or using this software.  
# Unless you have a different license agreement obtained from 
# CGISCRIPT.NET, installation or use of this software indicates 
# your acceptance of the license and warranty limitation terms
# contained in this Agreement. If you do not agree to the terms of this
# Agreement, promptly delete and destroy all copies of the Software.
#
# Versions of the Software 
# Only one copy of the registered version of CGISCRIPT.NET 
# may used on one web site.
# 
# License to Redistribute
# Distributing the software and/or documentation with other products
# (commercial or otherwise) or by other than electronic means without
# CGISCRIPT.NET's prior written permission is forbidden.
# All rights to the CGISCRIPT.NET software and documentation not expressly
# granted under this Agreement are reserved to CGISCRIPT.NET.
#
# Disclaimer of Warranty
# THIS SOFTWARE AND ACCOMPANYING DOCUMENTATION ARE PROVIDED "AS IS" AND
# WITHOUT WARRANTIES AS TO PERFORMANCE OF MERCHANTABILITY OR ANY OTHER
# WARRANTIES WHETHER EXPRESSED OR IMPLIED.   BECAUSE OF THE VARIOUS HARDWARE
# AND SOFTWARE ENVIRONMENTS INTO WHICH CGISCRIPT.NET MAY BE USED, NO WARRANTY 
# OF FITNESS FOR A PARTICULAR PURPOSE IS OFFERED.  THE USER MUST ASSUME THE
# ENTIRE RISK OF USING THIS PROGRAM.  ANY LIABILITY OF CGISCRIPT.NET WILL BE
# LIMITED EXCLUSIVELY TO PRODUCT REPLACEMENT OR REFUND OF PURCHASE PRICE.
# IN NO CASE SHALL CGISCRIPT.NET BE LIABLE FOR ANY INCIDENTAL, SPECIAL OR
# CONSEQUENTIAL DAMAGES OR LOSS, INCLUDING, WITHOUT LIMITATION, LOST PROFITS
# OR THE INABILITY TO USE EQUIPMENT OR ACCESS DATA, WHETHER SUCH DAMAGES ARE
# BASED UPON A BREACH OF EXPRESS OR IMPLIED WARRANTIES, BREACH OF CONTRACT,
# NEGLIGENCE, STRICT TORT, OR ANY OTHER LEGAL THEORY. THIS IS TRUE EVEN IF
# CGISCRIPT.NET IS ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. IN NO CASE WILL
# CGISCRIPT.NET' LIABILITY EXCEED THE AMOUNT OF THE LICENSE FEE ACTUALLY PAID
# BY LICENSEE TO CGISCRIPT.NET.
#
# Credits:
# Andy Angrick - Programmer
# Mike Barone - Design
# Email: contact@cgiscript.net
# For information about this script or other scripts see 
# http://www.cgiscript.net
#
# Thank you for trying out our script.
# If you have any suggestions or ideas for a new innovative script
# please direct them to contact@cgiscript.net.  Thanks.
#
########################################################################

$basepath = './';
$houroffset=0;
$flock=1;
$entriesperpage=50;
$submissionsperpage=50;

$in{'scriptname'} = 'csFormbuilder.cgi';

if(-f "$basepath/setup.cgi"){
	require("$basepath/setup.cgi");
	}
require("$basepath/libs.cgi");

$formurl=$htmlurl.'/forms';
$formpath=$htmlpath.'/forms';
$datapath=$cgipath.'/data';
$attachments=$cgipath.'/uploads';
$imageurl=$htmlurl.'/images';
$iconurl=$htmlurl.'/icons';
$in{'imageurl'} = $imageurl;
$in{'iconurl'} = $iconurl;
$in{'cgiurl'} = $cgiurl.'/'.$in{'scriptname'};
($sendmail !~ /sendmail/)&&($mailserver=$sendmail);

&main;

sub main{
($ENV{'CONTENT_TYPE'} =~ /multipart\/form-data/i)?(&getdata(1)):(&getdata());
($in{'command'} eq 'doexport')&&(&DoExport);
print "Content-type: text/html\n\n";
if((! -f "$basepath/setup.cgi")&&($in{'command'} eq "")){
	&DoSetup;
	}

if($in{'command'} eq "savesetup"){
	if(-e "$basepath/setup.cgi"){
		&PError("Error. Permission denied.");
		}
else{
	&SaveSetup;
	}
}
&GetCookies;
my $command = $in{'command'};
($command eq "login")&&(&DoLogin);
($command eq "")&&($in{'form-id'} > 0)&&(&MailForm);
($command eq "mailform")&&(&MailForm);
($command eq "")&&(&DoLogin);
($command eq 'vf')&&(&ViewForm);
&GetLogin;
($command eq "manage")&&(&Manage);
($command eq "cp")&&(&ChangePassword);
($command eq "showcp")&&(&ShowCP);
($command eq "showaddform")&&(&ShowAddForm);
($command eq "showaddformtemplate")&&(&ShowAddForm);
($command eq "saveform")&&(&SaveForm);
($command eq "saveformtemplate")&&(&SaveFormTemplate);
($command eq "showeditform")&&(&ShowEditForm);
($command eq "saveformchanges")&&(&SaveFormChanges);
($command eq "deleteform")&&(&DeleteForm);
($command eq "deletefield")&&(&DeleteField);
($command eq "copyform")&&(&CopyForm);
($command eq "copyfield")&&(&CopyField);
($command eq "showresultsconfig")&&(&ShowResultsConfig);
($command eq "showstyleconfig")&&(&ShowStyleConfig);
($command eq "showautoconfig")&&(&ShowAutoConfig);
($command eq "showlinks")&&(&ShowLinks);
($command eq "showfieldconfig")&&(&ShowFieldConfig);
($command eq "showaddfield")&&(&ShowAddField);
($command eq "savefield")&&(&SaveField);
($command eq "showfieldedit")&&(&ShowFieldEdit);
($command eq "savefieldchanges")&&(&SaveFieldChanges);
($command eq "movefieldup")&&(&MoveFieldUp);
($command eq "movefielddown")&&(&MoveFieldDown);
($command eq "previewform")&&(&PreviewForm);
($command eq "savestyle")&&(&SaveStyle);
($command eq "resetert")&&(&ResetTemplates);
($command eq "resetspt")&&(&ResetTemplates);
($command eq "saveresultsconfig")&&(&SaveResultsConfig);
($command eq "saveautoconfig")&&(&SaveAutoConfig);
($command eq "showaddattach")&&(&ShowAddAttach);
($command eq "addattach")&&(&AddAttach);
($command eq "removeattach")&&(&RemoveAttach);
($command eq "clearsubmissions")&&(&ClearSubmissions);
($command eq "viewsubmissions")&&(&ViewSubmissions);
($command eq "delsubmission")&&(&DeleteSubmissions);
($command eq 'showeditor')&&(&ShowEditor);
($command eq 'showhref')&&(&ShowHRef);
($command eq 'showuploadEditor')&&(&showuploadEditor);
($command eq 'uploadEditor')&&(&UploadEditor);
}


sub UploadEditor{
my $rn = &GetRealName($in{'file'});
&CheckExt($rn,'jpg,gif');
&SaveFile('file',"$formpath/images/$rn");
(!$in{'align'})&&($in{'align'}='left');
(!$in{'border'})&&($in{'border'}='0');
(!$in{'hspace'})&&($in{'hspace'}='0');
(!$in{'vspace'})&&($in{'vspace'}='0');
print <<"EOF";
<script language=javascript>
var sel=window.opener.editArea.document.selection.createRange();
sel.pasteHTML("<img src=\\"$formurl/images/$rn\\" align=\\"$in{'align'}\\" alt=\\"$in{'description'}\\" border=\\"$in{'border'}\\" hspace=\\"$in{'hspace'}\\" vspace=\\"$in{'vspace'}\\">");
sel.select();
window.close();
</script>
EOF
exit;
}

sub showuploadEditor{
&PageOut("$basepath/t_upload_imageEditor.htm");
exit;
}

sub ShowHRef{
&PageOut("$basepath/t_add_href.htm");
exit;
}

sub ShowEditor{
&PageOut("$basepath/t_editor.htm");
exit;
}

sub ViewForm{
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Error. Invalid ID"));
my $formname = &GetFormName($id);

open(OUT,"<$formpath/$formname.htm")||print "$!: $formname.htm<br>";
while(<OUT>){
my $o = $_;
$o =~ s/\r//g;
$o =~ s/\\/\\\\/g;
$o =~ s/\"/\\"/g;
$o =~ s/(scr)(ipt)/$1\"\+\"$2/gsi;
my @mylines = split(/\r*\n/,$o);    
    foreach my $q (@mylines){
      print qq|document.write("$q\\n");\n|;
      }
}
close OUT;

exit;
}

sub DoExport{
&GetCookies;
$in{'UserName'} = $cookie{'UserName'};
$in{'PassWord'} = $cookie{'PassWord'};
if($password =~ /^CS/){
	$in{'PassWord'} = crypt($in{'PassWord'},'CS');
	}
(($in{'UserName'} ne $username)||(($in{'PassWord'} ne $password)))&&(exit);
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Error. Invalid ID"));
print "Content-type: application/msexcel\n";
print "Content-disposition: inline; filename=\"Export.csv\"\n\n";
open(EXP,"<$datapath/$id-log.cgi");
while(<EXP>){
	$_ =~ s/^"(\d+)",/'"'.&ctime($1).'",'/e;
	print;
	}
close EXP;
exit;
}

sub DeleteSubmissions{
my(@l,%dt);
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Error. Invalid ID"));
(!$in{'sid'})&&(&PError("Error. No submissions selected to delete."));

my @sids = split(/\\0/,$in{'sid'});
foreach my $i (@sids){
	$dt{$i} = 1;
	}
open(DB,"+<$datapath/$id-log.cgi");
($flock)&&(flock(DB,2));
while(<DB>){
	my $oline = $_;
	$_ =~ s/\r*\n*$//g;
	$_ =~ s/^"//;
	$_ =~ s/"$//;
	my(@r) = split("\",\"",$_);
	if(!$dt{"$r[0]-$r[1]"}){
		push(@l,$oline);
		}
	}
seek(DB,0,0);

foreach my $i (@l){
	print DB $i;
	}
truncate(DB, tell(DB));

($flock)&&(flock(DB,8));
close DB;

print qq|
<script language=javascript>
alert("Submissions Deleted");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=viewsubmissions&id=$id&rnd="+rndURL;
</script>
|;
exit;


}

sub ViewSubmissions{
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));

$in{'FormName'} = &GetFormName($id);


$page='';
$page = $in{'page'};
(!$page)&&($page = 1);
my $start = ($page*$submissionsperpage)-$submissionsperpage;
my $end = $start + $submissionsperpage;
my $count=0;


open(DB,"<$datapath/$id-log.cgi");
my $header = <DB>;
chomp $header;
$header =~ s/\r*\n*$//g;
$header =~ s/^"//;
$header =~ s/"$//;
my @hd = split(/\",\"/,$header);
$in{'header'} = "<tr bgcolor=\"#E2E2E2\"><td>&nbsp;</td><td><b>".join("</b></td><td><b>",@hd)."</b></td></tr>";
while(<DB>){
$count++;
if(($count > $start) & ($count <= $end)){
	chomp;
	$_ =~ s/\r*\n*$//g;
	$_ =~ s/^"//;
	$_ =~ s/"$//;
	my @ln = split(/\",\"/,$_);
	my $ts = $ln[0] ;
	$ln[0] = ctime($ln[0]);
	foreach my $i (0..$#ln){
		$ln[$i] =~ s/\\n/<br>\n/g;
		}
	$in{'line'} .= "<tr><td><input type=checkbox name=sid value=\"$ts-$ln[1]\"></td><td>".join("</td><td>",@ln)."</td></tr>";
	}
}
close DB;

if(!$in{'line'}){
	$in{'line'} = "<tr><td><font face=tahoma size=2>No submissions</font></td></tr>";
	}
else{
	$in{'expbutton'} = qq|<input type="button" class=button  value="Delete Selected" onClick="Delete();"> <input type="button" class=button  value="Export" onClick="DoExport();">|;
	}

$in{'link'} = &GetNlinksMan($count,$submissionsperpage,"$in{'command'}&id=$id");
(!$in{'link'})&&($in{'link'} = ' 0');

&PageOut("$cgipath/t_viewsubmissions.htm");
exit;
}

sub ClearSubmissions{
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));

unlink("$datapath/$id-log.cgi");

print qq|
<script language=javascript>
alert("Submissions Cleared");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=manage&rnd="+rndURL;
</script>
|;
exit;
}

sub MailForm{

#get results config
my $id = $in{'form-id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));

&sanitizevars;

my @fields = GetFields($id);

#first check for required fields and consolidate multi fields
my $errormsg='';
foreach my $i (@fields){
	my(@f) = split("\t",$i);
	
	if(($f[1] eq 'PhoneField')&&($f[5] eq 'P1')&&($in{"${f[3]}_1"})&&($in{"${f[3]}_2"})&&($in{"${f[3]}_3"})){
		$in{$f[3]} = '('.$in{"${f[3]}_1"}.') '.$in{"${f[3]}_2"}.'-'.$in{"${f[3]}_3"};
		}

	if(($f[1] eq 'PhoneField')&&($f[5] eq 'P2')&&($in{"${f[3]}_1"})&&($in{"${f[3]}_2"})&&($in{"${f[3]}_3"})){
		$in{$f[3]} = '('.$in{"${f[3]}_1"}.') '.$in{"${f[3]}_2"}.'-'.$in{"${f[3]}_3"}.' Ext. '.$in{"${f[3]}_4"};
		}

	if(($f[1] eq 'TimeField')&&($f[5] eq 'P1')&&($in{"${f[3]}_1"})&&($in{"${f[3]}_2"})&&($in{"${f[3]}_3"})){
		$in{$f[3]} = $in{"${f[3]}_1"}.':'.$in{"${f[3]}_2"}.' '.$in{"${f[3]}_3"};
		}

	if(($f[1] eq 'TimeField')&&($f[5] eq 'P2')&&($in{"${f[3]}_1"})&&($in{"${f[3]}_2"})){
		$in{$f[3]} = $in{"${f[3]}_1"}.':'.$in{"${f[3]}_2"};
		}
		
	if(($f[7] eq 'Y')&&($in{$f[3]} eq "")){
		$f[2] =~ s/\s+$//;
		$f[2] =~ s/[^A-Za-z0-9]$//;
		$errormsg .= "$f[2]\\n";
		}
	}


if($errormsg){
$errormsg = "Response Required\\n==========\\n$errormsg";
print qq|
<script language=javascript>
alert("$errormsg");
history.back();
</script>
|;
exit;
}


#check for invalid email format
my $emailerror='';
foreach my $i (@fields){
	my(@f) = split("\t",$i);
	
	if($f[1] eq 'EmailAddress'){
	
		if(($f[19] eq 'Y')&&(!$in{"$f[3]_Verify"})){
			$emailerror .= "Verify email required\\n";
			}
			
		if(($f[19] eq 'Y')&&($in{$f[3]} ne $in{"$f[3]_Verify"})){
			$f[2] =~ s/\s+$//;
			$f[2] =~ s/[^A-Za-z0-9]$//;
			$emailerror .= "Please retype email address\\n";
			}
		
		if(!&ValidEmail($in{$f[3]})){
			$emailerror .= "Invalid email address\\n";
			}
		}
	}


if($emailerror){
$emailerror = "Error\\n==========\\n$emailerror";
print qq|
<script language=javascript>
alert("$emailerror");
history.back();
</script>
|;
exit;
}

#check for authentication code
my $autherror='';
my $fc=0;
foreach my $i (@fields){
	my(@f) = split("\t",$i);
	
	if($f[1] eq 'ImageVerify'){
		
		#foreach my $i (keys %in){
		#print "$i: $in{$i}<br>";
		#}
		
		my $sessionid = $in{"${f[3]}_sid"};
		my $key = $in{$f[3]};
		
		(!$key)&&($autherror .= "Authentication code required\\n")&&(last);
		($sessionid =~ /[^A-Z0-9]/)&&($autherror .= "Invalid session id\\n")&&(last);
		
		open(KEY,"<$datapath/key-$sessionid.cgi");
		my $secret = <KEY>;
		chomp $secret;
		&DeleteOldKeys();
		
		#check to see if we've go above threshhold
		open(LOG,"<$datapath/authip-${id}-$ENV{'REMOTE_ADDR'}.cgi");
		$fc = <LOG>;
		close LOG;
		
		if($fc > $f[19]){
			$autherror .= "Max failed attempts exceeded.\\n";
			last;
			}

		if($secret ne $key){
			#failed
			#foreach my $i (%in){
			#print "$i: $in{$i}<br>";
			#}
			$autherror .= "Authentication code mismatch. Please retype.\\n";
		
			$fc++;
			open(LOG,">$datapath/authip-${id}-$ENV{'REMOTE_ADDR'}.cgi");
			print LOG $fc;
			close LOG;
			last;
			}
		else{
			#passed!
			delete $in{"${f[3]}-sid"};
			#unlink("$datapath/key-$sessionid.cgi");
			unlink("$datapath/authip-$id-$ENV{'REMOTE_ADDR'}.cgi");
			}

		}
	}


if($autherror){
$autherror = "Error\\n==========\\n$autherror";
print qq|
<script language=javascript>
alert("$autherror");
history.back();
</script>
|;
exit;
}


#check for file upload extensions
my $uploaderror='';
$fhu=0;
my $uid = &GenRan();

$finaluploaddata='';
foreach my $i (@fields){
	my(@f) = split("\t",$i);
	
	if(($f[1] eq 'UploadField')&&($f[19]==1)){
		my $fn = GetRealName($in{$f[3]});
		next if (!$fn);
		if($f[23]){
			if(!&CheckExt($fn, $f[23])){
				$uploaderror .= "$fn - Only  $f[23] types are permitted\\n";
				}
			}
			
		my($fdata) = &GetFile($f[3]);
		(!$fdata)&&(next);
		if(length($fdata) >= ($f[6] * 1000000)){
			$uploaderror .= "Max file size exceeded ($f[6] MB)\\n";
			}
			
#send as attachment
if($f[20]==1){			
my $fa = &encode_base64($fdata);	

##add the upload##
$fhu=1;#flag for has upload
$finaluploaddata .= "
------=_NextPart_000_00AF_01C08EBD.B69D5020
Content-Type: application/octet-stream;
        name=\"$fn\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment;
        filename=\"$fn\"

$fa";
##add the upload##
}
else{
#store files
	if (-d "$f[21]"){
		#sanitize
		($f[21] =~ /[^A-Za-z0-9\/\_\-]/)&&($uploaderror .= "Error storing file. Invalid destination directory name\\n");
		($fn =~ /[^A-Za-z0-9\/\_\-]\./)&&($uploaderror .= "Error storing file. Invalid file name\\n");
		($fn =~ /\.{2,}/)&&($uploaderror .= "Error storing file. Invalid file name\\n");
		#get a unique id
		#my $uid = &GenRan();
		$fn = "$uid-$fn";
		if(!$uploaderror){
			open(FILE,">$f[21]/$fn");
			binmode(FILE);
			print FILE $fdata;
			close FILE;
			}
		}
	else{
		$uploaderror .= "Error storing file. Destination directory doesn't exist\\n";
		}
	
}

	$tmpfld{$f[3]} = GetRealName($in{$f[3]}); #save variable
	$in{$f[3]} =  $fn; #set variable to just filename (no path)
	}

#multi upload
if(($f[1] eq 'UploadField')&&($f[19] > 1)){
	my $count = $in{$f[3]};
	$in{$f[3]}=''; #clear out variable
	my $rc=0;
	my $totalbytes=0;
	for my $i (1..$count){
		next if(!$in{"${f[3]}_$i"});
		$rc++;
		#print "$rc: ".$in{"${f[3]}_$i"}."<br>";
		
		if($rc > $f[19]){
			$uploaderror .= "Only $f[19] files allowed for upload\\n";
			last;
			}
			
		my $fn = GetRealName($in{"${f[3]}_$i"});
		if($f[23]){
			if(!&CheckExt($fn, $f[23])){
			
				$uploaderror .= "$fn - Only  $f[23] types are permitted\\n";
				}
			}
			
		my($fdata) = &GetFile("${f[3]}_$i");
		(!$fdata)&&(next);
		if(($f[22] == 1)&&(length($fdata) > ($f[6] * 1000000))){
			$uploaderror .= "Max file size exceeded ($f[6] MB)\\n";
			}
		if($f[22] == 2){
			$totalbytes += length($fdata);
			if($totalbytes > ($f[6] * 1000000)){
				$uploaderror .= "Max file size exceeded ($f[6] MB)\\n";
				}
			}

#send as attachment
if($f[20]==1){			
my $fa = &encode_base64($fdata);	

##add the upload##
$fhu=1;#flag for has upload
$finaluploaddata .= "
------=_NextPart_000_00AF_01C08EBD.B69D5020
Content-Type: application/octet-stream;
        name=\"$fn\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment;
        filename=\"$fn\"

$fa";
##add the upload##
}
else{
#store files
	if (-d "$f[21]"){
		#sanitize
		($f[21] =~ /[^A-Za-z0-9\/\_\-]/)&&($uploaderror .= "Error storing file. Invalid destination directory name\\n");
		($fn =~ /[^A-Za-z0-9\/\_\-]\./)&&($uploaderror .= "Error storing file. Invalid file name\\n");
		($fn =~ /\.{2,}/)&&($uploaderror .= "Error storing file. Invalid file name\\n");
		#get a unique id
		#my $uid = &GenRan();
		$fn = "$uid-$fn";
		
		if(!$uploaderror){
			open(FILE,">$f[21]/$fn");
			binmode(FILE);
			print FILE $fdata;
			close FILE;
			}
		
		}
	else{
		$uploaderror .= "Error storing file. Destination directory doesn't exist\\n";
		}
}

		$tmpfld{$f[3]} .= GetRealName($in{"${f[3]}_$i"}).','; #save variable
		$in{$f[3]} .=  $fn.','; #set variable to just filename (no path)
		delete $in{"${f[3]}_$i"};
		}
	}
#end multi upload

$in{$f[3]} =~ s/,$//;#remove extra comma
$tmpfld{$f[3]} =~ s/,$//;#remove extra comma
}


if($uploaderror){
$uploaderror = "Error\\n==========\\n$uploaderror";
print qq|
<script language=javascript>
alert("$uploaderror");
history.back();
</script>
|;
exit;
}

my $found=0;
open(DB,"<$cgipath/data/forms.cgi");
while(<DB>){
	chomp;
	($in{'fid'},$in{'formname'},$in{'formdesc'},$in{'formsubject'},$in{'formsubjectadv'},$in{'formto'},$in{'formtoadv'},$in{'formcc'},$in{'formbcc'},$in{'formfrom'},$in{'formsublimit'},$in{'formlimithd'},$in{'formrestrictip'},$in{'formdelivery'},$in{'limitip'},$in{'multipage'}) = split("\t",$_);
	if($in{'fid'} == $id){
	$found=1;
	last;
	}
	}
close DB;

open(DB,"<$datapath/results-$id.cgi");
my $line = <DB>;
close DB;
my($sphide,$erhide);
my (%sh,$selS,$selH,%sh2,$sel2S,$sel2H,$drt,$det,$fcount);

($in{'spoptionsorig'},$in{'redirectURL'},$in{'multipageOLD'},$in{'successtemplate'},$in{'eroptions'},$in{'emailtemplate'},$in{'successhtml'},$in{'emailhtml'},$sphide,$erhide,$in{'MySQL'},$in{'MySQLHost'},$in{'MySQLDatabase'},$in{'MySQLUser'},$in{'MySQLPass'},$in{'MySQLFM'},$in{'spsbf'},$in{'ersbf'}) = split("\t",$line);
$in{'successtemplate'} = &reverseHTML($in{'successtemplate'});
$in{'emailtemplate'} = &reverseHTML($in{'emailtemplate'});

if($in{'multipage'} > 0){
	$in{'spoptions'} = 'M';
	}
else{
	$in{'spoptions'} = $in{'spoptionsorig'};
	}

my @fl = split("~",$sphide);
foreach my $i (@fl){
	$sh{$i} = 1;
	}

my @fl2 = split("~",$erhide);
foreach my $i (@fl2){
	$sh2{$i} = 1;
	}
	
$in{'formname'} = &GetFormName($id); 

#get form field values in the order they were submitted
my $hasnp=0;
my $output='';
my $formdate = &ctime(time);
my $REMOTE_ADDR = $ENV{'REMOTE_ADDR'};
my $HTTP_USER_AGENT = $ENV{'HTTP_USER_AGENT'};
my $HTTP_REFERER = $ENV{'HTTP_REFERER'};

(!$in{'spoptions'})&&($in{'spoptions'} =  'D');
(!$in{'eroptions'})&&($in{'eroptions'} =  'D');

### START SUCCESS PAGE ###


if($in{'command'} ne 'mailform'){

foreach my $i (@fldorder){
	next if ($i eq 'form-id');
	my $t='';
	($tmpfld{$i})?($t=$tmpfld{$i}):($t=$in{$i});
	$output .= "<b>$i: </b> $t<br>";
	}

$output =  qq|<font face=verdana size=2>The following information has been submitted:<br><br>$output<br>[ <a href="javascript:history.back();">BACK</a> ]</font>|;

}
elsif($in{'spoptions'} eq 'D'){
	#get fields
	foreach my $i (@fields){
		my(@f) = split("\t",$i);
		$fcount++;
		my $t='';
		($tmpfld{$f[3]})?($t=$tmpfld{$f[3]}):($t=$in{$f[3]});
		
		$t =~ s/\r*\n/<br>\n/g;
		if($in{'spsbf'} eq 'checked'){
			if($t){
				$output .= "<b>$f[2] </b> $t<br>" unless ($sh{$f[3]});
				}
			}
		else{
			$output .= "<b>$f[2] </b> $t<br>" unless ($sh{$f[3]});
			}
		
		}

	$output =  qq|<font face=verdana size=2>The following information has been submitted:<br><br>$output<br>[ <a href="javascript:history.back();">BACK</a> ]</font>|;

}
elsif($in{'spoptions'} eq 'R'){
	$output = qq|
	<noscript><a href="$in{'redirectURL'}">Click here to continue</a></noscript>
	<script language=javascript>
	window.location="$in{'redirectURL'}";
	</script>
	|;
}
elsif($in{'spoptions'} eq 'T'){
	($in{'successhtml'} ne 'checked')&&($output = "<pre>");
	$in{'successtemplate'} =~ s/\{Date\}/$formdate/g;
	$in{'successtemplate'} =~ s/\{REMOTE_ADDR\}/$REMOTE_ADDR/g;
	$in{'successtemplate'} =~ s/\{HTTP_USER_AGENT\}/$HTTP_USER_AGENT/g;
	$in{'successtemplate'} =~ s/\{HTTP_REFERER\}/HTTP_REFERER/g;
	$in{'successtemplate'} = &GetTemplate($in{'successtemplate'});
	$output .= $in{'successtemplate'};
	($in{'successhtml'} ne 'checked')&&($output .= "</pre>");
	}
elsif($in{'spoptions'} eq 'M'){
	$in{'nextpage'} = &GetFormName($in{'multipage'});
	#get contents of page
	my $np = '';
	open(DB,"<$formpath/$in{'nextpage'}.htm");
	while(<DB>){
		$np .= $_;
		}
	close DB;

	my $formvars='';

	foreach my $i (@fldorder){
		next if ($i eq 'form-id');
		next if ($i eq 'command');
		next if ($i eq 'form-camefrom');		
		#url encode
		$in{$i} = htmlspecialchars($in{$i});
		$formvars .= qq|<input type=hidden name="$i" value="$in{$i}">\n|;
		}
	
	#get came from form
	my @tmp = split(",",$in{'form-camefrom'});
	push(@tmp,$id);
	$in{'form-camefrom'} = join(",",@tmp);
	my $tag = qq|<input type=hidden name=form-id value="$in{'multipage'}">|;
	my $newtag = qq|<input type=hidden name=form-id value="$in{'multipage'}">
	<input type=hidden name=form-camefrom value="$in{'form-camefrom'}">
	$formvars|;
	$np =~ s/$tag/$newtag/i;
	#$np =~ s/<input type=submit value=\"([^\"]+)\">/<input type=button value=\"Back\" onClick=\"history.back();\"> <input type=submit value=\"$1\">/i;
	$output =  $np;
	$hasnp=1;
	}
else{
	#holder
	}

if($hasnp){
	#end now bypass email and autoresponse
	print $output;
	exit;
	}


if($in{'MySQL'}){
	require("$basepath/mysql.cgi");
	}


### START SUCCESS PAGE ###

### START EMAIL RESULTS ###
my $eroutput='';
my $contenttype = 'text/plain';
if($in{'command'} ne 'mailform'){
foreach my $i (@fldorder){
	next if ($i eq 'form-id');
	$eroutput .= "  $i: $in{$i}\r\n";
	}

$eroutput = qq|  The following information has been submitted on $formdate by $REMOTE_ADDR:\r\n\r\n$eroutput|;
	}
elsif($in{'eroptions'} eq 'D'){
	#get fields
	foreach my $i (@fields){
		my(@f) = split("\t",$i);
		$fcount++;
		if($in{'ersbf'} eq 'checked'){
			if($in{$f[3]}){
				$eroutput .= "  $f[2] $in{$f[3]}\r\n" unless ($sh2{$f[3]});
				}
			}
		else{
			$eroutput .= "  $f[2] $in{$f[3]}\r\n" unless ($sh2{$f[3]});
			}
		
		}
	close DB;

	$eroutput = qq|  The following information has been submitted on $formdate by $REMOTE_ADDR:\r\n\r\n$eroutput|;

	
	}
elsif($in{'eroptions'} eq 'T'){
	($in{'emailhtml'} eq 'checked')&&($contenttype = 'text/html');
	$in{'emailtemplate'} =~ s/\{Date\}/$formdate/g;
	$in{'emailtemplate'} =~ s/\{REMOTE_ADDR\}/$REMOTE_ADDR/g;
	$in{'emailtemplate'} =~ s/\{HTTP_USER_AGENT\}/$HTTP_USER_AGENT/g;
	$in{'emailtemplate'} =~ s/\{HTTP_REFERER\}/HTTP_REFERER/g;
	$in{'emailtemplate'} = &GetTemplate($in{'emailtemplate'});
	$eroutput = $in{'emailtemplate'};
	}
else{
	#holder
	}

### END EMAIL RESULTS ###

### GET FORM CONFIG OPTIONS ###
my $found=0;
open(DB,"<$cgipath/data/forms.cgi");
while(<DB>){
	chomp;
	($in{'id'},$in{'formname'},$in{'formdesc'},$in{'formsubject'},$in{'formsubjectadv'},$in{'formto'},$in{'formtoadv'},$in{'formcc'},$in{'formbcc'},$in{'formfrom'},$in{'formsublimit'},$in{'formlimithd'},$in{'formrestrictip'},$in{'formdelivery'},$in{'limitip'}) = split("\t",$_);
	if($in{'id'} == $id){
	$found=1;
	last;
	}
	}
close DB;
(!$found)&&(&PError("Form ID not found"));
$in{'formdesc'} =~ s/\\n/\n/g;
$in{'formsubjectadv'} =~ s/\\n/\n/g;
$in{'formto'} =~ s/\\n/\n/g;
$in{'formtoadv'} =~ s/\\n/\n/g;
$in{'formcc'} =~ s/\\n/\n/g;
$in{'formbcc'} =~ s/\\n/\n/g;
### END GET FORM CONFIG OPTIONS ###


### START EMAIL CONSTRUCTION ###
my($subject,$to,$from,$cc,$bcc);

$subject = $in{'formsubject'};
$subject  =~ s/\{(\w+)\}/$in{$1}/g;


if($in{'formsubjectadv'}){
	my @lines = split(/\r*\n/,$in{'formsubjectadv'});
	foreach my $i (@lines){
	my($fn,$fv,$s) = split(/\|/,$i);
		($in{$fn} eq $fv)&&($subject=$s);
		}
	}

$to = $in{'formto'};
my @advto;

if($in{'formtoadv'}){
	my @lines = split(/\r*\n/,$in{'formtoadv'});
	foreach my $i (@lines){
	my($fn,$fv,$ft) = split(/\|/,$i);
	
	my @t = split(",",$in{$fn});
	foreach my $y (@t){
		if($y eq $fv){
			$ft =~ s/\s+//g;	
			$to=$ft;
			push(@advto,$ft);
			}
		}	
		}
	}
$to =~ s/\r*\n/,/g;

$cc = $in{'formcc'};
$cc =~ s/\r*\n/,/g;
$bcc = $in{'formbcc'};
$bcc =~ s/\r*\n/,/g;
$from = '';

#find 'from' email.
	foreach my $i (@fields){
		my(@f) = split("\t",$i);
		if($f[1] eq 'EmailAddress'){
			$from = $in{$f[3]};
			}
		}
	close DB;
#guess the 'from' email.
if(!$from){
foreach my $i (keys %in){
if(($i =~ /\bemail_address\b/i)||($i =~ /\bemail\b/i)){
	$from = $in{$i};
	last;
	}
}

if(!$from){
	$from = $in{'formfrom'};
	}

}

#override for multi-to
if($#advto > 1){
	foreach my $e (@advto){
	next if (!$e);
	#print "Sending to: $e<br>";
	&SendEmail($id,$subject,$e,$from,$cc,$bcc,$contenttype,$eroutput);
	}
}
else{
	&SendEmail($id,$subject,$to,$from,$cc,$bcc,$contenttype,$eroutput);
	}
### END EMAIL CONSTRUCTION ###

### START AUTO RESPONSE ###
open(DB,"<$datapath/auto-$id.cgi");
my $line = <DB>;
close DB;
chomp $line;
($in{'autoenable'},$in{'autoto'},$in{'autofromname'},$in{'autofromemail'},$in{'autofromsubject'},$in{'autotemplate'},$in{'autohtml'}) = split("\t",$line);
$in{'autotemplate'} = &reverseHTML($in{'autotemplate'});
if($in{'autoenable'} eq 'checked'){
	&DoAuto($id,$in{'autofromsubject'},$in{'autoto'},$in{'autofromname'},$in{'autofromemail'},$in{'autotemplate'},$in{'autohtml'});
	}
### END AUTO RESPONSE ###

#PRINT FINAL OUTPUT

print $output;
exit;
}


sub DoAuto{
my($id,$autofromsubject,$autoto,$autofromname,$autofromemail,$autotemplate,$autohtml) = @_;
my $contenttype;
my $formdate = &ctime(time);
my $REMOTE_ADDR = $ENV{'REMOTE_ADDR'};
my $HTTP_USER_AGENT = $ENV{'HTTP_USER_AGENT'};
my $HTTP_REFERER = $ENV{'HTTP_REFERER'};

($autohtml eq 'checked')?($contenttype = 'text/html'):($contenttype = 'text/plain');
$autotemplate =~ s/\{Date\}/$formdate/g;
$autotemplate =~ s/\{REMOTE_ADDR\}/$REMOTE_ADDR/g;
$autotemplate =~ s/\{HTTP_USER_AGENT\}/$HTTP_USER_AGENT/g;
$autotemplate =~ s/\{HTTP_REFERER\}/HTTP_REFERER/g;
$autotemplate = &GetTemplate($autotemplate);

#see if we have any attachments
my @attach;
open(DB,"<$datapath/attach-$id.cgi");
while(<DB>){
	chomp;
	push(@attach,$_);
	}
close DB;

my $to = $in{$autoto};

if(!$to){
	#guess the 'to' email.
	foreach my $i (keys %in){
		if(($i =~ /\bemail_address\b/i)||($i =~ /\bemail\b/i)){
		$to = $in{$i};
		last;
		}
	}
}

##still no 'to' lets bail.
(!$to)&&(return);

if(!@attach){
#no attachment
	if($mailserver){
		require "$basepath/sendmail.cgi";
		my $subject = "$autofromsubject\nReply-To: $autofromemail\nErrors-To: $autofromemail\nMIME-Version: 1.0\nContent-Type: $contenttype; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit";
		&SendMail("$to",$autofromemail,$subject,$autotemplate,$mailserver,'','');
	}
	else{
		open(MAIL,"|$sendmail -t");
		print MAIL "To: $to\n";
		print MAIL "From: \"$autofromname\" <$autofromemail>\n";
		print MAIL "Reply-To: $autofromemail\n";
		print MAIL "Errors-To: $autofromemail\n";
		print MAIL "Subject: $autofromsubject\n";
		print MAIL "MIME-Version: 1.0\n";
		print MAIL "Content-Type: $contenttype; charset=\"iso-8859-1\"\n";
		print MAIL "Content-Transfer-Encoding: 8bit\n\n";
		print MAIL $autotemplate;
		close MAIL;
		}
}
else{
#attachments !
	if($mailserver){
		my $content = '';
		$content .= "This is a multi-part message in MIME format.\n";
		$content .= "------=_NextPart_000_00AF_01C08EBD.B69D5020\n";
		$content .= "Content-Type: $contenttype; charset=\"iso-8859-1\"\n";
		$content .= "Content-Transfer-Encoding: 8bit\n\n";
		$content .= $autotemplate;
		
		#add attachments
		foreach my $i (@attach){
			my($id,$fn) = split("\t",$i);
			(! -f "$attachments/$fn")&&(next);
			my $fa = &BFile("$attachments/$fn");
			$content .= "\n------=_NextPart_000_00AF_01C08EBD.B69D5020\n";
			$content .= "Content-Type: application/octet-stream;\n";
			$content .= "        name=\"$fn\"\n";
			$content .= "Content-Transfer-Encoding: base64\n";
			$content .= "Content-Disposition: attachment;\n";
 			$content .= "       filename=\"$fn\"\n";
			$content .= "\n";
			$content .= "$fa";
			}

		$content .= "------=_NextPart_000_00AF_01C08EBD.B69D5020--\n\n";
		
		my $subject = "$autofromsubject\nReply-To: $autofromemail\nErrors-To: $autofromemail\nMIME-Version: 1.0\nContent-Type: multipart/mixed; boundary=\"----=_NextPart_000_00AF_01C08EBD.B69D5020\"\nX-Priority: 3 (Normal)\nX-MSMail-Priority: Normal\nX-Mailer: csFormBuilder\nImportance: Normal";
		&SendMail("$to",$autofromemail,$subject,$content,$mailserver,'','');		
	}
	else{
		open(MAIL,"|$sendmail -t");
		print MAIL "To: $to\n";
		print MAIL "From: \"$autofromname\" <$autofromemail>\n";
		print MAIL "Reply-To: $autofromemail\n";
		print MAIL "Errors-To: $autofromemail\n";
		print MAIL "Subject: $autofromsubject\n";
		print MAIL "MIME-Version: 1.0\n";
		print MAIL "Content-Type: multipart/mixed; boundary=\"----=_NextPart_000_00AF_01C08EBD.B69D5020\"\n";
		print MAIL "X-Priority: 3 (Normal)\n";
		print MAIL "X-MSMail-Priority: Normal\n";
		print MAIL "X-Mailer: csFormBuilder\n";
		print MAIL "Importance: Normal\n\n";
		print MAIL "This is a multi-part message in MIME format.\n";
		print MAIL "------=_NextPart_000_00AF_01C08EBD.B69D5020\n";
		print MAIL "Content-Type: $contenttype; charset=\"iso-8859-1\"\n";
		print MAIL "Content-Transfer-Encoding: 8bit\n\n";
		print MAIL $autotemplate;
		
		#add attachments
		foreach my $i (@attach){
			my($id,$fn) = split("\t",$i);
			(! -f "$attachments/$fn")&&(next);
			my $fa = &BFile("$attachments/$fn");
			print MAIL "\n------=_NextPart_000_00AF_01C08EBD.B69D5020\n";
			print MAIL "Content-Type: application/octet-stream;\n";
			print MAIL "        name=\"$fn\"\n";
			print MAIL "Content-Transfer-Encoding: base64\n";
			print MAIL "Content-Disposition: attachment;\n";
 			print MAIL "       filename=\"$fn\"\n";
			print MAIL "\n";
			print MAIL "$fa";
			}

		print MAIL "------=_NextPart_000_00AF_01C08EBD.B69D5020--\n\n";
		close MAIL;
	}
}

}


sub SendEmail{
my($id,$subject,$to,$from,$cc,$bcc,$contenttype,$eroutput) = @_;
&DoLog($id);

if($in{'formdelivery'} != 0){
	return;
	}

if(!$fhu){

	if($mailserver){
		require "$basepath/sendmail.cgi";
		$subject = "$subject\nReply-To: $from\nErrors-To: $from\nMIME-Version: 1.0\nContent-Type: $contenttype; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit";
		&SendMail("$to",$from,$subject,$eroutput,$mailserver,$cc,$bcc);
		}
	else{
		open(MAIL,"|$sendmail -t");
		print MAIL "To: $to\n";
		if($cc){
			print MAIL "CC: $cc\n";
			}
		if($bcc){
			print MAIL "BCC: $bcc\n";
			}	
		print MAIL "From: $from\n";
		print MAIL "Reply-To: $from\n";
		print MAIL "Errors-To: $from\n";
		print MAIL "Subject: $subject\n";
		print MAIL "MIME-Version: 1.0\n";
		print MAIL "Content-Type: $contenttype; charset=\"iso-8859-1\"\n";
		print MAIL "Content-Transfer-Encoding: 8bit\n\n";
		print MAIL $eroutput;
		close MAIL;
		}
}
else{
#attachments !
	if($mailserver){
		require "$basepath/sendmail.cgi";
		$subject = "$subject\nReply-To: $from\nErrors-To: $from\nMIME-Version: 1.0\nContent-Type: multipart/mixed; boundary=\"----=_NextPart_000_00AF_01C08EBD.B69D5020\"\nX-Priority: 3 (Normal)\nX-MSMail-Priority: Normal\nX-Mailer: csFormBuilder\nImportance: Normal";
		my $content = "This is a multi-part message in MIME format.\n------=_NextPart_000_00AF_01C08EBD.B69D5020\nContent-Type: $contenttype; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\n\n${eroutput}${finaluploaddata}------=_NextPart_000_00AF_01C08EBD.B69D5020--\n\n";
		&SendMail("$to",$from,$subject,$content,$mailserver,$cc,$bcc);
		}
	else{
		open(MAIL,"|$sendmail -t");
		print MAIL "To: $to\n";
		if($cc){
			print MAIL "CC: $cc\n";
			}
		if($bcc){
			print MAIL "BCC: $bcc\n";
			}	
		print MAIL "From: $from\n";
		print MAIL "Reply-To: $from\n";
		print MAIL "Errors-To: $from\n";
		print MAIL "Subject: $subject\n";
		print MAIL "MIME-Version: 1.0\n";
		print MAIL "Content-Type: multipart/mixed; boundary=\"----=_NextPart_000_00AF_01C08EBD.B69D5020\"\n";
		print MAIL "X-Priority: 3 (Normal)\n";
		print MAIL "X-MSMail-Priority: Normal\n";
		print MAIL "X-Mailer: csFormBuilder\n";
		print MAIL "Importance: Normal\n\n";
		print MAIL "This is a multi-part message in MIME format.\n";
		print MAIL "------=_NextPart_000_00AF_01C08EBD.B69D5020\n";
		print MAIL "Content-Type: $contenttype; charset=\"iso-8859-1\"\n";
		print MAIL "Content-Transfer-Encoding: 8bit\n\n";
		print MAIL $eroutput;
		print MAIL $finaluploaddata;
		print MAIL "------=_NextPart_000_00AF_01C08EBD.B69D5020--\n\n";
		close MAIL;
		}

}

}

sub DoLog{
my($id) = @_;
#first check IP restrictions.
my @ips = split(/\r*\n/,$in{'formrestrictip'});
foreach my $i (@ips){
	($ENV{'REMOTE_ADDR'} =~ /$i/)&&(&PError("Your IP has been restricted from using this form."));
	exit;
	}

#check to see how many times this IP has submitted this day/this hour
if($in{'formsublimit'} > 0){
my($hourcount,$daycount);
open(LOG,"<$datapath/$id-log.cgi");
while(<LOG>){
	$_ =~ s/^"//;
	$_ =~ s/"$//;	
	my($dt,$ip,@r) = split("\",\"",$_);
	if(($in{'limitip'} == 0)&&($ip eq $ENV{'REMOTE_ADDR'})){
		((time - $dt) < 3600)&&($hourcount++);
		((time - $dt) < 86400)&&($daycount++);
		}
	if($in{'limitip'} == 1){
		((time - $dt) < 3600)&&($hourcount++);
		((time - $dt) < 86400)&&($daycount++);
		}	
	}
close LOG;

if(($in{'formlimithd'} eq 'Day')&&($daycount >= $in{'formsublimit'})){
	&PError("Maximum submissions exceeded.");
	exit;
	}
if(($in{'formlimithd'} eq 'Hour')&&($hourcount >= $in{'formsublimit'})){
	&PError("Maximum submissions exceeded.");
	exit;
	}
}


my(@export,@header,$doheader);
$doheader=0;
if(! -f "$datapath/$id-log.cgi"){
	$doheader=1;
	}

if($in{'form'} > 0){
foreach my $i (@fldorder){
	next if ($i eq 'form');
	$in{$i} =~ s/\r*\n/\\n/g;
	push(@export,$in{$i});
	push(@header,$i);
	}
}
else{

my @fields;

#see if we came from multi-page form
if($in{'form-camefrom'}){
	my @x = split(",",$in{'form-camefrom'});
	foreach my $i (@x){
	push(@fields,GetFields($i));
	}
}
push(@fields,GetFields($id));

foreach my $i (@fields){
	my(@f) = split("\t",$i);
	$in{$f[3]} =~ s/\r*\n/\\n/g;
	push(@export,$in{$f[3]});
	$f[2] =~ s/\s+$//g;
	$f[2] =~ s/[^A-Za-z0-9]$//g;	
	push(@header,$f[2]);
	}
	
}

open(LOG,">>$datapath/$id-log.cgi");
($flock)&&(flock(LOG,2));
if($doheader){
	print LOG "\"Date\",\"IP\",\"".join("\",\"",@header)."\"\r\n";
	}
	print LOG "\"".time."\",\"".$ENV{'REMOTE_ADDR'}."\",\"".join("\",\"",@export)."\"\r\n";
($flock)&&(flock(LOG,8));
close LOG;
}

sub RemoveAttach{
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));

my(@l);

my $fid = $in{'fid'};
my $filename='';
($fid =~ /[^\d]/)&&(&PError("Error. Invalid FID"));

open(DB,"+<$datapath/attach-$id.cgi");
($flock)&&(flock(DB,2));
while(<DB>){
	chomp;
	my(@r) = split("\t",$_);
	if($r[0] != $fid){
		push(@l,$_);
		}
	else{
		$filename = $r[1];
		}
	}
seek(DB,0,0);

foreach my $i (@l){
	print DB "$i\n";
	}
truncate(DB, tell(DB));

($flock)&&(flock(DB,8));
close DB;

#remove the file
if($filename){
	unlink("$attachments/$filename");
	}

print qq|
<script language=javascript>
alert("Attachment Removed");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=showautoconfig&id=$id&rnd="+rndURL;
</script>
|;
exit;
}

sub AddAttach{
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));

my $filename = GetRealName($in{'file'});

($filename =~ /[^A-Za-z0-9\-\_\.]/)&&(PError("Invalid filename. Only alpha-numeric characters are allowed and no spaces."));

if(-f "$attachments/$filename"){
	&PError("Error. File already exists.");
	}
($filename =~ /\.{2,}/)&&(PError("Invalid filename"));

my $fid = &GetID();

&SaveFile('file',"$attachments/$filename");

open(DB,">>$datapath/attach-$id.cgi");
print DB "$fid\t$filename\n";
close DB;


print qq|
<script language=javascript>
alert("Attachment Saved");
var rndURL = (1000*Math.random());
window.opener.location="$in{'cgiurl'}?command=showautoconfig&id=$id&rnd="+rndURL;
window.close();
</script>
|;
exit;
}

sub ShowAddAttach{
	&PageOut("$basepath/t_upload.htm");
	exit;
	}


sub RebuildForm{
	my($id) = @_;
	require("$basepath/rebuildform.cgi");
	DoRebuild($id);
	}



sub PreviewForm{
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));
my $formname;

$formname = &GetFormName($id); 

if(! -f "$formpath/$formname.htm"){
print "<font face=tahoma size=2><b>No preview available</b></font>";
}
else{
print qq|
<script language=javascript>
var rndURL = (1000*Math.random());
window.location = "$formurl/$formname.htm?"+rndURL;
</script>
|;
}

exit;
}

sub MoveFieldDown{

my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid ID"));
my $fid = $in{'fid'};
($fid =~ /[^\d]/)&&(&PError("Invalid FID"));

my @l;
my $cidx=0;
my $cpos=0;

open(DB,"+<$datapath/fields-$id.cgi");
($flock)&&(flock(DB,2));
while(<DB>){
chomp;
	my(@r) = split("\t",$_);
	push(@l,$_);
	
	if($r[0] == $fid){
		$cpos=$cidx;
		}
	$cidx++;
	}
	
my $newpos = $cpos+1;
if($newpos < $#l+1){
	#flip around
	my $tmp = $l[$newpos];
	$l[$newpos] = $l[$cpos];
	$l[$cpos] = $tmp;
	}

seek(DB,0,0);

foreach my $i (@l){
	print DB "$i\n";
	}
truncate(DB, tell(DB));

($flock)&&(flock(DB,8));
close DB;

&RebuildForm($id);

print qq|
<script language=javascript>
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=showfieldconfig&id=$id&rnd="+rndURL;
</script>
|;
exit;
}

sub MoveFieldUp{

my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid ID"));
my $fid = $in{'fid'};
($fid =~ /[^\d]/)&&(&PError("Invalid FID"));

my @l;
my $cidx=0;
my $cpos=0;

open(DB,"+<$datapath/fields-$id.cgi");
($flock)&&(flock(DB,2));
while(<DB>){
chomp;
	my(@r) = split("\t",$_);
	push(@l,$_);
	
	if($r[0] == $fid){
		$cpos=$cidx;
		}
	$cidx++;
	}
	
my $newpos = $cpos-1;
if($newpos > -1){
	#flip around
	my $tmp = $l[$newpos];
	$l[$newpos] = $l[$cpos];
	$l[$cpos] = $tmp;
	}

seek(DB,0,0);

foreach my $i (@l){
	print DB "$i\n";
	}
truncate(DB, tell(DB));

($flock)&&(flock(DB,8));
close DB;

&RebuildForm($id);

print qq|
<script language=javascript>
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=showfieldconfig&id=$id&rnd="+rndURL;
</script>
|;
exit;
}

sub SaveFieldChanges{

my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid ID"));
my $fid = $in{'fid'};
($fid =~ /[^\d]/)&&(&PError("Invalid FID"));

(!$in{'fieldname'})&&($in{'addfield'} ne 'BlankLine')&&(PError("Field name required."));
($in{'fieldname'} =~ /[^A-Za-z0-9\-\_]/)&&(PError("Field name can only contain alpha-numeric characters and no spaces."));
$in{'fieldlabel'} = &htmlspecialchars($in{'fieldlabel'});
$in{'fieldtip'} = &htmlspecialchars($in{'fieldtip'});
($in{'fieldwidth'})&&($in{'fieldwidth'} =~ /[^\d]/)&&(PError("Invalid field width"));
$in{'fieldanswers'} = &htmlspecialchars($in{'fieldanswers'});

my $newline='';

require("$basepath/savefieldchanges.cgi");
$newline = &GetFieldVars($fid);

my @l;
open(DB,"+<$datapath/fields-$id.cgi");
($flock)&&(flock(DB,2));
while(<DB>){
chomp;
	my(@r) = split("\t",$_);
	if($r[0] != $fid){
		push(@l,$_);
		}
	else{
		push(@l,$newline);
		}
	}
seek(DB,0,0);

foreach my $i (@l){
	print DB "$i\n";
	}
truncate(DB, tell(DB));

($flock)&&(flock(DB,8));
close DB;

&RebuildForm($id);

print qq|
<script language=javascript>
alert("Field Saved");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=showfieldconfig&id=$id&rnd="+rndURL;
</script>
|;
exit;


}

sub ShowFieldEdit{
my $id = $in{'id'};
my $fid = $in{'fid'};
my @f;

($id =~ /[^\d]/)&&(&PError("Invalid form ID"));
($fid =~ /[^\d]/)&&(&PError("Invalid form FID"));

my $found=0;
my $newfield='';
open(DB,"<$cgipath/data/fields-$id.cgi");
while(<DB>){
	chomp;
	(@f) = split("\t",$_);
	if($f[0] == $fid){
		$found=1;
		last;
		}
	}
close DB;

(!$found)&&(&PError("Field ID not found"));

require("$basepath/showfieldedit.cgi");
&GetEditForm(@f);

exit;
}

sub SaveField{

my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid ID"));
(!$in{'fieldname'})&&($in{'addfield'} ne 'BlankLine')&&(PError("Field name required."));
($in{'fieldname'} =~ /[^A-Za-z0-9\-\_]/)&&(PError("Field name can only contain alpha-numeric characters and no spaces."));
$in{'fieldlabel'} = &htmlspecialchars($in{'fieldlabel'});
$in{'fieldtip'} = &htmlspecialchars($in{'fieldtip'});
$in{'fieldanswers'} = &htmlspecialchars($in{'fieldanswers'});
($in{'fieldwidth'})&&($in{'fieldwidth'} =~ /[^\d]/)&&(PError("Invalid field width"));

my $fid = &GetID();
my $newline='';

require("$basepath/savefieldchanges.cgi");
$newline = &GetFieldVars($fid);

open(DB,">>$datapath/fields-$id.cgi");
print DB "$newline\n";
close DB;

&RebuildForm($id);

print qq|
<script language=javascript>
alert("Field Saved");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=showfieldconfig&id=$id&rnd="+rndURL;
</script>
|;
exit;
}

sub ShowAddField{
	require("$basepath/showaddfield.cgi");	
	exit;
	}

sub ShowFieldConfig{
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));

&ShowStyleConfig;

$in{'formname'} = &GetFormName($id); 
my $cf=1;
my $bgcolor='#EFEFEF';
open(DB,"<$datapath/fields-$id.cgi");
while(<DB>){
chomp;
($cf==1)?($bgcolor='#EFEFEF'):($bgcolor='#FFFFFF');
$cf = $cf * -1;
my(@f) = split("\t",$_);
my $mline='';
$f[2] = &reverseHTML($f[2]);
$mline="[ <a href=\"javascript:ShowEdit('$f[0]')\">Modify</a> ]";
if($f[1] eq 'BlankLine'){
	$f[2] = '&nbsp;';
	}

$in{'fline'} .= qq|<tr><td bgcolor="$bgcolor">$f[2]</td><td bgcolor="$bgcolor">$f[1]</td><td bgcolor="$bgcolor" align="center" valign="middle" nowrap> $mline [ <a href="javascript:Delete('$f[0]');">Delete</a> 
                      ]&nbsp;[ <a href="javascript:Copy('$f[0]');">Copy</a> ]
                      [<a href="javascript:MoveUp('$f[0]');"> Move Up</a> ] [ <a href="javascript:MoveDown('$f[0]');">Move Down</a> ] </td>\n|;
}
close DB;

(!$in{'fline'})&&($in{'fline'} = '<tr><td colspan=3>No fields configured</td></tr>');
(!$in{'formpreview'})&&($in{'formpreview'} = 'No preview available');
&PageOut("$basepath/t_field_config.htm");
}

sub ShowLinks{

($in{'formid'})&&($in{'formid'} =~ /[^\d]/)&&(&PError("Invalid form ID"));

my (%fsort,$sel);
open(DB,"<$cgipath/data/forms.cgi");
while(<DB>){
	chomp;
	my($id,$formname,$formdesc,$formsubject,$formsubjectadv,$formto,$formtoadv,$formcc,$formbcc,$formfrom,$formsublimit,$formlimithd,$formrestrictip,$formdelivery) = split("\t",$_);
	my $key = $formname.'-'.$id;
	$key =~ tr/a-z/A-Z/;
	($id==$in{'formid'})?($sel='selected'):($sel='');
	$fsort{$key} = qq|<option value="$id" $sel>$formname</option>|;
	}
close DB;

$in{'formidoptions'} = "<option value=\"\">==Select==</option>";
foreach my $i (sort keys %fsort){
	$in{'formidoptions'} .= $fsort{$i};
	}

if($in{'formid'}){
	my $formname = GetFormName($in{'formid'});
	$in{'directlink'} = qq|$formurl/$formname.htm|;
	my $sslurl = $formurl;
	$sslurl =~ s/^http:\/\/[^\/]+//;
	$in{'serversideinclude'} = qq|<!--#include virtual="$sslurl/$formname.htm" -->|;
	$in{'javascript'} = qq|<script language=javascript src="$in{'cgiurl'}?command=vf&id=$in{'formid'}"></script>|;
	$in{'PHP'} = qq|<? \@include("$formurl/$formname.htm"); ?>|;
	}
&PageOut("$basepath/t_links_wizard.htm");
}

sub SaveAutoConfig{
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));

$in{'autoenable'} = &htmlspecialchars($in{'autoenable'});
($in{'autotoother'})&&($in{'autoto'}=$in{'autotoother'});
$in{'autoto'} = &htmlspecialchars($in{'autoto'});
$in{'autofromname'} = &htmlspecialchars($in{'autofromname'});
$in{'autofromemail'} = &htmlspecialchars($in{'autofromemail'});
$in{'autofromsubject'} = &htmlspecialchars($in{'autofromsubject'});
$in{'autotemplate'} = &htmlspecialchars($in{'autotemplate'});
$in{'autohtml'} = &htmlspecialchars($in{'autohtml'});

my $newentry = "$in{'autoenable'}\t$in{'autoto'}\t$in{'autofromname'}\t$in{'autofromemail'}\t$in{'autofromsubject'}\t$in{'autotemplate'}\t$in{'autohtml'}\t";

open(DB,">$datapath/auto-$id.cgi");
print DB $newentry;
close DB;

print qq|
<script language=javascript>
alert("Autoresponder Saved");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=manage&rnd="+rndURL;
</script>
|;
exit;

}

sub ShowAutoConfig{
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));


open(DB,"<$datapath/auto-$id.cgi");
my $line = <DB>;
close DB;
chomp $line;

($in{'autoenable'},$in{'autoto'},$in{'autofromname'},$in{'autofromemail'},$in{'autofromsubject'},$in{'autotemplate'},$in{'autohtml'}) = split("\t",$line);
$in{'autotemplate'} = &reverseHTML($in{'autotemplate'});

$in{'tosel'} = "<option value=\"\">== select ==</option>\n";
open(DB,"<$datapath/fields-$id.cgi");
my $sel='';
my $haves=0;
while(<DB>){
	chomp;
	my(@f) = split("\t",$_);
	next if($f[1] eq 'TextHTML');
	next if($f[1] eq 'BlankLine');
	next if($f[1] eq 'HorizontalLine');
	next if($f[1] eq 'ImageVerify');
	((!$in{'autoto'})&&(($f[3] =~ /email/i)||($f[1] eq 'EmailAddress')))?($sel='selected'):($sel='');
	($in{'autoto'} eq $f[3])&&($haves=1);
	(($in{'autoto'})&&($in{'autoto'} eq $f[3]))?($sel='selected'):($sel='');
	$in{'tosel'} .= qq|<option $sel>$f[3]</option>\n|;
	}
close DB;
if(!$haves){
	$in{'autotoother'} = $in{'autoto'};
	}

(!$in{'autotemplate'})&&($in{'autotemplate'} = "Thank you for your submission. We will get back to you shortly");
(!$in{'autofromsubject'})&&($in{'autofromsubject'} = "== Your Submission ==");
$in{'command'} = 'saveautoconfig';

#get attachments
if(-f "$datapath/attach-$id.cgi"){
	open(DB,"<$datapath/attach-$id.cgi");
	while(<DB>){
	chomp;
	my($fid,$filename) = split("\t",$_);
	$in{'attachline'} .= "<li>$filename - [<a href=\"javascript:RemoveAttach('$fid');\">remove</a>]</li>\n";
	}
	close DB;
}
(!$in{'attachline'})&&($in{'attachline'}='no attachments configured');


&PageOut("$basepath/t_auto_config.htm");
}


sub SaveStyle{

my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));

$in{'labelfont'} = &htmlspecialchars($in{'labelfont'});
$in{'fieldfont'} = &htmlspecialchars($in{'fieldfont'});

$in{'labelsize'} = &htmlspecialchars($in{'labelsize'});
$in{'fieldsize'} = &htmlspecialchars($in{'fieldsize'});

$in{'labelforecolor'} = &htmlspecialchars($in{'labelforecolor'});
$in{'fieldforecolor'} = &htmlspecialchars($in{'fieldforecolor'});

$in{'labelbackcolor'} = &htmlspecialchars($in{'labelbackcolor'});
$in{'fieldbackcolor'} = &htmlspecialchars($in{'fieldbackcolor'});
$in{'fieldfocusbackcolor'} = &htmlspecialchars($in{'fieldfocusbackcolor'});

$in{'labelbold'} = &htmlspecialchars($in{'labelbold'});
$in{'labelitalic'} = &htmlspecialchars($in{'labelitalic'});
$in{'labelunderline'} = &htmlspecialchars($in{'labelunderline'});

$in{'fieldbold'} = &htmlspecialchars($in{'fieldbold'});
$in{'fielditalic'} = &htmlspecialchars($in{'fielditalic'});
$in{'fieldunderline'} = &htmlspecialchars($in{'fieldunderline'});

$in{'formtemplate'} = &htmlspecialchars($in{'formtemplate'});

$in{'buttontext'} = &htmlspecialchars($in{'buttontext'});
$in{'backbuttontext'} = &htmlspecialchars($in{'backbuttontext'});
$in{'resetbuttontext'} = &htmlspecialchars($in{'resetbuttontext'});

$in{'buttonfont'} = &htmlspecialchars($in{'buttonfont'});
$in{'buttonsize'} = &htmlspecialchars($in{'buttonsize'});
$in{'buttonforecolor'} = &htmlspecialchars($in{'buttonforecolor'});
$in{'buttonbackcolor'} = &htmlspecialchars($in{'buttonbackcolor'});
$in{'buttonfocuscolor'} = &htmlspecialchars($in{'buttonfocuscolor'});
$in{'buttonbold'} = &htmlspecialchars($in{'buttonbold'});
$in{'buttonitalic'} = &htmlspecialchars($in{'buttonitalic'});
$in{'buttonunderline'} = &htmlspecialchars($in{'buttonunderline'});
$in{'mandatorysymbol'} = &htmlspecialchars($in{'mandatorysymbol'});

open(DB,">$datapath/style-$id.cgi");
print DB "$in{'labelfont'}\t$in{'fieldfont'}\t$in{'labelsize'}\t$in{'fieldsize'}\t$in{'labelforecolor'}\t$in{'fieldforecolor'}\t$in{'labelbackcolor'}\t$in{'fieldbackcolor'}\t$in{'fieldfocusbackcolor'}\t$in{'labelbold'}\t$in{'labelitalic'}\t$in{'labelunderline'}\t$in{'fieldbold'}\t$in{'fielditalic'}\t$in{'fieldunderline'}\t$in{'formtemplate'}\t$in{'buttontext'}\t$in{'backbuttontext'}\t$in{'buttonfont'}\t$in{'buttonsize'}\t$in{'buttonforecolor'}\t$in{'buttonbackcolor'}\t$in{'buttonfocuscolor'}\t$in{'buttonbold'}\t$in{'buttonitalic'}\t$in{'buttonunderline'}\t$in{'mandatorysymbol'}\t$in{'buttonalign'}\t$in{'resetbuttontext'}\n";
close DB;

#create the style sheet

my $formname = &GetFormName($id); 
my $textfieldstyles='';
my $textlabelstyles='';
my $textfieldfocusstyles='';
my $buttonstyle='';
my $buttonfocus='';

($in{'labelfont'})&&($textlabelstyles .= qq|font-family:$in{'labelfont'};|);
($in{'labelsize'})&&($textlabelstyles .= qq|font-size :$in{'labelsize'};|);
($in{'labelforecolor'})&&($textlabelstyles .= qq|color :$in{'labelforecolor'};|);
($in{'labelbackcolor'})&&($textlabelstyles .= qq|background-color :$in{'labelbackcolor'};|);
($in{'labelbold'})&&($textlabelstyles .= qq|font-weight :bold;|);
($in{'labelitalic'})&&($textlabelstyles .= qq| font-style: italic;|);
($in{'labelunderline'})&&($textlabelstyles .= qq|text-decoration: underline;|);

($in{'fieldfont'})&&($textfieldstyles .= qq|font-family:$in{'fieldfont'};|);
($in{'fieldsize'})&&($textfieldstyles .= qq|font-size :$in{'fieldsize'};|);
($in{'fieldforecolor'})&&($textfieldstyles .= qq|color :$in{'fieldforecolor'};|);
($in{'fieldbackcolor'})&&($textfieldstyles .= qq|background-color :$in{'fieldbackcolor'};|);
($in{'fieldbold'})&&($textfieldstyles .= qq|font-weight :bold;|);
($in{'fielditalic'})&&($textfieldstyles .= qq| font-style: italic;|);
($in{'fieldunderline'})&&($textfieldstyles .= qq|text-decoration: underline;|);

($in{'fieldfont'})&&($textfieldfocusstyles .= qq|font-family:$in{'fieldfont'};|);
($in{'fieldsize'})&&($textfieldfocusstyles .= qq|font-size :$in{'fieldsize'};|);
($in{'fieldforecolor'})&&($textfieldfocusstyles .= qq|color :$in{'fieldforecolor'};|);
($in{'fieldfocusbackcolor'})&&($textfieldfocusstyles .= qq|background-color :$in{'fieldfocusbackcolor'};|);
($in{'fieldbold'})&&($textfieldfocusstyles .= qq|font-weight :bold;|);
($in{'fielditalic'})&&($textfieldfocusstyles .= qq| font-style: italic;|);
($in{'fieldunderline'})&&($textfieldfocusstyles .= qq|text-decoration: underline;|);


($in{'buttonfont'})&&($buttonstyle .= qq|font-family:$in{'buttonfont'};|);
($in{'buttonsize'})&&($buttonstyle .= qq|font-size :$in{'buttonsize'};|);
($in{'buttonforecolor'})&&($buttonstyle .= qq|color :$in{'buttonforecolor'};|);
($in{'buttonbackcolor'})&&($buttonstyle .= qq|background-color :$in{'buttonbackcolor'};|);
($in{'buttonbold'})&&($buttonstyle .= qq|font-weight :bold;|);
($in{'buttonitalic'})&&($buttonstyle .= qq| font-style: italic;|);
($in{'buttonunderline'})&&($buttonstyle .= qq|text-decoration: underline;|);

($in{'buttonfont'})&&($buttonfocus .= qq|font-family:$in{'buttonfont'};|);
($in{'buttonsize'})&&($buttonfocus .= qq|font-size :$in{'buttonsize'};|);
($in{'buttonforecolor'})&&($buttonfocus .= qq|color :$in{'buttonforecolor'};|);
($in{'buttonbackcolor'})&&($buttonfocus .= qq|background-color :$in{'buttonfocuscolor'};|);
($in{'buttonbold'})&&($buttonfocus .= qq|font-weight :bold;|);
($in{'buttonitalic'})&&($buttonfocus .= qq| font-style: italic;|);
($in{'buttonunderline'})&&($buttonfocus .= qq|text-decoration: underline;|);


my $stylesheet = qq|
INPUT.textField, SELECT.textField{
$textfieldstyles
}
INPUT.textFieldFocus, SELECT.textFieldFocus{
$textfieldfocusstyles
}
.textLabel{
$textlabelstyles
}

INPUT.buttonfield{
$buttonstyle
}

INPUT.buttonfieldFocus{
$buttonfocus
}
|;

open(DB,">$formpath/$formname.css");
print DB $stylesheet;
close DB;

&RebuildForm($id);

print qq|
<script language=javascript>
alert("Style Saved");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=showfieldconfig&id=$id&rnd="+rndURL;
</script>
|;
exit;
}

sub ShowStyleConfig{
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));
my $found=0;

if(-f "$cgipath/data/style-$id.cgi"){
	open(DB,"<$cgipath/data/style-$id.cgi");
	my $s = <DB>;
	chomp $s;
	($in{'labelfont'},$in{'fieldfont'},$in{'labelsize'},$in{'fieldsize'},$in{'labelforecolor'},$in{'fieldforecolor'},$in{'labelbackcolor'},$in{'fieldbackcolor'},$in{'fieldfocusbackcolor'},$in{'labelbold'},$in{'labelitalic'},$in{'labelunderline'},$in{'fieldbold'},$in{'fielditalic'},$in{'fieldunderline'},$in{'formtemplate'},$in{'buttontext'},$in{'backbuttontext'},$in{'buttonfont'},$in{'buttonsize'},$in{'buttonforecolor'},$in{'buttonbackcolor'},$in{'buttonfocuscolor'},$in{'buttonbold'},$in{'buttonitalic'},$in{'buttonunderline'},$in{'mandatorysymbol'},$in{'buttonalign'},$in{'resetbuttontext'}) = split("\t",$s);
	close DB;
	
	$in{'formtemplate'} = &reverseHTML($in{'formtemplate'});
	}
else{
	(!$in{'labelfont'})&&($in{'labelfont'} = 'Verdana');
	(!$in{'fieldfont'})&&($in{'fieldfont'} = 'Verdana');
	
	(!$in{'labelsize'})&&($in{'labelsize'} = '10px');
	(!$in{'fieldsize'})&&($in{'fieldsize'} = '10px');
	
	(!$in{'labelforecolor'})&&($in{'labelforecolor'} = '#000000');
	(!$in{'fieldforecolor'})&&($in{'fieldforecolor'} = '#000000');
	
	(!$in{'labelbackcolor'})&&($in{'labelbackcolor'} = '#FFFFFF');
	(!$in{'fieldbackcolor'})&&($in{'fieldbackcolor'} = '#FFFFFF');
	(!$in{'fieldfocusbackcolor'})&&($in{'fieldfocusbackcolor'} = '#FFFFFF');
	
	(!$in{'buttontext'})&&($in{'buttontext'} = 'Submit');
	(!$in{'backbuttontext'})&&($in{'backbuttontext'} = 'Back');
	(!$in{'mandatorysymbol'})&&($in{'mandatorysymbol'} = '*');
	(!$in{'formtemplate'})&&($in{'formtemplate'} = "Fill out the following information and click 'Submit'.<br>\n{FORM}");
	}

(!$in{'buttonalign'})&&($in{'buttonalign'} = 'left');	
$in{'buttonalign'.$in{'buttonalign'}} = 'checked';
$in{'command'} = 'savestyle';
#&PageOut("$basepath/t_styles_config.htm");

}

sub ResetTemplates{
my($drt,$det,$tid);
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));

my %mpfs;
open(DB,"<$cgipath/data/forms.cgi");
while(<DB>){
	chomp;
	($tid,$in{'formname'},$in{'formdesc'},$in{'formsubject'},$in{'formsubjectadv'},$in{'formto'},$in{'formtoadv'},$in{'formcc'},$in{'formbcc'},$in{'formfrom'},$in{'formsublimit'},$in{'formlimithd'},$in{'formrestrictip'},$in{'formdelivery'},$in{'limitip'},$in{'mpf'}) = split("\t",$_);
	$mpfs{$in{'mpf'}} = $tid;
	}
close DB;

my $mid = $id;
my %fline;
my $cnt=0;

do{
open(DB,"<$datapath/fields-$mid.cgi");
while(<DB>){
chomp;
my(@f) = split("\t",$_);

#don't loop
next if($f[1] eq 'TextHTML');
next if($f[1] eq 'BlankLine');
next if($f[1] eq 'HorizontalLine');
next if($f[1] eq 'ImageVerify');
$fline{$cnt} .= "  $f[2] {$f[3]}\n";
}
close DB;

last if ($cnt > 10);
$cnt++;
$mid = $mpfs{$mid};
} until(!$mid);

foreach my $i (sort {$b <=> $a} keys %fline){
	$drt .= $fline{$i};
	$det .= $fline{$i};
	}


my ($newsuccesstemplate,$newemailtemplate);
$newsuccesstemplate = "Thank you for submitting the following information:\n\n$drt";

$newemailtemplate = "  Form Submission\n  The following information was submitted on {Date} from {REMOTE_ADDR}:\n\n$det";


open(DB,"<$datapath/results-$id.cgi");
my $line = <DB>;
close DB;
my($sphide,$erhide);
($in{'spoptions'},$in{'redirectURL'},$in{'multipage'},$in{'successtemplate'},$in{'eroptions'},$in{'emailtemplate'},$in{'successhtml'},$in{'emailhtml'},$sphide,$erhide,$in{'MySQL'},$in{'MySQLHost'},$in{'MySQLDatabase'},$in{'MySQLUser'},$in{'MySQLPass'},$in{'MySQLFM'}) = split("\t",$line);

if($in{'command'} eq 'resetert'){
	$in{'emailtemplate'} = &htmlspecialchars($newemailtemplate);
	}
else{
	$in{'successtemplate'} = &htmlspecialchars($newsuccesstemplate);
	}

my $newentry = "$in{'spoptions'}\t$in{'redirectURL'}\t$in{'multipage'}\t$in{'successtemplate'}\t$in{'eroptions'}\t$in{'emailtemplate'}\t$in{'successhtml'}\t$in{'emailhtml'}\t$sphide\t$erhide\t$in{'MySQL'}\t$in{'MySQLHost'}\t$in{'MySQLDatabase'}\t$in{'MySQLUser'}\t$in{'MySQLPass'}\t$in{'MySQLFM'}\t";

open(DB,">$datapath/results-$id.cgi");
print DB $newentry;
close DB;

print qq|
<script language=javascript>
alert("Template Reset");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=showresultsconfig&id=$id&rnd="+rndURL;
</script>
|;
exit;
}

sub SaveResultsConfig{
my($sphide,$erhide,@sphide,@erhide);

my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));

#get fields to show/hide
open(DB,"<$datapath/fields-$id.cgi");
while(<DB>){
	chomp;
	my(@f) = split("\t",$_);
	next if($f[1] eq 'TextHTML');
	next if($f[1] eq 'BlankLine');
	next if($f[1] eq 'HorizontalLine');
	next if($f[1] eq 'ImageVerify');
	($in{$f[3]} eq 'H')&&(push(@sphide,$f[3]));
	($in{"$f[3]_2"} eq 'H')&&(push(@erhide,$f[3]));
	}
close DB;

$sphide = join("~",@sphide);
$erhide = join("~",@erhide);

$in{'spoptions'} = &htmlspecialchars($in{'spoptions'});
$in{'redirectURL'} = &htmlspecialchars($in{'redirectURL'});
$in{'multipage'} = &htmlspecialchars($in{'multipage'});
$in{'successtemplate'} = &htmlspecialchars($in{'successtemplate'});
$in{'eroptions'} = &htmlspecialchars($in{'eroptions'});
$in{'emailtemplate'} = &htmlspecialchars($in{'emailtemplate'});
$in{'successhtml'} = &htmlspecialchars($in{'successhtml'});
$in{'emailhtml'} = &htmlspecialchars($in{'emailhtml'});
$in{'spsbf'} = &htmlspecialchars($in{'spsbf'});
$in{'ersbf'} = &htmlspecialchars($in{'ersbf'});

$sphide = &htmlspecialchars($sphide);
$erhide = &htmlspecialchars($erhide);
if($in{'spoptions'} ne 'M'){
	$in{'multipage'}='';
	}
	

$in{'MySQLFM'} = &htmlspecialchars($in{'MySQLFM'});

my $newentry = "$in{'spoptions'}\t$in{'redirectURL'}\t$in{'multipage'}\t$in{'successtemplate'}\t$in{'eroptions'}\t$in{'emailtemplate'}\t$in{'successhtml'}\t$in{'emailhtml'}\t$sphide\t$erhide\t$in{'MySQL'}\t$in{'MySQLHost'}\t$in{'MySQLDatabase'}\t$in{'MySQLUser'}\t$in{'MySQLPass'}\t$in{'MySQLFM'}\t$in{'spsbf'}\t$in{'ersbf'}\t";

open(DB,">$datapath/results-$id.cgi");
print DB $newentry;
close DB;

#need to rebuild form in case they changed to multi-page
&RebuildForm($id);

print qq|
<script language=javascript>
alert("Results Saved");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=manage&rnd="+rndURL;
</script>
|;
exit;
}

sub ShowResultsConfig{

my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));


open(DB,"<$datapath/results-$id.cgi");
my $line = <DB>;
close DB;
my($sphide,$erhide);
my (%sh,$selS,$selH,%sh2,$sel2S,$sel2H,$drt,$det);

($in{'spoptions'},$in{'redirectURL'},$in{'multipage'},$in{'successtemplate'},$in{'eroptions'},$in{'emailtemplate'},$in{'successhtml'},$in{'emailhtml'},$sphide,$erhide,$in{'MySQL'},$in{'MySQLHost'},$in{'MySQLDatabase'},$in{'MySQLUser'},$in{'MySQLPass'},$in{'MySQLFM'},$in{'spsbf'},$in{'ersbf'}) = split("\t",$line);

if($in{'spoptions'}){
	$in{'spoptions'.$in{'spoptions'}}='checked';
	}
if($in{'eroptions'}){
	$in{'eroptions'.$in{'eroptions'}}='checked';
	}
$in{'successtemplate'} = &reverseHTML($in{'successtemplate'});
$in{'emailtemplate'} = &reverseHTML($in{'emailtemplate'});
$in{'MySQLFM'}= &reverseHTML($in{'MySQLFM'});

my @fl = split("~",$sphide);
foreach my $i (@fl){
	$sh{$i} = 1;
	}

my @fl2 = split("~",$erhide);
foreach my $i (@fl2){
	$sh2{$i} = 1;
	}
	
$in{'formname'} = &GetFormName($id); 


open(DB,"<$datapath/fields-$id.cgi");
while(<DB>){
chomp;
my(@f) = split("\t",$_);

#don't show static fields
next if($f[1] eq 'TextHTML');
next if($f[1] eq 'BlankLine');
next if($f[1] eq 'HorizontalLine');
next if($f[1] eq 'ImageVerify');

$selS='';$selH='';$sel2S='';$sel2H='';
(!$sh{$f[3]})?($selS='checked'):($selH='checked');
(!$sh2{$f[3]})?($sel2S='checked'):($sel2H='checked');

$drt .= "$f[2] {$f[3]}\n";
$det .= "  $f[2] {$f[3]}\n";

$in{'rline'} .= qq|
                          <tr> 
                            <td align="left" valign="middle">$f[2]</td>
                            <td align="center" valign="middle" nowrap>$f[3]</td>
                            <td align="center" valign="middle" nowrap> 
                              <input type="radio" value="S" name="$f[3]" $selS>
                              Show&nbsp;&nbsp;&nbsp;&nbsp; 
                              <input type="radio" value="H" name="$f[3]" $selH>
                              Hide </td>
                          </tr>
|;

$in{'rline2'} .= qq|
                          <tr> 
                            <td align="left" valign="middle">$f[2]</td>
                            <td align="center" valign="middle" nowrap>$f[3]</td>
                            <td align="center" valign="middle" nowrap> 
                              <input type="radio" value="S" name="$f[3]_2" $sel2S>
                              Show&nbsp;&nbsp;&nbsp;&nbsp; 
                              <input type="radio" value="H" name="$f[3]_2" $sel2H>
                              Hide </td>
                          </tr>
|;

}
close DB;

#get form names
$in{'mpsel'} = qq|<option value="">== Select ==</option>\n|;
open(DB,"<$cgipath/data/forms.cgi");
my $sel='';

while(<DB>){
	chomp;
	my ($fid,$formname,$formdesc,$formsubject,$formsubjectadv,$formto,$formtoadv,$formcc,$formbcc,$formfrom,$formsublimit,$formlimithd,$formrestrictip,$formdelivery) = split("\t",$_);
	($in{'multipage'} eq $fid)?($sel='selected'):($sel='');
	$in{'mpsel'} .= qq|<option value="$fid" $sel>$formname</option>\n|;
	}
close DB;

#get default templates
if(!$in{'successtemplate'}){
	$in{'successtemplate'} = "Thank you for submitting the following information:\n\n$drt";
	}

if(!$in{'emailtemplate'}){
	$in{'emailtemplate'} = "  Form Submission\n  The following information was submitted on {Date} from {REMOTE_ADDR}:\n\n$det";
	}
	
if(!$in{'spoptions'}){
	$in{'spoptionsD'} = 'checked';
	}

if(!$in{'eroptions'}){
	$in{'eroptionsD'} = 'checked';
	}
	
$in{'command'} = 'saveresultsconfig';	
&PageOut("$basepath/t_results_config.htm");
}


sub CopyField{
my $id = $in{'id'};
my $fid = $in{'fid'};

my(@rest);
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));
($fid =~ /[^\d]/)&&(&PError("Invalid form FID"));

my $found=0;
my $newfield='';
open(DB,"<$cgipath/data/fields-$id.cgi");
while(<DB>){
	chomp;
	($in{'id'},@rest) = split("\t",$_);
	if($in{'id'} == $fid){
		$found=1;
		last;
		}
	}
close DB;

(!$found)&&(&PError("Field ID not found"));

my $newid = GetID();

$newfield = "$newid\t".join("\t",@rest);
open(DB,">>$cgipath/data/fields-$id.cgi");
print DB "$newfield\n";
close DB;

&RebuildForm($id);

print qq|
<script language=javascript>
alert("Field Copied");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=showfieldconfig&id=$id&rnd="+rndURL;
</script>
|;
exit;
}

sub CopyForm{
my $id = $in{'id'};
my(@rest);
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));
my $found=0;
my $newform='';
open(DB,"<$cgipath/data/forms.cgi");
while(<DB>){
	chomp;
	($in{'id'},$in{'formname'},@rest) = split("\t",$_);
	if($in{'id'} == $id){
		$found=1;
		last;
		}
	}
close DB;

(!$found)&&(&PError("Form ID not found"));

my $newid = GetID();

$newform = "$newid\t$in{'formname'}-$newid\t".join("\t",@rest);
open(DB,">>$cgipath/data/forms.cgi");
print DB "$newform\n";
close DB;

use File::Copy;
copy("$datapath/attach-$id.cgi","$datapath/attach-$newid.cgi");
copy("$datapath/auto-$id.cgi","$datapath/auto-$newid.cgi");
copy("$datapath/fields-$id.cgi","$datapath/fields-$newid.cgi");
copy("$datapath/results-$id.cgi","$datapath/results-$newid.cgi");
copy("$datapath/style-$id.cgi","$datapath/style-$newid.cgi");
copy("$formpath/$in{'formname'}.htm","$formpath/$in{'formname'}-$newid.htm");
copy("$formpath/$in{'formname'}.css","$formpath/$in{'formname'}-$newid.css");

print qq|
<script language=javascript>
alert("Form Copied");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=manage&rnd="+rndURL;
</script>
|;
exit;
}

sub SaveFormChanges{
my(@l);
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));

#first rename old forms
my $oldform = &GetFormName($id);
if($oldform ne $in{'formname'}){
	rename("$formpath/$oldform.htm","$formpath/$in{'formname'}.htm");
	rename("$formpath/$oldform.css","$formpath/$in{'formname'}.css");
	}

my $outvars = &ValidateFormVars();

open(DB,"+<$datapath/forms.cgi");
($flock)&&(flock(DB,2));
while(<DB>){
chomp;
	my(@r) = split("\t",$_);
	if($r[0] ne $id){
		push(@l,$_);
		}
	else{
		push(@l,"$id\t$outvars");
		}
	}
seek(DB,0,0);
foreach my $i (@l){
	print DB "$i\n";
	}
truncate(DB, tell(DB));
($flock)&&(flock(DB,8));
close DB;

&RebuildForm($id);

print qq|
<script language=javascript>
alert("Changes Saved");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=manage&rnd="+rndURL;
</script>
|;
exit;
}

sub ShowEditForm{
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Invalid form ID"));
my $found=0;
open(DB,"<$cgipath/data/forms.cgi");
while(<DB>){
	chomp;
	($in{'id'},$in{'formname'},$in{'formdesc'},$in{'formsubject'},$in{'formsubjectadv'},$in{'formto'},$in{'formtoadv'},$in{'formcc'},$in{'formbcc'},$in{'formfrom'},$in{'formsublimit'},$in{'formlimithd'},$in{'formrestrictip'},$in{'formdelivery'},$in{'limitip'},$in{'mpf'}) = split("\t",$_);
	if($in{'id'} == $id){
	$found=1;
	last;
	}
	}
close DB;

(!$found)&&(&PError("Form ID not found"));
$in{'formdesc'} =~ s/\\n/\n/g;
$in{'formsubjectadv'} =~ s/\\n/\n/g;
$in{'formto'} =~ s/\\n/\n/g;
$in{'formtoadv'} =~ s/\\n/\n/g;
$in{'formcc'} =~ s/\\n/\n/g;
$in{'formbcc'} =~ s/\\n/\n/g;

$in{'formdelivery'.$in{'formdelivery'}} = 'checked';
$in{'limitip'.$in{'limitip'}} = 'checked';

$in{'formlimithd'.$in{'formlimithd'}} = 'selected';
$in{'command'} = 'saveformchanges';

#get redirects
#get form names
$in{'mpsel'} = qq|<option value="">None</option>\n|;
open(DB,"<$cgipath/data/forms.cgi");
my $sel='';
while(<DB>){
	chomp;
	my ($fid,$formname,$formdesc,$formsubject,$formsubjectadv,$formto,$formtoadv,$formcc,$formbcc,$formfrom,$formsublimit,$formlimithd,$formrestrictip,$formdelivery,$limitip,$mpf) = split("\t",$_);
	(($in{'mpf'} > 0)&&($in{'mpf'} eq $fid))?($sel='selected'):($sel='');
	$in{'mpsel'} .= qq|<option value="$fid" $sel>$formname</option>\n|;
	}
close DB;

&PageOut("$basepath/t_add_form.htm");
}


sub SaveFormTemplate{

if(-f "$formpath/$in{'formname'}.htm"){
	&PError("Form name already exists");
	exit();
	}

if(!$in{'templatename'}){
	&PError("Please select a template");
	exit;
	}
	
($in{'templatename'} =~ /[^A-Za-z0-9_\-]/)&&(&PError("Template name can only contain alpha-numeric characters"));


my $outvars = &ValidateFormVars();
my $id = GetID();

open(DB,">>$datapath/forms.cgi");
print DB "$id\t$outvars\n";
close DB;

#save the form
use File::Copy;

if(-f "$cgipath/templates/$in{'templatename'}.css"){
	copy("$cgipath/templates/$in{'templatename'}.css","$formpath/$in{'formname'}.css");
	}
	
if(-f "$cgipath/templates/$in{'templatename'}-auto.txt"){
	copy("$cgipath/templates/$in{'templatename'}-auto.txt","$datapath/auto-$id.cgi");
	}

if(-f "$cgipath/templates/$in{'templatename'}-results.txt"){
	copy("$cgipath/templates/$in{'templatename'}-results.txt","$datapath/results-$id.cgi");
	}

if(-f "$cgipath/templates/$in{'templatename'}-style.txt"){
	copy("$cgipath/templates/$in{'templatename'}-style.txt","$datapath/style-$id.cgi");
	}
	
if(-f "$cgipath/templates/$in{'templatename'}-fields.txt"){
	copy("$cgipath/templates/$in{'templatename'}-fields.txt","$datapath/fields-$id.cgi");
	}
	
&RebuildForm($id);

print qq|
<script language=javascript>
alert("Form Added");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=manage&rnd="+rndURL;
</script>
|;
exit;
}

sub SaveForm{

if(-f "$formpath/$in{'formname'}.htm"){
	&PError("Form name already exists");
	exit();
	}
	
my $outvars = &ValidateFormVars();
my $id = GetID();

open(DB,">>$datapath/forms.cgi");
print DB "$id\t$outvars\n";
close DB;

#save the default style sheet
my $formname = &htmlspecialchars($in{'formname'});
open(STYLE,">$formpath/$formname.css");
print STYLE qq|
INPUT.textField, BUTTON.textField, SELECT.textField{
font-family:Verdana;font-size :10px;color :#000000;background-color :#FFFFFF;
}
INPUT.textFieldFocus, BUTTON.textFieldFocus, SELECT.textFieldFocus{
font-family:Verdana;font-size :10px;color :#000000;background-color :#FFFFFF;
}
.textLabel{
font-family:Verdana;font-size :10px;color :#000000;background-color :#FFFFFF;
}
|;
close STYLE;

print qq|
<script language=javascript>
alert("Form Added");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=manage&rnd="+rndURL;
</script>
|;
exit;
}

sub ValidateFormVars{

(!$in{'formname'})&&(PError("Please enter a form name"));
($in{'formname'} =~ /[^A-Za-z0-9_\-]/)&&(&PError("Form name can only contain alpha-numeric characters"));


if(!$in{'multipage'}){

if($in{'formdelivery'} != 2){
	(!$in{'formsubject'})&&(PError("Please enter a default subject"));
	($in{'formsubject'} =~ /[^A-Za-z0-9_\- \=\>\<]/)&&(&PError("Invalid characters in default subject"));
	(!$in{'formto'})&&(PError("Please enter a default form 'to' email address"));
	
	my @ems = split(/\r*\n/,$in{'formto'});
	foreach my $i (@ems){
	if(!&ValidEmail($i)){
		&PError("Invalid 'to' email address: $i");
		}
	}
	
	#check advanced email
	if($in{'formtoadv'}){
	my(@s) = split(/\r*\n/,$in{'formtoadv'});
	foreach my $i (@s){
		my($a,$b,$c) = split(/\|/,$i);
		if(!&ValidEmail($c)){
			&PError("Invalid email address in advance 'to' settings");
			}
		}
	
	}
	}
($in{'formsublimit'})&&($in{'formsublimit'} =~ /[^\d]/)&&(PError("Invalid limit. Most be a number"));

if($in{'formrestrictip'}){
	my(@s) = split(/\r*\n/,$in{'formrestrictip'});
	foreach my $i (@s){
		($i =~ /[^\.\d]/)&&(&PError("Invalid IP Address"));
		}
	}
}

my $formname = &htmlspecialchars($in{'formname'});
my $formdesc = &htmlspecialchars($in{'formdesc'});
my $formsubject = &htmlspecialchars($in{'formsubject'});
my $formsubjectadv = &htmlspecialchars($in{'formsubjectadv'});
my $formto = &htmlspecialchars($in{'formto'});
my $formtoadv = &htmlspecialchars($in{'formtoadv'});
my $formcc = &htmlspecialchars($in{'formcc'});
my $formbcc = &htmlspecialchars($in{'formbcc'});
my $formfrom = &htmlspecialchars($in{'formfrom'});
my $formsublimit = &htmlspecialchars($in{'formsublimit'});
my $formlimithd = &htmlspecialchars($in{'formlimithd'});
my $formrestrictip = &htmlspecialchars($in{'formrestrictip'});
my $formdelivery = &htmlspecialchars($in{'formdelivery'});
my $limitip = &htmlspecialchars($in{'limitip'});
my $mpf = &htmlspecialchars($in{'multipage'});

my $outvar = "$formname\t$formdesc\t$formsubject\t$formsubjectadv\t$formto\t$formtoadv\t$formcc\t$formbcc\t$formfrom\t$formsublimit\t$formlimithd\t$formrestrictip\t$formdelivery\t$limitip\t$mpf\t";
return $outvar;
}

sub ShowAddForm{
	$in{'formdelivery0'} = 'checked';
	$in{'limitip0'} = 'checked';
	if($in{'command'} eq 'showaddformtemplate'){
		my $fopt;
		open(DATA,"<$cgipath/templates/templates.txt");
		while(<DATA>){
			chomp;
			my($n,$t) = split("\t",$_);
			$t =~ s/\s+//g;
			$fopt .= "<option value=\"$t\">$n</option>";
			}
		close DATA;

	$in{'templateline'} = qq|
                      <tr>
                        <td align="right" valign="top" nowrap><b>Template:</b></td>
                        <td align="left" valign="middle" nowrap>
                          <select name=templatename><option value="">-=Select=-</option>$fopt</select></option>
                        </td>
                      </tr>	
	|;
	$in{'command'} = 'saveformtemplate';
	}
	else{
		$in{'command'} = 'saveform';
		}
		
		

	#get redirects
	#get form names
	$in{'mpsel'} = qq|<option value="">None</option>\n|;
	open(DB,"<$cgipath/data/forms.cgi");
	my $sel='';
	while(<DB>){
		chomp;
		my ($fid,$formname,$formdesc,$formsubject,$formsubjectadv,$formto,$formtoadv,$formcc,$formbcc,$formfrom,$formsublimit,$formlimithd,$formrestrictip,$formdelivery,$mpf) = split("\t",$_);
		$in{'mpsel'} .= qq|<option value="$fid" $sel>$formname</option>\n|;
		}
	close DB;

	&PageOut("$basepath/t_add_form.htm");
	}

sub DeleteField{
my(@l);
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Error. Invalid ID"));

my $fid = $in{'fid'};
($fid =~ /[^\d]/)&&(&PError("Error. Invalid FID"));

open(DB,"+<$datapath/fields-$id.cgi");
($flock)&&(flock(DB,2));
while(<DB>){
	my(@r) = split("\t",$_);
	if($r[0] != $fid){
		push(@l,$_);
		}
	}
seek(DB,0,0);

foreach my $i (@l){
	print DB $i;
	}
truncate(DB, tell(DB));

($flock)&&(flock(DB,8));
close DB;

&RebuildForm($id);

print qq|
<script language=javascript>
alert("Field deleted");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=showfieldconfig&id=$id&rnd="+rndURL;
</script>
|;
exit;
}

sub DeleteForm{
my(@l);
my $id = $in{'id'};
($id =~ /[^\d]/)&&(&PError("Error. Invalid ID"));

my $formname = &GetFormName($id);

open(DB,"+<$datapath/forms.cgi");
($flock)&&(flock(DB,2));
while(<DB>){
	my(@r) = split("\t",$_);
	if($r[0] != $id){
		push(@l,$_);
		}
	}
seek(DB,0,0);

foreach my $i (@l){
	print DB $i;
	}
truncate(DB, tell(DB));

($flock)&&(flock(DB,8));
close DB;


#delete all files
unlink("$datapath/attach-$id.cgi");
unlink("$datapath/auto-$id.cgi");
unlink("$datapath/fields-$id.cgi");
unlink("$datapath/results-$id.cgi");
unlink("$datapath/style-$id.cgi");
unlink("$datapath/$id-log.cgi");
unlink("$formpath/$formname.htm");
unlink("$formpath/$formname.css");

print qq|
<script language=javascript>
alert("Form deleted");
var rndURL = (1000*Math.random());
window.location="$in{'cgiurl'}?command=manage&rnd="+rndURL;
</script>
|;
exit;
}


sub Manage{
my($count,$formip,$mpf,$formsubdate,$formsubmissions,$id,$formname,$formdesc,$formsubject,$formsubjectadv,$formto,$formtoadv,$formcc,$formbcc,$formfrom,$formsublimit,$formlimithd,$formrestrictip,$formdelivery);
my $formurl = $htmlurl.'/forms';
my %fsort;
my $mp='';

$page='';
$page = $in{'page'};

(!$page)&&($page = 1);
my $start = ($page*$entriesperpage)-$entriesperpage;
my $end = $start + $entriesperpage;
$count=0;

open(DB,"<$cgipath/data/forms.cgi");
while(<DB>){
	chomp;
	($id,$formname,$formdesc,$formsubject,$formsubjectadv,$formto,$formtoadv,$formcc,$formbcc,$formfrom,$formsublimit,$formlimithd,$formrestrictip,$formdelivery,$formip,$mpf) = split("\t",$_);
	$formdesc =~ s/\\n/<br>\n/g;
	($formdesc)&&($formdesc = "<br>$formdesc");
	
	($formsubmissions,$formsubdate) = &GetSubCount($id);
	(!$formsubmissions)&&($formsubmissions='0');
	(!$formsubmissions)&&($formsubdate='never');

	my $sublinks='';
	my $nomulti='';

	if($mpf > 0){
		$formsubmissions = 'N/A';
		$formsubdate = 'N/A';
		$nomulti = "<br>* Redirecting to ". &GetFormName($mpf);
		}
	else{
		$sublinks = qq|[ <a href="javascript:ViewSubmissions('$id');">View</a> ] [ <a href="javascript:ClearSubmissions('$id');">Clear</a> ]|;
		$nomulti = qq|[<a href="javascript:ShowResultConfig('$id');">Results</a>] [<a href="javascript:ShowAutoConfig('$id');">Autoresponder</a>]|;
		}
	my $key = $formname.'-'.$id;
	$key =~ tr/a-z/A-Z/;
	$fsort{$key} = qq|
	                  <tr> 
	                  <td align="center" valign="middle" nowrap>[<a href="javascript:ShowEdit('$id')">Modify</a>] [<a href="javascript:Delete('$id');">Delete</a>] [<a href="javascript:Copy('$id');">Copy</a>]</td> 
	                    <td align="left" valign="middle" nowrap><a href="$formurl/$formname.htm" target=_blank>$formname</a>$formdesc</td>
	                    <td align="right" valign="middle" nowrap><div align="center">$formsubmissions $sublinks</div></td>
	                    <td align="center" valign="middle" nowrap>$formsubdate</td>
	                    <td align="left" valign="middle" nowrap>[<a href="javascript:ShowFieldConfig('$id');">Fields/Style</a>] $nomulti</td>
                  </tr>
	|;
	}

close DB;

foreach my $i (sort keys %fsort){
		$count++;
		if(($count > $start) & ($count <= $end)){
			$in{'line'} .= $fsort{$i};
			}
	}
	
(!$in{'line'})&&($in{'line'} = qq|<tr><td colspan=5>No forms configured</td></tr>|);

$in{'link'} = &GetNlinksMan($count,$entriesperpage);
(!$in{'link'})&&($in{'link'} = '0');

&PageOut("$cgipath/t_manage.htm");
exit;
}

sub GetMulPage{
my($id) = @_;
open(CFG,"<$datapath/results-$id.cgi");
my $line = <CFG>;
close CFG;

my(@f) = split("\t",$line);

if($f[2]){
	my $txt = "<br>* Redirecting to ".&GetFormName($f[2]);
	return $txt;
	}
else{
	return '';
	}
}

sub GetSubCount{
my($id) = @_;
my $count=0;
my $lastsub=0;
open(LOG,"<$datapath/$id-log.cgi");
while(<LOG>){
	my(@f) = split(",",$_);
	$f[0] =~ s/[^\d]//g;
	if($f[0] > $lastsub){
		$lastsub = $f[0];
		}
	$count++;
	}
close LOG;
($count > 1)&&($count--);
return $count, &ctime($lastsub);
}

sub ShowCP{
$in{'musername'} = $username;
&PageOut("$cgipath/t_cp.htm");
exit;
}

sub ChangePassword{
my($buff,$encpass);
(!$in{'musername'})&&(&PError("Error. Please enter a username"));
(!$in{'mpassword'})&&(&PError("Error. Please enter a password"));
($in{'mpassword'} ne $in{'mpassword2'})&&(&PError("Error. Please retype passwords"));
($in{'musername'} =~ /[\%\s\|\$\*\.\']/)&&(&PError("Error. Invalid character in username"));
($in{'mpassword'} =~ /[\%\s\|\$\*\.\']/)&&(&PError("Error. Invalid character in password"));
open(DB,"<$basepath/setup.cgi");
while(<DB>){
	$buff .= $_;
	}
close DB;

if($^O !~ /win/i){
    	$encpass = crypt($in{'mpassword'},'CS');
    	}
else{
	$encpass = $in{'mpassword'};
	}
    	
$buff =~ s/\$username='.*'/\$username='$in{'musername'}'/;
$buff =~ s/\$password='.*'/\$password='$encpass'/;

open(DB,">$basepath/setup.cgi");
print DB $buff;
close DB;

print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
document.cookie="UserName=$in{'musername'}";
document.cookie="PassWord=$in{'mpassword'}";
alert("Username/Password changed");
window.location="$in{'cgiurl'}?command=manage&rnd="+rndURL;
</script>
EOF
exit;
}

sub GetFormName{
my($id) = @_;
my($formname,$tid,@rest);

my $found=0;
open(FRM,"<$cgipath/data/forms.cgi");
while(<FRM>){
	chomp;
	($tid,$formname,@rest) = split("\t",$_);
	if($tid == $id){
	$found=1;
	last;
	}
	}
close FRM;

#(!$found)&&(&PError("Form ID not found"));
if(!$found){
	$formname = 'unknown';
	}

return $formname;
}

sub GetFields{
my($id) = @_;
my @fields;

open(DB,"<$datapath/fields-$id.cgi");
while(<DB>){
	chomp;
	my(@fld) = split("\t",$_);
	next if($fld[1] eq 'TextHTML');
	next if($fld[1] eq 'BlankLine');
	next if($fld[1] eq 'HorizontalLine');
	#next if($fld[1] eq 'ImageVerify');
	push(@fields,$_);
	}
close DB;

return @fields;
}

sub sanitizevars{
	foreach my $i (keys %in){
		$in{$i} =~ s/\\0$//;
		$in{$i} =~ s/^\\0//;
		$in{$i} =~ s/\\0/,/g;
		$in{$i} =~ s/,+/,/g;
		}
	}

sub DoSetup{
(-f "$basepath/setup.cgi")&&(&PError("Error. Access Denied"));
use Cwd;
$in{'mcgipath'} = Cwd::cwd();
$in{'mcgiurl'} = "$ENV{'HTTP_HOST'}/$ENV{'SCRIPT_NAME'}";
$in{'mcgiurl'} =~ s/\/\//\//g;
$in{'mcgiurl'} = "http://".$in{'mcgiurl'};
$in{'mcgiurl'} =~ s/\/$in{'scriptname'}//i;

if(($^O !~ /win/i)&&($in{'mcgipath'} =~ /cgi\-bin/i)){
	$in{'mhtmlurl'} = "http://$ENV{'HTTP_HOST'}/cgi-script/csFormbuilder";
	$in{'mhtmlpath'} = "$ENV{'DOCUMENT_ROOT'}/cgi-script/csFormbuilder";
	}
else{
	$in{'mhtmlurl'} = $in{'mcgiurl'};
	$in{'mhtmlpath'} = $in{'mcgipath'};
	}

if($^O !~ /win/i){
	$in{'msendmail'} = '/usr/sbin/sendmail';
	}
else{
	$in{'msendmail'} = 'localhost';
	}

&PageOut("$basepath/t_setup.htm");
exit;
}


sub SaveSetup{
	(-f "$basepath/setup.cgi")&&(&PError("Error. Access Denied"));
	(!$in{'musername'})&&(PError("Please enter a username"));
	(!$in{'mpassword'})&&(PError("Please enter a password"));
	
	if($^O !~ /win/i){
	    	$in{'mpassword'} = crypt($in{'mpassword'},'CS');
	    	}
	$in{'mcgiurl'} =~ s/[\'\%\$\"]//g;
	$in{'mcgipath'} =~ s/[\'\%\$\"]//g;
	$in{'mhtmlurl'} =~ s/[\'\%\$\"]//g;
	$in{'mhtmlpath'} =~ s/[\'\%\$\"]//g;
	$in{'msendmail'} =~ s/[\'\%\$\"]//g;
	$in{'musername'} =~ s/[\'\%\$\"]//g;
	$in{'mpassword'} =~ s/[\'\%\$\"]//g;
	
	open(SETUP,">$basepath/setup.cgi");
	print SETUP "\$cgiurl='$in{'mcgiurl'}';\n";
	print SETUP "\$cgipath='$in{'mcgipath'}';\n";
	print SETUP "\$htmlurl='$in{'mhtmlurl'}';\n";
	print SETUP "\$htmlpath='$in{'mhtmlpath'}';\n";	
	print SETUP "\$sendmail='$in{'msendmail'}';\n";
	print SETUP "\$username='$in{'musername'}';\n";
	print SETUP "\$password='$in{'mpassword'}';\n";
	print SETUP "1;\n";
	&Redirect("$ENV{'SCRIPT_NAME'}?command=login","Setup.cgi reconfigured");
	exit;
}

sub GetNlinksMan{
	my($count,$numberPer,$cmd) = @_;
	my ($page,$lpage,$link,$nstart,$nend,$pend);
	(!$cmd)&&($cmd='manage');
	$page='';$lpage='';$link='';
	$page = $in{'page'};
	$lpage = $in{'lpage'};
	(!$page)&&($page=1);
	((!$page)||($lpage < 0))&&($lpage = 1);
	$nstart = ($lpage+10)-10;
	$nend = $nstart + 10;
	$npages = int($count/$numberPer);
	(($count/$numberPer) > $npages)&&($npages++);
	#my $nlpages = $npages - int(($count/$numberPer));
	my $nlpages = $npages-($npages%10);
	for(my $i = 1; $i <= $npages; $i++){
		if(($i >= $nstart) && ($i < $nend)){
    			($i == $page)?($link .= " <b>$i</b> "):($link .= " <a href=\"$in{'cgiurl'}?command=$cmd&page=$i&lpage=$lpage\" onmouseover=\"window.status='Next Page';return true;\" onmouseout=\"window.status='';return true;\">$i</a> ");
    			}
  	}
	$pend = $nend - 20;
	($npages > $nend)&&($link .= " <a href=\"$in{'cgiurl'}?command=$cmd&page=$nend&lpage=$nend\" onmouseover=\"window.status='Next Page';return true;\" onmouseout=\"window.status='';return true;\">[Next]</a> ");
	($nend > 11)&&($link = " <a href=\"$in{'cgiurl'}?command=$cmd&page=$pend&lpage=$pend\" onmouseover=\"window.status='Next Page';return true;\" onmouseout=\"window.status='';return true;\">[Prev]</a> " . $link);
	if($npages  > 1){
		$link = " <a href=\"$in{'cgiurl'}?command=$cmd&page=1&lpage=\" onmouseover=\"window.status='First';return true;\" onmouseout=\"window.status='';return true;\">[First]</a> $link <a href=\"$in{'cgiurl'}?command=$cmd&page=$npages&lpage=$nlpages\" onmouseover=\"window.status='Last';return true;\" onmouseout=\"window.status='';return true;\">[Last]</a>";
		}
	
	(!$link)&&($link='0');
	return ($link);
}