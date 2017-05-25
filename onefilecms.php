<?php ob_start(); mb_internal_encoding('utf-8');  $MESSAGE = ""; //initialize $MESSAGE here so can .= at any point later.

// OneFileCMS - github.com/Self-Evident/OneFileCMS

$OFCMS_version = '3.5.21';




//******************************************************************************
//Some basic security & error log settings
//
ini_set('session.use_trans_sid', 0);    //make sure URL supplied SESSID's are not used
ini_set('session.use_only_cookies', 1); //make sure URL supplied SESSID's are not used
error_reporting(E_ALL & ~E_STRICT);     //(E_ALL &~ E_STRICT) for everything, 0 for none.
ini_set('display_errors', 'on');
ini_set('log_errors'    , 'off');
ini_set('error_log'     , $_SERVER['SCRIPT_FILENAME'].'.ERROR.log');
//
//Determine good folder for session file. Default is /tmp/, which is not secure.
//session_save_path('/home/content/username/tmp/'); //##### or:  ini_set('session.save_path', 'some/safe/path/')
//******************************************************************************




/*******************************************************************************
Except where noted otherwise:

Copyright © 2009-2012 https://github.com/rocktronica
Copyright © 2012-     https://github.com/Self-Evident

Under the following terms (an "MIT" License):

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*******************************************************************************/



/*******************************************************************************
A portion of this software is copyright under terms of the "BSD" license (below).
The copyright holders of that portion are indicated near where that portion is included.
(Search for references to the BSD license)

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
    * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the
      documentation and/or other materials provided with the distribution.
    * Neither the name of the author or copyright holder, nor the
      names of its contributors may be used to endorse or promote products
      derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*******************************************************************************/




// CONFIGURABLE OPTIONS ********************************************************
$MAIN_TITLE = "OneFileCMS";

$USERNAME = "username";
$HASHWORD = "18350bc2181858e679605434735b1c2db6e7e4bb72b50a6d93d9ad1362f3e1c2";
//$HASHWORD = "18350bc2181858e679605434735b1c2db6e7e4bb72b50a6d93d9ad1362f3e1c2"; //"password" with $PRE_ITERATIONS = 1000
$SALT     = 'somerandomsalt';

$MAX_ATTEMPTS  = 3;    //Max failed login attempts before LOGIN_DELAY starts.
$LOGIN_DELAY   = 10;   //In seconds.
$MAX_IDLE_TIME = 600;  //In seconds. 600 = 10 minutes.  Other PHP settings (like gc) may limit its max effective value.
$TO_WARNING    = 120;  //In seconds. When idle time remaining is less than this value, a TimeOut warning is displayed.
$LOG_LOGINS    = true; //Keep log of login attempts.

$MAIN_WIDTH    = '810px'; //Width of main <div> defining page layout.          Can be px, pt, em, or %.  Assumes px otherwise.
$WIDE_VIEW_WIDTH = '97%'; //Width to set Edit page if [Wide View] is clicked.  Can be px, pt, em, or %.  Assumes px otherwise.

$LINE_WRAP = "on"; //"on", or (anything else) = "off".  Default for edit page. Once on page, line-wrap can toggle on/off.
$TAB_SIZE  = 8;    //Some browsers recognize a css tab-size. Some don't (IE/Edge, as of mid-2016).

$MAX_EDIT_SIZE = 200000;  // Edit gets flaky with large files in some browsers.  Trial and error your's.
$MAX_VIEW_SIZE = 1000000; // If file > $MAX_EDIT_SIZE, don't even view in OneFileCMS.
                          // The default max view size is completely arbitrary. Basically, it was 2am, and seemed like a good idea at the time.

$MAX_IMG_W   = 810;  //Max width (in px) to display images. (main width is 810)
$MAX_IMG_H   = 1000; //Max height (in px).  I don't know, it just looks reasonable.

$UPLOAD_FIELDS = 10; //Number of upload fields on Upload File(s) page. Max value is ini_get('max_file_uploads').

$FAVICON  = "favicon.ico"; //Path is relative to root of website.

$EXCLUDED_FILES  = ""; //csv list of filenames to exclude from directory listings- CaSe sEnsiTive!

$EDIT_FILES = "svg,asp,cfg,conf,csv,css,dtd,htm,html,xhtml,htaccess,ini,js,log,markdown,md,php,pl,txt,text"; //Editable file types.
$SHOW_FILES = "*"; // Shown types; only files of the given types should show up in the file-listing
	// Use $SHOW_FILES exactly like $EDIT_FILES: a list of extensions separated by commas.
	// If $SHOW_FILES is set to null - by intention or by error - only folders will be shown.
	// If $SHOW_FILES is set to the *-wildcard (the default), all files will show up.
	// If $SHOW_FILES is set to "html,htm" for example, only file with the extension "html" or "htm" will get listed.

$SHOW_IMGS = "jpg,gif,png,bmp,ico"; //image types to display on edit page.
//File types (extensions).  _ftypes & _fclass must have the same number of values. bin is default.
$FILE_TYPES = "bin,z,gz,7z,zip,jpg,gif,png,bmp,ico,svg,asp,cfg,conf,csv,css,dtd,htm,html,xhtml,htaccess,ini,js,log,markdown,md,php,pl,txt,text";
//Cooresponding file classes to _ftypes - used to determine icons for directory listing.
$FILE_CLASSES = "bin,z,z ,z ,z  ,img,img,img,img,img,svg,txt,txt,cfg ,txt,css,txt,htm,htm ,htm  ,txt     ,txt,txt,txt,txt   ,txt,php,php,txt,txt";

$EX = '<b>( ! )</b> '; //EXclaimation point "icon" Used in $MESSAGE's

$PAGEUPDOWN = 10; //Number of rows to jump using Page Up/Page Down keys on directory listing.

$SESSION_NAME = 'OFCMS'; //Name of session cookie. Change if using multiple copies of OneFileCMS concurrently.

//Restrict access to a particular folder.  Leave empty for access to entire website.
// "some/path/" is relative to root of website (with no leading slash).
//$ACCESS_ROOT = 'some/path/';


//URL of optional external style sheet.  Used as an href in <link ...>
//If file is not found, or is incomplete, built-in defaults will be used.
//$CSS_FILE = 'OneFileCMS.css';


//Notes for $LANGUAGE_FILE, $WYSIWYG_PLUGIN, and $CONFIG_FILE:
//
// Filename paths can be:
//  1) Absolute to the filesystem:  "/some/path/from/system/root/somefile.php"  or
//  2) Relative to root of website: "some/path/from/web/root/somefile.php"

//Name of optional external language file.  If file is not found, the built-in defaults will be used.
//$LANGUAGE_FILE = "OneFileCMS.LANG.EN.php";

//Init file for optional external wysiwyg editor.
//Sample init files are availble in the "extras\" folder of the OneFileCMS repo, but the actual editors are not.
//$WYSIWYG_PLUGIN = 'plugins/plugin-tinymce_init.php';
//$WYSIWYG_PLUGIN = 'plugins/plugin-ckeditor_init.php';

//Name of optional external config file.  Any settings it contains will supersede those above.
//See the sample file in the OneFileCMS github repo for format example.
//$CONFIG_FILE = 'OneFileCMS.config.SAMPLE.php';

//end CONFIGURABLE OPTIoNS *****************************************************




function System_Setup() {//*****************************************************

global $_, $MAX_IDLE_TIME, $LOGIN_ATTEMPTS, $LOGIN_DELAYED, 
	$MAIN_WIDTH, $WIDE_VIEW_WIDTH, $MAX_EDIT_SIZE, $MAX_VIEW_SIZE, $EXCLUDED_FILES, $TAB_SIZE, 
	$EDIT_FILES, $SHOW_FILES, $SHOW_IMGS, $FILE_TYPES, $FILE_CLASSES, 
	$SHOWALLFILES, $ETYPES, $STYPES, $ITYPES, $FTYPES, $FCLASSES, $EXCLUDED_LIST, 
	$LANGUAGE_FILE, $ACCESS_ROOT, $ACCESS_ROOT_len, $WYSIWYG_PLUGIN, $WYSIWYG_VALID, $WYSIWYG_PLUGIN_OS, 
	$INVALID_CHARS, $WHSPC_SLASH, $VALID_PAGES, $LOGIN_LOG_url, $LOGIN_LOG_file,
	$ONESCRIPT,  $ONESCRIPT_file, $ONESCRIPT_backup, $ONESCRIPT_file_backup, 
	$CONFIG_backup, $CONFIG_FILE, $CONFIG_FILE_backup, $VALID_CONFIG_FILE, 
	$DOC_ROOT, $DOC_ROOT_OS, $WEB_ROOT, $WEBSITE, $PRE_ITERATIONS, $EX, $MESSAGE, $ENC_OS,
	$DELAY_Expired_Reload, $DELAY_Sort_and_Show_msgs, $DELAY_Start_Countdown, $DELAY_final_messages, $MIN_DIR_ITEMS;

//Requires PHP 5.1 or newer, due to changes in explode() (and maybe others).
define('PHP_VERSION_ID_REQUIRED',50100);   //Ex: 5.1.23 is 50123
define('PHP_VERSION_REQUIRED'  ,'5.1 + '); //Used in exit() message.
//The predefined constant PHP_VERSION_ID has only been available since 5.2.7.
//So, if needed, convert PHP_VERSION (a string) to PHP_VERSION_ID (an integer).
//Ex: 5.1.23 converts to 50123.
if (!defined('PHP_VERSION_ID')) {
	$phpversion = explode('.', PHP_VERSION);
	define('PHP_VERSION_ID', ($phpversion[0] * 10000 + $phpversion[1] * 100 + $phpversion[2]));
}
if( PHP_VERSION_ID < PHP_VERSION_ID_REQUIRED ) {
	exit( 'PHP '.PHP_VERSION.'<br>'.hsc($_['OFCMS_requires']).' '.PHP_VERSION_REQUIRED );
}


mb_detect_order("UTF-8, ASCII, Windows-1252, ISO-8859-1"); 

//Get server's File System encoding.  Windows NTFS uses ISO-8859-1 / Windows-1252.
//Needed when working with non-ascii filenames.
if (php_uname("s") == 'Windows NT') {$ENC_OS = 'Windows-1252';}
else								{$ENC_OS = 'UTF-8';}

$DOC_ROOT = dirname(__FILE__); //root folder of website.
$DOC_ROOT_OS = Convert_encoding($DOC_ROOT);

//Allow OneFileCMS.php to be started from any dir on the site.
//This also effects the path in an include("path/somefile.php")
chdir($DOC_ROOT); 

$INVALID_CHARS = '< > ? * : " | / \\'; //Illegal characters for file & folder names.  Space deliminated.
$WHSPC_SLASH = "\x00..\x20/";  //Whitespace & forward slash. For trimming file & folder name inputs.

$WEB_ROOT  = basename($DOC_ROOT).'/'; //Used only for screen output - Non-url use.
$WEBSITE   = $_SERVER['HTTP_HOST'].'/';

$ONESCRIPT			   = URLencode_path($_SERVER['SCRIPT_NAME']);  //Used for URL's in HTML attributes
$ONESCRIPT_file		   = $_SERVER['SCRIPT_FILENAME'];              //Non-url file system use.
$ONESCRIPT_backup	   = $ONESCRIPT.'-BACKUP.txt';                 //used for p/w & u/n updates.
$ONESCRIPT_file_backup = $ONESCRIPT_file.'-BACKUP.txt';            //used for p/w & u/n updates.
$LOGIN_ATTEMPTS		   = $ONESCRIPT_file.'.invalid_login_attempts';//Non-url file system use.
$LOGIN_LOG_url		   = $ONESCRIPT.'-LOGIN.log';
$LOGIN_LOG_file		   = $ONESCRIPT_file.'-LOGIN.log';


//If specified & found, include $CONFIG_FILE.
$VALID_CONFIG_FILE = 0;
if (isset($CONFIG_FILE)) {
	$CONFIG_FILE_OS = Convert_encoding($CONFIG_FILE);
	if (is_file($CONFIG_FILE_OS)) { 
		$VALID_CONFIG_FILE = 1;
		include($CONFIG_FILE_OS);
		$CONFIG_backup      = URLencode_path($CONFIG_FILE).'-BACKUP.txt'; //used for p/w & u/n updates.
		$CONFIG_FILE_backup = $CONFIG_FILE.'-BACKUP.txt';                 //used for p/w & u/n updates.
	}
	else {
		$MESSAGE .= $EX.'<b>$CONFIG_FILE '.hsc($_['Not_found']).':</b> '.$CONFIG_FILE.'<br>';
		$CONFIG_FILE = $CONFIG_FILE_OS = '';
	}
}


//If specified, check for & load $LANGUAGE_FILE
if (isset($LANGUAGE_FILE)) {
	$LANGUAGE_FILE_OS = Convert_encoding($LANGUAGE_FILE);
	if (is_file($LANGUAGE_FILE_OS)) {include($LANGUAGE_FILE_OS);}
}


//If specified, validate $WYSIWYG_PLUGIN. Actual include() is at end of OneFileCMS.
$WYSIWYG_VALID = 0; //Default to invalid.
if (isset($WYSIWYG_PLUGIN)) {
	$WYSIWYG_PLUGIN_OS = Convert_encoding($WYSIWYG_PLUGIN); //Also used for include()
	if (is_file($WYSIWYG_PLUGIN_OS)) { $WYSIWYG_VALID = 1; }
}


//If specified, clean up & validate $ACCESS_ROOT
if (!isset($ACCESS_ROOT)) { $ACCESS_ROOT = ''; } //At least make sure it's set.
$ACCESS_ROOT_OS = Convert_encoding($ACCESS_ROOT);

if (!is_dir($DOC_ROOT_OS.$ACCESS_ROOT_OS) || (Check_path($ACCESS_ROOT,1) === false) ) {
	$MESSAGE .= __LINE__.$EX.'<b>$ACCESS_ROOT '.hsc($_['Invalid_path']).': </b>'.$ACCESS_ROOT.'<br>';
	$ACCESS_ROOT = $ACCESS_ROOT_OS = '';
}
if ($ACCESS_ROOT != '') {
	$ACCESS_ROOT = trim($ACCESS_ROOT, ' /').'/'; //make sure only a single trailing '/'
	$ACCESS_ROOT_OS = Convert_encoding($ACCESS_ROOT);
}
$ACCESS_ROOT_enc = mb_detect_encoding($ACCESS_ROOT);
$ACCESS_ROOT_len = mb_strlen($ACCESS_ROOT, $ACCESS_ROOT_enc);


$MAIN_WIDTH      = validate_units($MAIN_WIDTH);
$WIDE_VIEW_WIDTH = validate_units($WIDE_VIEW_WIDTH);


//Just some basic validation.  The 80 is just a round number that seems reasonable.
$TAB_SIZE = intval($TAB_SIZE);
if (($TAB_SIZE < 1) || ($TAB_SIZE > 80)) { $TAB_SIZE = 8; }


ini_set('session.gc_maxlifetime', $MAX_IDLE_TIME + 100); //in case the default is less.

$VALID_PAGES = array("login","logout","admin","hash","changepw","changeun","index","edit","upload","uploaded","newfile","renamefile","copyfile","deletefile","deletefolder","newfolder","renamefolder","copyfolder","mcdaction", "phpinfo", "raw_view");

//Make arrays out of a few config variables for actual use later.
//First, remove spaces and make lowercase (for *types).
$SHOWALLFILES = $STYPES = false;
  if ($SHOW_FILES == '*') { $SHOWALLFILES = true; }
  else { $STYPES   = explode(',', mb_strtolower(str_replace(' ', '', $SHOW_FILES))); }//shown file types
$ETYPES   = explode(',', mb_strtolower(str_replace(' ', '', $EDIT_FILES)));   //editable file types
$ITYPES   = explode(',', mb_strtolower(str_replace(' ', '', $SHOW_IMGS)));    //images types to display
$FTYPES   = explode(',', mb_strtolower(str_replace(' ', '', $FILE_TYPES)));   //file types with icons
$FCLASSES = explode(',', mb_strtolower(str_replace(' ', '', $FILE_CLASSES))); //for file types with icons
$EXCLUDED_LIST = explode(',', str_replace(' ', '', $EXCLUDED_FILES));


//A few variables for values that were otherwise hardcoded in js. 
//$DELAY_... values are in milliseconds.
//The values were determined thru quick experimentation, and may be tweaked if desired, except as noted.
$DELAY_Sort_and_Show_msgs = 20; //Needed so "Working..." message shows during directory sorts. Mostly for Firefox.
$DELAY_Start_Countdown	  = 25; //Needs to be > than $Sort_and_Show_msgs. Used in Timeout_Timer().
$DELAY_final_messages	  = 25; //Needs to be > than $Sort_and_Show_msgs. Delays final Display_Messages().
$DELAY_Expired_Reload  = 10000; //Delay from Session Expired to page load of login screen. Ten seconds, but can be less/more.
$MIN_DIR_ITEMS			  = 25; //Minimum number of directory items before "Working..." message is needed/displayed.


//Validate wide_view cookie...
if ( !isset($_COOKIE['wide_view']) || ($_COOKIE['wide_view'] !== "on") ) {
	$_COOKIE['wide_view'] = "off";
}


//Used in hashit() and js_hash_scripts().  IE<9 is WAY slow, so keep it low.
//For 200 iterations: (time on IE8) > (37 x time on FF). And the difference grows with the iterations.
//If you change this, or any other aspect of either hashit() or js_hash_scripts(), do so while logged in.
//Then, manually update your password as instructed on the Admin/Generate Hash page.
$PRE_ITERATIONS = 1000;
}//end  System_Setup() //*******************************************************




function Default_Language() { // ***********************************************
	global $_;
// OneFileCMS Language Settings v3.5.21
$_['LANGUAGE'] = 'English';
$_['LANG'] = 'EN';
// If no translation or value is desired for a particular setting, do not delete
// the actual setting variable, just set it to an empty string.
// For example:  $_['some_unused_setting'] = '';
//
// Remember to slash-escape any single quotes that may be within the text:  \'
// The back-slash itself may or may not also need to be escaped:  \\
//
// If present as a trailing comment, "## NT ##" means 'Needs Translation'.
//
// These first few settings control a few font and layout settings.
// In some instances, some langauges may use significantly longer words or phrases than others.
// So, a smaller font or less spacing may be desirable in those places to preserve page layout.
$_['front_links_font_size']  = '1.0em';   //Buttons on Index page.
$_['front_links_margin_L']   = '1.0em';
$_['MCD_margin_R']           = '1.0em';   //[Move] [Copy] [Delete] buttons
$_['button_font_size']       = '0.9em';   //Buttons on Edit page.
$_['button_margin_L']        = '0.7em';
$_['button_padding']         = '4px 4px 4px 4px'; //T R B L  ,or,   V H   if only two values.
$_['image_info_font_size']   = '1em';     //show_img_msg_01  &  _02
$_['image_info_pos']         = '';        //If 1 or true, moves the info down a line for more space.
$_['select_all_label_size']  = '.84em';   //Font size of $_['Select_All']
$_['select_all_label_width'] = '72px';    //Width of space for $_['Select_All']
$_['HTML']    = 'HTML';
$_['WYSIWYG'] = 'WYSIWYG';
$_['Admin']    = 'Admin';
$_['bytes']    = 'bytes';
$_['Cancel']   = 'Cancel';
$_['cancelled'] = 'cancelled';
$_['Close']    = 'Close';
$_['Copy']     = 'Copy';
$_['Copied']   = 'Copied';
$_['Create']   = 'Create';
$_['Date']     = 'Date';
$_['Delete']   = 'Delete';
$_['DELETE']   = 'DELETE';
$_['Deleted']  = 'Deleted';
$_['Edit']     = 'Edit';
$_['Enter']    = 'Enter';
$_['Error']    = 'Error';
$_['errors']   = 'errors';
$_['ext']      = '.ext';    //## NT ## filename[.ext]ension
$_['File']     = 'File';
$_['files']    = 'files';
$_['Folder']   = 'Folder';
$_['folders']  = 'folders';
$_['From']     = 'From';
$_['Hash']     = 'Hash';
$_['Move']     = 'Move';
$_['Moved']    = 'Moved';
$_['Name']     = 'Name';
$_['on']       = 'on';
$_['off']      = 'off';
$_['Password'] = 'Password';
$_['Rename']   = 'Rename';
$_['reset']    = 'Reset';
$_['save_1']   = 'Save';
$_['save_2']   = 'SAVE CHANGES';
$_['Size']     = 'Size';
$_['Source']   = 'Source';
$_['successful'] = 'successful';
$_['To']       = 'To';
$_['Upload']   = 'Upload';
$_['Username'] = 'Username';
$_['View']     = 'View';
$_['Working']         = 'Working - please wait...';
$_['Log_In']          = 'Log In';
$_['Log_Out']         = 'Log Out';
$_['Admin_Options']   = 'Administration Options';
$_['Are_you_sure']    = 'Are you sure?';
$_['View_Raw']        = 'View Raw'; //## NT ### as of 3.5.07
$_['Open_View']       = 'Open/View in browser window';
$_['Edit_View']       = 'Edit / View';
$_['Wide_View']       = 'Wide View';
$_['Normal_View']     = 'Normal View';
$_['Word_Wrap']       = 'Word Wrap'; //## NT ## as of 3.5.19
$_['Line_Wrap']       = 'Line Wrap'; //## NT ## as of 3.5.20
$_['Upload_File']     = 'Upload File';
$_['New_File']        = 'New File';
$_['Ren_Move']        = 'Rename / Move';
$_['Ren_Moved']       = 'Renamed / Moved';
$_['folders_first']   = 'folders first'; //## NT ##
$_['folders_first_info'] = 'Sort folders first, but don\'t change primary sort.'; //## NT ##
$_['New_Folder']      = 'New Folder';
$_['Ren_Folder']      = 'Rename / Move Folder';
$_['Submit']          = 'Submit Request';
$_['Move_Files']      = 'Move File(s)';
$_['Copy_Files']      = 'Copy File(s)';
$_['Del_Files']       = 'Delete File(s)';
$_['Selected_Files']  = 'Selected Folders and Files';
$_['Select_All']      = 'Select All';
$_['Clear_All']       = 'Clear All';
$_['New_Location']    = 'New Location';
$_['No_files']        = 'No files selected.';
$_['Not_found']       = 'Not found';
$_['Invalid_path']    = 'Invalid path';
$_['verify_msg_01']     = 'Session expired.';
$_['verify_msg_02']     = 'INVALID POST';
$_['get_get_msg_01']    = 'File does not exist:';
$_['get_get_msg_02']    = 'Invalid page request:';
$_['check_path_msg_02'] = '"dot" or "dot dot" path segments are not permitted.';
$_['check_path_msg_03'] = 'Path or filename contains an invalid character:';
$_['ord_msg_01']        = 'A file with that name already exists in the target directory.';
$_['ord_msg_02']        = 'Saving as';
$_['rCopy_msg_01']      = 'A folder can not be copied into one of its own sub-folders.';
$_['show_img_msg_01']   = 'Image shown at ~';
$_['show_img_msg_02']   = '% of full size (W x H =';
$_['hash_txt_01']   = 'The hashes generated by this page may be used to manually update $HASHWORD in OneFileCMS, or in an external config file.  In either case, make sure you remember the password used to generate the hash!';
$_['hash_txt_06']   = 'Type your desired password in the input field above and hit Enter.';
$_['hash_txt_07']   = 'The hash will be displayed in a yellow message box above that.';
$_['hash_txt_08']   = 'Copy and paste the new hash to the $HASHWORD variable in the config section.';
$_['hash_txt_09']   = 'Make sure to copy ALL of, and ONLY, the hash (no leading or trailing spaces etc).';
$_['hash_txt_10']   = 'A double-click should select it...';
$_['hash_txt_12']   = 'When ready, logout and login.';
$_['pass_to_hash']  = 'Password to hash:';
$_['Generate_Hash'] = 'Generate Hash';
$_['login_txt_01']  = 'Username:';
$_['login_txt_02']  = 'Password:';
$_['login_msg_01a'] = 'There have been';
$_['login_msg_01b'] = 'invalid login attempts.';
$_['login_msg_02a'] = 'Please wait';
$_['login_msg_02b'] = 'seconds to try again.';
$_['login_msg_03']  = 'INVALID LOGIN ATTEMPT #';
$_['edit_note_00']  = 'NOTES:';
$_['edit_note_01a'] = 'Remember- ';
$_['edit_note_01b'] = 'is';
$_['edit_note_02']  = 'So save changes before the clock runs out, or the changes will be lost!';
$_['edit_note_03']  = 'With some browsers, such as Chrome, if you click the browser [Back] then browser [Forward], the file state may not be accurate. To correct, click the browser\'s [Reload].';
$_['edit_h2_1']   = 'Viewing:';
$_['edit_h2_2']   = 'Editing:';
$_['edit_txt_00'] = 'Edit disabled.'; //## NT ## as of 3.5.07
$_['edit_txt_01'] = 'Non-text or unkown file type. Edit disabled.';
$_['edit_txt_02'] = 'File possibly contains an invalid character. Edit and view disabled.';
$_['edit_txt_03'] = 'htmlspecialchars() returned an empty string from what may be an otherwise valid file.';
$_['edit_txt_04'] = 'This behavior can be inconsistant from version to version of php.';
$_['too_large_to_edit_01'] = 'Edit disabled. Filesize >';
$_['too_large_to_edit_02'] = 'Some browsers (ie: IE) bog down or become unstable while editing a large file in an HTML <textarea>.';
$_['too_large_to_edit_03'] = 'Adjust $MAX_EDIT_SIZE in the configuration section of OneFileCMS as needed.';
$_['too_large_to_edit_04'] = 'A simple trial and error test can determine a practical limit for a given browser/computer.';
$_['too_large_to_view_01'] = 'View disabled. Filesize >';
$_['too_large_to_view_02'] = 'Click [View Raw] to view the raw/"plain text" file contents in a seperate browser window.'; //** NT ** changed wording as of 3.5.07
$_['too_large_to_view_03'] = 'Adjust $MAX_VIEW_SIZE in the configuration section of OneFileCMS as needed.';
$_['too_large_to_view_04'] = '(The default value for $MAX_VIEW_SIZE is completely arbitrary, and may be adjusted as desired.)';
$_['meta_txt_01'] = 'Filesize:';
$_['meta_txt_03'] = 'Updated:';
$_['edit_msg_01'] = 'File saved:';
$_['edit_msg_02'] = 'bytes written.';
$_['edit_msg_03'] = 'There was an error saving file.';
$_['upload_txt_03'] = 'Maximum size of each file:';
$_['upload_txt_01'] = '(php.ini: upload_max_filesize)';
$_['upload_txt_04'] = 'Maximum total upload size:';
$_['upload_txt_02'] = '(php.ini: post_max_size)';
$_['upload_txt_05'] = 'For uploaded files that already exist: ';
$_['upload_txt_06'] = 'Rename (to filename.ext.001 etc...)';
$_['upload_txt_07'] = 'Overwrite';
$_['upload_err_01'] = 'Error 1: File too large. From php.ini:';
$_['upload_err_02'] = 'Error 2: File too large. (Exceeds MAX_FILE_SIZE HTML form element)';
$_['upload_err_03'] = 'Error 3: The uploaded file was only partially uploaded.';
$_['upload_err_04'] = 'Error 4: No file was uploaded.';
$_['upload_err_05'] = 'Error 5:';
$_['upload_err_06'] = 'Error 6: Missing a temporary folder.';
$_['upload_err_07'] = 'Error 7: Failed to write file to disk.';
$_['upload_err_08'] = 'Error 8: A PHP extension stopped the file upload.';
$_['upload_error_01a'] = 'Upload Error. Total POST data (mostly filesize) exceeded post_max_size =';
$_['upload_error_01b'] = '(from php.ini)';
$_['upload_msg_02'] = 'Destination folder invalid:';
$_['upload_msg_03'] = 'Upload cancelled.';
$_['upload_msg_04'] = 'Uploading:';
$_['upload_msg_05'] = 'Upload successful!';
$_['upload_msg_06'] = 'Upload failed:';
$_['upload_msg_07'] = 'A pre-existing file was overwritten.';
$_['new_file_txt_01'] = 'File or Folder will be created in the current folder.';
$_['new_file_txt_02'] = 'Some invalid characters are:';
$_['new_file_msg_01'] = 'File or folder not created:';
$_['new_file_msg_02'] = 'Name contains an invalid character:';
$_['new_file_msg_04'] = 'File or folder already exists:';
$_['new_file_msg_05'] = 'Created file:';
$_['new_file_msg_07'] = 'Created folder:';
$_['CRM_txt_02'] = 'The new location must already exist.';
$_['CRM_txt_04'] = 'New Name';
$_['CRM_msg_01'] = 'Error - new parent location does not exist:';
$_['CRM_msg_02'] = 'Error - source file does not exist:';
$_['CRM_msg_03'] = 'Error - new file or folder already exists:';
$_['CRM_msg_05'] = 'Error during';
$_['delete_msg_03']   = 'Delete error:';
$_['session_warning'] = 'Warning: Session timeout soon!';
$_['session_expired'] = 'SESSION EXPIRED';
$_['unload_unsaved']  = ' Unsaved changes will be lost!';
$_['confirm_reset']   = 'Reset file and loose unsaved changes?';
$_['OFCMS_requires']  = 'OneFileCMS requires PHP';
$_['logout_msg']      = 'You have successfully logged out.';
$_['edit_caution_01'] = 'CAUTION'; //##### No longer used as of 3.5.07
$_['edit_caution_02'] = 'You are viewing the active copy of OneFileCMS.'; //## NT ## changed wording 3.5.07
$_['time_out_txt']    = 'Session time out in:';
$_['error_reporting_01'] = 'Display errors is';
$_['error_reporting_02'] = 'Log errors is';
$_['error_reporting_03'] = 'Error reporting is set to';
$_['error_reporting_04'] = 'Showing error types';
$_['error_reporting_05'] = 'Unexpected early output';
$_['error_reporting_06'] = '(nothing, not even white-space, should have been output yet)';
$_['admin_txt_00'] = 'Old Backup Found';
$_['admin_txt_01'] = 'A backup file was created in case of an error during a username or password change. Therefore, it may contain old information and should be deleted if not needed. In any case, it will be automatically overwritten on the next password or username change.';
$_['admin_txt_02'] = 'General Information';
$_['admin_txt_14'] = 'For a small improvement to security, change the default salt and/or method used by OneFileCMS to hash the password (and keep them secret, of course). Every little bit helps...';
$_['admin_txt_16'] = 'OneFileCMS can not be used to edit itself directly.  However, you can make a copy and edit it.'; //## NT ## Changed wording in 3.5.07
$_['pw_current'] = 'Current Password';
$_['pw_change']  = 'Change Password';
$_['pw_new']     = 'New Password';
$_['pw_confirm'] = 'Confirm New Password';
$_['un_change']  = 'Change Username';
$_['un_new']     = 'New Username';
$_['un_confirm'] = 'Confirm New Username';
$_['pw_txt_02'] = 'Password / Username rules:';
$_['pw_txt_04'] = 'Case-sensitive: "A" =/= "a"';
$_['pw_txt_06'] = 'Must contain at least one non-space character.';
$_['pw_txt_08'] = 'May contain spaces in the middle. Ex: "This is a password or username!"';
$_['pw_txt_10'] = 'Leading and trailing spaces are ignored.';
$_['pw_txt_12'] = 'In recording the change, only one file is updated: either the active copy of OneFileCMS, or - if specified, an external configuration file.';
$_['pw_txt_14'] = 'If an incorrect current password is entered, you will be logged out, but you may log back in.';
$_['change_pw_01'] = 'Password changed!';
$_['change_pw_02'] = 'Password NOT changed.';
$_['change_pw_03'] = 'Incorrect current password. Login to try again.';
$_['change_pw_04'] = '"New" and "Confirm New" values do not match.';
$_['change_pw_05'] = 'Updating';
$_['change_pw_06'] = 'external config file';
$_['change_pw_07'] = 'All fields are required.';
$_['change_un_01'] = 'Username changed!';
$_['change_un_02'] = 'Username NOT changed.';
$_['update_failed'] = 'Update failed - could not save file.';
$_['mcd_msg_01'] = 'file(s) and/or folder(s) moved.'; //#####
$_['mcd_msg_02'] = 'file(s) and/or folder(s) copied.'; //#####
$_['mcd_msg_03'] = 'file(s) and/or folder(s) deleted.'; //#####
}//end Default_Language() //****************************************************




function validate_units($cssvalue) {//******************************************
	//Determine if valid units are set for $cssvalue:  px, pt, em, or %.
	$main_units   = mb_substr($cssvalue, -2); 
	if ( ($main_units != "px") && ($main_units != "pt") && ($main_units != "em") && (mb_substr($cssvalue, -1) != '%')) {
		$cssvalue = ($cssvalue * 1).'px';   //If not, assume px.
	}
	return $cssvalue;
}//end validate_units() //******************************************************




function hsc($input) {//********************************************************
	$enc = mb_detect_encoding($input); //It should always be UTF-8 (or ASCII), but, just in case...
	if ($enc == 'ASCII') {$enc = 'UTF-8';} //htmlspecialchars() doesn't recognize "ASCII"
	return htmlspecialchars($input, ENT_QUOTES, $enc);
}//end hsc() //*****************************************************************




function Convert_encoding($string, $to_enc = "") {//****************************
	global $ENC_OS;
								  //mb_convert_encoding($string, $to_enc, $from_enc)
	if ($to_enc == 'UTF-8') {return mb_convert_encoding($string, 'UTF-8', $ENC_OS);} // Convert to UTF-8
	else  /* default */		{return mb_convert_encoding($string, $ENC_OS, 'UTF-8');} // Convert to server's/OS's filesystem enc
}//end Convert_encoding() //****************************************************




function Session_Startup() {//**************************************************
	global $SESSION_NAME, $page, $VALID_POST;

	$limit    =  0; //0 = session.
	$path     = '';
	$domain   = ''; // '' = hostname
	$https    = false;
	$httponly = true; //true = unaccessable via javascript. Some XSS protection.
	session_set_cookie_params($limit, $path, $domain, $https, $httponly);

	session_name($SESSION_NAME);
	session_start();

	//Set initial defaults...
	$page = 'login';
	$VALID_POST = 0;
	if ( !isset($_SESSION['valid']) ) { $_SESSION['valid'] = 0; }

	//Logging in?
	if ( isset($_POST['username']) && isset($_POST['password']) ) { Login_response(); }

	session_regenerate_id(true); //Helps prevent session fixation & hijacking.

	if ( $_SESSION['valid'] ) { Verify_IDLE_POST_etc(); }

	$_SESSION['nuonce'] = sha1(mt_rand().microtime()); //provided in <forms> to verify POST
}//end Session_Startup() //*****************************************************




function Verify_IDLE_POST_etc() {//*********************************************
	global $_, $page, $EX, $MESSAGE, $VALID_POST, $MAX_IDLE_TIME;

	//Verify consistant user agent. This is set during login. (every little bit helps every little bit)
	if ( !isset($_SESSION['user_agent']) || ($_SESSION['user_agent'] != $_SERVER['HTTP_USER_AGENT']) ) { Logout(); }

	//Check idle time
 	if ( isset($_SESSION['last_active_time']) ) {
		$idle_time = ( time() - $_SESSION['last_active_time'] );
		if ( $idle_time > $MAX_IDLE_TIME ) {
			Logout();
			$MESSAGE .= hsc($_['verify_msg_01']).'<br>';
			return;
		}
	}

	$_SESSION['last_active_time'] = time();

	//If POSTing, verify...
	if ( isset($_POST['nuonce']) ) {
		if ( $_POST['nuonce'] == $_SESSION['nuonce'] ) {
			$VALID_POST = 1;
		}else{ //If it exists but doesn't match - something's wrong. Probably a page reload.
			$page  = "index";
			$_POST = "";
			$MESSAGE .= $EX.'<b>'.hsc($_['verify_msg_02']).'</b><br>';
		}
	}
}//end Verify_IDLE_POST_etc() //************************************************




function hashit($key,$pre = false) {//******************************************
	//This is the super-secret stuff - Keep it secret, keep it safe!
	//If you change anything here, or the $SALT, manually update the hash for your password from the Generate Hash page.
	global $SALT, $PRE_ITERATIONS;
	$hash = trim($key); // trim off leading & trailing whitespace.

	//Generally, the "pre-hash" is done client-side during a login attempt, or when changing p/w or u/n.
	//However, if generating a hash from the Hash_Page(), do the "pre-hash" now.
	if ($pre) { for ( $x=0; $x < $PRE_ITERATIONS; $x++ ) {$hash = hash('sha256', $hash.$SALT);}  }

	for ( $x=0; $x < 10001; $x++ ) { $hash = hash('sha256', $hash.$SALT); }
	return $hash;
}//end hashit() //**************************************************************




function Error_reporting_status_and_early_output($show_status = 0, $show_types = 0) {//
//Display the status of error_reporting(), and ini_get() of display_errors & log_errors.
//Also displays any early output caught by ob_start().
	global $_, $early_output;

	$E_level = error_reporting();
	$E_types = '';
	$spc = ' &nbsp; '; // or '<br>' or PHP_EOL or whatever...
	if ( $E_level &     1 ) { $E_types .= 'E_ERROR'            .$spc; }
	if ( $E_level &     2 ) { $E_types .= 'E_WARNING'          .$spc; }
	if ( $E_level &     4 ) { $E_types .= 'E_PARSE'            .$spc; }
	if ( $E_level &     8 ) { $E_types .= 'E_NOTICE'           .$spc; }
	if ( $E_level &    16 ) { $E_types .= 'E_CORE_ERROR'       .$spc; }
	if ( $E_level &    32 ) { $E_types .= 'E_CORE_WARNING'     .$spc; }
	if ( $E_level &    64 ) { $E_types .= 'E_COMPILE_ERROR'    .$spc; }
	if ( $E_level &   128 ) { $E_types .= 'E_COMPILE_WARNING'  .$spc; }
	if ( $E_level &   256 ) { $E_types .= 'E_USER_ERROR'       .$spc; }
	if ( $E_level &   512 ) { $E_types .= 'E_USER_WARNING'     .$spc; }
	if ( $E_level &  1024 ) { $E_types .= 'E_USER_NOTICE'      .$spc; }
	if ( $E_level &  2048 ) { $E_types .= 'E_STRICT'           .$spc; }
	if ( $E_level &  4096 ) { $E_types .= 'E_RECOVERABLE_ERROR'.$spc; }
	if ( $E_level &  8192 ) { $E_types .= 'E_DEPRECATED'       .$spc; }
	if ( $E_level & 16384 ) { $E_types .= 'E_USER_DEPRECATED'  .$spc; }

	if ( $show_status && ( (error_reporting() !=  0) ||
						   (ini_get('display_errors') == 'on') ||
						   (ini_get('log_errors') == 'on') ) )
	{
?>		<style>
		.E_box {margin: 0;	 background-color: #F00; font-size: 1em; color: white;
				padding: 2px 5px 2px 5px; border: 1px solid white; }
		</style>
<?php
		echo '<p class="E_box"><b>PHP '.PHP_VERSION.$spc;
		echo hsc($_['error_reporting_01']).': '.ini_get('display_errors').'.'.$spc;
		echo hsc($_['error_reporting_02']).': '.ini_get('log_errors')    .'.'.$spc;
		echo hsc($_['error_reporting_03']).': '.error_reporting()        .'.'.$spc;
		echo 'E_ALL = '.E_ALL.$spc.'</b>';
		
		if ($show_types) {
			echo '<br><b>'.hsc($_['error_reporting_04']).': </b>';
			echo '<span style="font: 400 .8em arial">'.$E_types.'</span>';
		}
		echo '</p>';
	}//end if (error reporting on)

	//$early_output is contents of ob_get_clean(), just before page output.
	if (mb_strlen($early_output) > 0 ) {
		echo '<pre style="background-color: #F00; border: 0px solid #F00;"><b>';
		echo hsc($_['error_reporting_05']).'</b> ';
		echo hsc($_['error_reporting_06']).'<b>:</b> ';
		echo '<span style="background-color: white; border: 1px solid white">';
		echo hsc($early_output).'</span></pre>';
	}
}//end Error_reporting_status_and_early_output() //*****************************




function Update_Recent_Pages() {//**********************************************
	global $page;

	if (!isset($_SESSION['recent_pages'])) { $_SESSION['recent_pages'] = array($page); }

	$pages = count($_SESSION['recent_pages']);

	//Only update if actually a new page
	if ( $page != $_SESSION['recent_pages'][0] ) {
		array_unshift($_SESSION['recent_pages'], $page);
		$pages = count($_SESSION['recent_pages']);
	}

	//Only need 3 most recent pages (increase if needed)
	if ($pages > 3) { array_pop($_SESSION['recent_pages']); }

}//end Update_Recent_Pages() //*************************************************




function undo_magic_quotes() {//************************************************

	function strip_array($var) {
		//stripslashes() also handles cases when magic_quotes_sybase is on. 
		if (is_array($var)) {return array_map("strip_array", $var); }
		else                {return stripslashes($var); }
	}//end strip_array()

	if (get_magic_quotes_gpc()) {
		if (isset($_GET))    { $_GET     = strip_array($_GET);    }
		if (isset($_POST))   { $_POST    = strip_array($_POST);   }
		if (isset($_COOKIE)) { $_COOKIE  = strip_array($_COOKIE); }
	}
}//end undo_magic_quotes() //***************************************************




function Validate_params() {//**************************************************
	global $_, $ipath, $filename, $page, $param1, $param2, $param3, $IS_OFCMS, $EX, $MESSAGE;

	//Pages that require a valid $filename
	$file_pages = array("edit", "renamefile", "copyfile", "deletefile");

	//Make sure $filename & $page go together
	if ( ($filename != "") && !in_array($page, $file_pages) ) { $filename = "";  }
	if ( ($filename == "") &&  in_array($page, $file_pages) ) { $page = "index"; }

	//Init $param's used in <a> href's & <form> actions
	$param1 = '?i='.URLencode_path($ipath); //$param1 must not be blank.
	if ($filename == "") { $param2 = ""; } else { $param2 = '&amp;f='.rawurlencode(basename($filename)); }
	if ($page == ""    ) { $param3 = ""; } else { $param3 = '&amp;p='.$page; }

	//Used to restrict edit/del/etc. on active copy of OneFileCMS.
	$IS_OFCMS = 0;
	if ($filename == trim($_SERVER['SCRIPT_NAME'], '/')) { $IS_OFCMS = true; }

}//end Validate_params() //*****************************************************




function Valid_Path($path, $gotoroot=true) {//**********************************
	//$gotoroot: if true, return to index page of $ACCESS_ROOT.
	global  $ipath, $ipath_OS, $filename, $param1, $param2, $param3, $ACCESS_ROOT, $ACCESS_ROOT_len, $MESSAGE;

	//Limit access to the folder $ACCESS_ROOT:
	//$ACCESS_ROOT = some/root/path/
	//$path        = some/root/path/...(or deeper)   : good
	//$path        = some/root/                      : bad
	//$path        = some/other/path/                : bad

	$path_len     = mb_strlen($path);

	$path_root    = mb_substr($path, 0, $ACCESS_ROOT_len);

	$good_path = false;

	if (isset($_SESSION['admin_page']) && $_SESSION['admin_page']) {
		//Permit Admin actions: changing p/w, u/n, viewing OneFile...
		$ACCESS_ROOT == '';
		return true;
	}
	elseif ( $path_len <  $ACCESS_ROOT_len ) { $good_path = false; }
	else                                     { $good_path = ($path_root == $ACCESS_ROOT); }

	if (!$good_path && $gotoroot) {
		$ipath    = $ACCESS_ROOT;
		$ipath_OS = Convert_encoding($ipath);
		$filename = '';
		//$page     = 'index';  //#### If set to index here, can't logout.
		$param1   = '?i='.$ipath;
		$param2   = '';
		$param3   = '';
		$_GET     = '';
		$_POST    = '';
	}

	return $good_path;
}//end Valid_Path() //**********************************************************




function Get_GET() {//**** Get URL passed parameters ***************************
	global $_, $ipath, $ipath_OS, $filename, $filename_OS, $page, $VALID_PAGES, $EX, $MESSAGE;
	// i=some/path/,  f=somefile.xyz,          p=somepage,  m=somemessage
	// $ipath = i  ,  $filename = $ipath.f  ,  $page = p ,  $MESSAGE
	//   (NOTE: in some functions $filename = just the file's name, ie: $_GET['f'], with no path/)
	//#####  (Normalize $filename program-wide??)
	// Perform initial, basic, validation.
	// Get_GET() should not be called unless $_SESSION['valid'] == 1 (or true)

	//Initialize & validate $ipath
	$ipath = $ipath_OS = "";
	if (isset($_GET["i"])) {
		$ipath = Check_path($_GET["i"],1);
		$ipath_OS = Convert_encoding($ipath);
		if ( $ipath === false || !is_dir($ipath_OS)) { $ipath = $ipath_OS = ''; }
	}

	//Initialize & validate $filename
	if (isset($_GET["f"])) { $filename = $ipath.$_GET["f"]; } else { $filename = ""; }

	$filename_OS = Convert_encoding($filename);
	if ( ($filename != "") && !is_file($filename_OS)  ) {
		$MESSAGE .= $EX.'<b>'.hsc($_['get_get_msg_01']).'</b> ';
		$MESSAGE .= hsc(dir_name($filename)).'<b>'.hsc(basename($filename)).'</b><br>';
		$filename = $filename_OS = "";
	}

	//Initialize & validate $page
	if (isset($_GET["p"])) { $page = $_GET["p"]; } else { $page = "index"; }
	if (!in_array($page, $VALID_PAGES)) {
		$MESSAGE .= $EX.hsc($_['get_get_msg_02']).' <b>'.hsc($page).'</b><br>';
		$page = "index";  //If invalid $_GET["p"]
	}

	//Sanitize any message. Initialized on line 1 / top of this file.
	if (isset($_GET["m"])) { $MESSAGE .= hsc($_GET["m"]); }
}//end Get_GET() //*************************************************************




function Verify_Page_Conditions() {//*******************************************
	global $_, $ONESCRIPT_file, $ipath, $ipath_OS, $param1, $filename, $filename_OS, $page, $EX, $MESSAGE, 
			$VALID_POST, $IS_OFCMS;

	//If exited admin pages, restore $ipath 
	if    ( ($page == "index") && $_SESSION['admin_page'] ) {
		//...unless clicked www/some/path/ from edit or copy page while in admin pages.
		if ( ($_SESSION['recent_pages'][0] != 'edit') && ($_SESSION['recent_pages'][0] != 'copyfile') ){
			$ipath = $_SESSION['admin_ipath'];
			$param1 = '?i='.URLencode_path($ipath);
		}
		$_SESSION['admin_page']  = false;
		$_SESSION['admin_ipath'] = '';
	}
	//Don't load login screen when already in a valid session.
	//$_SESSION['valid'] may be false after Respond_to_POST()
	elseif ( ($page == "login") && $_SESSION['valid'] ) { $page = "index"; }
		
	elseif ( $page == "logout" ) {
		Logout();
		$MESSAGE .= hsc($_['logout_msg']);
	}
	//Don't load rename or delete folder pages at webroot.
	elseif ( ($page == "deletefolder" || $page == "renamefolder") && ($ipath == "") ) {
		$page = "index";
	}
	//Prep MCD_Page() to delete a single folder selected via (x) icon on index page.
	elseif ($page == "deletefolder") {
		$_POST['files'][1]  = basename($ipath); //Must precede next line (change of $ipath).
		$ipath    = dir_name($ipath);
		$ipath_OS = Convert_encoding($ipath);
		$param1 = '?i='.$ipath;
	}
	//There must be at least one 'file', and 'mcdaction' must = "move", "copy", or "delete"
	elseif ($page == "mcdaction") {
		if     (!isset($_POST['mcdaction'] )) { $page = "index"; }
		elseif (!isset($_POST['files']) )     { $page = "index"; }
		elseif ( ($_POST['mcdaction'] != "move") && ($_POST['mcdaction'] != "copy") && ($_POST['mcdaction'] != "delete") ) {
			$page = "index";
		}
	}
	//if size of $_POST > post_max_size, PHP only returns empty $_POST & $_FILE arrays.
	elseif ( ($page == "uploaded") && !$VALID_POST ) {
		$MESSAGE .= $EX.'<b> '.hsc($_['upload_error_01a']).' '.ini_get('post_max_size').'</b> '.hsc($_['upload_error_01b']).'<br>';
		$page = "index";
	}

	//[View Raw] file contents in a browser window (in plain text, NOT HTML).
	if ($page == "raw_view"){
		ob_start();
		$raw_contents = file_get_contents($filename_OS);
		$file_ENC = mb_detect_encoding($raw_contents); //ASCII, UTF-8, etc...
		header('Content-type: text/plain; charset=utf-8');
		echo mb_convert_encoding($raw_contents, 'UTF-8', $file_ENC);
		die;
	}
}//end Verify_Page_Conditions() //**********************************************




function has_invalid_char($string) {//******************************************
	global $INVALID_CHARS;
	$INVALID_CHARS_array = explode(' ', $INVALID_CHARS);
	foreach ($INVALID_CHARS_array as $bad_char) {
		if (mb_strpos($string, $bad_char) !== false) { return true; }
	}
	return false;
}//end has_invalid_char() //****************************************************




function URLencode_path($path){ // don't encode the forward slashes ************
	$path = str_replace('\\','/',$path);   //Make sure all forward slashes.
	$TS = '';  // Trailing Slash/
	if (mb_substr($path, -1) == '/' ) { $TS = '/'; } //start with a $TS?
	$path_array = explode('/',$path);
	$path = "";
	foreach ($path_array as $level) { $path .= rawurlencode($level).'/'; }
	$path = rtrim($path,'/').$TS;  //end with $TS only if started with one
	return $path;
}//end URLencode_path() //******************************************************




function dir_name($path) {//****************************************************
	//Modified dirname().
	$parent = dirname($path);
	if ($parent == "." || $parent == "/" || $parent == '\\' || $parent == "") { return ""; }
	else { return $parent.'/'; }
}//end dir_name() //************************************************************




function Check_path($path, $show_msg = false) {//*******************************
	// check for invalid characters & "dot" or "dot dot" path segments.
	// Does NOT check if exists - only if of valid construction.
	global  $_, $MESSAGE, $EX, $INVALID_CHARS, $WHSPC_SLASH;

	$path = str_replace('\\','/',$path);   //Make sure all forward slashes.
	$path = trim($path, $WHSPC_SLASH);     // trim whitespace & slashes

	if ( ($path == "") || ($path == ".") ){ return ""; } // At root.

	$err_msg = "";
	$errors  = 0;

	$pathparts = explode( '/', $path);

	foreach ($pathparts as $part) {
		
		//Check for any '.' and '..' parts of the path to protect directories outside webroot.
		//They also cause issues in <h2>www / current / path /</h2>
		if ( ($part == '.') || ($part == '..') ) {
			$err_msg .= $EX.' <b>'.hsc($_['check_path_msg_02']).'</b><br>';
			$errors++;
			break;
		}
		
		//Check for invalid characters
		$invalid_chars = str_replace(' /','',$INVALID_CHARS); //The forward slash is not present, or invalid, at this point.
		if ( has_invalid_char($part) ) {
			$err_msg .= $EX.' <b>'.hsc($_['check_path_msg_03']).' &nbsp; <span class="mono"> '.$invalid_chars.'</span></b><br>';
			$errors++;
			break;
		}
	}

	if ($errors > 0) {
		if ($show_msg) { $MESSAGE .= $err_msg; }
		return false;
	}

	return $path.'/';
}//end Check_path() //**********************************************************




function Sort_Seperate($path, $full_list) {//***********************************
	//Sort list, then seperate folders & files

	natcasesort($full_list);
	$files= array();
	$folders= array();
	$F=1; $D=1;  //indexes
	foreach ( $full_list as $item ) {
		if ( ($item == '.') || ($item == '..') || ($item == "")){ continue; }
		$fullpath_OS = Convert_encoding($path.$item);
		if (is_dir($fullpath_OS)) { $folders[$D++] = $item; }
		else                      { $files[$F++]   = $item; }
	}

	return array_merge($folders, $files);
}//end Sort_Seperate() //*******************************************************




function add_serial_num($filename, &$msg) {//***********************************
	//if file_exists(file.txt), add serial# to filename until it doesn't
	//ie: file.txt.001,  file.txt.002, file.txt.003  etc...
	global $_, $EX;

	$ordinal   = 0;

	//Convert $filename to server's File Syetem encoding
	$savefile    = $filename;
	$savefile_OS = Convert_encoding($savefile);

	if (file_exists($savefile_OS)) {
		
		$msg .= $EX.hsc($_['ord_msg_01']).'<br>';
		
		while (file_exists($savefile_OS)) {
			$ordinal = sprintf("%03d", ++$ordinal); //  001, 002, 003, etc...
			$savefile = $filename.'.'.$ordinal;
			$savefile_OS = Convert_encoding($savefile);
		}
		$msg .= '<b>'.hsc($_['ord_msg_02']).':</b> <span class="filename">'.hsc(basename($savefile)).'</span>';
	}
	return $savefile;
}//end add_serial_num() //******************************************************




function supports_svg() {//*****************************************************
	//IE < 9 is the only browser checked for currently.
	//EX: Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0)
	$USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	$pos_MSIE   = mb_strpos($USER_AGENT, 'MSIE ');
	$old_ie     = false;
	if ($pos_MSIE !== false) {
		$ie_ver = mb_substr($USER_AGENT, ($pos_MSIE+5), 1);
		$old_ie = ( $ie_ver < 9 );
	}
	return !$old_ie;
}//end supports_svg() //********************************************************




function rCopy( $old_path, $new_path ) {//**************************************
	global $_, $WHSPC_SLASH, $EX, $MESSAGE;
	//Recursively copy $old_path to $new_path
	//Both $old_ & $new_path must ALREADY be in OS/file system's encoding.
	//(ie: usually UTF-8, but often ISO-8859-1 for Windows.)
	//Return number of successful copy's + mkdir's, or 0 on error.

	//$old_path & $new_path must already be in OS/filesystem's file name encoding

	//Avoid a bottomless pit of sub-directories:
	//    ok: copy root/1/ to root/1/Copy_of_1/
	//NOT OK: copy root/1/ to root/1/2/Copy_of_1/
	//

	$error_code = 0;

	//First, trim / and white-space that will mess up strlen() check.
	$old_path = trim($old_path,$WHSPC_SLASH);
	$new_path = trim($new_path,$WHSPC_SLASH);
	//
	$test_path = dirname($new_path);
	while (mb_strlen($test_path) >= mb_strlen($old_path)) {
		$test_path = dirname($test_path);
		if ( $test_path == $old_path ) {
			$MESSAGE .= $EX.' <b>'.hsc($_['rCopy_msg_01']).'</b><br>';
			return 0;
		}
	}

	if ( is_file($old_path) ) { return (copy($old_path, $new_path)*1); }

	if ( is_dir($old_path) )  {
		
		$dir_list = scandir($old_path); //MUST come before mkdir().
		$error_code = (mkdir($new_path, 0755)*1);
		
		if ( sizeof($dir_list) > 0 ) {
			foreach ( $dir_list as $file ) {
				if ( $file == "." || $file == ".." ) { continue; }
				
				$error_code += rCopy( $old_path.'/'.$file, $new_path.'/'.$file);
			}
		}
		return $error_code;
	}

	return 0; //$old_path doesn't exist, or, I don't know what it is.
}//end rCopy() //***************************************************************




function rDel($path) {//********************************************************
	//Recursively delete $path & all sub-folders & files.
	//Returns number of successful unlinks & rmdirs.

	$path = trim($path, '/'); //Protect against deleting files outside of webroot.
	if ($path == "") { $path = '.'; }

	$path_OS = Convert_encoding($path);

	$count = 0;

	if ( is_file($path_OS) ) { return (unlink($path_OS)*1); }
	if ( is_dir($path_OS) ) {
		
		$dir_list = scandir($path_OS);
		foreach ( $dir_list as $dir_item ) {
			$dir_item_OS = Convert_encoding($dir_item);
			if ( ($dir_item == '.') || ($dir_item =='..') ) {continue;}
			$count += rDel($path.'/'.$dir_item);
		}
		
		$count += rmdir($path_OS);
		return $count;
	}
	return false; //$path doesn't exists, or, I don't know what it is...
}//end rDel() //****************************************************************




function Current_Path_Header() {//**********************************************
 	// Current path. ie: webroot/current/path/
	// Each level is a link to that level.
	global $ONESCRIPT, $ipath, $WEB_ROOT, $ACCESS_ROOT, $ACCESS_ROOT_len, $TABINDEX, $MESSAGE;

	$unaccessable    = '';
	$_1st_accessable = trim($WEB_ROOT, ' /');
	$remaining_path  = trim(mb_substr($ipath, $ACCESS_ROOT_len), ' /');	

	if ($ACCESS_ROOT != '') {
		$unaccessable    = dirname($ACCESS_ROOT);
		$_1st_accessable = basename($ACCESS_ROOT);
		
		if ($unaccessable == '.') { $unaccessable = $WEB_ROOT; }
		else { $unaccessable = $WEB_ROOT.dirname($ACCESS_ROOT).'/'; }
		$unaccessable = '&nbsp;'.hsc(trim(str_replace('/', ' / ',$unaccessable)));
	}

	echo '<h2 id="path_header">';
		//Root (or $ACCESS_ROOT) folder of web site.
		$p1 = '?i='.URLencode_path($ACCESS_ROOT);
		echo $unaccessable.'<a id=path_0 tabindex='.$TABINDEX++.' href="'.$ONESCRIPT.$p1.'" class="path">'.hsc($_1st_accessable).'</a>/';
		$x=0; //need here for focus() in case at webroot.

		if ($remaining_path != "" ) { //if not at root, show the rest
			$path_levels  = explode("/",trim($remaining_path,'/') );
			$levels = count($path_levels); //If levels=3, indexes = 0, 1, 2  etc...
			$current_path = "";
			
			for ($x=0; $x < $levels; $x++) {
				$current_path .= $path_levels[$x].'/';
				$p1 = '?i='.URLencode_path($ACCESS_ROOT.$current_path);
				echo '<a id="path_'.($x+1).'" tabindex='.$TABINDEX++.' href="'.$ONESCRIPT.$p1.'" class="path">';
				echo hsc($path_levels[$x]).'</a>/';
			}
		}//end if(not at root)
	echo '</h2>';
}//end Current_Path_Header() //*************************************************




function Page_Header() {//******************************************************
	global  $_, $DOC_ROOT, $ONESCRIPT, $page, $WEBSITE, $MAIN_TITLE, $OFCMS_version, $FAVICON, $TABINDEX, $MESSAGE;

	$TABINDEX = 1; //Initial tabindex

	$favicon_img = '';
	if (file_exists($DOC_ROOT.trim($FAVICON,'/'))) {
		$favicon_img =  '<img src="/'.URLencode_path($FAVICON).'" alt="">';
	}

	echo '<div id="header">';
		echo '<a href="'.$ONESCRIPT.'" id="logo" tabindex='.$TABINDEX++.'>'.hsc($MAIN_TITLE).'</a> '.$OFCMS_version.' ';
		
		$on_php = '('.hsc($_['on']).'&nbsp;php&nbsp;'.phpversion().')';
		if ($_SESSION["valid"]) { $on_php = '<a id=on_php tabindex='.$TABINDEX++.' href="'.$ONESCRIPT.'?p=phpinfo'.'" target=_blank>'.$on_php.'</a>';}
		echo $on_php;
		
		echo '<div class="nav">';
			echo '<b><a id=website href="./" tabindex='.$TABINDEX++.' target="_blank">'.$favicon_img.' '.hsc($WEBSITE).'</a></b>';
			if ($page != "login") {	echo ' | <a id=logout tabindex='.$TABINDEX++.' href="'.$ONESCRIPT.'?p=logout">'.hsc($_['Log_Out']).'</a>'; }
		echo '</div><div class=clear></div>';
	echo '</div>';//<!-- end header -->
}//end Page_Header() //*********************************************************




function Cancel_Submit_Buttons($submit_label) {//*******************************
	//$submit_label = Rename, Copy, Delete, etc...
	global $_, $ONESCRIPT, $ipath, $param1, $param2, $page;

	$params = $param1.$param2.'&amp;p='. $_SESSION['recent_pages'][1]; //.'&amp;m='.hsc($_['cancelled']) not sure I like this.
?>
	<p>
	<button type="button" class="button" id="cancel" onclick="parent.location = '<?php echo $ONESCRIPT.$params ?>'">
		<?php echo hsc($_['Cancel']) ?></button>
	<button type="submit" class="button" id="submitty" style="margin-left: 1em;"><?php echo hsc($submit_label);?></button>
	<script>document.getElementById("cancel").focus();</script>
<?php
}//end Cancel_Submit_Buttons() //***********************************************




function show_image() {//*******************************************************
	global $_, $filename, $MAX_IMG_W, $MAX_IMG_H;

	$IMG = $filename;
	$img_info = getimagesize($IMG);

	$W=0; $H=1; //indexes for $img_info[]
	$SCALE = 1; $SCALE_W = 1; $SCALE_H = 1;
	if ($img_info[$W] > $MAX_IMG_W) { $SCALE_W = ( $MAX_IMG_W/$img_info[$W] );}
	if ($img_info[$H] > $MAX_IMG_H) { $SCALE_H = ( $MAX_IMG_H/$img_info[$H] );}

	//Set $SCALE to the more restrictive scale.
	if   ( $SCALE_W > $SCALE_H ) { $SCALE = $SCALE_H; } //ex: if (.90 > .50)
	else                         { $SCALE = $SCALE_W; } //If _H >= _W, or both are 1

	//For languages with longer words that don't fit next to [Wide] & [Close] buttons.
	if ($_['image_info_pos']){ echo '<div class=clear></div>'."\n"; }

	echo '<p class="image_info">';
	echo hsc($_['show_img_msg_01']).round($SCALE*100).
		 hsc($_['show_img_msg_02']).' '.$img_info[0].' x '.$img_info[1].').</p>';
	echo '<div class=clear></div>'."\n";
	echo '<a  href="./'.URLencode_path($IMG).'" target="_blank">'."\n";
	echo '<img src="./'.URLencode_path($IMG).'" width="'.($img_info[$W] * $SCALE).'"></a>'."\n";
}//end show_image() //**********************************************************




function Timeout_Timer($COUNT, $ID, $ACTION="") {//*****************************
	global $DELAY_Start_Countdown;

	return '<script>setTimeout(\'Start_Countdown('.$COUNT.',"'.$ID.'","'.$ACTION.'")\','.$DELAY_Start_Countdown.');</script>';

}//end Timeout_Timer() //*******************************************************




function Init_Macros() {//**** ($varibale="some reusable chunk of code")********
	global 	$_, $ONESCRIPT, $param1, $param2, $INPUT_NUONCE, $FORM_COMMON, $PWUN_RULES;

	$INPUT_NUONCE = '<input type="hidden" name="nuonce" value="'.$_SESSION['nuonce'].'">'."\n";
	$FORM_COMMON = '<form method="post" action="'.$ONESCRIPT.$param1.$param2.'">'.$INPUT_NUONCE."\n";

	$PWUN_RULES  = '<p>'.hsc($_['pw_txt_02']);
	$PWUN_RULES	.= '<ol><li>'.hsc($_['pw_txt_04']).'<li>'.hsc($_['pw_txt_06']);
	$PWUN_RULES .=     '<li>'.hsc($_['pw_txt_10']).'<li>'.hsc($_['pw_txt_08']).'</ol>';
}//end Init_Macros() //*********************************************************




function Init_ICONS() {//********************************************************
	global 	$ICONS;

	//*********************************************************************
	function icon_txt($border='#333', $lines='#000', $fill='#FFF', $extra1="", $extra2=""){
		return '<svg version="1.1" width="14" height="16">'.
		'<rect x = "0" y = "0" width = "14" height = "16" fill="'.$fill.'" stroke="'.$border.'" stroke-width="2" />'.$extra2.
		'<line x1="3" y1="3.5"  x2="11" y2="3.5"  stroke="'.$lines.'" stroke-width=".6"/>'.
		'<line x1="3" y1="6.5"  x2="11" y2="6.5"  stroke="'.$lines.'" stroke-width=".6"/>'.
		'<line x1="3" y1="9.5"  x2="11" y2="9.5"  stroke="'.$lines.'" stroke-width=".6"/>'.
		'<line x1="3" y1="12.5" x2="11" y2="12.5" stroke="'.$lines.'" stroke-width=".6"/>'.$extra1.'</svg>';
	}//end icon_txt() //***************************************************


	function icon_folder($extra = "") {//**********************************
		return '<svg version="1.1" width="18" height="14"><g transform="translate(0,0)">'.
			'<path  d="M0.5, 1  L8,1  L9,2  L9,3  L16.5,3  L17,3.5  L17,13.5  L.5,13.5  L.5,.5" '.
				'fill="#F0CD28" stroke="rgb(200,170,15)" stroke-width="1" />'.
			'<path  d="M1.5, 8  L7, 8  L8.5,6.3  L16,6.3  L7.5, 6.3   L6.5,7.5  L1.5,7.5" '.
				'fill="transparent" stroke="white" stroke-width="1" />'.
			'<path  d="M1.5,13  L1.5,2  L7.5,2  L8.5,3  L8.5,4  L15.5,4 L16,4.5  L16,13" '.
				'fill="transparent" stroke="white" stroke-width="1" />'.
			$extra.'</g></svg>';
	}//end icon_folder() //************************************************


	//Some common components
	$circle_x = '<circle cx="5" cy="5" r="5" stroke="#D00" stroke-width="1.3" fill="#D00"/>'.
		'<line x1="2.5" y1="2.5" x2="7.5" y2="7.5" stroke="white" stroke-width="1.5"/>'.
		'<line x1="7.5" y1="2.5" x2="2.5" y2="7.5" stroke="white" stroke-width="1.5"/>';

	$circle_plus = '<circle cx="5" cy="5" r="5" stroke="#080" stroke-width="0" fill="#080"/>'.
		'<line x1="2" y1="5" x2="8" y2="5" stroke="white" stroke-width="1.5" />'.
		'<line x1="5" y1="2" x2="5" y2="8" stroke="white" stroke-width="1.5" />';

	$circle_plus_rev = '<circle cx="5" cy="5" r="5" stroke="#080" stroke-width="1.3" fill="white"/>'.
		'<line x1="2" y1="5" x2="8" y2="5" stroke="#080" stroke-width="1.5" />'.
		'<line x1="5" y1="2" x2="5" y2="8" stroke="#080" stroke-width="1.5" />';

	$pencil = '<polygon points="2,0 9,7 7,9 0,2" stroke-width="1" stroke="darkgoldenrod" fill="rgb(246,222,100)"/>'.
		'<path  d="M0,2    L0,0  L2,0"   stroke="tan"    stroke-width="1" fill="tan"/>'.
		'<path  d="M0,1.5  L0,0  L1.5,0" stroke="black"  stroke-width="1.5" fill="transparent"/>'.
		'<line x1="7.3" y1="10"  x2="10" y2="7.3" stroke="silver" stroke-width="1"/>'.
		'<line x1="8.1" y1="10.8"  x2="10.8" y2="8.1"  stroke="red" stroke-width="1"/>';

	$img_0 = '<rect x="0"    y="0"   width="14" height="16" fill="#FF8" stroke="#44F" stroke-width="2"/>'.
		'<rect x="2"    y="2"   width="5"  height="5"  fill="#F66" stroke-width="0" />'.
		'<rect x="7.5"  y="6"   width="5"  height="5"  fill="#6F6" stroke-width="0" />'.
		'<rect x="2"    y="10"  width="5"  height="5"  fill="#66F" stroke-width="0" />';

	$arc_arrow = '<path d="M 3.5,12 a 30,30 0 0,1  9,-9  l -1.5,-2.4  l 6,1.3  l -1.6,6 l -1.5,-2.4'.
					   ' a 30,30 0 0,0 -9,6.5 Z"  fill="white" stroke="blue" stroke-width="1.1" />';

	$up_arrow = '<polygon points="6,0  12,6  8,6  8,11  4,11  4,6  0,6" stroke-width="1" stroke="white" fill="green" />';

	$zero = '<rect x="0"  y="0"  width="3" height="6" fill="transparent" stroke="#555" stroke-width="1" />';
	$one  = '<line x1="0" y1="-.5"   x2="0" y2="6.5"  stroke="#555" stroke-width="1"/>';

	$extra_up  = '<g transform="scale(1.1) translate(1.75,4)">'.$up_arrow.'</g>';
	$extra_new = '<g transform="translate(4,6)">'.$circle_plus.'</g>';
	$extra_z   = '<text x="4" y="12" style="font-size:8pt;font-weight:900;fill:blue ;font-family:Arial;">z</text>';

	//The icons
	$ICONS['bin'] =  '<svg version="1.1" width="14" height="16">'.
		  '<g transform="translate( 0.5,0.5)">'.$one .'</g>'.
		  '<g transform="translate( 3.5,0.5)">'.$zero.'</g>'.'<g transform="translate( 9.5,0.5)">'.$one .'</g>'.
		  '<g transform="translate(12.5,0.5)">'.$one .'</g>'.'<g transform="translate( 0.5,9.5)">'.$zero.'</g>'.
		  '<g transform="translate( 6.5,9.5)">'.$one .'</g>'.'<g transform="translate( 9.5,9.5)">'.$zero.'</g>'.
		  '</svg>';
	$ICONS['z'] = icon_txt('#333','#FFF','#FFF',$extra_z);
	$ICONS['img'] = '<svg version="1.1" width="14" height="16">'.$img_0.'</svg>';
	$ICONS['svg'] = icon_txt('#333', '#444', '#FFF', "", $img_0);
	$ICONS['txt'] = icon_txt('#333', '#000', '#FFF');
	$ICONS['htm'] = icon_txt('#444', '#222', '#FABEAA'); //rgb(250,190,170)
	$ICONS['php'] = icon_txt('#333', '#111', '#C3C3FF'); //rgb(195,195,225)
	$ICONS['css'] = icon_txt('#333', '#111', '#FFE1A5'); //rgb(255,225,165)
	$ICONS['cfg'] = icon_txt('#444', '#111', '#DDD');
	$ICONS['dir']    = icon_folder();
	$ICONS['folder'] = icon_folder();
	$ICONS['folder_new'] = icon_folder('<g transform="translate(7.5,4)">'.$circle_plus.'</g>');
	$ICONS['upload']     = icon_txt('#333', 'black', 'white', $extra_up);
	$ICONS['file_new']   = icon_txt('#444', 'black', 'white', $extra_new);
	$ICONS['ren_mov'] = icon_folder('<g transform="translate(2.5,3)">'.$pencil.'</g>'.$arc_arrow);
	$ICONS['move']    = icon_folder($arc_arrow);
	$ICONS['copy']    = '<svg version="1.1" width="12" height="14"><g transform="translate(1,2)">'.$circle_plus_rev.'</g></svg>';
	$ICONS['delete']  = '<svg version="1.1" width="12" height="14"><g transform="translate(1,2)">'.$circle_x.'</g></svg>';
	$ICONS['up_dir']  = icon_folder('<g transform="scale(1.1) translate(1.75,2) rotate(-45, 5, 5)">'.$up_arrow.'</g>');

	if (!supports_svg()) { //Text "icons" if SVG not supported.  Mostly for IE < 9
		foreach ($ICONS as $key=> $value) { $ICONS[$key] = ""; }
		$ICONS['up_dir']  = '[&lt;]';
		$ICONS['dir']	  = '[+]';
		$ICONS['folder']  = '[+]';
		$ICONS['ren_mov'] = '<span class="RCD1 R">&gt;</span>';
		$ICONS['move']    = '<span class="RCD1 R">&gt;</span>';
		$ICONS['copy']    = '<span class="RCD1 C">+</span>';
		$ICONS['delete']  = '<span class="RCD1 D">x</span>';
	}
}//end Init_ICONS() {//*********************************************************




function List_File($file, $file_url) {//****************************************
	global $_, $ONESCRIPT, $ICONS;

	$file_OS = Convert_encoding($file);
	clearstatcache ();
	$href = $ONESCRIPT.'?i='.dir_name(trim($file_url,'/')).'&amp;f='.basename($file_url);
	$edit_link = '<a href="'.$href.'&amp;p=edit'.'" id="old_backup">'.hsc(basename($file)).'</a>';
?>
	<tr>
	<td><a href="<?php echo $href.'&amp;p=deletefile' ?>" class="button" id="del_backup">
	<?php echo $ICONS['delete'].'&nbsp;'.hsc($_['Delete']) ?></a></td>
	<td class="file_name"><?php echo $edit_link; ?></td>
	<td class="meta_T file_size">&nbsp;	<?php echo number_format(filesize($file_OS)); ?> B	</td>  
	<td class="meta_T file_time"> &nbsp;<script>FileTimeStamp(<?php echo filemtime($file_OS); ?>, 1, 0, 1);</script></td>
	</tr>
<?php
}//end List_File() //***********************************************************




function List_Backups_and_Logs() {//********************************************
	global $_, $ONESCRIPT_backup, $ONESCRIPT_file, $ONESCRIPT_file_backup, 
		   $CONFIG_backup, $CONFIG_FILE_backup, $LOGIN_LOG_url, $LOGIN_LOG_file;

	//Indicate if a login log or backups (from a prior p/w or u/n change) exist.

	$CONFIG_FILE_backup_OS    = Convert_encoding($CONFIG_FILE_backup);
	$ONESCRIPT_file_backup_OS = Convert_encoding($ONESCRIPT_file_backup);
	$LOGIN_LOG_file_OS		  = Convert_encoding($LOGIN_LOG_file);

	clearstatcache ();
	$backup_found = $log_found = false;
	if (is_file($ONESCRIPT_file_backup_OS) || is_file($CONFIG_FILE_backup_OS) ) { $backup_found = true; }
	if (is_file($LOGIN_LOG_file_OS)) { $log_found = true; }

	if ( $backup_found || $log_found ) {
		echo '<table class="index_T">';
		if ($log_found)                         { List_File($LOGIN_LOG_file, $LOGIN_LOG_url); }
		if (is_file($ONESCRIPT_file_backup_OS)) { List_File($ONESCRIPT_file_backup, $ONESCRIPT_backup); }
		if (is_file($CONFIG_FILE_backup_OS))    { List_File($CONFIG_FILE_backup, $CONFIG_backup); }
		echo '</table>';
		
		if ($backup_found) {
			echo '<p style="margin-top: .5em"><b>'.hsc($_['admin_txt_00']).'</b></p>';
			echo '<p>'.hsc($_['admin_txt_01']);
		}
		echo '<hr>';
	}//end of check for backup
}//end List_Backups_and_Logs() //***********************************************




function Admin_Page() {//*******************************************************
	global $_, $ONESCRIPT, $ipath, $filename, $param1, $param2, $MAIN_TITLE;

	// Restore/Preserve $ipath prior to admin page in case OneFileCMS is edited (which would change $ipath).
	if   ( $_SESSION['admin_page'] ) { $ipath  = $_SESSION['admin_ipath'];
									   $param1 = '?i='.URLencode_path($ipath); }
	else { $_SESSION['admin_page']  = true;
		   $_SESSION['admin_ipath'] = $ipath; }

	// [Close] returns to either the index or edit page.
	$params = "";
	if ($filename != "") { $params = $param2.'&amp;p=edit'; }

	$button_attribs = '<button type="button" class="button" onclick="parent.location =\''.$ONESCRIPT;
	$edit_params = '?i='.dir_name($ONESCRIPT).'&amp;f='.basename($ONESCRIPT).'&amp;p=edit';

	echo '<h2>'.hsc($_['Admin_Options']).'</h2>';

	echo '<span class="admin_buttons">';
	echo $button_attribs.$param1.$params.'\'" id="close">'.hsc($_['Close']).'</button>'; 
	echo $button_attribs.$param1.'&amp;p=changepw\'">'.hsc($_['pw_change']).'</button>'; 
	echo $button_attribs.$param1.'&amp;p=changeun\'">'.hsc($_['un_change']).'</button>'; 
	echo $button_attribs.$param1.'&amp;p=hash\'">'.hsc($_['Generate_Hash']).'</button>'; 
	echo $button_attribs.$edit_params.'\'">'.hsc($_['View'].' '.$MAIN_TITLE).'</button>';
	echo '</span>';

	echo '<div class="info">';

	List_Backups_and_Logs();

	echo '<p><b>'.hsc($_['admin_txt_02']).'</b>';
	echo '<p>'   .hsc($_['admin_txt_16']);
	echo '<p>'.hsc($_['admin_txt_14']);
	echo '</div>'; //end class=info

	echo '<script>document.getElementById("close").focus();</script>';
}//end Admin_Page() //**********************************************************




function Hash_Page() {//********************************************************
	global $_, $ONESCRIPT, $param1, $param3, $INPUT_NUONCE, $PWUN_RULES;

	if (!isset($_POST['whattohash'])) { $_POST['whattohash'] = ''; }
?>
	<style>#message_box {font-family: courier; min-height: 3.1em;}</style>

	<h2><?php echo hsc($_['Generate_Hash']) ?></h2>

	<form id="hash" name="hash" method="post" action="<?php echo $ONESCRIPT.$param1.$param3; ?>">
		<?php echo $INPUT_NUONCE; ?>
		<?php echo hsc($_['pass_to_hash']) ?>
		<input type="text" name="whattohash" id="whattohash" value="<?php echo hsc($_POST['whattohash']) ?>">
		<p><?php Cancel_Submit_Buttons($_['Generate_Hash']) ?>
		<script>document.getElementById('whattohash').focus()</script>
	</form>

	<div class="info">
		<p><?php echo hsc($_['hash_txt_01']) ?><br>
		<ol><li><?php echo hsc($_['hash_txt_06']) ?><br>
				<?php echo hsc($_['hash_txt_07']) ?>
			<li><?php echo hsc($_['hash_txt_08']) ?><br>
				<?php echo hsc($_['hash_txt_09']) ?><br>
				<?php echo hsc($_['hash_txt_10']) ?><br>
			<li><?php echo hsc($_['hash_txt_12']) ?>
		</ol>
		<?php echo $PWUN_RULES ?>
	</div>
<?php
}//end Hash_Page() //***********************************************************




function Hash_response() {//****************************************************
	global $_, $MESSAGE;
	$_POST['whattohash'] = trim($_POST['whattohash']); // trim whitespace.

	//Ignore/don't hash an empty string - passwords can't be blank.
	if ($_POST['whattohash'] == "") { return; }

	//The second parameter to hashit(), 1, tells hashit() to also do the "pre-hash", which is
	//normally done client-side during a login attempt, p/w change, or u/n change.
	$MESSAGE .= hsc($_['Password']).': '.hsc($_POST['whattohash']).'<br>';
	$MESSAGE .= hsc($_['Hash']).': '.hashit($_POST['whattohash'], 1).'<br>';
}//end Hash_response() //*******************************************************




//******************************************************************************
function Change_PWUN_Page($pwun, $type, $page_title, $label_new, $label_confirm) {
	//$pwun must = "pw" or "un"
	global $_, $EX, $ONESCRIPT, $param1, $param2, $param3, $INPUT_NUONCE, $PWUN_RULES;

	$params = $param1.$param2.'&amp;p='. $_SESSION['recent_pages'][1];
?>
	<?php //preserve space for message_box even when there's no message. ?>
	<style>#message_box {min-height: 2em;}</style>

	<h2><?php echo hsc($page_title) ?></h2>

	<form id="change" method="post" action="<?php echo $ONESCRIPT.$param1.$param3; ?>">
		<input type="hidden" name="<?php echo $pwun ?>" value="">
		
		<?php echo $INPUT_NUONCE; ?>
		
		<p><?php echo hsc($_['pw_current']) ?><br>
		<input type="password" name="password" id="password" value="">
		
		<p><?php echo hsc($label_new) ?><br>
		<input type="<?php echo $type ?>" name="new1" id="new1" value="">
		
		<p><?php echo hsc($label_confirm) ?><br>
		<input type="<?php echo $type ?>" name="new2" id="new2" value="">
		
		<p><input type="button" class="button" id="cancel" value="<?php echo hsc($_['Cancel']) ?>"
			onclick="parent.location = '<?php echo $ONESCRIPT.$params ?>'">
		<input type="button" class="button"    id="submitty" value="<?php echo hsc($_['Submit']) ?>" style="margin-left: 1em;">
		
		<script>document.getElementById('password').focus()</script>
	</form>

	<div class="info">
	<?php echo $PWUN_RULES ?>
	<p><?php echo hsc($_['pw_txt_12']) ?>
	<p><?php echo hsc($_['pw_txt_14']) ?>
	</div>
<?php
	//Note: The button with id="submitty" above must NOT be of type="submit",
	//NOR have an id="submit", or the event_scripts won't work.
	pwun_event_scripts('change', 'submitty', $pwun); //Doesn't work if an id="submit"
	js_hash_scripts();
}//end Change_PWUN_Page() //****************************************************



 
//******************************************************************************
function Update_config($search_for, $replace_with, $search_file, $backup_file) {
	global  $_, $EX, $MESSAGE;

	$search_file_OS = Convert_encoding($search_file);
	$backup_file_OS = Convert_encoding($backup_file);

	if ( !is_file($search_file_OS) ) {
		$MESSAGE .= $EX.' <b>'.hsc($_['Not_found']).': </b>'.hsc($search_file).'<br>';
		return false;
	}

	//Read file into an array for searching.
	$search_lines = file($search_file_OS, FILE_IGNORE_NEW_LINES);

	//Search start of each $line in (array)$search_lines for (string)$search_for.
	//If match found, replace $line with $replace_with, end search.
	$search_len = mb_strlen($search_for);
	$found = false;
	foreach ($search_lines as $key => $line) {
		if ( mb_substr($line,0,$search_len) == $search_for ) {
			$found = true;
			$search_lines[$key] = $replace_with;
			break 1; //only replace first occurrance of $search_for
		}
	}

	//This should not happen, but just in case...
	if (!$found){ $MESSAGE .= $EX.' <b>'.hsc($_['Not_found']).': </b>'.hsc($search_for).'<br>'; return false; }

	copy($search_file_OS, $backup_file_OS); // Just in case...

	$updated_contents = implode("\n", $search_lines);

	if (file_put_contents($search_file_OS, $updated_contents, LOCK_EX) === false) {
		$MESSAGE .= $EX.'<b>'.hsc($_['update_failed']).'</b><br>';
		return false;
	}else {return true;}
}//end Update_config() //*******************************************************




function Change_PWUN_response($PWUN, $msg) {//**********************************
	//Update $USERNAME or $HASHWORD. Default $page = changepw or changeun
	global $_, $ONESCRIPT, $USERNAME, $HASHWORD, $EX, $MESSAGE, $page, 
		   $ONESCRIPT_file, $ONESCRIPT_file_backup, $CONFIG_FILE, $CONFIG_FILE_backup, $VALID_CONFIG_FILE;

	// trim white-space from input values
	$current_pass = trim($_POST['password']);
	$new_pwun     = trim($_POST['new1']);
	$confirm_pwun = trim($_POST['new2']);

	$error_msg   = $EX.'<b>'.hsc($msg).'</b> ';

	//If all fields are blank, do nothing.
	if ( ($current_pass == "") && ($new_pwun == "") && ($confirm_pwun == "") ) {
		return;
	}
	//If any field is blank...
	elseif ( ($current_pass == "") || ($new_pwun == "") || ($confirm_pwun == "") ) {
		$MESSAGE .= $error_msg.hsc($_['change_pw_07']).'<br>';
	}
	//If new & Confirm values don't match...
	elseif ($new_pwun != $confirm_pwun) {
		$MESSAGE .= $error_msg.hsc($_['change_pw_04']).'<br>';
	}
	//If incorrect current p/w, logout.  (new == confirm at this point)
	elseif (hashit($current_pass) != $HASHWORD) { 
		$MESSAGE .= $error_msg.'<br>'.hsc($_['change_pw_03']).'<br>';
		Logout();
	}
	//Else change username or password
	else {
		if ($PWUN == "pw") {
			$search_for   = '$HASHWORD '; //include space after $HASHWORD
			$replace_with = '$HASHWORD = "'.hashit($new_pwun).'";';
			$success_msg  = '<b>'.hsc($_['change_pw_01']).'</b>';
		}else { //$PWUN = "un"
			$search_for   = '$USERNAME '; //include space after $USERNAME
			$replace_with = '$USERNAME = "'.$new_pwun.'";';
			$success_msg  = '<b>'.hsc($_['change_un_01']).'</b>';
		}
		
		//If specified & it exists, update external config file.
		if ( $VALID_CONFIG_FILE ) {
			$MESSAGE .= hsc($_['change_pw_05']).' '.hsc($_['change_pw_06']).'. . . ';
			$updated = Update_config($search_for, $replace_with, $CONFIG_FILE, $CONFIG_FILE_backup);
		}else{ //Update OneFileCMS
			$MESSAGE .= hsc($_['change_pw_05']).' OneFileCMS . . . ';
			$updated = Update_config($search_for, $replace_with, $ONESCRIPT_file, $ONESCRIPT_file_backup);
		}
		
		if ($updated === false) { $MESSAGE .= $error_msg.'<br>'; }
		else                    { $MESSAGE .= $success_msg.'<br>'; }
		
		$page = "admin"; //Return to Admin page.
	}
}//end Change_PWUN_response() //************************************************




function Logout() {//***********************************************************
	global $page;
	session_regenerate_id(true);
	session_unset();
	session_destroy();
	session_write_close();
	unset($_GET);
	unset($_POST);
	$_SESSION = array();
	$_SESSION['valid'] = 0;
	$page = 'login';
}//end Logout() //**************************************************************




function Login_Page() {//*******************************************************
	global $_, $ONESCRIPT;
?>
	<?php //preserve space for message_box even when there's no message. ?>
	<style>#message_box {height: 3.1em;}</style>

	<h2><?php echo hsc($_['Log_In']) ?></h2>
	<form method="post" id="login_form" name="login_form" action="<?php echo $ONESCRIPT; ?>">
		<label for ="username"><?php echo hsc($_['login_txt_01']) ?></label>
		<input name="username" type="text"     id="username">
		<label for ="password"><?php echo hsc($_['login_txt_02']) ?></label>
		<input name="password" type="password" id="password">
		<input type="button"  class="button"   id="login" value="<?php echo hsc($_['Enter']) ?>">
	</form>
	<script>document.getElementById('username').focus();</script>
<?php
	//Note: The "login" button above must NOT be of type="submit", NOR have an id="submit", or the event_scripts won't work.
	pwun_event_scripts('login_form', 'login');
	js_hash_scripts();
}//end Login_Page() //**********************************************************




function Login_response() {//***************************************************
	global $_, $EX, $ONESCRIPT_file, $MESSAGE, $page, $USERNAME, $HASHWORD,
				$LOGIN_ATTEMPTS, $MAX_ATTEMPTS, $LOGIN_DELAY, $LOGIN_DELAYED, $LOG_LOGINS, $LOGIN_LOG_file;

	$_SESSION = array();    //make sure it's empty
	$_SESSION['valid'] = 0; //Default to failed login.
	$attempts = 0;
	$elapsed  = 0;
	$LOGIN_ATTEMPTS = Convert_encoding($LOGIN_ATTEMPTS); //$LOGIN_ATTEMPTS only used for filesystem access.

	$LOGIN_DELAYED = 0; //used to start Countdown at end of file

	//Check for prior login attempts (but don't increment count just yet)
	if (is_file($LOGIN_ATTEMPTS)) {
		$attempts = (int)file_get_contents($LOGIN_ATTEMPTS);
		$elapsed  = time() - filemtime($LOGIN_ATTEMPTS);
	}
	if ($attempts > 0) { $MESSAGE .= '<b>'.hsc($_['login_msg_01a']).' '.$attempts.' '.hsc($_['login_msg_01b']).'</b><br>'; }

	if ( ($attempts >= $MAX_ATTEMPTS) && ($elapsed < $LOGIN_DELAY) ){
		$LOGIN_DELAYED = ($LOGIN_DELAY - $elapsed);
		$MESSAGE .= hsc($_['login_msg_02a']).' <span id=timer0></span> '.hsc($_['login_msg_02b']);
		return;
	}

	//Trim any incidental whitespace before validating.
	$_POST['password'] = trim($_POST['password']);
	$_POST['username'] = trim($_POST['username']);

	//validate login.
	if ( ($_POST['password'] == "") || ($_POST['username'] == "") )  {
		return; //Ignore login attempt if either username or password is blank.
		
	}elseif ( (hashit($_POST['password']) == $HASHWORD) && ($_POST['username'] == $USERNAME) ) {
		session_regenerate_id(true);
		$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT']; //for user consistancy check.
		$_SESSION['valid'] = 1;
		$page = "index";
		if ( is_file($LOGIN_ATTEMPTS) ) { unlink($LOGIN_ATTEMPTS); } //delete count/file of $LOGIN_ATTEMPTS
		
	}else{
		file_put_contents($LOGIN_ATTEMPTS, ++$attempts); //increment attempts
		$MESSAGE  = $EX.'<b>'.hsc($_['login_msg_03']).$attempts.'</b><br>';
		if ($attempts >= $MAX_ATTEMPTS) {
			$LOGIN_DELAYED = $LOGIN_DELAY;
			$MESSAGE .= hsc($_['login_msg_02a']).' <span id=timer0></span> '.hsc($_['login_msg_02b']);
		}
	}

	//Log login attempts
	if ($LOG_LOGINS) {
		$log_file    = Convert_encoding($LOGIN_LOG_file);
		$pass_fail   = $_SESSION['valid'].' ';
		$timestamp   = date("Y-m-d H:i:s").' ';
		$client_IP   = $_SERVER['REMOTE_ADDR'].' ';
		$client_port = $_SERVER['REMOTE_PORT'].' ';
		$client      = '"'.$_SERVER['HTTP_USER_AGENT'].'"';
		
		file_put_contents($log_file, $pass_fail.$timestamp.$client_IP.$client_port.$client."\n",FILE_APPEND);
	}//
}//end Login_response() //******************************************************




function Create_Table_for_Listing() {//*****************************************
	global$_, $ONEFILECMS, $ipath, $ipath_OS, $DOC_ROOT_OS, $ICONS, $TABINDEX, $ACCESS_ROOT;

	//Header row: | Select All|[ ]|[X](folders first)      Name      (ext) |   Size   |    Date    |

	$new_path = URLencode_path(dir_name($ipath)); //for "../" entry in dir list.
	$new_path_OS = $DOC_ROOT_OS.dir_name($ipath_OS);//.dir_name($ipath_OS);

	//<input hidden> is a dummy input to make sure files[] is always an array for Select_All() & Confirm_Ready().
?>
	<INPUT TYPE=hidden NAME="files[]" VALUE="">

	<?php //RE: $TABINDEX's below
		// In order to have ['Name'] (it's background) expand to fill available space in header,
		// (ext) is float'ed right, but has to be listed first, before ['Name'].
		// However, tabindex's need to be in order as displayed, not in order as listed in source.
	?>

	<table class="index_T">
	<tr>
	<th colspan=3><LABEL for=select_all_ckbox id=select_all_label><?php echo hsc($_['Select_All']) ?></LABEL></th>
	<th><div class=ckbox>
			<INPUT id=select_all_ckbox tabindex=<?php echo $TABINDEX++ ?> TYPE=checkbox NAME=select_all VALUE=select_all>
		</div>
	</th>
	<th class=file_name>
		<div id=ff_ckbox_div class=ckbox>
			<INPUT tabindex=<?php echo $TABINDEX++?> TYPE=checkbox id=folders_first_ckbox NAME=folders_first VALUE=folders_first checked>
		</div>
		<label for=folders_first_ckbox id=folders_first_label title="<?php  echo hsc($_['folders_first_info']) ?>">
			(<?php echo hsc($_['folders_first']) ?>)
		</label>
		<a tabindex=<?php echo ($TABINDEX + 1)?> href="#" id=header_sorttype>(<?php echo hsc($_['ext']) ?>)</a>
		<a tabindex=<?php echo $TABINDEX++?>     href="#" id=header_filename><?php echo hsc($_['Name']) ?></a>
		<?php $TABINDEX++ // ?>
	</th>
	<th class=file_size><a tabindex=<?php echo $TABINDEX++?> href="#" id=header_filesize><?php echo hsc($_['Size']." (".$_['bytes'].")") ?></a></th>
	<th class=file_time><a tabindex=<?php echo $TABINDEX++?> href="#" id=header_filedate><?php echo hsc($_['Date']) ?></a></th>
	</tr>

	<tr><?php // "../" directory entry ?>
		<td colspan=4></td>
		<td>
<?php		if ($ipath == $ACCESS_ROOT) {
				echo '<a id=f0c4 tabindex='.$TABINDEX++.'>&nbsp;</a>';
			}
			else {
				echo '<a id=f0c4 tabindex='.$TABINDEX++.' href="'.$ONEFILECMS.'?i='.$new_path.'">'.$ICONS['up_dir'].' <b>..</b> /</a>'; //#### '.$ICONS['up_dir'].'
			}
?>		</td>
		<td></td>
		<td></td>
	<tr>

	<?php //Directory & footer content will be inserted later. ?>
	<tbody id=DIRECTORY_LISTING></tbody>
	<tr><td id=DIRECTORY_FOOTER colspan=7></td></tr>
	</table>
<?php
}//Create_Table_for_Listing() //************************************************




function Get_DIRECTORY_DATA($raw_list) {//**************************************
	global $_, $ONESCRIPT, $ipath, $ipath_OS, $param1, $ICONS, $MESSAGE, 
			$FTYPES, $FCLASSES, $EXCLUDED_LIST, $STYPES, $SHOWALLFILES, 
			$DIRECTORY_COUNT, $DIRECTORY_DATA, $ENC_OS;

	//Doesn't use global $filename or $filename_OS in this function (because they shouldn't exist on the Index page)
	//$filename below is JUST the file's name.  In other functions, it's the full/path/filename

	$DIRECTORY_COUNT = 0; //final count to exclude . & .., and possibly $excluded file names
	foreach ($raw_list as $raw_filename) { //$raw_list is in server's File System encoding
		
		if ( ($raw_filename == '.') || ($raw_filename == '..') ) {continue;}
		
		$filename_OS = $ipath_OS.$raw_filename; //for is_dir() & file_exists() below
		
		//Normalize filename encoding for general use & display. (UTF-8, which may not be same as the server's File System)
		if ($ENC_OS == 'UTF-8') {$filename = $raw_filename;}
		else                    {$filename = Convert_encoding($raw_filename,'UTF-8');}
		
		//Get file .ext & check against $STYPES (files types to show)
		$filename_parts = explode(".", mb_strtolower($filename));
		
		//Check for no $ext:  "filename"  or ".filename"
		$segments = count($filename_parts);
		if( $segments === 1 || (($segments === 2) && ($filename_parts[0] === "")) ) {
				 $ext =  '';
		} else { $ext = end($filename_parts); }
		
		//Check $filename & $ext against white & black lists. If not to be shown, get next $filename...
		if (!is_dir($filename_OS)) {
			if ($SHOWALLFILES || in_array($ext, $STYPES)) { $SHOWTYPE = TRUE; } else { $SHOWTYPE = FALSE; }
			if (in_array($filename, $EXCLUDED_LIST)) 	  { $excluded = TRUE; } else { $excluded = FALSE; }
			if ( !$SHOWTYPE || in_array($filename, $EXCLUDED_LIST) ) { continue; }
		}
			
		//Used to hide rename & delete options for active copy of OneFileCMS.
		$IS_OFCMS = 0;
		if ( $ipath.$filename == trim($_SERVER['SCRIPT_NAME'], '/') ) { $IS_OFCMS = 1; }
		
		//Set icon type based on if dir, or file type ($ext).
		if (is_dir($filename_OS)) { $type = 'dir'; }
		else					  { $type = $FCLASSES[array_search($ext, $FTYPES)]; }
		
		//Determine icon to show
		if (in_array($type,$FCLASSES)) { $icon = $ICONS[$type];}
		elseif ($type == 'dir')        { $icon = $ICONS['folder']; }
		else                           { $icon = $ICONS['bin']; } //default
			
		//Get file size & date.
		$file_size_raw = filesize($filename_OS);
		$file_time_raw = filemtime($filename_OS);
			
		//Store data
		$DIRECTORY_DATA[$DIRECTORY_COUNT] = array('', '', 0, 0, 0, '');
		$DIRECTORY_DATA[$DIRECTORY_COUNT][0] = $type;  //used to determine icon & f_or_f
		$DIRECTORY_DATA[$DIRECTORY_COUNT][1] = $filename;
		$DIRECTORY_DATA[$DIRECTORY_COUNT][2] = $file_size_raw;
		$DIRECTORY_DATA[$DIRECTORY_COUNT][3] = $file_time_raw;
		$DIRECTORY_DATA[$DIRECTORY_COUNT][4] = $IS_OFCMS; //If = 1, Don't show ren, del, ckbox.
		$DIRECTORY_DATA[$DIRECTORY_COUNT][5] = $ext;
		$DIRECTORY_COUNT++;
	}//end foreach file

	return $DIRECTORY_COUNT;
}//end Get_DIRECTORY_DATA() //**************************************************



 
function Send_directory_data_to_js() {//****************************************
	global $DIRECTORY_DATA, $DIRECTORY_COUNT;
	//"send" DIRECTORY_DATA to javascript.
	$data_for_js = "<script>\n";

	$row = 0; //index after filter of . & ..
	for ($x = 0; $x < $DIRECTORY_COUNT; $x++) {
		$filename = $DIRECTORY_DATA[$x][1];
		if ( ($filename != '.') && ($filename != '..') ) {; // skip . & ..
			$data_for_js .= 'DIRECTORY_DATA['.$row++.'] = [';
			$data_for_js .= '"'  .$DIRECTORY_DATA[$x][0].'"';				// "type"
			$data_for_js .= ', "'.addslashes($DIRECTORY_DATA[$x][1]).'"';	// "file name"
			$data_for_js .= ', ' .$DIRECTORY_DATA[$x][2];					// filesize
			$data_for_js .= ', ' .$DIRECTORY_DATA[$x][3];					// timestamp
			$data_for_js .= ', ' .$DIRECTORY_DATA[$x][4];					// is_ofcms
			$data_for_js .= ', "'.addslashes($DIRECTORY_DATA[$x][5]).'"';	// "ext"
			$data_for_js .= "];\n";
		}//end skip . & ..
	}//end for x

	$data_for_js .= "var DIRECTORY_ITEMS = DIRECTORY_DATA.length;\n";

	$data_for_js .= "</script>\n";
	echo $data_for_js;

}//end Send_directory_data_to_js() {//******************************************




function Index_Page_buttons_top($file_count) {//********************************
	global $_, $ONESCRIPT, $param1, $ICONS, $TABINDEX;

	echo '<div id=index_page_buttons>'."\n";

	echo '<div id=mcd_submit>'."\n";
	if ($file_count > 0) {
		$onclick_m = 'onclick="Confirm_Submit( \'move\');   "';
		$onclick_c = 'onclick="Confirm_Submit( \'copy\');   "';
		$onclick_d = 'onclick="Confirm_Submit( \'delete\' );"';
		echo '<button id=b1 tabindex='.$TABINDEX++.' type=button '.$onclick_m.'>'.$ICONS['move'  ].hsc($_['Move']  )."</button\n>";
		echo '<button id=b2 tabindex='.$TABINDEX++.' type=button '.$onclick_c.'>'.$ICONS['copy'  ].hsc($_['Copy']  )."</button\n>";
		echo '<button id=b3 tabindex='.$TABINDEX++.' type=button '.$onclick_d.'>'.$ICONS['delete'].hsc($_['Delete'])."</button\n>";
	}
	echo '</div>'."\n"; //end mcd_submit

	echo '<div class="front_links">'."\n";
		echo '<a id=b4 tabindex='.$TABINDEX++.' href="'.$ONESCRIPT.$param1.'&amp;p=newfolder">'.$ICONS['folder_new'].hsc($_['New_Folder']) .'</a>';
		echo '<a id=b5 tabindex='.$TABINDEX++.' href="'.$ONESCRIPT.$param1.'&amp;p=newfile">'  .$ICONS['file_new']  .hsc($_['New_File'])   .'</a>';
		echo '<a id=b6 tabindex='.$TABINDEX++.' href="'.$ONESCRIPT.$param1.'&amp;p=upload">'   .$ICONS['upload']    .hsc($_['Upload_File']).'</a>';
	echo '</div>'; //end front_links

	echo '</div>'."\n"; //end index_page_buttons

} //end Index_Page_buttons_top() //*********************************************



 
function Index_Page() {//*******************************************************
	global  $ONESCRIPT, $ipath_OS, $param1;

	init_ICONS_js();

	$raw_list = scandir('./'.$ipath_OS);  //Get current directory list  (unsorted)
	$file_count = Get_DIRECTORY_DATA($raw_list);

	//<form> to contain directory, including buttons at top.
	echo '<form method="post" name="mcdselect" action="'.$ONESCRIPT.$param1.'&amp;p=mcdaction">';
	echo '<input type="hidden" name="mcdaction" value="">'; //along with $page, affects response

	Index_Page_buttons_top($file_count);

	Create_Table_for_Listing(); //sets up table with empty <tbody></tbody>

	echo "</form>\n";

	Index_Page_scripts();
	Send_directory_data_to_js();
	Index_Page_events();
}//end Index_Page() //**********************************************************




function Edit_Page_buttons_top($text_editable,$file_ENC) {//********************
	global $_, $ONESCRIPT, $param1, $param2, $filename, $filename_OS, $IS_OFCMS, 
				$WYSIWYG_VALID, $EDIT_WYSIWYG, $WYSIWYG_label, $MESSAGE;

	clearstatcache ();

	//[View Raw] button.
	if ($text_editable) {
		$view_raw_button = '<button type=button id=view_raw class=button>'.hsc('View Raw')."</button>\n";
	} else {$view_raw_button = '';}

	//[Wide View] / [Normal View] button.  Label is what button will do, not an indicator the current state.
	if ($_COOKIE['wide_view'] === "on") { $wv_label = hsc($_['Normal_View']); }
	else 								{ $wv_label = hsc($_['Wide_View']); }
	$wide_view_button = "<button type=button id=wide_view class=button value={$_COOKIE['wide_view']}>$wv_label</button>\n";

	//[Edit WYSIWYG] / [Edit Source] button.
	$WYSIWYG_button  = '';
	if ($text_editable && $WYSIWYG_VALID && !$IS_OFCMS) { //Only show when needed/applicable
		//Set current mode for Edit page, and label for [Edit WYSIWIG/Source] button
		if ( isset($_COOKIE['edit_wysiwyg']) && ($_COOKIE['edit_wysiwyg'] == '1')) {
			   $EDIT_WYSIWYG = '1'; $WYSIWYG_label = $_['Source']; }  //wysiwyg mode
		else { $EDIT_WYSIWYG = '0'; $WYSIWYG_label = $_['WYSIWYG']; } //plain text mode
		
		$WYSIWYG_button  = '<button type=button id=edit_WYSIWYG class=button>'; 
		$WYSIWYG_button .= hsc($_['Edit']).' '.hsc($WYSIWYG_label).'</button>';
	}

	//[Close] button
	$close_button = '<button type=button id=close1 class=button>'.hsc($_['Close']).'</button>';

?>
	<div class="edit_btns_top">
		<div class="file_meta">
			<span class="file_size">
				<?php echo hsc($_['meta_txt_01']).' '.number_format(filesize($filename_OS)).' '.hsc($_['bytes']); ?>
			</span>	&nbsp;
			<span class="file_time">
				<?php echo hsc($_['meta_txt_03']).' <script>FileTimeStamp('.filemtime($filename_OS).', 1, 1, 1);</script>'; ?>
				<?php echo '&nbsp; '.$file_ENC; ?>
			</span><br>
		</div>
		
		<div class="buttons_right">
			<?php echo $view_raw_button  ?>
			<?php echo $wide_view_button ?>
			<?php echo $WYSIWYG_button   ?>
			<?php echo $close_button     ?>
		</div>
		<div class=clear></div>
	</div>
<?php
}//end Edit_Page_buttons_top() //***********************************************




function Edit_Page_buttons($text_editable, $too_large_to_edit) {//**************
	global $_, $MESSAGE, $ICONS, $MAX_IDLE_TIME, $IS_OFCMS, $WYSIWYG_VALID, $EDIT_WYSIWYG;

	//Using ckeditor WYSIWYG editor, <input type=reset> button doesn't work. (I don't know why.)
	$reset_button = '<input type=reset  id="reset" class=button value="'.hsc($_['reset']).'" onclick="return Reset_File();">';
	if ($WYSIWYG_VALID && $EDIT_WYSIWYG) {$reset_button = '';}

	echo '<div class="edit_btns_bottom">';
		
		if ($text_editable && !$too_large_to_edit && !$IS_OFCMS) { //Show save & reset only if editable file
			echo '<span id=timer1  class="timer"></span>';
			echo '<button type="submit" class="button" id="save_file">'.hsc($_['save_1']).'</button>'; //Submit Button
			echo $reset_button;
		}//end if editable
		
		function RCD_button($action, $icon, $label) {//***************
			global $ICONS;
			echo '<button type=button id="'.$action.'_btn" class="button RCD">'.$ICONS[$icon].'&nbsp;'.hsc($label).'</button>';
		}//end RCD_button() //****************************************
		
		//Don't show [Rename] or [Delete] if viewing OneFileCMS itself.
		if (!$IS_OFCMS)      { RCD_button('renamefile', 'ren_mov', $_['Ren_Move']); }
		/*Always show Copy*/ { RCD_button('copyfile'  , 'copy'   , $_['Copy']); }
		if (!$IS_OFCMS)      { RCD_button('deletefile', 'delete' , $_['Delete']); }
		
	echo '</div>';

}//end Edit_Page_buttons() //***************************************************




//******************************************************************************
function Edit_Page_form($ext, $text_editable, $too_large_to_edit, $too_large_to_view, $file_ENC){
	global $_, $ONESCRIPT, $param1, $param2, $param3, $filename, $filename_OS, $ITYPES, $INPUT_NUONCE, $EX, $MESSAGE, 
		   $FILECONTENTS, $WYSIWYG_VALID, $EDIT_WYSIWYG, $IS_OFCMS, $MAX_EDIT_SIZE, $MAX_VIEW_SIZE, $LINE_WRAP;

	//Line-wrap on or off?  $LINE_WRAP default value set in configuration section.
	//Used to set initial value of on/off button below textarea. A default value is in config section.
	if (isset($_COOKIE['line_wrap'])) {
		if (($_COOKIE['line_wrap'] === "on") || ($_COOKIE['line_wrap'] === "off")) {
			$LINE_WRAP = $_COOKIE['line_wrap'];
		}
	}



	$too_large_to_edit_message =
		'<b>'.hsc($_['too_large_to_edit_01']).' '.number_format($MAX_EDIT_SIZE).' '.hsc($_['bytes']).'</b><br>'.
		hsc($_['too_large_to_edit_02']).'<br>'.hsc($_['too_large_to_edit_03']).'<br>'.hsc($_['too_large_to_edit_04']);

	$too_large_to_view_message =
		'<b>'.hsc($_['too_large_to_view_01']).' '.number_format($MAX_VIEW_SIZE).' '.hsc($_['bytes']).'</b><br>'.
		hsc($_['too_large_to_view_02']).'<br>'.hsc($_['too_large_to_view_03']).'<br>';

	echo "\n".'<form id=edit_form name=edit_form method=post action="'.$ONESCRIPT.$param1.$param2.$param3.'">'."\n";
		
		echo $INPUT_NUONCE;
		
		Edit_Page_buttons_top($text_editable, $file_ENC);
		
		if ( !in_array( mb_strtolower($ext), $ITYPES) ) { //If non-image...
			
			//Did htmlspecialchars return an empty string from a non-empty file?
			$bad_chars = ( ($FILECONTENTS == "") && (filesize($filename_OS) > 0) );
			
			if     (!$text_editable) { $MESSAGE .= hsc($_['edit_txt_01']).'<br><br>'; }
			elseif ( $text_editable && $too_large_to_view ) {
				echo '<p class="message_box_contents">'.$too_large_to_view_message.'</p>';
			} else {
				
				if ($IS_OFCMS || $too_large_to_edit) {$readonly = "readonly";} else {$readonly = "";}
				
				if ( $too_large_to_edit ) { $MESSAGE .= $too_large_to_edit_message; }
				
				if ($bad_chars){ //Show message: may be a bad character in file
					echo '<pre class="edit_disabled">'.$EX.hsc($_['edit_txt_02']).'<br>';
					echo hsc($_['edit_txt_03']).'<br>';
					echo hsc($_['edit_txt_04']).'<br></pre>'."\n";
				}else{          //show editable <textarea>
					
					//<input name=filename> is used only to signal an Edit_response().
					echo '<input type=hidden name=filename value="'.rawurlencode($filename).'">';
					
					echo "<div id=wrapper_linenums_editor>\n";
					echo 	"<div id=line_numbers tabindex='-1'><div id=line_1>1</div><div id=line_0></div></div>\n";
					echo 	"<textarea $readonly id=file_editor name=contents cols=70 rows=25>$FILECONTENTS</textarea>\n";
					echo "</div>\n";
					
					$wrap_on_off  = hsc($_['Line_Wrap'])." ";
					$wrap_on_off .= "<span id=w_on>" .hsc($_['on']) ."</span>/";
					$wrap_on_off .= "<span id=w_off>".hsc($_['off'])."</span>";
					
					echo "<button type=button class=button id=toggle_wrap name=toggle_wrap value=$LINE_WRAP>$wrap_on_off</button>";
				}
			}//end if/elseif...
			
		}//end if non-image
		
		Edit_Page_buttons($text_editable, $too_large_to_edit);
	echo "\n</form>\n";

	Edit_Page_scripts();

	if ( !$IS_OFCMS && $text_editable && !$too_large_to_edit && !$bad_chars ) {Edit_Page_Notes();}
}//end Edit_Page_form() //******************************************************




function Edit_Page_Notes() {//**************************************************
	global $_, $MAX_IDLE_TIME;
			$SEC = $MAX_IDLE_TIME;
			$HRS = floor($SEC/3600);
			$SEC = fmod($SEC,3600);
			$MIN = floor($SEC/60);   if ($MIN < 10) { $MIN = "0".$MIN; };
			$SEC = fmod($SEC,60);    if ($SEC < 10) { $SEC = "0".$SEC; };
			$HRS_MIN_SEC = $HRS.':'.$MIN.':'.$SEC;
?>
			<div id="edit_notes">
				<div class="notes"><?php echo hsc($_['edit_note_00']) ?></div>
				<div class="notes"><b>1)
					<?php echo hsc($_['edit_note_01a']).' $MAX_IDLE_TIME '.hsc($_['edit_note_01b']) ?>
					<?php echo ' '.$HRS_MIN_SEC.'. '.hsc($_['edit_note_02']) ?></b>
				</div>
				<div class="notes"><b>2) </b> <?php echo hsc($_['edit_note_03']) ?></div>
			</div>
<?php
}//end Edit_Page_Notes() //*****************************************************




function Edit_Page() {//********************************************************
	global $_, $filename, $filename_OS, $FILECONTENTS, $ETYPES, $ITYPES, $EX, $MESSAGE, $page,
			$MAX_EDIT_SIZE, $MAX_VIEW_SIZE, $WYSIWYG_VALID, $IS_OFCMS;

	$filename_parts = explode(".", mb_strtolower($filename));
	$ext = end($filename_parts);

	//Determine if a text editable file type
	if ( in_array($ext, $ETYPES) ) { $text_editable = TRUE;  }
	else                           { $text_editable = FALSE; }

	$too_large_to_edit = (filesize($filename_OS) > $MAX_EDIT_SIZE);
	$too_large_to_view = (filesize($filename_OS) > $MAX_VIEW_SIZE);

	//Don't load $WYSIWYG_PLUGIN if not needed
	if (!$text_editable || $too_large_to_edit) {$WYSIWYG_VALID = 0;}

	//Get file contents
 	if (($text_editable && !$too_large_to_view) || $IS_OFCMS) {
		$raw_contents = file_get_contents($filename_OS);
		$file_ENC = mb_detect_encoding($raw_contents); //ASCII, UTF-8, ISO-8859-1, etc...
		if ($file_ENC != 'UTF-8') { $raw_contents = mb_convert_encoding($raw_contents, 'UTF-8', $file_ENC); }
	}else{
		$file_ENC     = "";
		$raw_contents = "";
	}


	if (PHP_VERSION_ID < 50400) { $FILECONTENTS = hsc($raw_contents); }
	else						{ $FILECONTENTS = htmlspecialchars($raw_contents,ENT_SUBSTITUTE | ENT_QUOTES, 'UTF-8');	}

	if     ($too_large_to_view || !$text_editable)				 { $header2 = "";}
	elseif ($text_editable && !$too_large_to_edit && !$IS_OFCMS) { $header2 = hsc($_['edit_h2_2']); }
	else									  					 { $header2 = hsc($_['edit_h2_1']); }

	echo '<h2 id="edit_header">'.$header2.' ';
	echo '<a class="h2_filename" href="./'.URLencode_path($filename).'" target="_blank" title="'.hsc($_['Open_View']).'">';
	echo hsc(basename($filename)).'</a>';
	echo '</h2>'."\n";

	Edit_Page_form($ext, $text_editable, $too_large_to_edit, $too_large_to_view, $file_ENC);

	if ( in_array( $ext, $ITYPES) ) { show_image(); } //If image, show below the [Rename/Move] [Copy] [Delete] buttons

	echo '<div class=clear></div>';

	//If viewing OneFileCMS itself, show Edit Disabled message.
	if ($IS_OFCMS && $page == "edit") {
		$MESSAGE .= '<style>.message_box_contents {background: red;}</style>';
		$MESSAGE .= '<style>#message_box          {color: white;}   </style>';
		$MESSAGE .= '<b>'.$EX.hsc($_['edit_caution_02']).' &nbsp; '.$_['edit_txt_00'].'</b><br>';
	}
}//end Edit_Page() //***********************************************************




function Edit_response() {//***If on Edit page, and [Save] clicked *************
	global $_, $EX, $MESSAGE, $filename, $filename_OS;

	$contents    = $_POST['contents'];

	$contents = str_replace("\r\n", "\n", $contents); //Normalize EOL
	$contents = str_replace("\r"  , "\n", $contents); //Normalize EOL

	$bytes = file_put_contents($filename_OS, $contents);

	if ($bytes !== false) {
		$MESSAGE .= '<b>'.hsc($_['edit_msg_01']).' '.number_format($bytes).' '.hsc($_['edit_msg_02']).'</b><br>';
	}else{
		$MESSAGE .= $EX.'<b>'.hsc($_['edit_msg_03']).'</b><br>';
	}
}//end Edit_response() //*******************************************************




function Upload_Page() {//******************************************************
	global $_, $ONESCRIPT, $ipath, $param1, $INPUT_NUONCE, $UPLOAD_FIELDS, $MAIN_WIDTH;

	$max_file_uploads = ini_get('max_file_uploads');
	if ($max_file_uploads < 1) { $max_file_uploads = $UPLOAD_FIELDS; } 
	if ($max_file_uploads < $UPLOAD_FIELDS) { $UPLOAD_FIELDS = $max_file_uploads; }

	//$main_width is used below to determine size (width) of <input type=file> in FF.
	$main_width = $MAIN_WIDTH * 1;   //set in config section. Default is 810px.
	$main_units = mb_substr($MAIN_WIDTH, -2); //should be px, pt, or em.
	//convert to px.  16px = 12pt = 1em
	if     ( $main_units == "em") { $main_width = $main_width * 16 ; }
	elseif ( $main_units == "pt") { $main_width = $main_width * (16 / 12); }

	echo '<h2>'.hsc($_['Upload_File']).'</h2>';
	echo '<p>';
	echo hsc($_['upload_txt_03']).' '.ini_get('upload_max_filesize').' '.hsc($_['upload_txt_01']).'<br>';
	echo hsc($_['upload_txt_04']).' '.ini_get('post_max_size')      .' '.hsc($_['upload_txt_02']).'<br>';

	echo '<form enctype="multipart/form-data" action="'.$ONESCRIPT.$param1.'&amp;p=uploaded" method="post">';
		echo $INPUT_NUONCE;
		
		echo '<div class="action"><LABEL>'.hsc($_['upload_txt_05']).'</LABEL></div>';
		echo '<div class="ren_over">'; //So <LABEL>'s wrap w/o word breaks if $MAIN_WIDTH is narrow.
			echo '<label><INPUT TYPE=radio NAME=ifexists VALUE=rename checked> '.hsc($_['upload_txt_06']).'</label>';
			echo '<label><INPUT TYPE=radio NAME=ifexists VALUE=overwrite     > '.hsc($_['upload_txt_07']).'</label>';
		echo '</div>';
		
		for ($x = 0; $x < $UPLOAD_FIELDS; $x++) {
			//size attibute is for FF (and is not em, px, pt, or %).
			//width attribute is for IE & Chrome, and can be set via css (in style_sheet()).
			//In FF, width of <input type="file" size=1> is 121px. If size=2, width = 128, etc. The base value is 114px.
			echo '<input type="file" name="upload_file[]" size="'.floor(($main_width - 114) / 7).'"><br>'."\n";
		}
		echo '<p>';
		Cancel_Submit_Buttons($_['Upload']);
	echo "\n</form>\n";
}//end Upload_Page() //*********************************************************




function Upload_response() {//**************************************************
	global $_, $ipath, $ipath_OS, $page, $EX, $MESSAGE, $UPLOAD_FIELDS;

	$page  = "index"; //return to index.

	$filecount = 0;
	foreach ($_FILES['upload_file']['name'] as $N => $name) {
		if ($name == "") { continue; } //ignore empty upload fields
		
		$filecount++;
		$filename_up = $ipath.$_FILES['upload_file']['name'][$N]; //just filename, no path.
		$filename_OS = Convert_encoding($filename_up);
		
		$savefile_msg = '';
		
		$MAXUP1 = ini_get('upload_max_filesize');
		//$MAXUP2 = ''; //number_format($_POST['MAX_FILE_SIZE']).' '.hsc($_['bytes']);
		$ERROR = $_FILES['upload_file']['error'][$N];
		
		if     ( $ERROR == 1 ){ $ERRMSG = hsc($_['upload_err_01']).' upload_max_filesize = '.$MAXUP1;}
		elseif (($ERROR > 1) && ($ERROR < 9)) { $ERRMSG = hsc($_['upload_err_0'.$ERROR]); }
		else                  { $ERRMSG = ''; }
		
		if ( ($ipath === false) || (($ipath != "") && !is_dir($ipath_OS))) {
			$MESSAGE .= $EX.'<b>'.hsc($_['upload_msg_02']).'</b><br>';
			$MESSAGE .= '<span class="filename">'.hsc($ipath).'</span></b><br>';
			$MESSAGE .= hsc($_['upload_msg_03']).'</b><br>';
		}else{
			$MESSAGE .= '<b>'.hsc($_['upload_msg_04']).'</b> <span class="filename">'.hsc(basename($filename_up)).'</span><br>';
			
			if ( isset($_POST['ifexists']) && ($_POST['ifexists'] == 'overwrite') ) {
				if (is_file($filename_OS)) { $savefile_msg .= hsc($_['upload_msg_07']) ; }
			}else{ //rename to "file.etc.001"  etc...
				$filename_up = add_serial_num($filename_up, $savefile_msg);
			}
			
			$filename_OS = Convert_encoding($filename_up);
			if(move_uploaded_file($_FILES['upload_file']['tmp_name'][$N], $filename_OS)) {
				$MESSAGE .= '<b>'.hsc($_['upload_msg_05']).'</b> '.$savefile_msg.'<br>';
			} else{
				$MESSAGE .= '<b>'.$EX.hsc($_['upload_msg_06']).'</b> '.$ERRMSG.'</b><br>';
			}
		}
	}//end foreach $_FILES

	if ($filecount == 0) { $page = "upload"; } //If nothing selected, just reload Upload page.
}//end Upload_response() //*****************************************************




function New_Page($title, $new_f_or_f) {//**********************************************
	global $_, $FORM_COMMON, $INVALID_CHARS;

	echo '<h2>'.hsc($title).'</h2>';
	echo $FORM_COMMON;
		echo '<p>'.hsc($_['new_file_txt_01'].' '.$_['new_file_txt_02']);
		echo '<span class="mono"> '.hsc($INVALID_CHARS).'</span></p>';
		echo '<input type="text" name="'.$new_f_or_f.'" id="'.$new_f_or_f.'" value=""><p>';
		Cancel_Submit_Buttons($_['Create']);
	echo "\n</form>\n";
}//end New_Page() //************************************************************




function New_response($post, $isfile) {//***************************************
	global $_, $ipath, $ipath_OS, $filename, $filename_OS, $page, $param1, $param2, $param3, $MESSAGE, $EX, $INVALID_CHARS, $WHSPC_SLASH;

	$page      = "index"; //Return to index if folder, or on error.

	$new_name     = trim($_POST[$post], $WHSPC_SLASH); //Trim whitespace & slashes.

	$filename     = $ipath.$new_name;
	$filename_OS  = Convert_encoding($filename);

	if ($isfile) { $f_or_f = "file";   }
	else         { $f_or_f = "folder"; }

	$msg_new  = '<span class="filename">'.hsc($new_name).'</span><br>';

	if (has_invalid_char($new_name)){
		$MESSAGE .= $EX.'<b>'.hsc($_['new_file_msg_01']).'</b> '.$msg_new;
		$MESSAGE .= '<b>'.hsc($_['new_file_msg_02']).'<span class="mono"> '.hsc($INVALID_CHARS).'</span></b>';
		
	}elseif ($new_name == ""){ //No new name given.
		$page   = "new".$f_or_f;
		$param3 = '&amp;p=index'; //For [Cancel] button
		
	}elseif (file_exists($filename_OS)) { //Does file or folder already exist ?
		$MESSAGE .= $EX.'<b>'.hsc($_['new_file_msg_04']).' '.$msg_new;
		
	}elseif ($isfile && touch($filename_OS) ) { //Create File
		$MESSAGE .= '<b>'.hsc($_['new_file_msg_05']).'</b> '.$msg_new; //New File success.
		$page     = "edit";                                      //Return to edit page.
		$param2   = '&amp;f='.rawurlencode(basename($filename)); //for Edit_Page() buttons
		$param3   = '&amp;p=edit';                               //for Edit_Page() buttons
		
	}elseif (!$isfile && mkdir($filename_OS,0755)) { //Create Folder
		$MESSAGE .= '<b>'.hsc($_['new_file_msg_07']).'</b> '.$msg_new; //New folder success
		$ipath    = $filename;  //return to new folder
		$ipath_OS = Convert_encoding($filename);
		$param1   = '?i='.URLencode_path($ipath);
		
	}else{
		$MESSAGE .= $EX.'<b>'.hsc($_['new_file_msg_01']).':</b><br>'.$msg_new; //'Error - new file not created:'
	}
}//end New_response() //********************************************************




function Set_Input_width() {//**************************************************
	global $_, $WEB_ROOT, $MAIN_WIDTH, $ACCESS_ROOT;

	// (width of <input type=text>) = $MAIN_WIDTH - (Width of <label>) - (width of <span>$WEB_ROOT</span>)
	// $MAIN_WIDTH: Set in config section, may be in em, px, pt, or %. Ignoring % for now.
	// Width of 1 character = .625em = 10px = 7.5pt  (1em = 16px = 12pt)

	$main_units  = mb_substr($MAIN_WIDTH, -2);
	$main_width  = $MAIN_WIDTH * 1;

	$root_width  = mb_strlen($WEB_ROOT.$ACCESS_ROOT);
	$label_width = mb_strlen($_['New_Location']);

	//convert to em
	$root_width  *= .625;
	$label_width *= .625;
	if     ( $main_units == "px") { $main_width = $main_width / 16 ; }
	elseif ( $main_units == "pt") { $main_width = $main_width / 12 ; }

	//The .4 at the end is needed for some rounding erros above. Or something... I don't know.
	$input_type_text_width = ($main_width - $label_width - $root_width - .4).'em';

	echo '<style>input[type="text"] {width: '.$input_type_text_width.';}';
	echo 'label {display: inline-block; width: '.$label_width.'em; }</style>';

}//end Set_Input_width() //*****************************************************




function CRM_Page($action, $title, $action_id, $old_full_name) {//*******************
	//$action    = 'Copy' or 'Rename'.
	//$action_id = 'copy_file' or 'rename_file'
	global $_, $WEB_ROOT, $ipath, $param1, $filename, $FORM_COMMON, $ACCESS_ROOT, $ACCESS_PATH;

	$new_full_name = $old_full_name; //default

	if (is_dir(Convert_encoding($old_full_name))) {
		$param1 = '?i='.dir_name($ipath); //If dir, return to parent on [Cancel]
		$ACCESS_PATH = dir_name($ACCESS_PATH);
	}

	Set_Input_width();

	echo '<h2>'.hsc($action.' '.$title).'</h2>';

	echo $FORM_COMMON;
		echo '<input type="hidden" name="'.hsc($action_id).'"  value="'.hsc($action_id).'">';
		echo '<input type="hidden" name=old_full_name     value="'.hsc($old_full_name).'">';
		
		echo '<label>'.hsc($_['CRM_txt_04']).':</label>';
		echo '<input type=text name=new_name id=new_name value="'.hsc(basename($new_full_name)).'"><br>';
		
		echo '<label>'.hsc($_['New_Location']).':</label>';
		echo '<span class="web_root">'.hsc($WEB_ROOT.$ACCESS_ROOT).'</span>';
		echo '<input type=text name=new_location id=new_location value="'.hsc($ACCESS_PATH).'"><br>';
		
		echo '('.hsc($_['CRM_txt_02']).')<p>';
		Cancel_Submit_Buttons($action);
	echo "\n</form>\n";
}//end CRM_Page() //************************************************************



 
function CRM_response($action, $msg1, $show_message = 3) {//********************
	//$action = 'rCopy' or 'rename'.  Returns 0 if successful, 1 on error.
	//$show_message: 0 = none; 1 = errors only; 2 = successes only; 3 = all messages (default).
	global $_, $ONESCRIPT, $ipath, $ipath_OS, $filename, $page, $param1, $param2, $param3, 
			$MESSAGE, $EX, $INVALID_CHARS, $WHSPC_SLASH;

	$old_full_name = trim($_POST['old_full_name'], $WHSPC_SLASH);     //Trim whitespace & slashes.
	$new_name_only = trim($_POST['new_name'], $WHSPC_SLASH);
	$new_location  = trim($_POST['new_location'], $WHSPC_SLASH);
	if ($new_location != "") { $new_location .= '/'; }
	$new_full_name = $new_location.$new_name_only;
	$filename      = $old_full_name; //default if error.

	//for function calls that access the server file system, such as rCopy, rename, file_exists, etc...
	$old_full_name_OS = Convert_encoding($old_full_name);
	$new_full_name_OS = Convert_encoding($new_full_name);
	$new_location_OS  = Convert_encoding($new_location);

	$isfile = 0; if (is_file($old_full_name_OS)) { $isfile = 1;} //File or folder?

	//Common message lines
	$com_msg  = '<div id="message_left">'.hsc($_['From']).'<br>'.hsc($_['To']).'</div>';
	$com_msg .= '<b>: </b><span class="filename">'.hsc($old_full_name).'</span><br>';
	$com_msg .= '<b>: </b><span class="filename">'.hsc($new_full_name).'</span><br>';

	$bad_name = ""; //bad file or folder name (can be either old_ or new_)

	$err_msg = ''; //Error message.
	$scs_msg = ''; //Success message.

	$error_code = 0; //1 = success (no error), 0 = an error. Used for return value.

	//Check old name for invalid chars (like .. ) (Unlikely to be false outside a malicious attempt)
	if ( Check_path($old_full_name,$show_message) === false ) {
		$bad_name = $old_full_name;
	}elseif ( !file_exists($old_full_name_OS) ) {
		$err_msg .= $EX.'<b>'.hsc($msg1.' '.hsc($_['CRM_msg_02'])).'</b><br>';
		$bad_name = $old_full_name;
	//Ignore if new name is blank.
	}elseif ( mb_strlen($new_name_only) == 0 ) {
		$page = 'copyfile';
		$param3 = '&amp;p=copyfile';
		return 0;
	//Check new name for invalid chars, including slashes.
	}elseif ( has_invalid_char($new_name_only) ) {
		$err_msg .= $EX.'<b>'.hsc($_['new_file_msg_02']).'<span class="filename"> '.hsc($INVALID_CHARS).'</span></b><br>';
		$bad_name = $new_name_only;
	//Check new location for invalid chars etc.
	}elseif ( Check_path($new_location,$show_message) === false ) {
		$bad_name = $new_location;
	//$new_location must already exist as a directory
	}elseif ( ($new_location != "") && !is_dir($new_location_OS) ) {
		$err_msg .= $EX.'<b>'.hsc($msg1.' '.hsc($_['CRM_msg_01'])).'</b><br>';
		$bad_name = $new_location;
	//Don't overwrite existing files.
	}elseif ( file_exists($new_full_name_OS) ) {
		$bad_name = $new_full_name;
		$err_msg .= $EX.'<b>'.hsc($msg1.' '.hsc($_['CRM_msg_03'])).'</b><br>';
	}else{ //attempt $action
		$error_code = $action($old_full_name_OS, $new_full_name_OS);
		if ( $error_code > 0 ) { 
			$scs_msg .= '<b>'.hsc($msg1.' '.hsc($_['successful'])).'</b><br>'.$com_msg;
			if ($isfile) { $filename = $new_full_name; }
			$ipath    = $new_location;
			$ipath_OS = $new_location_OS;
		}else{
			$err_msg .= $EX.'<b>'.hsc($_['CRM_msg_05'].' '.$msg1).'</b><br>'.$com_msg;
		}
	}//

	if (($bad_name !='' ) && ($error_code == 0)) { $err_msg .= '<span class="filename">'.hsc($bad_name).'</span><br>'; }

	if (($show_message & 1) && ($error_code == 0)) { $MESSAGE .= $err_msg; } //Show error message.
	if ( $show_message & 2)                        { $MESSAGE .= $scs_msg; } //Show success message.

	//Prior page should be either index or edit
	$page = $_SESSION['recent_pages'][1];
	$param1 = '?i='.URLencode_path($ipath);
	if ($isfile & $page == "edit") {$param2 = '&amp;f='.rawurlencode(basename($filename));}

	return $error_code; //
}//end CRM_response() //********************************************************




function Delete_response($target, $show_message=3) {//**************************
	global $_, $ipath, $ipath_OS, $param1, $filename, $param2, $page, $MESSAGE, $EX;

	if ($target == "") { return 0; } //Prevent accidental delete of entire website.

	$target = Check_path($target,$show_message); //Make sure $target is within $WEB_ROOT
	$target = trim($target,'/');
	$page = "index"; //Return to index

	//If came from admin page, return there.
	if ( $_SESSION['admin_page'] ) { $page = 'admin'; }

	$err_msg = ''; //On error, set this message.
	$scs_msg = ''; //On success, set this message.

	$error_code = rDel($target);
	if ($error_code > 0) { // 0 = error, > 0 is number of successes
		$scs_msg .= '<b>'.hsc($_['Deleted']).':</b> ';
		$scs_msg .= '<span class="filename">'.hsc(basename($target)).'</span></br>';
		$ipath  = dir_name($target); //Return to parent dir.
		$ipath_OS = Convert_encoding($ipath);
		$param1 = '?i='.URLencode_path($ipath);
		$filename = "";
		$param2   = "";
	}else { //Error
		$err_msg .= $EX.'<b>'.hsc($_['delete_msg_03']).'</b> <span class="filename">'.hsc($target).'</span><br>';
		$page = $_SESSION['recent_pages'][1];
		if ($page == "edit") {
			$filename = $target;
			$param2 = '&amp;f='.basename($filename);
		}
	}

	if ($show_message & 1) { $MESSAGE .= $err_msg; } //Show error message.
	if ($show_message & 2) { $MESSAGE .= $scs_msg; } //Show success message.

	return $error_code;
}//end Delete_response() //*****************************************************



 
function MCD_Page($action, $page_title, $classes = '') {//**********************
	//$action = mcd_mov or mcd_cpy or mcd_del
	global $_,  $WEB_ROOT, $ONESCRIPT, $ipath, $ipath_OS, $param1, $filename, $page,
			$ICONS, $ACCESS_ROOT, $ACCESS_PATH, $INPUT_NUONCE, $MESSAGE;

	//Prep for a single file or folder
	if( $page == "deletefile" || $page == "deletefolder" ){
		$_POST['mcdaction'] = 'delete'; //set mcdaction != copy or move (see below).
		
		if ($page == "deletefile") { $_POST['files'][1]  = basename($filename); }
	  //If  $page == deletefolder,   $_POST['files'][1] is set in Verify_Page_Conditions()
	}

	Set_Input_width();

	echo '<h2>'.hsc($page_title).'</h2>';

	echo '<form method="post" action="'.$ONESCRIPT.$param1.'">'.$INPUT_NUONCE;
		echo '<input type="hidden" name="'.hsc($action).'" value="'.hsc($action).'">'."\n";
		
		if ( ($_POST['mcdaction'] == 'copy') || ($_POST['mcdaction'] == 'move') ) {
			echo '<label>'.hsc($_['New_Location']).':</label>';
			echo '<span class="web_root">'.hsc($WEB_ROOT.$ACCESS_ROOT).'</span>';
			echo '<input type=text   name=new_location  id=new_location value="'.hsc($ACCESS_PATH).'">';
			echo '<p>('.hsc($_['CRM_txt_02']).')</p>';
		}
		 
		echo '<p><b>'.hsc($_['Are_you_sure']).'</b></p>';
		Cancel_Submit_Buttons($page_title);
			
		//List selected folders & files
		$full_list = Sort_Seperate($ipath, $_POST['files']); 
		
		echo '<table class="verify '.$classes.'">';
		echo '<tr><th>'.hsc($_['Selected_Files']).':</th></tr>'."\n";
		foreach ($full_list as $file) {
			$file_OS = Convert_encoding($file);
			if (is_dir($ipath_OS.$file_OS)) { echo '<tr><td>'.$ICONS['folder'].'&nbsp;'.hsc($file).' /</td></tr>'; }
			else                            { echo '<tr><td>'                          .hsc($file).'</td></tr>'; }
			echo '<input type=hidden  name="files[]" value="'.hsc($file).'">'."\n";
		}
		
		echo '</table>';
	echo "\n</form>\n";
}//end MCD_Page() //************************************************************




function MCD_response($action, $msg1, $success_msg = '') {//********************
	global $_, $ipath, $ipath_OS, $EX, $MESSAGE, $WHSPC_SLASH;

	$files      = $_POST['files']; //List of files to delete (path not included)
	$errors     = 0; //number of failed moves, copies, or deletes
	$successful = 0;

	$new_location = "";
	if (isset($_POST['new_location'])) {
		$new_location    =                  $_POST['new_location'];
		$new_location_OS = Convert_encoding($_POST['new_location']);
	}

	$show_message = 1; //1= show error msg only.

	if ( ($new_location != "") && !is_dir($new_location_OS)) {
		$MESSAGE .= $EX.'<b>'.hsc($msg1.' '.$_['CRM_msg_01']).'</b><br>';
		$MESSAGE .= '<span class="filename">'.hsc($_POST['new_location']).'</span><br>';
		return;
	}elseif ($action == 'rDel') {
		foreach ($files as $file){
			if ($file == "") {continue;} //a blank file name would cause $ipath to be deleted.
			$error_code = Delete_response($ipath.$file, $show_message);
			$successful += $error_code;
			if ($error_code == 0) {$errors++;}
		}
	}else { //move or rCopy
		$mcd_ipath = $ipath; //CRM_response() changes $ipath to $new_location
		
		foreach ($files as $file){
			$_POST['old_full_name'] = $mcd_ipath.$file;
			$_POST['new_name'] = $file;
		  //$_POST['new_location'] should already be set by the client ( via MCD_Page() ).
			$error_code = CRM_response($action, $msg1, $show_message);
			$successful += $error_code;
			if ($error_code == 0) {$errors++;}
		}
	}

	if ($errors) {$MESSAGE .= $EX.' <b>'.$errors.' '.hsc($_['errors']).'.</b><br>';}

	$MESSAGE .= '<b>'.$successful.' '.hsc($success_msg).'</b><br>';

	if ($action != 'rDel') {
		if ($successful > 0) { //"From:" & "To:" lines if any successes.
			$MESSAGE .= '<div id="message_left"><b>'.hsc($_['From']).'<br>'.hsc($_['To']).'</b></div>';
			$MESSAGE .= '<b>:</b><span class="filename"> '.hsc($mcd_ipath).'</span><br>';
			$MESSAGE .= '<b>:</b><span class="filename"> '.hsc($ipath).'</span><br>';
		}
	}
}//end MCD_response() //********************************************************




function Page_Title() {//***<title>Page_Title()</title>*************************
	global $_, $page;

	if     (!$_SESSION['valid'])     { return $_['Log_In'];        }
	elseif ($page == "admin")        { return $_['Admin_Options']; }
	elseif ($page == "hash")         { return $_['Generate_Hash']; }
	elseif ($page == "changepw")     { return $_['pw_change'];     }
	elseif ($page == "changeun")     { return $_['un_change'];     }
	elseif ($page == "edit")         { return $_['Edit_View'];     }
	elseif ($page == "upload")       { return $_['Upload_File'];   }
	elseif ($page == "newfile")      { return $_['New_File'];      }
	elseif ($page == "copyfile" )    { return $_['Copy_Files'];    }
	elseif ($page == "copyfolder" )  { return $_['Copy_Files'];    }
	elseif ($page == "renamefile")   { return $_['Ren_Move'].' '.$_['File'];}
	elseif ($page == "deletefile")   { return $_['Del_Files'];     }
	elseif ($page == "deletefolder") { return $_['Del_Files'];     }
	elseif ($page == "newfolder")    { return $_['New_Folder'];    }
	elseif ($page == "renamefolder") { return $_['Ren_Folder'];    }
	elseif ($page == "mcdaction" && ($_POST['mcdaction'] == "copy") )   { return $_['Copy_Files'];}
	elseif ($page == "mcdaction" && ($_POST['mcdaction'] == "move") )   { return $_['Move_Files'];}
	elseif ($page == "mcdaction" && ($_POST['mcdaction'] == "delete") ) { return $_['Del_Files']; }
	else                             { return $_SERVER['SERVER_NAME']; }
}//end Page_Title() //**********************************************************




function Load_Selected_Page() {//***********************************************
	global $_, $ONESCRIPT, $ipath, $filename, $page;

	if     (!$_SESSION['valid'])     { Login_Page(); }
	elseif ($page == "admin")        { Admin_Page(); }
	elseif ($page == "hash")         { Hash_Page();  }
	elseif ($page == "changepw")     { Change_PWUN_Page('pw', 'password', $_['pw_change'], $_['pw_new'], $_['pw_confirm']);}
	elseif ($page == "changeun")     { Change_PWUN_Page('un', 'text',     $_['un_change'], $_['un_new'], $_['un_confirm']);}
	elseif ($page == "edit")         { Edit_Page();  }
	elseif ($page == "upload")       { Upload_Page();}
	elseif ($page == "newfile")      { New_Page($_['New_File']  , "new_file");  }
	elseif ($page == "newfolder")    { New_Page($_['New_Folder'], "new_folder");}
	elseif ($page == "copyfile")     { CRM_Page($_['Copy'],     $_['File']  , 'copy_file'  , $filename);}
	elseif ($page == "copyfolder")   { CRM_Page($_['Copy'],     $_['Folder'], 'copy_file'  , $ipath);}
	elseif ($page == "renamefile")   { CRM_Page($_['Ren_Move'], $_['File']  , 'rename_file', $filename);}
	elseif ($page == "renamefolder") { CRM_Page($_['Ren_Move'], $_['Folder'], 'rename_file', $ipath);}
	elseif ($page == "deletefile")   { MCD_Page('mcd_del', $_['Del_Files'],'verify_del'); }
	elseif ($page == "deletefolder") { MCD_Page('mcd_del', $_['Del_Files'],'verify_del'); }
	elseif ($page == "mcdaction")    {
		if ($_POST['mcdaction'] == 'move')  { MCD_Page('mcd_mov', $_['Move_Files']); }
		if ($_POST['mcdaction'] == 'copy')  { MCD_Page('mcd_cpy', $_['Copy_Files']); }
		if ($_POST['mcdaction'] == 'delete'){ MCD_Page('mcd_del', $_['Del_Files'], 'verify_del'); }
	}
	else                             { Index_Page();          } //default if valid session.
}//end Load_Selected_Page() //**************************************************




function Respond_to_POST() {//**************************************************
	global $_, $VALID_POST, $ipath, $page, $EX, $ACCESS_ROOT, $MESSAGE;

	if (!$VALID_POST) { return; }

	//First, validate any $_POST'ed paths against $ACCESS_ROOT.
	if (isset($_POST["old_full_name"]) && !Valid_Path($_POST["old_full_name"], false)) {
		//unlikely, but just in case
		$MESSAGE .= $EX.'<b>'.hsc($_['Invalid_path']).': </b><span class=filename>'.hsc($_POST["old_full_name"]).'</span>';
		$VALID_POST = 0;
		return;
	}
	if (isset($_POST["new_location"])) {
		$_POST["new_location"] = $ACCESS_ROOT.$_POST["new_location"];
		if (!Valid_Path($_POST["new_location"], false)) {  
			$MESSAGE .= $EX.'<b>'.hsc($_['Invalid_path']).': </b><span class=filename>'.hsc($_POST["new_location"]).'</span>';
			$VALID_POST = 0;
			return;
		}
	}

	if     (isset($_POST['mcd_mov']      )) { MCD_response('rename', $_['Ren_Move'], $_['mcd_msg_01']); } //move == rename
	elseif (isset($_POST['mcd_cpy']      )) { MCD_response('rCopy' , $_['Copy']    , $_['mcd_msg_02']); }
	elseif (isset($_POST['mcd_del']      )) { MCD_response('rDel'  , $_['Delete']  , $_['mcd_msg_03']); }
	elseif (isset($_POST['whattohash']   )) { Hash_response(); }
	elseif (isset($_POST['pw']           )) { Change_PWUN_response('pw', $_['change_pw_02']);}
	elseif (isset($_POST['un']           )) { Change_PWUN_response('un', $_['change_un_02']);}
	elseif (isset($_POST['filename']     )) { Edit_response(); }
	elseif (isset($_POST['new_file']     )) { New_response('new_file'  , 1);} //1=file
	elseif (isset($_POST['new_folder']   )) { New_response('new_folder', 0);} //0=folder
	elseif (isset($_POST['rename_file']  )) { CRM_response('rename', $_['Ren_Move']);}
	elseif (isset($_POST['copy_file']    )) { CRM_response('rCopy' , $_['Copy']   );}
	elseif (isset($_FILES['upload_file']['name']))  { Upload_response(); }

	//If Changed p/w, u/n, or other Admin Page action, make sure to not return to a folder outside of $ACCESS_ROOT.
	Valid_Path($ipath, true);
}//end Respond_to_POST() //*****************************************************




function init_ICONS_js() {//****************************************************
	global $ICONS;

	//Currently, only icons for dir listing are needed in js
?>
<script>
var ICONS = new Array();
ICONS['bin']	 = '<?php echo $ICONS["bin"]	 ?>';
ICONS['z']		 = '<?php echo $ICONS["z"]		 ?>';
ICONS['img']	 = '<?php echo $ICONS["img"]	 ?>';
ICONS['svg']	 = '<?php echo $ICONS["svg"]	 ?>';
ICONS['txt']	 = '<?php echo $ICONS["txt"]	 ?>';
ICONS['htm']	 = '<?php echo $ICONS["htm"]	 ?>';
ICONS['php']	 = '<?php echo $ICONS["php"]	 ?>';
ICONS['css']	 = '<?php echo $ICONS["css"]	 ?>';
ICONS['cfg']	 = '<?php echo $ICONS["cfg"]	 ?>';
ICONS['dir']     = '<?php echo $ICONS["dir"]     ?>';
ICONS['folder']  = '<?php echo $ICONS["folder"]  ?>';
ICONS['ren_mov'] = '<?php echo $ICONS["ren_mov"] ?>';
ICONS['move']    = '<?php echo $ICONS["move"]    ?>';
ICONS['copy']    = '<?php echo $ICONS["copy"]    ?>';
ICONS['delete']  = '<?php echo $ICONS["delete"]  ?>';
</script>
<?php
}//end init_ICONS_js() //*******************************************************




function common_scripts() {//***************************************************
	global $_, $TO_WARNING, $MESSAGE, $page, $DELAY_Expired_Reload;
?>

<script>
var $MESSAGE = "";


function pad(num){ if ( num < 10 ){ num = "0" + num; }; return num; }



function hsc(text) {//************************************************
	//A basic htmlspecialchars()
	return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}//end hsc() //*******************************************************



function trim($string) {//********************************************

	//trim leading whitespace
	$len = $string.length;
	$trimmed = "";
	for (var $x=0; $x < $len; $x++) {
		$charcode = $string.charCodeAt($x);
		if ( $charcode > 32) { $trimmed += $string.substr($x); $x = $len; }
	}

	//trim trailing whitespace
	$string = $trimmed;
	$len = $string.length;
	$trimmed = "";
	for ($x=($len-1); $x >= 0; $x--) {
		$charcode = $string.charCodeAt($x);
		if ( $charcode > 32) { $trimmed += $string.substr(0,$x+1); $x = -1; }
	}

	return $trimmed;
}//end trim() //******************************************************



function FormatTime(Seconds) {//**************************************
	var Hours = Math.floor(Seconds / 3600); Seconds = Seconds % 3600;
	var Minutes = Math.floor(Seconds / 60); Seconds = Seconds % 60;
	if ((Hours == 0) && (Minutes == 0)) { Minutes = "" } else { Minutes = pad(Minutes) }
	if (Hours == 0) { Hours = ""} else { Hours = pad(Hours) + ":"}

	return (Hours + Minutes + ":" + pad(Seconds));
}//end FormatTime() //************************************************



function format_number(number, sep) {//*******************************
	sep = typeof sep !== 'undefined' ? sep : ','; //default to a comma
	var number	= number + "";   // 1234567890     convert number to a string
	var result  = "";            // 1,234,567,890  sample result

	for (var x = 0; x < number.length ; x += 3) {
		a = number.length - x - 3;
		b = number.length - x;
		result = number.substring(a,b) + result;
		if (a > 0) {result = sep + result} //add sep if still have more digits
	}
	return result;
}//end format_number() //*********************************************



//********************************************************************
function Countdown(count, End_Time, Timer_ID, Action){
	var Timer        = document.getElementById(Timer_ID);
	var Current_Time = Math.round(new Date().getTime()/1000); //js uses milliseconds
	    count        = End_Time - Current_Time;
	var params = count + ', "' + End_Time + '", "' + Timer_ID + '", "' + Action + '"';

	var $msg_box = document.getElementById('message_box');

	Timer.innerHTML = FormatTime(count);

	if ((count == <?php echo $TO_WARNING ?>) && (Action != "")) { //Two minute warning...
		
		var timeout_warning  = '<div class="message_box_contents"><b><?php echo hsc($_['session_warning']) ?></b> ';
			timeout_warning += '<b><span id=timer2>:--</span></b></div>';
		$msg_box.innerHTML  = timeout_warning;
		setTimeout('Start_Countdown(' + count + ',"timer2","")',25);
		
		var Timer2 = document.getElementById('timer2');
		Timer.style.color           = Timer2.style.color           = "red";
		Timer.style.fontWeight      = Timer2.style.fontWeight      = "900";
		Timer.style.backgroundColor = Timer2.style.backgroundColor = "white";
	}

	if ( count < 1 ) {
		if ( Action == 'LOGOUT') {
			Timer.innerHTML        = '<?php echo hsc($_['session_expired']) ?>';
			$msg_box.innerHTML = '<div class=message_box_contents><b><?php echo hsc($_['session_expired']) ?></b></div>';
			//Load login screen, but delay first to make sure really expired:
			setTimeout('window.location = window.location.pathname', <?php echo $DELAY_Expired_Reload ?>);
		}
		return;
	}
	setTimeout('Countdown(' + params + ')',1000); //1000 = one second
}//end Countdown() //*************************************************



function Start_Countdown(count, ID, Action) {//***********************

	var Time_Start  = Math.round(new Date().getTime()/1000); //in seconds
	var Time_End    = Time_Start + count;

	Countdown(count, Time_End, ID, Action); //(seconds to count, id of element)
}//end Start_Countdown() //*******************************************



//********************************************************************
function FileTimeStamp(php_filemtime, show_date, show_offset, write_return){

	//php's filemtime returns seconds, javascript's date() uses milliseconds.
	var FileMTime = php_filemtime * 1000;

	var TIMESTAMP  = new Date(FileMTime);
	var YEAR  = TIMESTAMP.getFullYear();
	var	MONTH = pad(TIMESTAMP.getMonth() + 1);
	var DATE  = pad(TIMESTAMP.getDate());
	var HOURS = TIMESTAMP.getHours();
	var MINS  = pad(TIMESTAMP.getMinutes());
	var SECS  = pad(TIMESTAMP.getSeconds());

	if ( HOURS < 12) { AMPM = "am"; } else { AMPM = "pm"; }
	if ( HOURS > 12 ) {HOURS = HOURS - 12; }
	HOURS = pad(HOURS);

	var GMT_offset = -(TIMESTAMP.getTimezoneOffset()); //Yes, I know- seems wrong, but its works.

	if (GMT_offset < 0) { NEG = -1; SIGN = "-"; } else { NEG = 1; SIGN = "+"; }

	var offset_HOURS = Math.floor(NEG*GMT_offset/60);
	var offset_MINS  = pad( NEG * (GMT_offset % 60) );
	var offset_FULL  = "UTC " + SIGN + offset_HOURS + ":" + offset_MINS;

	var FULLDATE = YEAR + "-" + MONTH + "-" + DATE;
	var FULLTIME = HOURS + ":" + MINS + ":" + SECS + " " + AMPM;

	var               DATETIME = FULLTIME;
	if (show_date)  { DATETIME = FULLDATE + " &nbsp;" + FULLTIME;}
	if (show_offset){ DATETIME += " ("+offset_FULL+")"; }
		
	if (write_return) { document.write(DATETIME); }
	else 			  { return DATETIME; }
}//end FileTimeStamp() //*********************************************



function Display_Messages($msg, take_focus) {//***********************

	if (typeof take_focus === 'undefined') {take_focus = 0;}  //default is X_box doesn't take focus()

	if (typeof $tabindex_xbox === 'undefined') {$tabindex_xbox = 0;}

	var $page     = '<?php echo $page ?>';
	var new_focus = '';

	if      ($page == 'index') { new_focus = 'header_filename'; }
	else if ($page == 'edit')  { new_focus = 'close1'; }
	else if ($page == 'login') { new_focus = 'username'; }
	else if ($page == 'hash')  { new_focus = 'whattohash'; }
	else if ($page == 'admin') { new_focus = 'close'; }

	var $X_box		 = '<button tabindex=' + $tabindex_xbox + ' type=button id=X_box>&times;</button>';
	var $msg_div	 = '<div class=message_box_contents>' + $msg + '</div>';
	var $msg_box     = document.getElementById("message_box");
	var $new_focus	 = document.getElementById(new_focus)

	if ($msg == '') { $msg_box.innerHTML = ' '; } //innerHTML must be given a space or $msg_box won't clear.
	else {
		$msg_box.innerHTML = $X_box + $msg_div;
		var $X_box_btn	 = document.getElementById('X_box');
		if (take_focus) {$X_box_btn.focus();}
		$X_box_btn.onclick = function () { $msg_box.innerHTML = " "; $new_focus.focus();}
	}

}//end Display_Messages() //******************************************

</script>

<?php
}//end common_scripts() //******************************************************




function Index_Page_events() {//************************************************
	global $_, $PAGEUPDOWN, $EX;
?>
<script>
//onclick events
var Select_All_ckbox	= document.getElementById('select_all_ckbox');
var Header_Sorttype		= document.getElementById('header_sorttype');
var Folders_First_Ckbox = document.getElementById('folders_first_ckbox');
var Header_Filename		= document.getElementById('header_filename');
var Header_Filesize		= document.getElementById('header_filesize');
var Header_Filedate		= document.getElementById('header_filedate');

Select_All_ckbox.onclick	 = function () {Select_All();}
Folders_First_Ckbox.onclick  = function () {Sort_and_Show(SORT_by, SORT_order); this.focus()}
Header_Filename.onclick  = function () {Sort_and_Show(1, FLIP_IF); this.focus(); return false;}
Header_Filesize.onclick  = function () {Sort_and_Show(2, FLIP_IF); this.focus(); return false;}
Header_Filedate.onclick  = function () {Sort_and_Show(3, FLIP_IF); this.focus(); return false;}
Header_Sorttype.onclick	 = function () {Sort_and_Show(5, FLIP_IF); this.focus(); return false;}

Header_Filename.focus();



document.onmousedown = function (event) { //************************
	//Mouse clicks may remove focus from focused elements, including checkboxes, 
	//but do not clear the manual "highlight" of the parent div's & label's of checkbox's

	//Clear parent div of a checkbox
	var ID = document.activeElement.id;
	if (document.activeElement.type == 'checkbox') {
		document.getElementById(ID).parentNode.style.backgroundColor = "";
	}

	//Clear labels...  (don't check, just clear 'em)
	document.getElementById('select_all_label').style.backgroundColor = "";
	document.getElementById('folders_first_label').style.backgroundColor = "";

}//end onmousedown() //***********************************************



function on_Tab_down(ID, FR,shifted) { //*****************************
	//Handle the background colors of checkboxes' parent <div>'s & <label>'s.
	//(checkboxes generally don't have "background colors" as far as css goes...)
	//Current checkbox already cleared by onkeydown().

	//Prep for Tab key...
	//Default tab action occurrs on keyUP, so "new" location is not known by onkeydown().
	//So, if current focus is ck_box, clear bg, else if we're heading there, set bg.
	//Tab from L, Current ID will be "f<FR>c2"
	//Tab from R: Current ID is "f<FR>"
	var fFR   = "f" + FR + "c4" //Filename
	var ckbox = "f" + FR + "c3" //[ ] Checkbox
	var del   = "f" + FR + "c2" //(x) Delete

	var ck_box = document.getElementById(ckbox);
	var highlight1 = "rgb(255,250,150)";
	var highlight2 = "rgb(255,240,140)";

	if      (!shifted)  { //just Tab
		if      (ID == ckbox) { ck_box.parentNode.style.backgroundColor = "";}
		else if (ID == del  ) { ck_box.parentNode.style.backgroundColor = highlight2; }
		else if (ID == "b6" ) { //[New Folder]
			document.getElementById('select_all_ckbox').parentNode.style.backgroundColor = highlight1;
			document.getElementById('select_all_label').style.backgroundColor = highlight1;
		}
		else if (ID == "select_all_ckbox" ) {
			document.getElementById('select_all_label').style.backgroundColor = "";
			document.getElementById('folders_first_ckbox').parentNode.style.backgroundColor = highlight1;
			document.getElementById('folders_first_label').style.backgroundColor = highlight1;
		}
	}
	else if (shifted)  { //Shift-Tab
		if       (ID == ckbox){ ck_box.parentNode.style.backgroundColor = "";}
		else if ((ID == fFR) && (FR > 0) ) { ck_box.parentNode.style.backgroundColor = highlight2; }
		else if  (ID == "header_filename")  {
			document.getElementById('folders_first_ckbox').parentNode.style.backgroundColor = highlight1;
			document.getElementById('folders_first_label').style.backgroundColor = highlight1;
		}
		else if (ID == "folders_first_ckbox") {
			document.getElementById('folders_first_label').style.backgroundColor = "";
			document.getElementById('select_all_ckbox').parentNode.style.backgroundColor = highlight1;
			document.getElementById('select_all_label').style.backgroundColor = highlight1;
		}
	}
}//end on_Tab_down() { //*********************************************




document.onkeydown = function(event) { //*****************************
	//Control cursor keys to navigate index page. (Arrows, Page, Home, End)

	var jump = <?php echo $PAGEUPDOWN ?>;//# of rows to jump with Page Up/Page Down.
	var highlight1 = "rgb(255,250,150)";
	var highlight2 = "rgb(255,240,140)";

	//Get key pressed...
	if (!event) {var event = window.event;} //for IE
	var key = event.keyCode;

	//Assign a few handy "constants": Arrow U/D/L/R, Page Up/Down, etc... 
	var AU = 38, AD = 40, AL = 37, AR = 39, PU = 33, PD = 34; END = 35, HOME = 36, ESC = 27, TAB = 9, ENTER = 13;

	//Ignore any other key presses...
	if ((key != AU) && (key != AD) && (key != AL) && (key != AR) && (key != PU) && (key != PD) && 
		(key != HOME) && (key != END) && (key != ESC) && (key != TAB) && (key != ENTER)) { return }

	//File Rows. For these events, "../" is 0, and files are indexed 1 to DIRECTORY_ITEMS.
	var FROWS     = DIRECTORY_ITEMS;
	var LAST_FILE = "f" + FROWS + "c4";
	var FIRST_FILE = "f0c4";

	//Get id of current focus (before this event). If focus is in file list, ID = 'fn', or 'fnn', etc.
	var ID      = document.activeElement.id;
	var x_focus = ID.substr(0,1);

	//When ID=f00c0 (zeros mean any digit)
	//FR: Digits after "f" are the (F)ile (R)ow    (0,1, ... FROWS)
	//FC: Digit  after 'c' is  the (F)ile (C)olumn (0=move, 1=copy, 2=del, 3=ckbox)
	var FR = parseInt(ID.substr(1));      if (isNaN(FR) || (x_focus != "f")) {FR = -1;} //If not in file list...
	var FC = parseInt(ID.split('c')[1]);  if (isNaN(FC)) {FC = -1;}

	if(key != ENTER) { //(ignore if ENTER since focus doesn't change.)
		
		//If current ID/element is checkbox, clear bgcolor of parent div (ckboxes don't have background colors).
		var is_ckbox = (document.activeElement.type == "checkbox");
		if (is_ckbox) {document.getElementById(ID).parentNode.style.backgroundColor = ""; }
		
		//Always clear these labels (simply losing focus() of their child checkboxes won't).
		document.getElementById('select_all_label').style.backgroundColor = "";
		document.getElementById('folders_first_label').style.backgroundColor = "";
	}

	//If no files in current folder, [Move][Copy][Delete] won't exist (id's b1 b2 b3). Use [New Folder] (id="b4").
	if (document.getElementById("b2")) {var button_row = "b2"} else {var button_row = "b4"}

	//Indicate if current focus is on one of the elements of the table header row. (true / false)
	//Select All[ ] | [x](folders first) Name  (.ext) | Size |  Date  |
	var focus_header = ((ID == "select_all_ckbox") || (ID == "folders_first_ckbox") || (ID == "header_filename") || 
						(ID == "header_sorttype")  || (ID == "header_filesize")     || (ID == "header_filedate"));

	//Prep for Arrow Left/Right keys ...
	//To simulate Tab/Shift-tab, get list of all tab-able tags.
	//Below, will compare each tabindex to current tabindex, and allow for skips in tabindex.
	//All tab-able tags should have a tabindex = 1, 2, 3... etc, with no duplicates.
	if ((key == AL) || (key == AR)){
		var focus_tabindex = document.activeElement.tabIndex;
		
		//Need to check all elements on each onkeydown(), in case things change (like closing of message box).
		var all_tags     = document.getElementsByTagName('*');
		var tag_count    = all_tags.length;
		var tabindex_IDs = []; //Array of ID's of all tags with a tabindex, indexed by tabindex.
		
		//Create array of the ID's of all tags with a tabindex. (All tabable elements should have a tabindex set.)
		for (var x = 0; x < tag_count; x++) {
			var ti = all_tags[x].tabIndex;
			if (ti > 0) { tabindex_IDs[ti] = all_tags[x].id; }
		}
	}

	//PROCESS THE KEYDOWN EVENT... /////////////////////////////////////////////
	//In general:
	//  ENTER - enabled to check/unckeck checkboxes, and respond as needed.
	//  Tab- handle checkbox's (parent <div>'s & <label>'s), otherwise allow default action.
	//  Esc simply removes focus from active element.
	//	Home goes to the first row in list - (../)
	//	End goes only to last file in list.
	//	Arrow Up/Down will loop from (top to bottom)/(bottom to top) of page (no hard stops).
	//  Page Up/Down will likewise loop thru page, with soft-stops at first/last filenames.
	//  Arrow Left/Right will function similarly to Tab/Shift-Tab, but hard stop at first/last link on page.

	if (key == ENTER) {	
		
		if (ID == "select_all_ckbox") {
			document.mcdselect.select_all.checked = !document.mcdselect.select_all.checked
			Select_All();
		}
		else if (ID == "folders_first_ckbox") {
			document.mcdselect.folders_first_ckbox.checked = !document.mcdselect.folders_first_ckbox.checked;
			Sort_and_Show(SORT_by, SORT_order);
		}
		else if (FC == 3) {  //Is focus on a checkbox next to a file name?
			document.getElementById(ID).checked = !document.getElementById(ID).checked;
		}
		
		return;
	}
	else if (key == TAB)  {
		on_Tab_down(ID, FR, event.shiftKey);
		return;
	}
	else if (key == ESC)  { document.activeElement.blur();    return; }
	else if (key == END)  { if (ID != LAST_FILE ) {ID = LAST_FILE; } }
	else if (key == HOME) {	if (ID != FIRST_FILE) {ID = FIRST_FILE;} }
	else if (key == AL) {
		//Find first tab-able element to the left (usually just (focus_tabindex - 1))
		for (var new_index = (focus_tabindex - 1); new_index > 0; new_index--) {
			if (tabindex_IDs[new_index]) { ID = tabindex_IDs[new_index]; break; }
		}
	}
	else if (key == AR) {
		//Find first tab-able element to the right (usually just (focus_tabindex + 1))
		for (var new_index = (focus_tabindex + 1); new_index < tabindex_IDs.length; new_index++) {
			if (tabindex_IDs[new_index]) { ID = tabindex_IDs[new_index]; break; }
		}
	}
	else if (ID == "admin") {
		if      (key == AU) {ID = LAST_FILE}
		else if (key == PU) {ID = LAST_FILE}
		else if (key == AD) {ID = "logo"}
		else if (key == PD) {ID = "logo"}
	}
	else if ((ID == "logo")|| (ID == "on_php") || (ID == "website") || (ID == "logout")) {
		if      (key == AU) {ID = "admin"}
		else if (key == PU) {ID = "admin"}
		else if (key == AD) {ID = "path_0"}
		else if (key == PD) {ID = "f0c4"}
	}
	else if (ID == "X_box") {
		if      (key == AU)   {ID = "path_0"}
		else if (key == PU)   {ID = "logo"}
		else if (key == AD)   {ID = button_row}
		else if (key == PD)   {ID = "f0c4"}
	}
	else if (x_focus == 'p') { //In path_header: webroot/current/path/
		if      (key == AU)   {ID = "logo"}
		else if (key == PU)   {ID = "logo"}
		else if (key == AD)   {ID = button_row}
		else if (key == PD)   {ID = "f0c4"}
	}
	else if (x_focus == "b") { //[Move][Copy][Delete]  [New Folder][New File][Upload File]
		if 		(key == AU) {ID = "path_0"		   }
		else if (key == PU) {ID = "path_0"		   }
		else if (key == AD) {ID = "header_filename"}
		else if (key == PD) {ID = "f0c4"		   }
	}
	else if (focus_header) { //Table header row
		if      (key == AU) {ID = button_row}
		else if (key == PU) {ID = "path_0"}
		else if	(key == AD) {ID = "f0c4"}
		else if	(key == PD) {FR += jump; if (FR < FROWS) {ID = "f" + FR + "c4"} else {ID = LAST_FILE}}
	}
	else if ((FR == 0) && (FROWS == 0)) { //empty folder
		if		(key == AU) {ID = "header_filename"}
		else if	(key == PU) {ID = "path_0"}
		else if (key == AD) {ID = "admin";}
		else if (key == PD) {ID = "admin";}
	}
	else if (FR == FROWS) { //Last row (FROWS is the number of files listed)
		if		(key == AU) { FR--      ; if (FR >= 0) {ID = "f" + FR + "c" + FC} else {ID = "header_filename" } }
		else if	(key == PU) { FR -= jump; if (FR >= 0) {ID = "f" + FR + "c" + FC} else {ID = "f0c4"} }
		else if (key == AD) { ID = "admin" }
		else if (key == PD) { ID = "admin" }
	}
	else if (FR == 0) { //FR (File Row) is in the first row of files
		if		(key == AU) {ID = "header_filename"}
		else if	(key == PU) {ID = "path_0"}
		else if (key == AD) {FR++      ; if (FR <= FROWS) {ID = "f" + FR + "c" + FC} else {ID = "path_0";}  }
		else if (key == PD) {FR += jump; if (FR <= FROWS) {ID = "f" + FR + "c" + FC} else {ID = LAST_FILE;} }
	}
	else if (FR > 0){ //Middle rows...
		if		(key == AU) { FR--      ; if (FR == 0) {FC=4} ID = "f" + FR + "c" + FC;	}
		else if	(key == PU) { FR -= jump; if (FR >= 0)      { ID = "f" + FR + "c" + FC} else {ID = "f0c4"}	 }
		else if (key == AD) { FR++; 	  if (FR <= FROWS)  { ID = "f" + FR + "c" + FC} else {ID = "path_0"; } }
		else if (key == PD) { FR += jump; if (FR <= FROWS)  { ID = "f" + FR + "c" + FC} else {ID = LAST_FILE;} }
	}
	else if (FR == -1) {ID = "path_0"}     //Anyplace other than path_header, buttons, table
	else {
		//just in case I missed something...
		var error_message  = '<?php echo __LINE__.$EX.'<b>'.hsc($_['Error']).'</b> onkeydown(): ' ?>';
		    error_message += "key = " + key + ", FR = " + FR + ", ID = " + ID + ",x_focus = " + x_focus
		Display_Messages(error_message);
		return;
	}

	document.getElementById(ID).focus();

	//If new ID/element is checkbox, set bgcolor of parent div & it's label (ckboxes don't have background colors).
	if (document.activeElement.type == "checkbox") {document.getElementById(ID).parentNode.style.backgroundColor = highlight2;}
	if (ID == "select_all_ckbox")    {document.getElementById('select_all_label').style.backgroundColor = highlight1;}
	if (ID == "folders_first_ckbox") {document.getElementById('folders_first_label').style.backgroundColor = highlight1;}

	//Prevent default browser scrolling via arrow & Page keys, so focus()'d element stays visible/in view port.
	//(A few exceptions skip this via a return in the above  if/else's.)
	if ( (ID != 'path_0') || ((ID == 'path_0') && (key == AD)) || ((ID == 'path_0') && (key == PD))) {
		if (event.preventDefault) { event.preventDefault() } else { event.returnValue = false }
	}
}//end onkeydown() //*************************************************
</script>
<?php
}//end Index_Page_events() //***************************************************




function Index_Page_scripts() {//***********************************************
	global $_, $ONESCRIPT, $param1, $ipath, $MESSAGE, $DELAY_Sort_and_Show_msgs, $MIN_DIR_ITEMS, $TABINDEX;
?>
<script>
//  DIRECTORY_DATA[x] = ("type", "file name", filesize, timestamp, is_ofcms, "ext")	
var DIRECTORY_DATA	  = new Array();

var ONESCRIPT	= "<?php echo $ONESCRIPT ?>";
var PARAM1		= "<?php echo $param1 ?>";  //capitalized here as it is used as a constant.
var TABINDEX    = <?php echo $TABINDEX ?>;  //TABINDEX only used by js from this point on...

//a few usefull constants for using sort_DIRECTORY()
var DESCENDING	= 0;
var ASCENDING	= 1;
var FLIP		= 2; //Reverse the current direction (ascending <-> descending)
var FLIP_IF		= 3; //Flip only if new column selected.

//A few flags for using sort_DIRECTORY(). These are not constants.
var SORT_by		     = '1';   // Sort key (column) from DIRECTORY_DATA[x][key].
var SORT_order       = true;  // Default to "normal" sort orders (ascending). Set to false for reverse (descending).
var SORT_folders_1st = true;  // Initially set to true. false = did not consider folders during prior sort.




function Sort_Folders_First() {//*************************************

	//DIRECTORY_DATA[x] = ("type", "file name", filesize, timestamp, is_ofcms)	

	var type = ""; //= row_data[0] = DIRECTORY_DATA[x][0]
	var files   = new Array();
	var folders = new Array();
	var row_data = new Array();
	var F = D = row = 0;  //indexes

	for (row = 0; row < DIRECTORY_DATA.length; row++) {;
		row_data = DIRECTORY_DATA[row];
		type     = row_data[0];
		if (type == "dir") { folders[D++] = row_data; }
		else 			   { files[F++]   = row_data; }
	}//end for

	//Replace contents of DIRECTORY_DATA[] with a "merged" folders[] & files[].
	DIRECTORY_DATA = new Array();
	row = 0
	for (D = 0; D < folders.length; D++) { DIRECTORY_DATA[row++] = folders[D]; }
	for (F = 0; F < files.length;   F++) { DIRECTORY_DATA[row++] = files[F];   }

	SORT_folders_1st = true;

}//end Sort_Folders_First() //****************************************




function sort_DIRECTORY(col, direction) {//***************************

	if (DIRECTORY_DATA.length < 2) {return} //can't sort 1 or zero items.

	//sort DIRECTORY_DATA[] by col and direction

	//col: 1 for "file name", 2 for filesize, 3 for timestamp, 5 for "ext"
	//direction: 0 = desending, 1 = ascending, 2 = flip, 3 = flip only if new col != SORT_by

	//SORT_by, SORT_order, and SORT_folders_1st: values set by prior (or initial) sort.

	//If needed, set default col and/or direction.
	if (typeof col       === 'undefined') { col = 1 }
	if (typeof direction === 'undefined') { direction = ASCENDING }

	//Filename ckboxes are cleared automatically on a resort, in Assemble_Insert_row(), so this needs cleared also.
	Select_All_ckbox.checked = false;

	//If new sort column, sort ascending. (FLIP overides, but is not currently used.)
	if ((col != SORT_by) && (direction != FLIP)) { direction = ASCENDING; SORT_by = col; } 

	//Get status of [x](folders first) checkbox
	var folders_first_checked = document.getElementById('folders_first_ckbox').checked;

	//If '[x](folders first)' is now checked, but was previously unchecked,
	//no need to re-sort by col, just sort by folders. Otherwise, first resort by column.
	if ( !(folders_first_checked && !SORT_folders_1st) ) { 
		
		if      ( direction == ASCENDING  ) { SORT_order = true;  }
		else if ( direction == DESCENDING ) { SORT_order = false; }
		else if ( direction == FLIP       ) { SORT_order = !SORT_order; }
		else if ( direction == FLIP_IF    ) { SORT_order = !SORT_order; }
		else                                { SORT_order = true; }
		
		if (col == 1 || col == 5) {  // If "file name" or "ext", sort alphabetically
			if (SORT_order) { DIRECTORY_DATA.sort( function (a, b) {return a[col].localeCompare(b[col]);} ); }
			else            { DIRECTORY_DATA.sort( function (b, a) {return a[col].localeCompare(b[col]);} ); }		
		} else { //sort numerically
			if (SORT_order) { DIRECTORY_DATA.sort( function (a, b) {return a[col]       -       b[col] ;} ); }
			else            { DIRECTORY_DATA.sort( function (b, a) {return a[col]       -       b[col] ;} ); }
		}
	}//end if folders first only / full resort

	if (folders_first_checked == true) { Sort_Folders_First(); }

}//end sort_DIRECTORY() //********************************************




function Init_Dir_table_rows(DIR_LIST) {//****************************

	var row, cell, cells, tr, td;

	for (row = 0; row < DIRECTORY_ITEMS; row++){
		
		//initialize <tr> with empty <td>'s
		tr = DIR_LIST.insertRow(row);
		for (cell = 0; cell < 7; cell++) {td = tr.insertCell(-1);}
		cells = tr.cells;
		
		//assign css classes
		cells[4].className = 'file_name';
		cells[5].className = 'file_size meta_T';
		cells[6].className = 'file_time meta_T';
	}
}//end Init_Dir_table_rows() {//**************************************




//********************************************************************
function Assemble_Insert_row(IS_OFCMS, row, trow, href, f_or_f, filename, file_name, file_size, file_time){

	//While DIRECTORY_DATA, and the table rows created to list the data, are indexed from 0 (zero),
	//the id's of files in the directory list are indexed from 1 (f1, f2...), as "../" is listed first with id=f0 (f-zero).
	//The id's are used in Index_Page_events() "cursor" control.
	row++;

	//[Move] [Copy] [Delete]  [x]
	var ren_mov  = copy = del = checkbox = '';

	//Assemble [move] [copy] [delete] [x]   ([copy] is always available)
	//The empty <a>'s are to accommodate keyboard nav via onkeydown() in Index_Page_events()...
	if (!IS_OFCMS) {
		ren_mov  = '<a id=f' + row + 'c0 tabindex='+ (TABINDEX++) +' class=MCD href="' + href + '&amp;p=rename' + f_or_f + '" title="<?php echo hsc($_['Ren_Move']) ?>">' + ICONS['ren_mov'] + '</a>';
	} else {
		ren_mov  = '<a id=f' + row + 'c0 tabindex='+ (TABINDEX++) +'>&nbsp;</a>'
	}

	copy         = '<a id=f' + row + 'c1 tabindex='+ (TABINDEX++) +' class=MCD href="' + href + '&amp;p=copy'   + f_or_f + '" title="<?php echo hsc($_['Copy'])     ?>">' + ICONS['copy']    + '</a>';

	if (!IS_OFCMS) {
		del      = '<a id=f' + row + 'c2 tabindex='+ (TABINDEX++) +' class=MCD href="' + href + '&amp;p=delete' + f_or_f + '" title="<?php echo hsc($_['Delete'])   ?>">' + ICONS['delete']  + '</a>';
		checkbox = '<div class=ckbox><INPUT id=f' + row + 'c3 tabindex='+ (TABINDEX++) +' TYPE=checkbox class=select_file NAME="files[]"  VALUE="'+ hsc(filename) +'"></div>';
	} else {
		del      = '<a id=f' + row + 'c2 tabindex='+ (TABINDEX++) +'>&nbsp;</a>'
		checkbox = '<a id=f' + row + 'c3 tabindex='+ (TABINDEX++) +'>&nbsp;</a>'
	}

	//fill the <td>'s
	cells = trow.cells;
	cells[0].innerHTML = ren_mov;
	cells[1].innerHTML = copy;
	cells[2].innerHTML = del;
	cells[3].innerHTML = checkbox;
	cells[4].innerHTML = file_name;
	cells[5].innerHTML = file_size;
	cells[6].innerHTML = file_time;

}//end Assemble_Insert_row() //***************************************




function Build_Directory() {//****************************************

	TABINDEX    = <?php echo $TABINDEX ?>;  //Rest TABINDEX

	var DIR_LIST = document.getElementById("DIRECTORY_LISTING");

	if (DIR_LIST.rows.length < 1) {Init_Dir_table_rows(DIR_LIST);}

	for (var row = 0; row < DIRECTORY_ITEMS; row++) {
		
		var filetype = DIRECTORY_DATA[row][0];
		var filename = DIRECTORY_DATA[row][1];
		var filesize = DIRECTORY_DATA[row][2];
		var filetime = DIRECTORY_DATA[row][3];
		
		//folder or file?
		if (filetype == "dir"){
			var DS        = ' /';
			var f_or_f    = 'folder';
			var href      = ONESCRIPT + PARAM1 + encodeURIComponent(filename);
			var file_size = '';
		} else {
			var DS        = '';
			var f_or_f    = 'file';
			var href      = ONESCRIPT + PARAM1 + '&amp;f=' + encodeURIComponent(filename) + '&amp;p=edit';
			var file_size = format_number(filesize);
		}
		
		//For file, (TABINDEX + 4) to account for [m][c][d][x] which are added in Assemble_Insert_Row()
		var file_name  = '<a id=f'+(row + 1)+'c'+4+ ' tabindex='+ (TABINDEX + 4) +' href="' + href  + '"'; 
			file_name += ' title="<?php echo hsc($_['Edit_View']) ?>: ' + hsc(filename) + '" >';
			file_name += ICONS[filetype] + '&nbsp;' + hsc(filename) + DS + '</a>';
		var file_time  = FileTimeStamp(filetime, 1, 0, 0);
		
		var IS_OFCMS = DIRECTORY_DATA[row][4];
		var trow = DIR_LIST.rows[row];
		
		Assemble_Insert_row(IS_OFCMS, row, trow, href, f_or_f, filename, file_name, file_size, file_time);
		TABINDEX++; //To accuont for file_name above
	}//end for (row...
}//end Build_Directory() //*******************************************




function Directory_Summary() {//**************************************

	var total_items  = DIRECTORY_DATA.length;
	var folder_count = 0;
	var total_bytes  = 0;
	var SUMMARY      = "";

	//Add up file sizes...
	for (x=0; x < DIRECTORY_DATA.length; x++) {
		filetype = DIRECTORY_DATA[x][0];
		filename = DIRECTORY_DATA[x][1];
		if (filetype == "dir"){ folder_count++; }
		total_bytes += DIRECTORY_DATA[x][2];
	}

	//Directory Summary
	SUMMARY += folder_count + " <?php echo hsc($_['folders']) ?>, &nbsp; ";
	SUMMARY += total_items - folder_count + ' <?php echo hsc($_['files']) ?>, ';
	SUMMARY += '&nbsp; ' + format_number(total_bytes) + " <?php echo hsc($_['bytes']) ?>";

	return SUMMARY;

}//end Directory_Summary() //*****************************************




function Sort_and_Show(col, direction) {//****************************

	var DELAY = 0;

	if (DIRECTORY_ITEMS > <?php echo $MIN_DIR_ITEMS ?>) { //
		//(Any pre-existing $MESSAGE will be displayed after directory is displayed.)
		Display_Messages('<b><?php echo $_['Working'] ?></b>');
		
		DELAY = <?php echo $DELAY_Sort_and_Show_msgs ?>;
	}

	//setTimeout() needed so 'Working' message will actually get displayed *before* the sort.
	setTimeout( function () {
		sort_DIRECTORY(col, direction); //Sort DIRECTORY_DATA
		Build_Directory();
		document.getElementById('DIRECTORY_FOOTER').innerHTML = Directory_Summary();
		Display_Messages('');
	}, DELAY);

}//end Sort_and_Show() //*********************************************




function Select_All() {//********************************************

	//Does not work in IE if the variable name is spelled the same as the Element Id
	//So, prefix with a dollar sign (a valid character in JS for variable names).
	$select_all_label = document.getElementById('select_all_label');

	var files = document.mcdselect.elements['files[]'];
	var last  = files.length; //number of files
	var select_all = document.mcdselect.select_all;

	if (select_all.checked) {
		$select_all_label.innerHTML = '<?php echo hsc($_['Clear_All']) ?>';
	}else{
		$select_all_label.innerHTML = '<?php echo hsc($_['Select_All']) ?>';
	}

	//Start x at 1 as files[0] is a dummy <input> used to force an array even if only one file is in a folder.
	for (var x = 1; x < last ; x++) { files[x].checked = select_all.checked; }
}//end Select_All() //************************************************




function Confirm_Submit(action) {//***********************************

	var files = document.mcdselect.elements['files[]'];
	var last  = files.length;   //number of files
	var no_files = true;
	var f_msg    = "<?php echo hsc($_['No_files']) ?>";	

	document.mcdselect.mcdaction.value = action; 

	//Confirm at least one file is checked
	for (var x = 0; x < last ; x++) {
		if (files[x].checked) { no_files = false ; break; }
	}

	//Don't submit form if no files are checked.
	if ( no_files ) { Display_Messages(f_msg, 1); return false; }

	document.mcdselect.submit(); //submit form.
}//end Confirm_Submit() //********************************************

</script>

<?php
}//end Index_Page_scripts() //**************************************************




function Edit_Page_scripts() {//************************************************
	global $_, $ONESCRIPT, $ONESCRIPT_file, $ipath, $param1, $param2, $filename, $LINE_WRAP,
			$MAIN_WIDTH, $WIDE_VIEW_WIDTH, $current_view, $WYSIWYG_VALID, $EDIT_WYSIWYG, $TAB_SIZE;

	//Get current view width.
	$current_view = $MAIN_WIDTH; //default
	if ( $_COOKIE['wide_view'] === "on" ) { $current_view = $WIDE_VIEW_WIDTH; }

	//For [Edit WYSIWYG/Source] button
	$WYSIWYG_onclick  = "parent.location = onclick_params + 'edit'; ";
	$WYSIWYG_onclick .= "document.cookie='edit_wysiwyg=".(!$EDIT_WYSIWYG*1)."';";

	//For [Close] button
	$close_params = $ONESCRIPT.$param1;
	if ( $_SESSION['admin_page'] ) { $close_params .= '&p=admin'; } //If came from admin page, return there.
?>


<script>
function Set_File_Textarea_Width() {
	var Mw  =  parseInt(window.getComputedStyle(Main_div).getPropertyValue("width"));
	var Mbr =  parseInt(window.getComputedStyle(Main_div).getPropertyValue("border-right-width"));
	var Mbl =  parseInt(window.getComputedStyle(Main_div).getPropertyValue("border-left-width"));
	var Lw  =  parseInt(window.getComputedStyle(Line_Numbers_div).getPropertyValue("width"));
	var Lmr =  parseInt(window.getComputedStyle(Line_Numbers_div).getPropertyValue("margin-right"));
	var Fml =  parseInt(window.getComputedStyle(File_textarea).getPropertyValue("margin-left"));
	File_textarea.style.width = (Mw - Lw - Mbr - Mbl- Lmr - Fml) + "px";
}




function Correct_Word_Wrapping(text_area) {

	//Correct word-wrapping and save cursor postion/selection after toggling 
	// between view modes (Wide/Normal or Wrap on/off).
	//When width or wrap changed dynamically, the browser doesn't always wrap 
	// correctly, or seem to use break-all.
	//
	//This is so line-numbers line-up correctly.

	var tmp = text_area.value;
	var cursorX1 = text_area.selectionStart;
	var cursorx2 = text_area.selectionEnd;
	text_area.value = "";
	text_area.value = tmp;
	text_area.selectionStart = cursorX1;
	text_area.selectionEnd   = cursorx2;
}




function Wide_View() {

	var normal_view_width = '<?php echo $MAIN_WIDTH ?>';
	var wide_view_width	  = '<?php echo $WIDE_VIEW_WIDTH ?>';

	//Toggle view width
	if (Wide_View_button.value == "on") {
		Main_div.style.width       = normal_view_width;
		Set_File_Textarea_Width();
		Wide_View_button.innerHTML = "<?php echo hsc($_['Wide_View'])?>"; //Button label is what to do next click, not current state.
		document.cookie            = 'wide_view=off';
		Wide_View_button.value 	   = "off"
	}else{
		Main_div.style.width       = wide_view_width;
		Set_File_Textarea_Width();
		Wide_View_button.innerHTML = '<?php echo hsc($_['Normal_View']) ?>';
		document.cookie            = 'wide_view=on';
		Wide_View_button.value 	   = "on"
	}

	Correct_Word_Wrapping(File_textarea);

	Line_Numbers.Set_Line_Numbers();
}




function Toggle_Line_Wrap(on_off) {

	if (on_off.value == "on") {
		on_off.value  				 = "off"
		document.cookie 			 = 'line_wrap=off'
		File_textarea.style["white-space"] = "pre";
		document.getElementById('w_on').style.textDecoration  = "none";
		document.getElementById('w_off').style.textDecoration = "underline";
	}
	else {
		on_off.value  				 = "on"
		document.cookie				 = 'line_wrap=on'
		File_textarea.style["white-space"] = "pre-wrap";
		document.getElementById('w_on').style.textDecoration  = "underline";
		document.getElementById('w_off').style.textDecoration = "none";
	}

	Correct_Word_Wrapping(File_textarea);

	Line_Numbers.Set_Line_Numbers();
	
}//end Toggle_Line_Wrap()




function Reset_file_status_indicators() {	
	changed = false;
	File_textarea.style.backgroundColor = "#F5FFF5";  //light green
	Save_File_button.style.borderColor  = "";
	Save_File_button.innerHTML          = "<?php echo hsc($_['save_1'])?>";
	Reset_button.disabled               = "disabled";
}




function Check_for_changes(event){
	if (!event) {var event = window.event;} //if IE
	var keycode = event.keyCode? event.keyCode : event.charCode;
	changed = (File_textarea.value != start_value);

	if (changed){
		document.getElementById('message_box').innerHTML = " "; //Must have a space, or it won't clear the msg.
		File_textarea.style.backgroundColor    = "white";
		Save_File_button.style.borderColor	   = "#F33";
		Save_File_button.innerHTML			   = "<?php echo hsc($_['save_2'])?>";
		Reset_button.disabled				   = "";
	}else{
		Reset_file_status_indicators()
	}
}




//Reset textarea value to when page was loaded.
//Used by [Reset] button, and when page unloads (browser back, etc).
//Needed becuase if the page is reloaded (ctl-r, or browser back/forward, etc.),
//the text stays changed, but var "changed" gets set to false, which looses warning.
//
function Reset_File() {

    <?php //use addslashes() because this is for a js alert() or confirm(), not HTML ?>
	if (changed) { if ( !(confirm("<?php echo addslashes($_['confirm_reset']) ?>")) ) { return false; } }

	File_textarea.value = start_value;
	Reset_file_status_indicators();

	File_textarea.selectionStart = 0;
	File_textarea.selectionEnd = 0;

	Line_Numbers.Set_Line_Numbers();

	Close_button.focus();

	//needed so textarea cursor selectionStart/End stay set to 0.  I don't known why. I wish I did...
	return false;
}




function Line_Numbering(wrapper_id, line_numbers_id, listing_id, line0_id, line1_id) {


	//***** functions ************************************************
	
	function Display_Width_Chars() {
		return Math.floor((listing.clientWidth - padding_L - padding_R) / char_width)
	}



	function Line_Count(str) {
		var i = 0
		var line_count = 0;
		
		for (i = 0; i < str.length; ++i) { 
			//Line-endings are normalized to \n elsewhere in OFCMS. (server-side)
			if(str[i] == '\n') { line_count++; }
		}
		
		line_count++;  //Last line doesn't have a new-line at the end.
		return line_count; 
		
	}//end Line_Count()



	function Effective_Line_Length(line, tab_size){
		var TAB = "\t";
		var effective_length = 0;
		var next_tab_stop    = 0;
		
		for (x = 0; x < line.length; x++) {
			//At this point, this may include a tab char, but not any subsequent space(s) to the next tab-stop.
			effective_length++;
			if (effective_length > next_tab_stop) {next_tab_stop += tab_size;}
			if (line[x] == TAB) {effective_length = next_tab_stop;}  //adds the subsequent space to the next tab-stop.
		}
		
		return effective_length;
		
	}//end Effective_Line_Length()



	function Create_Line_Numbers(){
		
		var current_width = Display_Width_Chars();
		
		var lc = Line_Count(listing.value)
		var numbers  = '';	//String to contain the line numbers.
		var lines    = listing.value.split('\n');
		var cur_line = 0;	//listing[cur_line]
		var line_len = 0;	//line length adjusted for tabs, to get effective length, and effective word-wrap.
		var effective_line_length = 0; //line length after tabs are expanded...
		var line_count_wrapped = 0;   //number of visual lines, not neccessarily numbered lines, with line-wrap on.
		
		for(var num = 1; num <= lc; num++) { 
			
			cur_line = num - 1;
			
			numbers += num + "\n";  // \n is MUCH faster than <br>
			
			effective_line_length = Effective_Line_Length(lines[cur_line], TAB_SIZE);
			
			if ((Toggle_Wrap.value == "on") && (effective_line_length > current_width)) {
				
				line_count_wrapped = Math.ceil(effective_line_length / current_width) - 1; //# of addtional lines after wrapped...
				
				//If desired, to mark a continued line, put a dash, plus, or whatever, just before the \n.
				for (var x = 0; x < (line_count_wrapped); x++) { numbers += "\n"; }
			}
		}
		
		line_one.innerHTML = numbers;
		
	}//end Create_Line_Numbers()



	function Set_Line_Numbers(event) {
		
		//Ignore a few keys that don't affect/not needed for line numbering.
		if (event) { //event
			if (window.event) { var event = window.event } 
				
			//Page Up/Down, End, Home, Arrow L/U/R/D
			if ((event.keyCode > 32) && (event.keyCode < 41)) {return;}
		} 
		
		Create_Line_Numbers();
		
		//Scroll/align the line numbers with the textarea.
		line_numbers.scrollTop = listing.scrollTop;
		
	}//end Set_Line_Numbers()

	//*** end functions **********************************************



	//*** common variables *******************************************

	var wrapper		 = document.getElementById(wrapper_id);
	var line_numbers = document.getElementById(line_numbers_id);
	var listing 	 = document.getElementById(listing_id);
	var line_zero    = document.getElementById(line0_id); //empty: used for char-width calc.
	var line_one     = document.getElementById(line1_id); //<div>1</div> will contain the line numbers.

	line_zero.innerHTML = ""; //Just makin' sure. It's only used for the char_width calc.
	
	var char_width     = (line_zero.offsetLeft - line_one.offsetLeft);
	var padding_L 	   = parseInt(window.getComputedStyle(listing).getPropertyValue("padding-left"));
	var padding_R 	   = parseInt(window.getComputedStyle(listing).getPropertyValue("padding-right"));


	//Check for tabSize css support.  Default/standard size is 8.
	var TAB_SIZE = 8;
	
	if ("tabSize" in document.body.style){
		TAB_SIZE = <?php echo $TAB_SIZE ?>;
		listing.style.tabSize = TAB_SIZE;
	}
	else if ("MozTabSize" in document.body.style) {
		TAB_SIZE = <?php echo $TAB_SIZE ?>;
		listing.style.MozTabSize = TAB_SIZE;
	}
	else if ("OTabSize" in document.body.style) {
		TAB_SIZE = <?php echo $TAB_SIZE ?>;
		listing.style.OTabSize = TAB_SIZE;
	}

	//*** end common variables ***************************************



	//*** attach events **********************************************

	if (listing.getAttribute('readonly') === null) {
		//If not readonly (ie: editable)...
		listing.addEventListener("keyup",   function(event){Set_Line_Numbers(event)});
		listing.addEventListener("mouseup", function(event){Set_Line_Numbers(event)});
		listing.addEventListener("paste",   function(event){Set_Line_Numbers(event)});
	}

	listing.addEventListener("scroll",  function(event){Set_Line_Numbers(event)});

	//*** end attach events ******************************************


	//Set initial cursor location to start of file, instead of end (the default).
	listing.selectionStart = 0;
	listing.selectionEnd = 0;


	//Set_Line_Numbers() is also used by Wide_View() & Toggle_Line_Wrap().
	//Toggle_Line_Wrap() will make the initial call to Set_Line_Numbers().
	var LN = {};
	LN.Set_Line_Numbers = Set_Line_Numbers;

	return LN;

}//end Line_Numbering() //********************************************




//***** Global variables *********************************************
var Main_div		   = document.getElementById('main');
var Ln_Editor_wrapper  = document.getElementById('wrapper_linenums_editor');
var Line_Numbers_div   = document.getElementById('line_numbers');
var File_textarea      = document.getElementById('file_editor');
var View_Raw_button    = document.getElementById('view_raw');
var Wide_View_button   = document.getElementById('wide_view');
var WYSIWYG_button	   = document.getElementById('edit_WYSIWYG');
var Close_button       = document.getElementById('close1');
var Toggle_Wrap		   = document.getElementById('toggle_wrap');
var Save_File_button   = document.getElementById('save_file');
var Reset_button       = document.getElementById('reset');
var Rename_File_button = document.getElementById('renamefile_btn');
var Copy_File_button   = document.getElementById('copyfile_btn');
var Delete_File_button = document.getElementById('deletefile_btn');

var submitted  = false;
var changed    = false;

if (File_textarea) { var start_value = File_textarea.value; }

var onclick_params = '<?php echo $ONESCRIPT.$param1.'&f='.rawurlencode(basename($filename)).'&p=' ?>';

//Wide View / Normal View init...
Main_div.style.width = "<?php echo $current_view ?>"; //Set current width
//***** end Global variables *****************************************



//***** Events assignments *******************************************
//[Close], and [Copy], should always be present on Edit Page.
Close_button.onclick     = function () { parent.location = '<?php echo $close_params ?>'; }
Copy_File_button.onclick = function () { parent.location = onclick_params + 'copyfile';   }
Toggle_Wrap.onclick 	 = function () {Toggle_Line_Wrap(this);}

//These elements do not exist if file is not editable, or maybe if in WYSIWYG mode.
if (View_Raw_button)    { View_Raw_button.onclick 	 = function () {window.open(onclick_params + 'raw_view'); } }
if (Wide_View_button)   { Wide_View_button.onclick 	 = function () {Wide_View();}    }
if (Save_File_button)   { Save_File_button.onclick 	 = function () {submitted=true;} }
if (WYSIWYG_button  )   { WYSIWYG_button.onclick 	 = function () {<?php echo $WYSIWYG_onclick ?>} }
if (Rename_File_button) { Rename_File_button.onclick = function () {parent.location = onclick_params + 'renamefile';} }
if (Delete_File_button) { Delete_File_button.onclick = function () {parent.location = onclick_params + 'deletefile';} }
if (File_textarea)      { File_textarea.addEventListener("keyup", function(event) {Check_for_changes(event);}) }


window.onbeforeunload = function() {
	if ( changed && !submitted ) {
		//FF4+ Ingores the supplied msg below & only uses a system msg for the prompt.
		<?php //use addslashes(), not hsc(), because this is for a js alert() / confirm(), not HTML ?>
		return "<?php echo addslashes($_['unload_unsaved']) ?>";
	}
}


window.onunload = function() {
	//without this, a browser back then forward would reload file with local/
	// unsaved changes, but with a green b/g as tho that's the file's saved contents.
	if (!submitted) {
		File_textarea.value = start_value;
		Reset_file_status_indicators();
	}
}
//***** end Events assignments ***************************************




Set_File_Textarea_Width();

Line_Numbers = Line_Numbering("wrapper_linenums_editor", "line_numbers", "file_editor", "line_0", "line_1");

//Set default/page load condition, and also init's the line numbers...
//We're just setting the initial condition now, not actually toggling,
//so "pre-toggle" the indicator here as Toggle_Line_Wrap() will toggle it back...
//
if (Toggle_Wrap.value === "off") {Toggle_Wrap.value = "on";} else {Toggle_Wrap.value = "off";}
Toggle_Line_Wrap(Toggle_Wrap);

Reset_file_status_indicators();

Close_button.focus();
</script>
<?php
}//end Edit_Page_scripts() //***************************************************




function pwun_event_scripts($form_id, $button_id, $pwun='') {//*****************
	global $_;

	//pre-hash "new1" & "new2" only if changing p/w (not if changing u/n).
	$hash_new_new = '';
	if ($pwun == 'pw') {
		$hash_new_new = " hash('new1'); hash('new2');";
	}//end if changing p/w --------------------------------------
?>
<script>
var $form          = document.getElementById('<?php echo $form_id ?>');
var $submit_button = document.getElementById('<?php echo $button_id ?>');
var $pwun_msg_box   = document.getElementById('message_box');
var $thispage      = false; //Used to ignore keyup if keydown started on prior page.
var $submitdown    = false; //Used in document.mouseup event


//Key or mouse down events trigger "Working..." message.
$form.onkeydown            = function(event) {events_down(event, 13);} //Form captures Enter key (13)
$submit_button.onkeydown   = function(event) {events_down(event, 32);} //Submit button captures Space key (32)
$submit_button.onmousedown = function(event) {$submitdown = true; events_down(event,  0);}

//Key or mouse up events trigger hash and submit.
$form.onkeyup              = function(event) {events_up(event, 13);}
$submit_button.onkeyup     = function(event) {events_up(event, 32);}
$submit_button.onmouseup   = function(event) {events_up(event,  0);} //For mouse events, keyCode is 0 or undefined, and ignored.


function events_down(event, capture_key) {
	if (!event) {var event = window.event;} //if IE
	$thispage = true; //Make sure keydown was on this page.
	if ((event.type.substr(0,3) == 'key') && (event.keyCode != capture_key)) {return true;}
	$pwun_msg_box.innerHTML = '<div class="message_box_contents"><b><?php echo hsc($_['Working']) ?></b>';
}


function events_up(event, capture_key) {
	if (!event) {var event = window.event;} //if IE
	if (!$thispage) {return false;} //Ignore keyup if there was no keydown on this page.
	if ((event.type.substr(0,3) == 'key') && (event.keyCode != capture_key)) {return true;}
	if (!pre_validate_pwun()) {return false};
	$submit_button.disabled = "disabled";  //Prevent extra clicks
	hash('password');
	<?php echo $hash_new_new ?>
	$form.submit();
}


document.onmouseup = function(event) {
	if (!event) {var event = window.event;} //if IE

	//if mousedown was on submit button, but mouseup wasn't, clear message.
	var target = event.target || event.srcElement; //target = most brosers || IE
	if ($submitdown && ($submit_button.id != target.id) ) { $pwun_msg_box.innerHTML = ''; } 
	$submitdown = false;
}


function pre_validate_pwun() {
	var $pw = document.getElementById('password');

	var $username = $pw;
	var $new1 	  = $pw;
	var $new2 	  = $pw;

	if (document.getElementById('username')){
		$username = document.getElementById('username');
	}
	if (document.getElementById('new1')){
		$new1 = document.getElementById('new1');
		$new2 = document.getElementById('new2');
	}


	//If any field is blank..
	if (($username.value == '') || ($pw.value == '') || ($new1.value == '') || ($new2.value == '')) {
		$pwun_msg_box.innerHTML = '<div class="message_box_contents"><b><?php echo hsc($_['change_pw_07']) ?></b>';
		return false;
	}
	//If new & confirm new values do not match...
	if (trim($new1.value) != trim($new2.value)) {
		$pwun_msg_box.innerHTML = '<div class="message_box_contents"><b><?php echo hsc($_['change_pw_04']) ?></b>';
		return false;
	}
	return true;
}//end pre_validate_pwun()
</script>

<?php
}//end pwun_event_scripts() //**************************************************




function js_hash_scripts() {//**************************************************
	global $SALT, $PRE_ITERATIONS;

//Used to hash p/w's client side.  This does not really add any security to the 
//server side application that uses it, as the "pre-hash" becomes the actual p/w 
//as far as the server is concerned, and is just as vulnerable to exposure while 
//in transit. However, this does help to protect the user's plain-text p/w, which
//may be used elsewhere.
?>

<script>
/* hex_sha256() (and directly associated functions)
 *
 * A JavaScript implementation of SHA-256, as defined in FIPS 180-2
 * Version 2.2 Copyright Angel Marin, Paul Johnston 2000 - 2009.
 * Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
 * Distributed under the BSD License 
 * See http://pajhome.org.uk/crypt/md5 for details.
 * Also http://anmar.eu.org/projects/jssha2/
 */
var hexcase=0;function hex_sha256(a){return rstr2hex(rstr_sha256(str2rstr_utf8(a)))}function sha256_vm_test(){return hex_sha256("abc").toLowerCase()=="ba7816bf8f01cfea414140de5dae2223b00361a396177a9cb410ff61f20015ad"}function rstr_sha256(a){return binb2rstr(binb_sha256(rstr2binb(a),a.length*8))}function rstr2hex(c){try{hexcase}catch(g){hexcase=0}var f=hexcase?"0123456789ABCDEF":"0123456789abcdef";var b="";var a;for(var d=0;d<c.length;d++){a=c.charCodeAt(d);b+=f.charAt((a>>>4)&15)+f.charAt(a&15)}return b}function str2rstr_utf8(c){var b="";var d=-1;var a,e;while(++d<c.length){a=c.charCodeAt(d);e=d+1<c.length?c.charCodeAt(d+1):0;if(55296<=a&&a<=56319&&56320<=e&&e<=57343){a=65536+((a&1023)<<10)+(e&1023);d++}if(a<=127){b+=String.fromCharCode(a)}else{if(a<=2047){b+=String.fromCharCode(192|((a>>>6)&31),128|(a&63))}else{if(a<=65535){b+=String.fromCharCode(224|((a>>>12)&15),128|((a>>>6)&63),128|(a&63))}else{if(a<=2097151){b+=String.fromCharCode(240|((a>>>18)&7),128|((a>>>12)&63),128|((a>>>6)&63),128|(a&63))}}}}}return b}function rstr2binb(b){var a=Array(b.length>>2);for(var c=0;c<a.length;c++){a[c]=0}for(var c=0;c<b.length*8;c+=8){a[c>>5]|=(b.charCodeAt(c/8)&255)<<(24-c%32)}return a}function binb2rstr(b){var a="";for(var c=0;c<b.length*32;c+=8){a+=String.fromCharCode((b[c>>5]>>>(24-c%32))&255)}return a}function sha256_S(b,a){return(b>>>a)|(b<<(32-a))}function sha256_R(b,a){return(b>>>a)}function sha256_Ch(a,c,b){return((a&c)^((~a)&b))}function sha256_Maj(a,c,b){return((a&c)^(a&b)^(c&b))}function sha256_Sigma0256(a){return(sha256_S(a,2)^sha256_S(a,13)^sha256_S(a,22))}function sha256_Sigma1256(a){return(sha256_S(a,6)^sha256_S(a,11)^sha256_S(a,25))}function sha256_Gamma0256(a){return(sha256_S(a,7)^sha256_S(a,18)^sha256_R(a,3))}function sha256_Gamma1256(a){return(sha256_S(a,17)^sha256_S(a,19)^sha256_R(a,10))}function sha256_Sigma1512(a){return(sha256_S(a,14)^sha256_S(a,18)^sha256_S(a,41))}function sha256_Gamma1512(a){return(sha256_S(a,19)^sha256_S(a,61)^sha256_R(a,6))}var sha256_K=new Array(1116352408,1899447441,-1245643825,-373957723,961987163,1508970993,-1841331548,-1424204075,-670586216,310598401,607225278,1426881987,1925078388,-2132889090,-1680079193,-1046744716,-459576895,-272742522,264347078,604807628,770255983,1249150122,1555081692,1996064986,-1740746414,-1473132947,-1341970488,-1084653625,-958395405,-710438585,113926993,338241895,666307205,773529912,1294757372,1396182291,1695183700,1986661051,-2117940946,-1838011259,-1564481375,-1474664885,-1035236496,-949202525,-778901479,-694614492,-200395387,275423344,430227734,506948616,659060556,883997877,958139571,1322822218,1537002063,1747873779,1955562222,2024104815,-2067236844,-1933114872,-1866530822,-1538233109,-1090935817,-965641998);function binb_sha256(n,o){var p=new Array(1779033703,-1150833019,1013904242,-1521486534,1359893119,-1694144372,528734635,1541459225);var k=new Array(64);var B,A,z,y,w,u,t,s;var r,q,x,v;n[o>>5]|=128<<(24-o%32);n[((o+64>>9)<<4)+15]=o;for(r=0;r<n.length;r+=16){B=p[0];A=p[1];z=p[2];y=p[3];w=p[4];u=p[5];t=p[6];s=p[7];for(q=0;q<64;q++){if(q<16){k[q]=n[q+r]}else{k[q]=safe_add(safe_add(safe_add(sha256_Gamma1256(k[q-2]),k[q-7]),sha256_Gamma0256(k[q-15])),k[q-16])}x=safe_add(safe_add(safe_add(safe_add(s,sha256_Sigma1256(w)),sha256_Ch(w,u,t)),sha256_K[q]),k[q]);v=safe_add(sha256_Sigma0256(B),sha256_Maj(B,A,z));s=t;t=u;u=w;w=safe_add(y,x);y=z;z=A;A=B;B=safe_add(x,v)}p[0]=safe_add(B,p[0]);p[1]=safe_add(A,p[1]);p[2]=safe_add(z,p[2]);p[3]=safe_add(y,p[3]);p[4]=safe_add(w,p[4]);p[5]=safe_add(u,p[5]);p[6]=safe_add(t,p[6]);p[7]=safe_add(s,p[7])}return p}function safe_add(a,d){var c=(a&65535)+(d&65535);var b=(a>>16)+(d>>16)+(c>>16);return(b<<16)|(c&65535)};
</script>


<script>
//OneFileCMS wrapper function for using the hex_sha256() functions
function hash($element_id) {
	var $input = document.getElementById($element_id);
	var $hash = trim($input.value); //trim() defined in common_scripts()
	var $SALT = '<?php echo $SALT ?>';
	var $PRE_ITERATIONS = <?php echo $PRE_ITERATIONS ?>; //$PRE_ITERATIONS also used in hashit()
	if ($hash.length < 1) {$input.value = $hash; return;} //Don't hash nothing.
	for ( $x=0; $x < $PRE_ITERATIONS; $x++ ) { $hash = hex_sha256($hash + $SALT); } ;
	$input.value = $hash;
}//end hash()
</script>

<?php
}//end js_hash_scripts() //*****************************************************




function style_sheet() {//******************************************************
?>

<style>
/* --- reset --- */
* { border : 0; outline: 0; margin: 0; padding: 0;
    font-family: inherit; font-weight: inherit; font-style : inherit;
    font-size  : 100%; vertical-align: baseline; box-sizing: border-box; }

:before, :after { box-sizing: border-box; } /*not currently used anywhere, but you never know...*/

/* --- general formatting --- */

html { background: linear-gradient(170deg, white, rgb(50, 120,190)); background-attachment: fixed;}

body { height: 100%; font-size: 1em; font-family: sans-serif; overflow-y: scroll; }

svg { position: relative; top: 2px; }

p, table, ol { margin-bottom: .6em;}

h1,h2,h3,h4,h5,h6 { font-weight: bold; }
h2, h3 { font-size: 1.2em; margin: .4em 0 .4em 0; } /*TRBL*/

li { margin-left: 2em }

i, em     { font-style : italic; }
b, strong { font-weight: bold;   }

:focus {outline:0;}
:hover {border-color: #333;}

table { border-collapse:separate; border-spacing:0; }
th,td { text-align:left; font-weight:400; }

label { font-size : 1em; font-weight: bold; }

pre { background: white; border: 1px solid #777; padding: .2em; margin: 0; }

input[type="text"]     { width: 100%; border: 1px solid #777; padding: 1px 1px 1px 0; font : 1em Courier; }
input[type="password"] { width: 100%; border: 1px solid #777; padding: 0   1px 0   0; }
input[type="file"]     { width: 100%; border: 1px solid #777; background-color: white; margin: 0; }
input[type="radio"]    { margin: 0 1px 2px 3px; vertical-align: middle; cursor : pointer; }

input[readonly]        { color: #333; background-color: #EEE; }
input[disabled]        { color: #555; background-color: #EEE; }

input:focus  { background-color: rgb(255,250,150); border: 1px solid #333; }
input:hover  { background-color: rgb(255,250,150); }

/*-- Must be after input:focus, as it alters border --*/
input[type="checkbox"] { cursor: pointer; border: none;}

button, .button {border-radius: 5px;}

button:hover  { background-color: rgb(255,250,150); border-color: #333;}
button:focus  { background-color: rgb(255,250,150); border-color: #333;}
button:active { background-color: rgb(245,245,50);  border-color: #333;}

button:active, .button:active{ position:relative; top :1px; left:1px; }

/* --- layout --- */

#main {
	border : 0px solid #777;
	width  : 810px;     /*Adjusted by $MAIN_WIDTH config variable*/
	margin : 0 auto 2em auto;
	}


#header {
	border-bottom : 1px solid #777;
	padding: 4px 0px 1px 0px;
	margin : 0 0 0 0;
	}


#logo {
	font-family: 'Trebuchet MS', sans-serif;
	font-size:2em;
	font-weight: bold;
	color: black;
	padding: .1em;
	}


.h2_filename {
	border: 1px solid #777;
	padding: .1em .2em .1em .2em;
	font-weight: 700;
	font-family: courier;
	background-color: #EEE;
	}


#message_box { border: none; margin: .5em 0 .5em 0; padding: 0; min-height: 1.88em;}

.message_box_contents { border: 1px solid gray; padding: 3px 2px 2px 4px; background: #FFF000; }

#message_box #message_left {float: left; margin: 0; padding: 0; border: none; font-weight: 900; }

#message_box  #X_box {
	display: block;
	float  : right;
	margin : 0;
	padding: 0px 0px 0 1px;
	border : 1px solid gray;
	font-size  : 20px;
	line-height: 16px;
	background : #EEE;
	}

#message_box  #X_box:hover  {background-color: rgb(255,250,150); border-color: #333}
#message_box  #X_box:focus  {background-color: rgb(255,250,150); border-color: #333}
#message_box  #X_box:active {background-color: rgb(245,245,50); }

.filename { font-family: courier; }


/* ------ INDEX Page ------ */

#index_page_buttons     { margin: 0; }
#index_page_buttons div { display: inline-block; vertical-align: bottom; }


/*** Select All [x] ***/
#select_all_label { 
	font   : 400 .84em arial;
	color  : #333;
	display: inline-block;
	padding: 4px 0 3px 0;
	cursor : pointer;
	width  : 72px; /*Adjusted by langauge files*/
	border-right: solid transparent 1px;
	}

#select_all_label:hover  { background-color: rgb(255,250,150); }
#select_all_label:active { background-color: rgb(245,245, 50); }


/*** Directory list file select boxes ***/
/*ckbox is assigned to <div>'s etc that contain <input type=checkbox>*/
.ckbox        {padding: 4px 4px 2px 4px; display: inline-block;}
.ckbox:hover  {background-color: rgb(255,240,140);} 
.ckbox:active {background-color: rgb(245,245, 50);}

/* Slightly darker colors for [m][c][d] file options since they are small & less noticable*/
.MCD:hover  {background-color: rgb(255,240,140);}
.MCD:focus  {background-color: rgb(255,240,140);}
.MCD:active {background-color: rgb(245,245, 50);}


/*** [x] (folders first) ***/

#ff_ckbox_div {float: left;}

#folders_first_label {
	display: inline-block;
	float: left;
	font-size  : .9em;
	font-weight: normal;
	border     : solid 1px transparent;
	color  : #333;
	margin : 0 0 0 0;
	padding: 4px 3px 2px 0;
	cursor : pointer;
	}

#folders_first_label:hover {
	background-color  : rgb(255,250,150);
	border-left-color : silver;
	border-right-color: silver;
	}

#folders_first_label:active {background-color  : rgb(245,245, 50);}


/* --- Directory Listing --- */

table.index_T {
	min-width: 30em;
	font-size: .95em;
	border         : 1px solid #777;
	border-collapse: collapse;
	margin: .5em 0 0 0;
	background-color: #FFF;
	}

table.index_T tr:hover {border: 1px solid #777; background-color: #EEE}
table.index_T th { border: 1px inset silver; vertical-align: middle; text-align: center; padding: 0 ;}
table.index_T td { border: 1px inset silver; vertical-align: middle;}
table.index_T th:hover { background-color: white;}

.index_T td a {	display: block; border: none; padding: 2px 4px 2px 4px; overflow : hidden; }
.index_T th a { padding: 1px 0 1px 0; border-width: 0px;}

th.file_name {min-width: 15em}

.index_T th.file_name a {
	display: inline-block;
	padding: 4px 1em 3px 1em;
	border-top-width: 0px;
	border-bottom-width: 0px;
	text-align: center;
	}

#header_filename       {border-width: 0 1px 0 1px; display: block; overflow: auto;}
#header_filename:hover {border-color: silver;}
#header_filename:focus {border-color: silver;}

.index_T th.file_size a { display  : block; padding: 4px 0 3px 0; }
.index_T th.file_time a { display  : block; padding: 4px 0 3px 0; }

#header_sorttype       {float: right; padding: 4px 5px 3px 4px; border-width: 0px 0 0 1px;}
#header_sorttype:hover {border-color: silver;}
#header_sorttype:focus {border-color: silver;}

.file_name { max-width: 26em; }
.file_size { min-width:  6em; }
.file_time { min-width: 10em; }

.meta_T { padding: 0 .6em; text-align: right; font-family: courier; font-size: .9em; color: #222; }

#DIRECTORY_FOOTER {text-align: center; font-size: .9em; color: #333; padding: 3px 0 0 0; }


/*** front_links:  [New File] [New Folder] [Upload File] ***/
.front_links { float: right; }
 
.front_links a {
	display		: inline-block;
	border      : 1px solid #777;
	font-size   : 1em;  /*Adjusted by langauge files*/
	margin-left : 1em;  /*Adjusted by langauge files*/
	padding     : 3px 5px 2px 4px; /*TRBL*/
	background-color: #EEE;
	border-radius: 5px;
	}

.front_links svg { position: relative; top: 1px; margin-right: 5px; }

/*These must go after .front_links and other style that affect <a> tags*/
a { border: 1px solid transparent; text-decoration: none; }
a:focus  { border: 1px solid #333; background-color: rgb(255,250,150); }
a:hover  { border: 1px solid #333; background-color: rgb(255,250,150); }
a:active { border: 1px solid #333; background-color: rgb(245,245,50);  }


/*** [Move] [Copy] [Delete] ***/

#mcd_submit { margin: 0; }

#mcd_submit button {
	height   : 1.75em;
	cursor   : pointer;
	border   : 1px solid #777;
	padding  : 0px 3px 0px 2px; /*TRBL*/
	margin-right: 1.0em;  /* Adjusted by language files */
	font-size: .9em;
	color    : rgb(100,45,0);
	background-color: #EEE;
	}

#mcd_submit svg { margin-right: 5px; }

#mcd_submit button:focus  { border: 1px solid #333; background-color: rgb(255,250,150); }
#mcd_submit button:hover  { border: 1px solid #333; background-color: rgb(255,250,150); }
#mcd_submit button:active { border: 1px solid #333; background-color: rgb(245,245, 50); }

.buttons_right         { float: right; }
.buttons_right .button { margin-left: .5em; }

.button {
	cursor : pointer;
	border : 1px solid #777;
	color  : black;
	padding    : 4px 7px 4px 7px; /*Adjusted by langauge files*/
	font-size  : .9em;            /*Adjusted by langauge files*/
	font-family: sans-serif;
	background-color: #EEE;
	}

.button:hover     { border: 1px solid #333; background-color: rgb(255,250,150); }
.button:focus     { border: 1px solid #333; background-color: rgb(255,250,150); }
.button:active    { background-color: rgb(245,245,50); }                  /*first                 */
.button[disabled] { color: #777; background-color: #EEE; cursor: default} /*second - order matters*/

#renamefile_btn {padding: 2px 7px 4px 7px;}


/* --- header --- */

.nav   { float: right; display: inline-block; margin-top: 1.35em; font-size : 1em; }
.nav a { border: 1px solid transparent; font-weight: bold; padding: .2em .6em .1em .6em; }
.nav a:hover  { border: 1px solid #333; }
.nav a:focus  { border: 1px solid #333; }


/* --- edit --- */

#edit_header  {margin: .5em 0 0 0;}
#edit_header a:hover  { border: 1px solid #000; }

#edit_form    {margin: 0;}

.edit_disabled {
	border : 1px solid #777;
	width  : 99%;
	height : 35em;
	padding: .2em;
	margin : .5em 0 .6em 0;
	color  : #222;
	background-color: #FFF000;
	line-height: 1.4em;
	white-space: pre-wrap;
	word-wrap: break-word;
	overflow: auto;
	}

.view_file { font: .9em Courier; background-color: #F8F8F8; }



#wrapper_linenums_editor {
	vertical-align	: top;
	white-space		: nowrap;
	padding			: 0px;
	border			: none;
	width		 	: 100%;
}

#line_numbers, #file_editor {
	vertical-align  : top;
	display			: inline-block;
	height			: 40em;
	white-space		: pre;
	margin			: 0;
	font			: normal .9em courier;
}


#line_numbers {
	min-width	: 3.1em;  /* Must be wider than scroll-bar left-right arrows, or no scrollbar appears. */
	padding		: 1px .3em 0 .2em;
	border		: 1px solid #777;
	background	: #ccc;
	color		: #444;
	overflow-y	: hidden;
	overflow-x  : scroll;  /*This may be grayed out, but provides visual consistancy with #file_editor.*/
	text-align	: right;
	float		: left;  /*only needed to help eliminate whitespace between #line_numbers & #file_editor*/
}

#line_0, #line_1 {margin: 0; display: inline-block; }

#file_editor {
	font  	   : .9em Courier;
	border	   : 1px solid #777;
	width      : 96%;		/* Dynamically set by Set_File_Textarea_Width(), base on Normal or Wide view. */
	margin	   : 0 0 .7em 2px;
	padding    : 1px 0 0 3px;
	overflow   : scroll;
	word-wrap  : normal;
	word-break : break-all;
	white-space: pre-wrap;
	resize     : none;

	color 			: black; /* Default. May make themeable, along with background-color. Someday... */
	background-color: white; /* Set in Reset_file_status_indicators() and Check_for_changes() */
	}


#file_editor:focus { border-color: #000; }

.tab_size {	tab-size: 8; -o-tab-size: 8; -moz-tab-size: 8;  }


.file_meta	{ float: left; margin-top: .6em; font-size: .95em; color: #222; }

#edit_notes { font-size: .8em; color: #222 ;margin-top: 1em; clear:both; }

.notes      { margin-bottom: .4em; }





/* --- log in --- */

#login_page {
	border  : 1px solid #777;
	width   : 370px;
	margin  : 5em auto;
	padding : .5em 1.2em .1em 1em;
	}

#login_page .nav { margin-top: .5em; }

#login_page input {margin: 0 0 .7em 0;}


hr { /*-- -- -- -- -- -- --*/
	line-height  : 0;
	Xfont-size    : 1px;
	display : block;
	position: relative;
	padding : 0;
	margin  : .6em auto;
	width   : 100%;
	clear   : both;
	border  : none;
	border-top   : 1px solid #777;
	Xborder-bottom: 1px solid #eee;
	overflow: visible;
	}


.verify {
	min-width       : 50%; 
	font            : 1em Courier;
	border          : 1px solid gray;
	border-collapse : collapse;
	background-color: white;
	}

.verify th {
	border          : 1px solid gray;
	padding         : 0 1em 0 1em;
	text-align      : center;
	font-weight     : 900;
	font-family     : arial;
	background-color: #EEE;
	}

.verify td {
	border : 1px inset silver;
	padding: .1em 1em .1em .5em;
	vertical-align: middle;
	}

.verify_del {
	font  : 1em Courier;
	border: 1px solid #F00;
	padding: .2em .4em;
	color  : #222;
	background-color: #FDD;
	}

.verify_del td { border: 1px solid #F44; }


#admin {padding: 3px 5px;}

.admin_buttons .button {margin-right: .5em;}

.clear {clear:both; padding: 0; margin: 0; border: none}

.web_root { border: 1px solid  #777; border-right: none; font: 1em Courier; padding: 1px; background-color: #EEE;}

.mono {font-family: courier;}

.info {margin: .7em 0 .5em 0; background: #f9f9f9; padding: .2em .5em;}

.path {padding: 1px 5px 1px 5px} /*TRBL*/

.timer {border: 1px solid #eee; padding: 3px .5em 4px .5em;}

.timeout {float:right; font-size: .95em; color: #111; padding-right: .3em;}

.edit_btns_top {margin: .2em 0 .5em 0;}

.image_info {
	color: #222;
	font-size: 1em ; /*Adjusted by langauge files*/
	margin: .7em 0 1em 0;
	}

.edit_btns_bottom {float: right;}
.edit_btns_bottom .button { margin-left: .7em; } /*Adjusted by langauge files*/

input[type="text"]#new_name {width  : 50%; margin-bottom: .2em;}
#new_location {border-left: none;}

#del_backup   { margin: 0; padding: 2px 5px; border: 1px solid transparent;}

/*** For old IE only: text "icons" for Rename, Copy, and Delete ***/
.RCD1  {font: 900 7pt arial; padding: 0px 3px 0px 3px; margin: 0px; float: left}
.R    {color: #00a;    border: 1px solid #804000}
.C    {color: #006400; border: 1px solid #008400}
.D    {color: #b00;    border: 1px solid #b00}

.action   {display: inline-block}
.ren_over {display: inline-block}
.ren_over input {margin: 0 0 0 2em}
.ren_over label {font-weight: normal}

#path_header{
	display: inline-block;
	background-color:white;
	border: solid 1px #777;
	font-weight: normal;
	padding: 0 .5em 0 0;
	margin: .5em 0 0 0;
	}

#path_header a {
	outline: none;
	border: none;
	border-left : solid 1px transparent;
	border-right: solid 1px transparent;
	display: inline-block;
	padding: 1px 5px 0 5px;
	}

#path_header a:hover  { border-left : solid 1px #777; border-right: solid 1px #777; }
#path_header a:focus  { border-left : solid 1px #777; border-right: solid 1px #777; }
</style>

<?php
}//end style_sheet() //*********************************************************




function Language_and_config_adjusted_styles() {//******************************
	global $_, $MAIN_WIDTH, $MESSAGE, $page, $TAB_SIZE;
?>

<style>
#main { width: <?php echo $MAIN_WIDTH ?>; } /*Default 810px*/

.tab_size {
	tab-size     : <?php echo $TAB_SIZE ?>;
	-o-tab-size  : <?php echo $TAB_SIZE ?>;
	-moz-tab-size: <?php echo $TAB_SIZE ?>;
}

.button {
	padding  : <?php echo $_['button_padding']   ?>; /*Default 4px 7px 4px 7px */
	font-size: <?php echo $_['button_font_size'] ?>; /*Default .9em */
	}

.front_links a {
	font-size  : <?php echo $_['front_links_font_size'] ?>; /*Default 1em */
	margin-left: <?php echo $_['front_links_margin_L']  ?>; /*Default 1em */
	}

#mcd_submit button{ margin-right: <?php echo $_['MCD_margin_R']  ?>;}  /*Default 1em*/

.image_info { font-size: <?php echo $_['image_info_font_size'] ?>; }   /*Default 1em*/

.edit_btns_bottom .button {
	margin-left: <?php echo $_['button_margin_L'] ?>; /*Default .7em*/
	}


#select_all_label { font-size: <?php echo $_['select_all_label_size']?>; } /*Default .84em */
#select_all_label { width: <?php echo $_['select_all_label_width']?>; }    /*Default 72px  */
</style>

<?php
}//end Language_and_config_adjusted_styles() //*********************************




function Load_style_sheet() {//*************************************************
	global $CSS_FILE, $MESSAGE;

	style_sheet(); //first load built-in defaults

	if ( isset($CSS_FILE) ) { //Check for external file
		echo '<link rel="stylesheet" type="text/css" href="'.URLencode_path($CSS_FILE).'">';
	}

	Language_and_config_adjusted_styles();

}//end Load_style_sheet() //****************************************************




//******************************************************************************
//Main logic to determine page action
//******************************************************************************

Default_Language();

System_Setup();

Session_Startup();

if (!isset($_SESSION['admin_page'])) {
	$_SESSION['admin_page']  = false;
	$_SESSION['admin_ipath'] = '';
}

if ($_SESSION['valid']) {

	undo_magic_quotes();

	Init_ICONS();

	Get_GET();

	if ($page == "phpinfo") { phpinfo(); die; }

	Valid_Path($ipath, true);

	Validate_params();

	Init_Macros(); //Needs to be after Get_Get()/Validate_params()/Valid_Path()

	//$ACCESS_ROOT.$ACCESS_PATH == $ipath
	$ipath_len = mb_strlen($ipath);
	$ACCESS_PATH = '';
	if (($ACCESS_ROOT_len < $ipath_len)) {
		$ACCESS_PATH = trim(mb_substr($ipath, $ACCESS_ROOT_len), ' /').'/';
	}

	Respond_to_POST();

	Verify_Page_Conditions(); //Must come after Respond_to_POST()

	Update_Recent_Pages();

	//Don't show current/path/ header on some pages.
	$Show_Path = true;
	$pages_dont_show_path = array("login","admin","hash","changepw","changeun");
	if ( in_array($page, $pages_dont_show_path) ){ $Show_Path = false; } //

}//end if $_SESSION[valid] 

//end logic to determine page action *******************************************




//******************************************************************************
//Output page contents
//******************************************************************************
$early_output = ob_get_clean(); // Should be blank unless trouble-shooting.
ob_start();
header('Content-type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="robots" content="noindex">
<?php
echo '<title>'.hsc($MAIN_TITLE.' - '.Page_Title()).'</title>'."\n";

Load_style_sheet();

common_scripts();

echo '</head><body>';

Error_reporting_status_and_early_output(0,0); //0,0 will only show early output.

if ($_SESSION['valid']) { echo '<div id=main >'; }
else                    { echo '<div id=login_page>'; }


Page_Header();

if ($_SESSION['valid'] && $Show_Path) { Current_Path_Header(); }

$TABINDEX_XBOX = $TABINDEX++; //Messages, and the [X] box, not displayed until later.
echo '<div id="message_box"></div>';

Load_Selected_Page();

//footer...
if ($_SESSION['valid']) {
	//Countdown timer
	echo "<hr style='border-color: white;'>\n";
	echo "<span id=timer0  class='timer timeout'></span>";
	echo "<span class=timeout>".hsc($_['time_out_txt'])."</span>";

	//Adjust tabindex to account for [m][c][d][x] and file names in directory list.
	//(Directory list created via js, so $TAB_INDEX is also passed to, and handled by, js at that point.)
	if (isset($DIRECTORY_COUNT)) {$TAB_INDEX = "tabindex=".($TABINDEX + ($DIRECTORY_COUNT * 5));}
	else                         {$TAB_INDEX = ""; }

	//Admin link
	if ( ($_SESSION['admin_page'] === false) ) {
		echo '<a id="admin" '.$TAB_INDEX.' href="'.$ONESCRIPT.$param1.$param2.'&amp;p=admin">'.hsc($_['Admin']).'</a>';
	}
}//end footer

echo "\n</div>\n"; //end main/login_page
echo "</body></html>\n";

if ( ($page == "edit") && $WYSIWYG_VALID && $EDIT_WYSIWYG ) { include($WYSIWYG_PLUGIN_OS); }

//Display any $MESSAGE's
echo "\n\n<script>\n";
echo 'var $tabindex_xbox = '.$TABINDEX_XBOX.";\n"; //Used in Display_Messages()
echo 'var $page = "'.$page.'";'."\n";
echo '$MESSAGE += "'.addslashes($MESSAGE).'";'."\n"; //js version of $MESSAGE declared at top of common_scripts().
	    //Cause $MESSAGE's $X_box to take focus on these pages only.
echo 'if (($page == "index") || ($page == "edit")) {take_focus = 1}'."\n";
echo 'else										   {take_focus = 0}'."\n\n";

//Initial sort & display of the directory, by (filename, ascending).
if ($page == "index") {	echo "Sort_and_Show();\n\n"; }

//The setTimeout() delay should be greater than what is set for the Sort_and_Show() "working..." message.
echo 'setTimeout("Display_Messages($MESSAGE, take_focus)", '.$DELAY_final_messages.');';
echo "</script>\n\n";

	//##### ACTUAL COUNTDOWN STARTS ON THE SERVER.
	//##### DO I NEED TO ACCOUNT FOR TIME RECEIVING & LOADING PAGE CLIENT SIDE?

//start any timers...
if ($_SESSION['valid']) { echo Timeout_Timer($MAX_IDLE_TIME, 'timer0', 'LOGOUT'); }
if ($page == 'edit')    { echo Timeout_Timer($MAX_IDLE_TIME, 'timer1', 'LOGOUT'); }
if ($LOGIN_DELAYED > 0) { echo Timeout_Timer($LOGIN_DELAYED, 'timer0', ''); }
//##### END OF FILE ############################################################

//##### Header (UTF-8) for [View Raw] incorrect or not getting sent??
//##### If file has non-ascii characters, browers display in ISO-8859-1/Windows-1252,
//##### Except IE, which asks to download the file...
//##### When browsers manually set to UTF-8, files display fine.
