<?php 
// OneFileCMS - github.com/Self-Evident/OneFileCMS

$version = '3.3.1';

/*******************************************************************************
Copyright © 2009-2012 https://github.com/rocktronica
Copyright © 2012-     https://github.com/Self-Evident  David W. Gay

This software is copyright under terms of the "MIT" license:

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




//Some basic security & error log settings
ini_set('session.use_trans_sid', 0);    //make sure URL supplied SESSID's are not used
ini_set('session.use_only_cookies', 1); //make sure URL supplied SESSID's are not used
error_reporting(0); //0 for none, or (E_ALL &~ E_STRICT) if display and/or log are on.
ini_set('display_errors', 'off'); //Ok to turn on for trouble-shooting.
ini_set('log_errors'    , 'off');
ini_set('error_log'     , $_SERVER['SCRIPT_FILENAME'].'.log');
//Determine good folder for session file? Default is tmp/, which is not secure.
//session_save_path($safepath)  or  ini_set('session.save_path', $safepath)




// CONFIGURABLE INFO ***********************************************************
$config_title     = "OneFileCMS";

$USERNAME = 'username';

$PASSWORD = 'password'; //If using $HASHWORD, you may leave this value empty.
$USE_HASH = 0 ; // If = 0, use $PASSWORD. If = 1, use $HASHWORD. 
$HASHWORD = 'c3e70af96ab1bfc5669280e98b438e1a8c08ca5e0bb3354c05ceaa6f339fd3f6'; //hash for "password"
$SALT     = 'somerandomsalt';

$LANGUAGE = ""; //Filename of language settings. Leave blank for built-in default.

$HTML_WYSIWYG_EDIT = false; //Enable WYSIWYG mode when editing HTML files?

$MAX_ATTEMPTS  = 3;   //Max failed login attempts before LOGIN_DELAY starts.
$LOGIN_DELAY   = 10;  //In seconds.
$MAX_IDLE_TIME = 600; //In seconds. 600 = 10 minutes.  Other PHP settings may limit its max effective value.
					  //  For instance, 24 minutes is the PHP default for garbage collection.
$MAX_IMG_W   = 810;  // Max width to display images. (page container = 810)
$MAX_IMG_H   = 1000; // Max height.  I don't know, it just looks reasonable.

$MAX_EDIT_SIZE = 150000;  // Edit gets flaky with large files in some browsers.  Trial and error your's.
$MAX_VIEW_SIZE = 1000000; // If file > $MAX_EDIT_SIZE, don't even view in OneFileCMS.
                          // The default max view size is completely arbitrary. It was 2am and seemed like a good idea at the time.
$config_favicon   = "/favicon.ico";
$config_excluded  = ""; //files to exclude from directory listings- CaSe sEnsaTive!

$config_etypes = "html,htm,xhtml,php,css,js,txt,text,cfg,conf,ini,csv,svg,log"; //Editable file types.
$config_stypes = "*"; // Shown types; only files of the given types should show up in the file-listing
	// Use $config_stypes exactly like $config_etypes (list of extensions separated by semicolons).
	// If $config_stypes is set to null - by intention or by error - OFCMS will only display folders.
	// If $config_stypes is set to the *-wildcard (as per default), all files will show up.
	// If $config_stypes is set to "html,htm" for example, only file with the extension "html" or "htm" will get listed.

$config_itypes = "jpg,gif,png,bmp,ico"; //image types to display on edit page.
$config_ftypes = "bin,jpg,gif,png,bmp,ico,svg,txt,cvs,css,php,ini,cfg,conf,asp,js ,htm,html"; // _ftype & _fclass must have same
$config_fclass = "bin,img,img,img,img,img,svg,txt,txt,css,php,txt,cfg,cfg ,txt,txt,htm,htm";  // number of values. bin is default.

$EX = '<b>( ! )</b> '; //EXclaimation point "icon" Used in $message's

$SESSION_NAME = 'OFCMS'; //Also the cookie name. Change if using multiple copies of OneFileCMS.

$config_file = 'ofcms.ini'; //External config file, if there is one.
// End CONFIGURABLE INFO *******************************************************




// PROCESS CONFIGURATION FILE **************************************************
# Check for an external configuration file:
if (is_file($config_file)) {
	# Parse file
	$settings = parse_ini_file($config_file);

	# Configure which variables can get overwritten by the config file:
	$overwritable_variables = array(
		'config_title',
		'USERNAME',
		'PASSWORD',
		'USE_HASH',
		'HASHWORD',
		'SALT',
		'LANGUAGE',
		'HTML_WYSIWYG_EDIT',
		'config_stypes');

	# Loop through options and overwrite default configuration
	foreach($settings as $key => $value) {
		# Check if variable can get overwritten:
		if (in_array($key, $overwritable_variables)) {
			$GLOBALS[$key] = $value;
		}
	}
}
// End PROCESS CONFIGURATION FILE **********************************************




//******************************************************************************
//Some global system values

ini_set('session.gc_maxlifetime', $MAX_IDLE_TIME + 100); //in case the default is less.

//PHP_VERSION_ID is better to use when checking current version as it's an actual number, not a string.
if (!defined('PHP_VERSION_ID')) {            //PHP_VERSION_ID only available since 5.2.7
    $phpversion = explode('.', PHP_VERSION); //PHP_VERSION, however, available even in older versions. (but it's a string)
    define('PHP_VERSION_ID', ($phpversion[0] * 10000 + $phpversion[1] * 100 + $phpversion[2]));
}

$ONESCRIPT = URLencode_path($_SERVER["SCRIPT_NAME"]);
$DOC_ROOT  = $_SERVER["DOCUMENT_ROOT"].'/';
$WEB_ROOT  = URLencode_path(basename($DOC_ROOT)).'/';
$WEBSITE   = $_SERVER["HTTP_HOST"].'/';
$LOGIN_ATTEMPTS = $DOC_ROOT.trim($_SERVER["SCRIPT_NAME"],'/').'.invalid_login_attempts';

$valid_pages = array("hash", "login","logout","index","edit","iframe_edit","upload","uploaded","newfile","copy","rename","delete","newfolder","renamefolder","deletefolder" );

$INVALID_CHARS = '< > ? * : " | / \\'; //Illegal characters for file/folder names.
$INVALID_CHARS_array = explode(' ', $INVALID_CHARS); // (Space deliminated)

//Make arrays out of a few $config_variables for actual use later.
//Also, remove spaces and make lowercase.
$SHOWALLFILES = $stypes = false;
  if ($config_stypes == '*') { $SHOWALLFILES = true; }
  else { $stypes   = explode(',', strtolower(str_replace(' ', '', $config_stypes))); }//shown file types
$etypes   = explode(',', strtolower(str_replace(' ', '', $config_etypes))); //editable file types
$itypes   = explode(',', strtolower(str_replace(' ', '', $config_itypes))); //images types to display
$ftypes   = explode(',', strtolower(str_replace(' ', '', $config_ftypes))); //file types with icons
$fclasses = explode(',', strtolower(str_replace(' ', '', $config_fclass))); //for file types with icons
$excluded_list = (explode(",", $config_excluded));
//******************************************************************************




function hsc($input) { return htmlspecialchars($input); }// end hsc() **********




function Default_Language() { // ***********************************************

	return('

LANGUAGE = "English (default)"

;// These are the default values included directly in onefilecms.php.
;//
;// If no translation or value is desired for a particular setting, do not delete
;// the actual setting variable, just set it to an empty string.
;// For example:  some_unused_setting = ""
;//
;// Remember to slash-escape double quotes that may be within a value:  \"
;// And, if the these settings are set directly in Default_Language() in onefilecms.php,
;// single quotes must also be escaped:   \'

Upload_File = "Upload File"
New_File    = "New File"
Ren_Move    = "Rename/Move"
Ren_Moved   = "Renamed/Moved"
New_Folder  = "New Folder"
Ren_Folder  = "Rename/Move Folder"
Del_Folder  = "Delete Folder"

Admin  = "Admin"
Enter  = "Enter"
Edit   = "Edit"
Close  = "Close"
Cancel = "Cancel"
Upload = "Upload"
Create = "Create"
Copy   = "Copy"
Copied = "Copied"
Rename = "Rename"
Delete = "Delete"
DELETE = "DELETE"
File   = "File"
Folder = "Folder"

Log_In  = "Log In"
Log_Out = "Log Out"
Hash    = "Hash"
Generate_Hash = "Generate Hash"

save_1      = "Save"
save_2      = "SAVE CHANGES!"
reset       = "Reset - loose changes"
Wide_View   = "Wide View"
Normal_View = "Normal View"

on_      = "on"

verify_msg_01 = "Session expired."
verify_msg_02 = "INVALID POST"

get_get_msg_01 = "File does not exist:"

check_path_msg_01 = "Directory does not exist: "

ord_msg_01 = "A file with that name already exists in the target directory."
ord_msg_02 = "Saving as"

show_img_msg_01 = "Image shown at ~"
show_img_msg_02 = "% of full size (W x H = "

hash_h2 = "Generate a Password Hash"
hash_txt_01 = "There are two ways to change your OneFileCMS password:"
hash_txt_02 = "1) Use the $PASSWORD config variable to store your desired password, and set $USE_HASH = 0 (zero)."
hash_txt_03 = "2) Or, use $HASHWORD to store the hash of your password, and set $USE_HASH = 1."
hash_txt_04 = "Keep in mind that due to a number of widely varied considerations, this is largely an academic excersize. That is, take the idea that this adds much of an improvement to security with a grain of cryptographic salt.	However, it does eleminate the storage of your password in plain text, which is a good thing."
hash_txt_05 = "Anyway, to use the $HASHWORD password option:"
hash_txt_06 = "Type your desired password in the input field above and hit Enter."
hash_txt_07 = "The hash will be displayed in a yellow message box above that."
hash_txt_08 = "Copy and paste the new hash to the $HASHWORD variable in the config section."
hash_txt_09 = "Make sure to copy ALL of, and ONLY, the hash (no leading or trailing spaces etc)."
hash_txt_10 = "A double-click should select it..."
hash_txt_11 = "Make sure $USE_HASH is set to 1 (or true)."
hash_txt_12 = "When ready, logout and login."
hash_txt_13 = "You can use OneFileCMS to edit itself.  However, be sure to have a backup ready for the inevitable ytpo..."
hash_txt_14 = "For another small improvement to security, change the default salt and/or method used by OneFileCMS to hash the password (and keep \'em secret, of course).  Remever, every little bit helps..."

hash_msg_01 = "Password: "
hash_msg_02 = "Hash    : "

login_h2 = "Log In"
login_txt_01 = "Username:"
login_txt_02 = "Password:"

login_msg_01a = "There have been "
login_msg_01b = "invalid login attempts."
login_msg_02a = "Please wait"
login_msg_02b = "seconds to try again."
login_msg_03  = "INVALID LOGIN ATTEMPT #"

edit_notes_00  = "NOTES:"
edit_note_01a = "Remember- your "
edit_note_01b = " is "
edit_note_02 = "So save changes before the clock runs out, or the changes will be lost!"
edit_note_03 = "some browsers, such as Chrome, if you click the browser [Back] then browser [Forward] (or vice versa), the file state may not be accurate.  To correct, click the browser\'s [Reload]."
edit_note_04 = "Chrome\'s XSS filters may disable some javascript in a page if the page even appears to contain inline javascript in certain contexts.  This can affect some features of the OneFileCMS edit page when editing files that legitimately contain such code, such as OneFileCMS itself.  However, such files can still be edited and saved with OneFileCMS.  The primary function lost is the incidental change of background colors (red/green) indicating whether or not the file has unsaved changes.  The issue will be noticed after the first save of such a file."

edit_h2_1 = "Viewing: "
edit_h2_2 = "Editing: "
edit_txt_01 = "Non-text or unkown file type. Edit disabled."
edit_txt_02 = "File possibly contains an invalid character. Edit and view disabled."
edit_txt_03 = "htmlspecialchars() returned and empty string from what may be an otherwise valid file."
edit_txt_04 = "This behavior can be inconsistant from version to version of php."

too_large_to_edit_01a = "Edit disabled. Filesize > "
too_large_to_edit_01b = " bytes."
too_large_to_edit_02 = "Some browsers (ie: IE) bog down or become unstable while editing a large file in an HTML <textarea>."
too_large_to_edit_03 = "Adjust $MAX_EDIT_SIZE in the configuration section of OneFileCMS as needed."
too_large_to_edit_04 = "A simple trial and error test can determine a practical limit for a given browser/computer."

too_large_to_view_01a = "View disabled. Filesize > "
too_large_to_view_01b = " bytes."
too_large_to_view_02 = "Click the the file name above to view as normally rendered in a browser window."
too_large_to_view_03 = "Adjust $MAX_VIEW_SIZE in the configuration section of OneFileCMS as needed."
too_large_to_view_04 = "(The default value for $MAX_VIEW_SIZE is completely arbitrary, and may be adjusted as desired.)"

meta_txt_01 = "Filesize: "
meta_txt_02 = " bytes."
meta_txt_03 = "Updated: "

edit_msg_01 = "File saved: "
edit_msg_02 = "bytes written."
edit_msg_03 = "There was an error saving file."

upload_h2 = "Upload File"
upload_txt_01 = "  per upload_max_filesize in php.ini."
upload_txt_02 = "per post_max_size in php.ini"
upload_txt_03 = "Note: Maximum upload file size is: "

upload_err_01a = "Error 1: File too large.  "
upload_err_01b = " (From php.ini)"
upload_err_02a = "Error 2: File too large.  "
upload_err_02b = " (From OneFileCMS)"
upload_err_03  = "Error 3: The uploaded file was only partially uploaded."
upload_err_04  = "Error 4: No file was uploaded."
upload_err_05  = "Error 5:"
upload_err_06  = "Error 6: Missing a temporary folder."
upload_err_07  = "Error 7: Failed to write file to disk."
upload_err_08  = "Error 8: A PHP extension stopped the file upload."

upload_msg_01 = "No file selected for upload."
upload_msg_02 = "Destination folder does not exist: "
upload_msg_03 = "Upload cancelled."
upload_msg_04 = "Uploading: "
upload_msg_05 = "Upload successful! "
upload_msg_06 = "Upload failed: "

new_file_h2 = "New File"
new_file_txt_01 = "File will be created in the current folder.  "
new_file_txt_02 = "Some invalid characters are: "

new_file_msg_01 = "New file not created:"
new_file_msg_02 = "Name contains invalid character(s): "
new_file_msg_03 = "New file not created - no name given"
new_file_msg_04 = "File already exists: "
new_file_msg_05 = "Created file:"
new_file_msg_06 = "Error - new file not created:"

CRM_txt_01  = "To move a file or folder, change the path/to/folder/or_file. The new location must already exist."
CRM_txt_02  = "Old name:"
CRM_txt_03  = "New name:"

CRM_msg_01 = " Error - new parent location does not exist:"
CRM_msg_02 = " Error - source file does not exist:"
CRM_msg_03 = " Error - target filename already exists:"
CRM_msg_04 = " to "
CRM_msg_05a = "Error during "
CRM_msg_05b = " from the above to the following:"

delete_h2 = "Delete File"
delete_txt_01 = "Are you sure?"

delete_msg_01 = "Deleted file:"
delete_msg_02 = "Error deleting "

new_folder_h2 = "New Folder"
new_folder_txt_1 = "Folder will be created in the current folder.  "
new_folder_txt_2 = "Some invalid characters are: "

new_folder_msg_01 = "New folder not created:"
new_folder_msg_02 = "Name contains invalid character(s): "
new_folder_msg_03 = "New folder not created - no name given."
new_folder_msg_04 = "Folder already exists: "
new_folder_msg_05 = "Created folder:"
new_folder_msg_06 = "Error - new folder not created: "

delete_folder_h2 = "Delete Folder"
delete_folder_txt_01 = "Are you sure?"

delete_folder_msg_01 = "Folder not empty.   Folders must be empty before they can be deleted."
delete_folder_msg_02 = "Deleted folder:"
delete_folder_msg_03 = "an error occurred during delete."

page_title_login      = "Log In"
page_title_hash       = "Hash Page"
page_title_edit       = "Edit/View File"
page_title_upload     = "Upload File"
page_title_new_file   = "New File"
page_title_copy       = "Copy File"
page_title_ren        = "Rename File"
page_title_del        = "Delete File"
page_title_folder_new = "New Folder"
page_title_folder_ren = "Rename/Move Folder"
page_title_folder_del = "Delete Folder"

session_expired = "SESSION EXPIRED"
unload_unsaved  = "               Unsaved changes will be lost!"
confirm_reset   = "Reset file and loose unsaved changes?"

OFCMS_requires  = "OneFileCMS requires PHP5 to operate. Tested on versions 5.2.17, 5.3.3 & 5.4"

logout_msg       = "You have successfully logged out."
folder_del_msg   = "Folder not empty.   Folders must be empty before they can be deleted."
upload_error_01a = " Upload Error.  Total POST data (mostly filesize) exceeded post_max_size = "
upload_error_01b = " (from php.ini)"
edit_caution_01  = "CAUTION "
edit_caution_02  = " You are editing the active copy of OneFileCMS - BACK IT UP & BE CAREFUL !!"

time_out_txt = "Session time out in:"

	'); //end return('language string')
}//end Default_Language() ******************************************************




function Session_Startup() {//**************************************************
	global $USERNAME, $PASSWORD, $USE_HASH, $HASHWORD, $page, $VALID_POST, $MAX_IDLE_TIME, $SESSION_NAME;
 
	$limit    = 0; //0 = session.  
	$path     = dirname($_SERVER['SCRIPT_NAME']);
	$domain   = ''; // '' = hostname
	$https    = false; 
	$httponly = true;//true = unaccessable via javascript. Some XSS protection.
	session_set_cookie_params($limit, $path, $domain, $https, $httponly);

	session_name($SESSION_NAME);
	session_start();

	//Set initial defaults...
	$page = 'login'; 
	$VALID_POST = 0;
	if ( !isset($_SESSION['valid']) ) { $_SESSION['valid'] = 0; }

	//Logging in?
	if ( isset($_POST["username"]) || isset($_POST["password"]) ) { Login_response(); }

	session_regenerate_id(true); //Helps prevent session fixation & hijacking.

	if ( $_SESSION['valid'] ) { Verify_IDLE_POST_etc(); }
	
	$_SESSION['nuonce'] = sha1(mt_rand().microtime()); //provided in <forms> to verify POST

	chdir($_SERVER["DOCUMENT_ROOT"]); //Allow OneFileCMS.php to be started from any dir on the site.
}//End Session_Startup() *******************************************************




function Verify_IDLE_POST_etc() { //********************************************
	global $_, $EX, $message, $VALID_POST, $MAX_IDLE_TIME;

	//Verify consistant user agent... (every little bit helps a little bit) 
	if ( ($_SESSION['USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) ) { Logout(); }

	//Check idle time
 	if ( isset($_SESSION['last_active_time']) ) {
		$idle_time = ( time() - $_SESSION['last_active_time'] );
		if ( $idle_time > $MAX_IDLE_TIME ) {
			Logout();
			$message .= hsc($_['verify_msg_01']).'<br>';
		}
	}

	$_SESSION['last_active_time'] = time();

	//If POSTing, verify...
	if ( isset($_POST['nuonce']) ) { 
		if ( $_POST['nuonce'] == $_SESSION['nuonce'] ) {
			$VALID_POST = 1;
		}else{
			Logout();
			$message .= $EX.'<b>'.hsc($_['verify_msg_02']).'</b><br>';
		}
	}
}//end Verify_IDLE_POST_etc() //************************************************




function hashit($key){ //*******************************************************
	//This is the super-secret stuff - Keep it secret, keep it safe!
	//If you change anything here, or the $SALT, redo the hash for your password.
	global $SALT;
	$hash = hash('sha256', trim($key).$SALT); // trim off leading & trailing spaces.
	for ( $x=0; $x < 1000; $x++ ) { $hash = hash('sha256', $hash.$SALT); }
	return $hash;
}//end hashit() ****************************************************************




function undo_magic_quotes(){ //************************************************

	function strip_array($var) {
		if (is_array($var)) {return array_map("strip_array", $var); }
		else                {return stripslashes($var); }
	} //Note: stripslashes also handles cases when magic_quotes_sybase is on.

	if (get_magic_quotes_gpc()) {
		if (isset($_GET))    { $_GET     = strip_array($_GET);    }
		if (isset($_POST))   { $_POST    = strip_array($_POST);   }
		if (isset($_COOKIE)) { $_COOKIE  = strip_array($_COOKIE); }
	}
}//end undo_magic_quotes() *****************************************************




function Get_GET() { //*** Get main parameters *********************************
	// i=some/path/,  f=somefile.xyz,  p=somepage
	global $_, $ipath, $filename, $page, $valid_pages, $param1, $param2, $param3, $message, $EX;

	undo_magic_quotes();

	if (isset($_GET["i"])) { $ipath = Check_path($_GET["i"]); }else{ $ipath = ""; }

	if (isset($_GET["f"])) {
		$filename = $ipath.$_GET["f"];
		if ( !is_file($filename) && $_SESSION['valid'] )//Set $message except for login page.
			{ $message .= $EX.'<b>'.hsc($_['get_get_msg_01']).'</b> '.htmlentities($filename).'<br>'; }
		if ( !is_file($filename) ) { $filename = ""; $page = "index"; }
	}else{ $filename = ""; }

	if (isset($_GET["p"])) { $page = $_GET["p"]; } 
	if (!in_array(strtolower($page), $valid_pages)) { $page = "index"; }

	$param1 = '?i='.URLencode_path($ipath);
	if ($filename == "") { $param2 = ""; }else{ $param2 = '&amp;f='.rawurlencode(basename($filename)); }
	if ($page == ""    ) { $param3 = ""; }else{ $param3 = '&amp;p='.$page; }
}//end Get_GET()****************************************************************




function URLencode_path($path){ // don't encode the forward slashes ************
	$TS = '';  // Trailing Slash/
	if (substr($path, -1) == '/' ) { $TS = '/'; } //start with a $TS?
	$path_array = explode('/',$path);
	$path = "";
	foreach ($path_array as $level) { $path .= rawurlencode($level).'/'; }
	$path = rtrim($path,'/').$TS;  //end with $TS only if started with one
	return $path;
}//end URLencode_path($path) ***************************************************




function Check_path($path) { // returns first valid path in some/supplied/path/
	global  $_, $message, $EX;
	$invalidpath = $path; //used for message if supplied $path doesn't exist.
	$path = str_replace('\\','/',$path);   //Make sure all forward slashes.
	$path = trim($path,"/ ."); // trim slashes, dots, and spaces

	//Remove any '.' and '..' parts of the path.  Causes issues in <h2>www / current / path /</h2>
	$pathparts = explode( '/', $path);
	$len       = count($pathparts);
	$path      = "";  //Cleaned path.
	foreach ($pathparts as $value) { //(More reliable than str_replace(entire_string).)
		if ( !(($value == '.') && (!value == '..')) ) { $path .= $value.'/'; }
	}

	$path = trim($path,"/"); // Remove -for now- final trailing slash.

	if (strlen($path) < 1) { return ""; } //If at site root
	else {
		if (!is_dir($path) && (strlen($message) < 1))
			{ $message .= $EX.'<b>'.hsc($_['check_path_msg_01']).'</b>'.htmlentities($invalidpath).'<br>'; }

		while ( (strlen($path) > 0) && (!is_dir($path)) ) {
			$path = dirname($path);
		}

		$path = $path.'/';
		if ($path == './') { $path = ""; } // ./ means path not found, so clear for root.
	}

	return $path; 
}//end Check_path() ************************************************************




function is_empty($path){ //****************************************************
	$empty = false;
	$dh = opendir($path);
	for($i = 3; $i; $i--) { $empty = (readdir($dh) === FALSE); }
	closedir($dh);
	return $empty;
}//end is_empty() //************************************************************




function ordinalize($destination,$filename, &$msg) { //*************************
//if file_exists(file.txt), ordinalize filename until it doesn't
//ie: file.txt.001,  file.txt.002, file.txt.003  etc...
	global $_, $EX;

	$ordinal   = 0;
	$savefile = $destination.$filename;

	if (file_exists($savefile)) {

		$msg .= $EX.hsc($_['ord_msg_01']).'<br>';

		while (file_exists($savefile)) {
			$ordinal = sprintf("%03d", ++$ordinal); //  001, 002, 003, etc...
			$savefile = $destination.$filename.'.'.$ordinal;
		}
		$msg .= hsc($_['ord_msg_02']).'"<b>'.htmlentities(basename($savefile)).'</b>"';
	}
	return $savefile;
}//end ordinalize() filename ***************************************************




function Current_Path_Header(){ //**********************************************
 	// Current path. ie: webroot/current/path/ 
	// Each level is a link to that level.

	global $ONESCRIPT, $ipath, $WEB_ROOT;

	echo '<h2>';
		//Root folder of web site.
		echo '<a id="path_0" href="'.$ONESCRIPT.'" class="path"> '.htmlentities(trim($WEB_ROOT, '/')).'</a>/';
		$x=0; //need here for focus() in case at webroot.

		if ($ipath != "" ) { //if not at root, show the rest
			$path_levels  = explode("/",trim($ipath,'/') );
			$levels = count($path_levels); //If levels=3, indexes = 0, 1, 2  etc... 
			$current_path = "";

			for ($x=0; $x < $levels; $x++) {
				$current_path .= $path_levels[$x].'/';
				echo '<a id="path_'.($x+1).'" href="'.$ONESCRIPT.'?i='.URLencode_path($current_path).'" class="path">';
				echo htmlentities($path_levels[$x]).'</a>/';
			}
		}//end if (not at root)
	echo '</h2>';
	echo '<script>document.getElementById("path_'.$x.'").focus();</script>';
}//end Current_Path_Header() //*************************************************




function message_box() { //*****************************************************
	global $ONESCRIPT, $param1, $param2, $param3, $message, $page;

	if (isset($message)) {
?>
		<div id="message"><p>
		<span id="Xbox"><!-- [X] to dismiss message box -->
			<a id="dismiss" href='<?php echo $ONESCRIPT.$param1.$param2.$param3; ?>'
 			onclick='document.getElementById("message").innerHTML = " ";return false;'>
			[X]</a>
		</span>
		<?php echo $message.PHP_EOL ;?>
		</p></div>
		<script>document.getElementById("dismiss").focus();</script>
<?php
	}else {
		echo '<div id="message"></div>'; // Needed on Edit page to keep js feedback from failing
	} //end isset($message)
	
	// Used on Edit Page to preserve vertical spacing, so edit area doesn't jump as much.
	if ($page == "edit") {echo '<style>#message { min-height: 1.86em; }</style>';}
}//end message_box()  **********************************************************




function Upload_New_Rename_Delete_Links() { //**********************************
	global $_, $ONESCRIPT, $ipath, $param1;
	echo '<p class="front_links">';
	echo '<a href="'.$ONESCRIPT.$param1.'&amp;p=upload">'   ; svg_icon_upload()    ; echo hsc($_['Upload_File']).'</a>';
	echo '<a href="'.$ONESCRIPT.$param1.'&amp;p=newfile">'  ; svg_icon_file_new()  ; echo hsc($_['New_File'])   .'</a>';
	echo '<a href="'.$ONESCRIPT.$param1.'&amp;p=newfolder">'; svg_icon_folder_new(); echo hsc($_['New_Folder']) .'</a>';
	if ($ipath !== "") { //if at root, don't show Rename & Delete links
		echo '<a href="'.$ONESCRIPT.$param1.'&amp;p=renamefolder">'; svg_icon_folder_ren(); echo hsc($_['Ren_Folder']).'</a>';
		echo '<a href="'.$ONESCRIPT.$param1.'&amp;p=deletefolder">'; svg_icon_folder_del(); echo hsc($_['Del_Folder']).'</a>';
	}
	echo '</p>';
}//end Upload_New_Rename_Delete_Links()  ***************************************




function Cancel_Submit_Buttons($submit_label, $focus) { //**********************
	//$submit_label = Rename, Copy, Delete, etc...
	//$focus is ID of element to receive focus(). (element may be outside this function)
	global $_, $ONESCRIPT, $ipath, $param1, $param2, $filename, $page;

	// [Cancel] returns to either the index, or edit page.
	if ($filename == "") {$params = "";}else{ $params = $param2.'&amp;p=edit'; }
?>
	<p> 
	<input type="button" class="button" id="cancel" name="cancel" value="<?php echo hsc($_['Cancel']) ?>"
		onclick="parent.location = '<?php echo $ONESCRIPT.$param1.$params ?>'">
	<input type="submit" class="button" value="<?php echo $submit_label;?>" style="margin-left: 1.3em;">
<?php 
	if ($focus != ""){ echo '<script>document.getElementById("'.$focus.'").focus();</script>'; }
	//Do not close the <p> tag yet/here. Need to leave it open for edit btn on hash page.
}// End Cancel_Submit_Buttons() //**********************************************




function show_image(){ //*******************************************************
	global $_, $filename, $MAX_IMG_W, $MAX_IMG_H;
	
	$IMG = $filename;
	$img_info = getimagesize($IMG);

	$W=0; $H=1; //indexes for $img_info[]
	$SCALE = 1; $TOOWIDE = 0; $TOOHIGH = 0;
	if ($img_info[$W] > $MAX_IMG_W) { $TOOWIDE = ( $MAX_IMG_W/$img_info[$W] );}
	if ($img_info[$H] > $MAX_IMG_H) { $TOOHIGH = ( $MAX_IMG_H/$img_info[$H] );}
	
	if ($TOOHIGH || $TOOWIDE) {
		if     (!$TOOWIDE)           {$SCALE = $TOOHIGH;}
		elseif (!$TOOHIGH)           {$SCALE = $TOOWIDE;}
		elseif ($TOOHIGH > $TOOWIDE) {$SCALE = $TOOWIDE;} //ex: if (.90 > .50)
		else                         {$SCALE = $TOOHIGH;}
	}

	echo '<p>';
	echo hsc($_['show_img_msg_01']). round($SCALE*100) .hsc($_['show_img_msg_02']).$img_info[0].' x '.$img_info[1].').</p>';
	echo '<div style="clear:both"></div>'.PHP_EOL;
	echo '<a href="/' .URLencode_path($IMG). '" target="_blank">'.PHP_EOL;
	echo '<img src="/'.URLencode_path($IMG).'"  height="'.$img_info[$H]*$SCALE.'"></a>'.PHP_EOL;
}// end show_image() ***********************************************************




function show_favicon(){ //*****************************************************
	global $config_favicon, $DOC_ROOT;
	if (file_exists($DOC_ROOT.$config_favicon)) { 
		echo '<img src="'.URLencode_path($config_favicon).'" alt="">'; 
	}
}// end show_favicon() *********************************************************




function Timeout_Timer($COUNT, $ID, $CLASS, $ACTION) { //************************

	return 	'<script>'.
			'Start_Countdown('.$COUNT.', "'.$ID.'", "'.$CLASS.'", "'.$ACTION.'");'.
			'</script>';

} //end Timeout_Timer() **************************************************




function Init_Macros(){ //*** ($varibale="some reusable chunk of code")*********

global 	$ONESCRIPT, $param1, $param2, $INPUT_NUONCE, $FORM_COMMON, 
		$SVG_icon_circle_plus, $SVG_icon_circle_x, $SVG_icon_pencil, $SVG_icon_img_0;

$INPUT_NUONCE = '<input type="hidden" name="nuonce" value="'.$_SESSION['nuonce'].'">'.PHP_EOL;
$FORM_COMMON = '<form method="post" action="'.$ONESCRIPT.$param1.$param2.'">'.$INPUT_NUONCE;

$SVG_icon_circle_plus = '<circle cx="5" cy="5" r="5" stroke="black" stroke-width="0" fill="#080"/>
	  <line x1="2" y1="5" x2="8" y2="5" stroke="white" stroke-width="1.5" />
	  <line x1="5" y1="2" x2="5" y2="8" stroke="white" stroke-width="1.5" />';

$SVG_icon_circle_x = '<circle cx="5" cy="5" r="5" stroke="black" stroke-width="0" fill="#D00"/>
	<line x1="2.5" y1="2.5" x2="7.5" y2="7.5" stroke="white" stroke-width="1.5"/>
	<line x1="7.5" y1="2.5" x2="2.5" y2="7.5" stroke="white" stroke-width="1.5"/>';

$SVG_icon_pencil = '<polygon points="2,0 9,7 7,9 0,2" stroke-width="1" stroke="darkgoldenrod" fill="rgb(246,222,100)"/>
	  <path  d="M0,2   L0,0  L2,0"      stroke="tan" fill="tan" stroke-width="1" />
	  <path  d="M0,1.5   L0,0  L1.5,0"      stroke="black" fill="transparent" stroke-width="1" />
	  <line x1="7.3" y1="10"  x2="10" y2="7.3"  stroke="silver" stroke-width="1"/>
	  <line x1="8.1" y1="10.8"  x2="10.8" y2="8.1"  stroke="red" stroke-width="1"/>';

$SVG_icon_img_0 = '<rect x="0"    y="0"   width="14" height="16" fill="#FF8" stroke="#44F" stroke-width="2" />
	<rect x="2"    y="2"   width="5"  height="5"  fill="#F66" stroke-width="0" />
	<rect x="7.5"  y="6"   width="5"  height="5"  fill="#6F6" stroke-width="0" />
	<rect x="2"    y="10"  width="5"  height="5"  fill="#66F" stroke-width="0" />';
}//end Init_Macros() ***********************************************************




function svg_icon_bin(){ //*****************************************************
$zero = '<rect x="0"  y="0"  width="3" height="6" fill="transparent" stroke="#555" stroke-width="1" />';
$one  = '<line x1="0" y1="-.5"   x2="0" y2="6.5"  stroke="#555" stroke-width="1"/>';
?><svg class="icon" xmlns="http://www.w3.org/2000/svg" version="1.1" width="14" height="16">
	<g transform="translate( 0.5,0.5)"><?php echo $one  ?></g>
	<g transform="translate( 3.5,0.5)"><?php echo $zero ?></g>
	<g transform="translate( 9.5,0.5)"><?php echo $one  ?></g>
	<g transform="translate(12.5,0.5)"><?php echo $one  ?></g>
	<g transform="translate( 0.5,9.5)"><?php echo $zero ?></g>
	<g transform="translate( 6.5,9.5)"><?php echo $one  ?></g>
	<g transform="translate( 9.5,9.5)"><?php echo $zero ?></g>
</svg><?php 
} //end svg_icon_bin() *********************************************************



function svg_icon_img(){ //*****************************************************
global $SVG_icon_img_0;
?><svg class="icon icon_file" xmlns="http://www.w3.org/2000/svg" version="1.1" width="14" height="16">
	<?php echo $SVG_icon_img_0 ?>
</svg><?php 
} //end svg_icon_img() *********************************************************



function svg_icon_svg(){ //*****************************************************
global $SVG_icon_img_0;
?><svg class="icon icon_file" xmlns="http://www.w3.org/2000/svg" version="1.1" width="14" height="16">
	<?php echo $SVG_icon_img_0 ?>
	<line x1="3" y1="3.5"  x2="11" y2="3.5"  stroke="#444" stroke-width=".6"/>
	<line x1="3" y1="6.5"  x2="11" y2="6.5"  stroke="#444" stroke-width=".6"/>
	<line x1="3" y1="9.5"  x2="11" y2="9.5"  stroke="#444" stroke-width=".6"/>
	<line x1="3" y1="12.5" x2="11" y2="12.5" stroke="#444" stroke-width=".6"/>
</svg><?php 
} //end svg_icon_img() *********************************************************



function svg_icon_txt_0($border, $lines, $fill, $extra){ //*********************
?><svg class="icon icon_file" xmlns="http://www.w3.org/2000/svg" version="1.1" width="14" height="16">
	<rect x = "0" y = "0" width = "14" height = "16" 
		fill="<?php echo $fill ?>" stroke="<?php echo $border ?>" stroke-width="2" />
	<line x1="3" y1="3.5"  x2="11" y2="3.5"  stroke="<?php echo $lines ?>" stroke-width=".6"/>
	<line x1="3" y1="6.5"  x2="11" y2="6.5"  stroke="<?php echo $lines ?>" stroke-width=".6"/>
	<line x1="3" y1="9.5"  x2="11" y2="9.5"  stroke="<?php echo $lines ?>" stroke-width=".6"/>
	<line x1="3" y1="12.5" x2="11" y2="12.5" stroke="<?php echo $lines ?>" stroke-width=".6"/>
	<?php echo $extra ?>
</svg><?php 
} //end svg_icon_txt() *********************************************************



function svg_icon_txt(){ svg_icon_txt_0('#333', '#000', '#FFF', ''); } //*******

function svg_icon_htm(){ svg_icon_txt_0('#444', '#222', '#FABEAA', ''); } //**** rgb(250,190,170)

function svg_icon_php(){ svg_icon_txt_0('#333', '#111', '#C3C3FF', ''); } //**** rgb(195,195,225)

function svg_icon_css(){ svg_icon_txt_0('#333', '#111', '#FFE1A5', ''); } //**** rgb(255,225,165)

function svg_icon_cfg(){ svg_icon_txt_0('#444', '#111', '#DDD', ''); } //*******



function svg_icon_upload(){ //**************************************************
	$extra = '<g transform="scale(1.1) translate(1.75,4)">
		<polygon points="6,0  12,6  8,6  8,11  4,11  4,6  0,6" 
		stroke-width="1" stroke="white" fill="green" /></g>';
	svg_icon_txt_0('#333', 'black', 'white', $extra);
} //end svg_icon_upload() ******************************************************



function svg_icon_file_new(){ //************************************************
	global $SVG_icon_circle_plus;
	$extra = '<g transform="translate(4,6)">'.$SVG_icon_circle_plus.'</g>';
	svg_icon_txt_0('#444', 'black', 'white', $extra);
} //end svg_icon_file_new() ****************************************************



function svg_icon_file_del(){ //************************************************
global $SVG_icon_circle_x;
	$extra = '<g transform="translate(4,6)">'.$SVG_icon_circle_x.'</g>';
	svg_icon_txt_0('#444', 'black', 'white', $extra);
} //end svg_icon_file_del() ****************************************************



function svg_icon_folder_0($extra){ //******************************************
?><svg class="icon icon_fldr" xmlns="http://www.w3.org/2000/svg" version="1.1" width="18" height="14">
	<path  d="M0.5, 1  L8,1  L9,2  L9,3  L16.5,3  L17,3.5  L17,13.5  L.5,13.5  L.5,.5" 
			fill="#FBE47b" stroke="#F0CD28" stroke-width="1" />
	<path  d="M1.5, 8  L7, 8  L8.5,6.3  L16,6.3  L7.5, 6.3   L6.5,7.5  L1.5,7.5" 
			fill="transparent" stroke="white" stroke-width="1" />
	<path  d="M1.5,13  L1.5,2  L7.5,2  L8.5,3  L8.5,4  L15.5,4 L16,4.5  L16,13"  
			fill="transparent" stroke="white" stroke-width="1" />
	<?php echo $extra ?>
</svg><?php 
} //end svg_icon_folder_0() ****************************************************



function svg_icon_folder(){ svg_icon_folder_0(''); } //*************************



function svg_icon_folder_new(){ //**********************************************
	global $SVG_icon_circle_plus;
	$extra = '<g transform="translate(7.5,4)">'.$SVG_icon_circle_plus.'</g>';
	svg_icon_folder_0($extra);
} //end svg_icon_folder_new() **************************************************



function svg_icon_folder_ren(){ //**********************************************
	global $SVG_icon_pencil;
	$extra = '<g transform="translate(6,3)">'.$SVG_icon_pencil.'</g>';
	svg_icon_folder_0($extra);
} //end svg_icon_folder_ren() **************************************************



function svg_icon_folder_del(){ //**********************************************
	global $SVG_icon_circle_x; 
	$extra = '<g transform="translate(7.5,4)">'.$SVG_icon_circle_x.'</g>';
	svg_icon_folder_0($extra);
} //end svg_icon_folder_del() **************************************************




function show_icon($type){ //***************************************************
	if     ($type == 'bin') { svg_icon_bin(); }
	elseif ($type == 'img') { svg_icon_img(); }
	elseif ($type == 'svg') { svg_icon_svg(); }
	elseif ($type == 'txt') { svg_icon_txt(); }
	elseif ($type == 'htm') { svg_icon_htm(); }
	elseif ($type == 'php') { svg_icon_php(); }
	elseif ($type == 'css') { svg_icon_css(); }
	elseif ($type == 'cfg') { svg_icon_cfg(); }
	else                    { svg_icon_bin(); } //default
}//end show_icon() *************************************************************




function Hash_Page() { //******************************************************
	global $_, $DOC_ROOT, $ONESCRIPT, $param1, $param2, $message, $INPUT_NUONCE, $config_title;
	$params = '?i='.dirname($ONESCRIPT).'&amp;f='.basename($ONESCRIPT).'&amp;p=edit';
	if (!isset($_POST['whattohash'])) { $_POST['whattohash'] = ''; }
?>
	<style>#message {font-family: courier; min-height: 3.1em;}
	li {margin-left: 2em}</style>

	<h2><?php echo hsc($_['hash_h2']) ?></h2>
	
	<form id="hash" name="hash" method="post" action="<?php echo $ONESCRIPT.$param1.'&amp;p=hash'; ?>">
		<?php echo $INPUT_NUONCE; ?>
		Password to hash:
		<input type="text" name="whattohash" id="whattohash" value="<?php echo hsc($_POST["whattohash"]) ?>">
		<?php Cancel_Submit_Buttons(hsc($_['Generate_Hash']), 'whattohash') ?>
 		<a class="button edit_onefile" href="<?php echo $ONESCRIPT.$params; ?>" ><?php echo hsc($_['Edit']).' '.$config_title ?></a>
	</form>

	<div class="info">
 	<p><?php echo hsc($_['hash_txt_01']) ?><br>
	<p>
	<?php echo hsc($_['hash_txt_02']) ?><br>
	<?php echo hsc($_['hash_txt_03']) ?><br>

	<p><?php echo hsc($_['hash_txt_04']) ?>

	<p><?php echo hsc($_['hash_txt_05']) ?>
	<ol><li><?php echo hsc($_['hash_txt_06']) ?><br>
			<?php echo hsc($_['hash_txt_07']) ?>
		<li><?php echo hsc($_['hash_txt_08']) ?><br>
			<?php echo hsc($_['hash_txt_09']) ?><br>
			<?php echo hsc($_['hash_txt_10']) ?><br>
		<li><?php echo hsc($_['hash_txt_11']) ?>
		<li><?php echo hsc($_['hash_txt_12']) ?>
	</ol>
	<p><?php echo hsc($_['hash_txt_13']) ?>
	<p>
	<?php echo hsc($_['hash_txt_14']) ?>

	</div>
<?php 
} //end Hash_Page() ************************************************************




function Hash_response() { //***************************************************
	global $_, $message;
	$_POST['whattohash'] = trim($_POST['whattohash']); // trim leading & trailing spaces.
	$message .= hsc($_['hash_msg_01']).hsc($_POST['whattohash']).'<br>';
	$message .= hsc($_['hash_msg_02']).hashit($_POST["whattohash"]);
} //end Hash_response() ********************************************************




function Logout() { //**********************************************************
	global $page;
	session_regenerate_id(true);
	session_unset();
	session_destroy();
	session_write_close();
	unset($_GET);
	unset($_POST);
	$_SESSION['valid'] = 0;
	$page = 'login';
}//end Logout() ****************************************************************




function Login_Page() { //******************************************************
	global $_, $ONESCRIPT, $message;
?>
	<h2><?php echo hsc($_['login_h2']) ?></h2>
	<form method="post" action="<?php echo $ONESCRIPT; ?>">
		<label for="username"><?php echo hsc($_['login_txt_01']) ?></label>
		<input type="text" name="username" id="username" class="login_input" >
		<label for="password"><?php echo hsc($_['login_txt_02']) ?></label>
		<input type="password" name="password" id="password" class="login_input">
		<input type="submit" class="button" value="<?php echo hsc($_['Enter']) ?>">
	</form>
	<script>document.getElementById('username').focus();</script>
<?php 
} //end Login_Page() ***********************************************************




function Login_response() { //**************************************************
	global $_, $EX, $message, $page, $LOGIN_ATTEMPTS, 
		   $USERNAME, $PASSWORD, $USE_HASH, $HASHWORD, $MAX_ATTEMPTS, $LOGIN_DELAY;

	$_SESSION = array();    //make sure it's empty
	$_SESSION['valid'] = 0; //Default to failed login.
	$attempts = 0;
	$elapsed  = 0;

	if (is_file($LOGIN_ATTEMPTS)) { //Check for prior failed attempts
		$attempts = (int)file_get_contents($LOGIN_ATTEMPTS); //Don't increment yet...
		$elapsed  = time() - filemtime($LOGIN_ATTEMPTS);
	}

	if ($attempts > 0) { $message .= '<b>'.hsc($_['login_msg_01a']).' '.$attempts.' '.hsc($_['login_msg_01b']).'</b><br>';}
	if ( ($attempts >= $MAX_ATTEMPTS) && ($elapsed < $LOGIN_DELAY) ){
		$message .= hsc($_['login_msg_02a']).' '.Timeout_Timer(($LOGIN_DELAY - $elapsed), 'timer0', '', '').' '.hsc($_['login_msg_02b']);
		return;
	}

	//Validate password
	if ($USE_HASH) { $VALID_PASSWORD = (hashit($_POST['password']) == $HASHWORD); }
	else           { $VALID_PASSWORD = (       $_POST['password']  == $PASSWORD); }

	//validate login.  Ignore attempt if username & password are blank. 
	if ( ($_POST['password'] == "") && ($_POST['username'] == "") )  { ; //
	}elseif ( $VALID_PASSWORD && ($_POST['username'] == $USERNAME) ) {
		session_regenerate_id(true);
		$_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT']; //for user consistancy check.
		$_SESSION['valid'] = 1;
		$page = "index";
		if ( is_file($LOGIN_ATTEMPTS) ) { unlink($LOGIN_ATTEMPTS); } //delete invalid attempts count file
	}else{
		file_put_contents($LOGIN_ATTEMPTS, ++$attempts); //increment & save attempt
		$message  = $EX.'<b>'.hsc($_['login_msg_03']).$attempts.'</b><br>';
		if ($attempts >= $MAX_ATTEMPTS) {
			$message .= hsc($_['login_msg_02a']).' '.Timeout_Timer($LOGIN_DELAY, 'timer0', '', '').' '.hsc($_['login_msg_02b']);
		}
	}
}//end Login_response() //******************************************************




function List_Files() { // ...in a vertical table ******************************
//called from Index Page

	global $ONESCRIPT, $ipath, $param1, $ftypes, $fclasses, $excluded_list, $stypes, $SHOWALLFILES;

	$files = scandir('./'.$ipath);
	natcasesort($files);

	echo '<table class="index_T">';
	foreach ($files as $file) {
		
		$excluded = FALSE;
		if (in_array(basename($file), $excluded_list)) { $excluded = TRUE; };

		//Get file type & check against $stypes (files types to show)
		$ext = end( explode(".", strtolower($file)) );
		if ($SHOWALLFILES || in_array($ext, $stypes)) { $SHOWTYPE = TRUE; } else { $SHOWTYPE = FALSE; }
		
		if ( $SHOWTYPE && !is_dir($ipath.$file) && !$excluded ) {
			
			//Set icon type based on file type ($ext).
			$type = $fclasses[array_search($ext, $ftypes)];
?>
			<tr>
				<td>
					<?php echo '<a href="'.$ONESCRIPT.$param1.'&amp;f='.rawurlencode($file).'&amp;p=edit" >'; ?>
					<?php show_icon($type); echo  htmlentities($file), '</a>'; ?>
				</td>
				<td class="meta_T meta_size">&nbsp;
					<?php echo number_format(filesize($ipath.$file)); ?> B
				</td>
				<td class="meta_T meta_time"> &nbsp;
					<script>FileTimeStamp(<?php echo filemtime($ipath.$file); ?>, 1, 0);</script>
				</td>
			</tr>
<?php 
		}//end if !is_dir...
	}//end foreach file
	echo '</table>';
}//end List_Files() ************************************************************




function Index_Page(){ //*******************************************************
	global $ONESCRIPT, $ipath;

	//<!--==== List folders/sub-directores ====-->
	echo '<p class="index_folders">';
		$folders = glob($ipath."*",GLOB_ONLYDIR);
		natcasesort($folders);
		foreach ($folders as $folder) {
			echo '<a href="'.$ONESCRIPT.'?i='.URLencode_path($folder).'/">'.PHP_EOL;
			svg_icon_folder();
			echo htmlentities(basename($folder)).' /</a>';
		}
	echo '</p>';

	Upload_New_Rename_Delete_Links();

	List_Files();

	Upload_New_Rename_Delete_Links();

}//end Index_Page()*************************************************************




function Edit_Page_buttons_top($text_editable){ //******************************
	global $_, $ONESCRIPT, $param1, $filename;
?>
	<div class="edit_btns_top">
		<div class="file_meta">
			<span class="meta_size">
				<?php echo hsc($_['meta_txt_01']).number_format(filesize($filename)).' '.hsc($_['meta_txt_02']); ?>
			</span> &nbsp; 
			<span class="meta_time">
				<?php echo hsc($_['meta_txt_03']) ?><script>FileTimeStamp(<?php echo filemtime($filename); ?>, 1, 1);</script>
			</span><br>
		</div>

		<div class="buttons_right">
			<?php if ( $text_editable ) { ?>
				<input type="button" id="wide_view" class="button" value="<?php echo hsc($_['Wide_View']) ?>" onclick="Wide_View();">
			<?php } ?>
			<input type="button" id="close1" class="button" value="<?php echo hsc($_['Close']) ?>" 
				onclick="parent.location = '<?php echo $ONESCRIPT.$param1 ?>'">
			<script>document.getElementById('close1').focus();</script>
		</div>
		<div style="clear:both"></div>
	</div>
<?php 
}//end Edit_Page_buttons_top(){ //**********************************************




function Edit_Page_buttons($text_editable, $too_large_to_edit) { //*************
	global $_, $ONESCRIPT, $param1, $param2, $MAX_IDLE_TIME;
	$Button = '<input type="button" class="button" value="';
	$ACTION = '" onclick="parent.location = \''.$ONESCRIPT.$param1.$param2.'&amp;p=';
?>
	<div class="edit_btns_bottom">
	<?php if ($text_editable && !$too_large_to_edit) { //Show save & reset only if editable file ?> 
		<?php echo Timeout_Timer($MAX_IDLE_TIME, 'timer1','timer', 'LOGOUT'); ?>
		<input type="submit" class="button" value="Save"                  onclick="submitted = true;" id="save_file">
		<input type="button" class="button" value="Reset - loose changes" onclick="Reset_File()"      id="reset">
		<script>
			//Set disabled here instead of via input attribute in case js is disabled.
			//If js is disabled, user would be unable to save changes.
			//Only disable buttons when not working with an iframe:
			if (!document.getElementById("html_editor")) {
				document.getElementById('save_file').disabled = "disabled";
				document.getElementById('reset').disabled     = "disabled";
			}
		</script>
	<?php } ?>
	<?php echo $Button.hsc($_['Ren_Move']).$ACTION ?>rename'">
	<?php echo $Button.hsc($_['Copy'])    .$ACTION ?>copy'"  >
	<?php echo $Button.hsc($_['Delete'])  .$ACTION ?>delete'">
	<?php echo $Button.hsc($_['Close']) ?>" onclick="parent.location = '<?php echo $ONESCRIPT.$param1 ?>'">
	</div>
<?php
}//end Edit_Page_buttons()******************************************************




//******************************************************************************
function Edit_Page_form($ext, $text_editable, $too_large_to_edit, $too_large_to_edit_message){ 
	global $_, $ONESCRIPT, $ipath, $HTML_WYSIWYG_EDIT, $param1, $param2, $param3, $filename, $itypes, $INPUT_NUONCE, $EX, $message, $MAX_IDLE_TIME;
?>
	<form id="edit_form" onsubmit="return synchronize_data()" name="edit_form" method="post" action="<?php echo $ONESCRIPT.$param1.$param2.$param3 ?>">
		<script type="text/javascript">
			function synchronize_data() {
				var rc = true;

				if (document.getElementById("html_editor"))
				{
					// Get contents of body:
					var content=document.getElementById("html_editor").
						contentWindow.document.body.innerHTML;

					// Whole html:
					//var content=document.getElementById("html_editor").
					// 	contentWindow.document.documentElement.outerHTML;

					// Save body into hidden input-field:
					document.getElementById("content").value = content;

					rc = true;
				}

				return rc;
			}
		</script>
		<?php echo $INPUT_NUONCE; ?>
<?php
		if ( !in_array( strtolower($ext), $itypes) ) { //If non-image...

			if (!$text_editable) { // If non-text file...
				echo '<p class="edit_disabled">'.hsc($_['edit_txt_01']).'<br><br></p>';

			}elseif ( $too_large_to_edit ) {
 				echo '<p class="edit_disabled">'.$too_large_to_edit_message.'</p>';

			}elseif (in_array($ext, array('html', 'htm')) && $HTML_WYSIWYG_EDIT) {
				# Embed iframe
				echo '<input type="hidden" name="filename" id="filename" 
					value="',hsc($filename),'">
					<input type="hidden" name="content" id="content">
					<input type="hidden" name="wysiwyg" value="1">
					<iframe id="html_editor" style="border:1px solid #000;"
						src="?i=',URLencode_path($ipath),
						'&f=',rawurlencode(basename($filename)),
						'&p=iframe_edit"
						width="100%" height="350"></iframe>';

				# Enable browser-builtin WYSIWYG editor for the whole document with JavaScript
				echo '<script type="text/javascript">
					window.onload = function() {
						// Define not with var, so it stays global:
						editor = document.getElementById("html_editor");
						editor.contentDocument.designMode = "On";
					}
					</script>';

			}else{
				if (PHP_VERSION_ID  < 50400) {  // 5.4.0
					$filecontent = hsc(file_get_contents($filename));
				}else{
					$filecontent = hsc(file_get_contents($filename),ENT_SUBSTITUTE);
				}
				$bad_chars = ($filecontent == "" && filesize($filename) > 0);

				if ($bad_chars){ //did htmlspecialchars return an empty string?
					echo '<pre class="edit_disabled">'.$EX.hsc($_['edit_txt_02']).'<br>';
					echo hsc($_['edit_txt_03']).'<br>';
					echo hsc($_['edit_txt_04']).'<br></pre>';
				}else{
					echo '<input type="hidden" name="filename" id="filename" value="'.hsc($filename).'">';
					echo '<textarea id="file_contents" name="content" cols="70" rows="25"
						onkeyup="Check_for_changes(event);">'.$filecontent.'</textarea>'.PHP_EOL;
				}
			} //end if non-text file...
		} //end if non-image

		Edit_Page_buttons($text_editable, $too_large_to_edit);

		Edit_Page_scripts();
?>	</form>
<?php
	if ($text_editable && !$too_large_to_edit && !$bad_chars) { Edit_Page_Notes(); }
}//end Edit_Page_form() ********************************************************




function Edit_Page_Notes() { //*************************************************
	global $_, $MAX_IDLE_TIME;
			$SEC = $MAX_IDLE_TIME;
			$HRS = floor($SEC/3600);
			$SEC = fmod($SEC,3600);
			$MIN = floor($SEC/60);   if ($MIN < 10) { $MIN = "0".$MIN; };
			$SEC = fmod($SEC,60);    if ($SEC < 10) { $SEC = "0".$SEC; };
			$HRS_MIN_SEC = $HRS.':'.$MIN.':'.$SEC;
?>
			<div id="edit_notes">
				<div class="notes"><?php echo hsc($_['edit_notes_00']) ?></div>
				<div class="notes"><b>1)
					<?php echo hsc($_['edit_note_01a']).'$MAX_IDLE_TIME '.hsc($_['edit_note_01b']) ?>
					<?php echo ' '.$HRS_MIN_SEC.'. '.hsc($_['edit_note_02']) ?></b>
				</div>
				<div class="notes"><b>2) </b> <?php echo hsc($_['edit_note_03']) ?></div>
				<div class="notes"><b>3) </b> <?php echo hsc($_['edit_note_04']) ?></div>
			</div>
<?php 
}//end Edit_Page_Notes() { //***************************************************




function Edit_Page() { //*******************************************************
	global $_, $ONESCRIPT, $param1, $filename, $filecontent, $etypes, $itypes, $MAX_EDIT_SIZE, $MAX_VIEW_SIZE;
	clearstatcache ();

	//Determine if text editable file type
	$ext = end( explode(".", strtolower($filename) ) );
	if ( in_array($ext, $etypes) ) { $text_editable = TRUE;  }
	else                           { $text_editable = FALSE; }
	
	$too_large_to_edit = (filesize($filename) > $MAX_EDIT_SIZE);
	$too_large_to_view = (filesize($filename) > $MAX_VIEW_SIZE);
	
	if ( $too_large_to_edit ) { $header2 = hsc($_['edit_h2_1']); }
	else                      { $header2 = hsc($_['edit_h2_2']); }

	$too_large_to_edit_message = 
'<b>'.hsc($_['too_large_to_edit_01a']).number_format($MAX_EDIT_SIZE).' '.hsc($_['too_large_to_edit_01b']).'</b><br>'.
hsc($_['too_large_to_edit_02']).'<br>'.hsc($_['too_large_to_edit_03']).'<br>'.hsc($_['too_large_to_edit_04']);

	$too_large_to_view_message = 
'<b>'.hsc($_['too_large_to_view_01a']).number_format($MAX_VIEW_SIZE).' '.hsc($_['too_large_to_view_01b']).'</b><br>'.
hsc($_['too_large_to_view_02']).'<br>'.hsc($_['too_large_to_view_03']).'<br>'.hsc($_['too_large_to_view_04']);

	echo '<h2 id="edit_header">'.$header2;
	echo '<a class="filename" href="/'.URLencode_path($filename).'" target="_blank">'.htmlentities(basename($filename)).'</a>';
	echo '</h2>'.PHP_EOL;

	Edit_Page_buttons_top($text_editable);

	Edit_Page_form($ext, $text_editable, $too_large_to_edit, $too_large_to_edit_message);
	
	if ( in_array( $ext, $itypes) ) { show_image(); }

	echo '<div style="clear:both"></div>';

	if     ( $text_editable && $too_large_to_view ) {
		echo '<p class="edit_disabled">'.$too_large_to_view_message.'</p>';
	}
	elseif ( $text_editable && $too_large_to_edit ){ 
		$filecontent = hsc(file_get_contents($filename), ENT_COMPAT,'UTF-8');
		echo '<pre class="edit_disabled view_file">'.$filecontent.'</pre>';
	}
}//End Edit_Page ***************************************************************




/**
 * Outputs the HTML of the choosen file, with disharmed JavaScript
 */
function Output_HTML() { //*****************************************************
	global $filename;

	# Open and read file
	$filecontent = file_get_contents($filename);

	# Extract body:
	# $body = preg_replace("/.*<body[^>]*>|<\/body>.*/si", "", $filecontent);

	# Make JavaScript in body disfunctional,
	# because it can modify the HTML code
	# on-the-fly. When saving the modified 
	# HTML code, the JavaScript additions
	# cannot get stripped out.
	# Probably the following events should
	# get searched and disharmed too:
	#   - onabort
	#   - onblur
	#   - onchange
	#   - onclick
	#   - ondblclick
	#   - onerror
	#   - onfocus
	#   - onkeydown
	#   - onkeypress
	#   - onkeyup
	#   - onload
	#   - onmousedown
	#   - onmousemove
	#   - onmouseout
	#   - onmouseover
	#   - onmouseup
	#   - onreset
	#   - onresize
	#   - onselect
	#   - onsubmit
	#   - onunload
	echo str_ireplace(
		array('<script', '/script>'),
		array('<OFCMSscript', '/OFCMSscript>'),
		$filecontent);

	# Prevent other OFCMS functions to fire:
	exit;
}//End Output_HTML *************************************************************






function Edit_response(){ //***If on Edit page, and [Save] clicked *************
	global $_, $EX, $message, $filename;
	$filename = $_POST["filename"];
	$content  = $_POST["content"];

	// Save HTML posted per iframe/WYSIWYG?
	if (isset($_POST['wysiwyg']) && $_POST['wysiwyg']) {
		// Restore Javascript
		$content = str_ireplace(
			array('<OFCMSscript', '/OFCMSscript>'),
			array('<script', '/script>'),
			$content);

		// Inject posted body into file-body:
		$html = file_get_contents($filename);
		$html = preg_replace(
			'/(<body[^>]*>).*(<\/body>)/si',
			'\\1' . $content . '\\2',
			$html);
		$content = $html;
	}

	$bytes = file_put_contents($filename, $content);

	if ($bytes !== false) {
		$message .= '<b>'.hsc($_['edit_msg_01']).' '.$bytes.' '.hsc($_['edit_msg_02']).'</b>';
	}else{
		$message .= $EX.'<b>'.hsc($_['edit_msg_03']).'</b>';
	}
}//end Edit_response() *********************************************************




function Upload_Page() { //*****************************************************
	global $_, $ONESCRIPT, $ipath, $param1, $INPUT_NUONCE;

	//Determine $MAX_FILE_SIZE to upload
	$upload_max_filesize = ini_get('upload_max_filesize'); //This should be < post_max_size,
	$post_max_size       = ini_get('post_max_size');       //but, just in case, check both...

	function shorthand_to_int($SHORTHAND){ //*******************
		$KMG = strtoupper(substr($SHORTHAND, -1));
		if     ($KMG == "K") { return $SHORTHAND * 1024; }
		elseif ($KMG == "M") { return $SHORTHAND * 1048576; }
		elseif ($KMG == "G") { return $SHORTHAND * 1073741824; }
		else                 { return $SHORTHAND; }
	}//end function shorthand_to_int() *************************

	$UMF = shorthand_to_int($upload_max_filesize);
	$PMS = shorthand_to_int($post_max_size);

	if ($UMF <= $PMS){ $MAX_FILE_SIZE = $UMF; $max_msg = $upload_max_filesize.' '.hsc($_['upload_txt_01']); }
	else             { $MAX_FILE_SIZE = $PMS; $max_msg = $post_max_size      .' '.hsc($_['upload_txt_02']); }
?>
	<h2><?php echo hsc($_['upload_h2']) ?></h2>
	<p><?php echo hsc($_['upload_txt_03']).$max_msg; ?></p>
	<form enctype="multipart/form-data" action="<?php echo $ONESCRIPT.$param1; ?>&amp;p=uploaded" method="post">
		<?php echo $INPUT_NUONCE; ?>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $MAX_FILE_SIZE ?>"> 
		<input type="hidden" name="upload_destination" value="<?php echo hsc($ipath); ?>" >
		<input type="file"   name="upload_file" id="upload_file" size="100">
		<?php Cancel_Submit_Buttons(hsc($_['Upload']),"cancel"); ?>
	</form>
<?php 
} //end Upload_Page() **********************************************************




function Upload_response() { //*************************************************
	global $_, $filename, $message, $EX, $page;
	$filename    = $_FILES['upload_file']['name'];
	$destination = Check_path($_POST["upload_destination"]);
	$page  = "index";
	$MAXUP1 = ini_get('upload_max_filesize');
	$MAXUP2 = number_format($_POST['MAX_FILE_SIZE']).hsc($_['bytes_01']);
	$ERROR = $_FILES['upload_file']['error'];

	if     ( $ERROR == 1 ){ $ERRMSG = hsc($_['upload_err_01a']).' upload_max_filesize = '.$MAXUP1.' '.hsc($_['upload_err_01b']);}
	elseif ( $ERROR == 2 ){ $ERRMSG = hsc($_['upload_err_02a']).' $MAX_FILE_SIZE = '     .$MAXUP2.' '.hsc($_['upload_err_02b']);}
	elseif ( $ERROR == 3 ){ $ERRMSG = hsc($_['upload_err_03']); }
	elseif ( $ERROR == 4 ){ $ERRMSG = hsc($_['upload_err_04']); }
	elseif ( $ERROR == 5 ){ $ERRMSG = hsc($_['upload_err_05']); }
	elseif ( $ERROR == 6 ){ $ERRMSG = hsc($_['upload_err_06']); }
	elseif ( $ERROR == 7 ){ $ERRMSG = hsc($_['upload_err_07']); }
	elseif ( $ERROR == 8 ){ $ERRMSG = hsc($_['upload_err_08']); }
	else                  { $ERRMSG = ''; }

	if (($filename == "")){ 
		$message .= $EX.'<b>'.hsc($_['upload_msg_01']).'</b>';
	}elseif (($destination != "") && !is_dir($destination)) {
		$message .= $EX.hsc($_['upload_msg_02']).'<br><b>';
		$message .= htmlentities($WEB_ROOT.$destination).'</b><br>'.hsc($_['upload_msg_03']).'</b>';
	}else{
		$message .= hsc($_['upload_msg_04']).' "<b>'.htmlentities($filename).'</b>"...';
		$savefile = ordinalize($destination, $filename, $savefile_msg);
		if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $savefile)) {
			$message .= '<br>'.hsc($_['upload_msg_05']).' '.$savefile_msg;
		} else{
			$message .= '<br>'.$EX.'<b>'.hsc($_['upload_msg_06']).'</b> '.$ERRMSG.'';
		}
	}
}//end Upload_response() *******************************************************




function New_File_Page() { //***************************************************
	global $_, $FORM_COMMON, $INVALID_CHARS;
?>
	<h2><?php echo hsc($_['new_file_h2']) ?></h2>
	<?php echo $FORM_COMMON ?>
		<p><?php echo hsc($_['new_file_txt_01']) . hsc($_['new_file_txt_02']) ?>
		<span class="mono"><?php echo htmlentities($INVALID_CHARS) ?></span></p>
		<input type="text" name="new_file" id="new_file" value="">
		<?php Cancel_Submit_Buttons(hsc($_['Create']),"new_file"); ?>
	</form>
<?php 
}//end New_File_Page()**********************************************************




function New_File_response() { //***********************************************
	global $_, $ipath, $param2, $param3, $filename, $page, $message, $EX, $INVALID_CHARS, $INVALID_CHARS_array;

	$new_name = trim($_POST["new_file"],'/ '); //Trim spaces and slashes.
	$filename = $ipath.$new_name;
	$page = "index"; // return to index if new file fails
	
	$invalid = false;
	foreach ($INVALID_CHARS_array as $bad_char) {
		if (strpos($new_name, $bad_char) !== false) { $invalid = true; }
	}

	if ($invalid){
		$message .= $EX.'<b>'.hsc($_['new_file_msg_01']).'</b> '.htmlentities($new_name).'<br>'.
			'<b> &nbsp; &nbsp; &nbsp; '.hsc($_['new_file_msg_02']).
			'<span class="mono">'.htmlentities($INVALID_CHARS).'</span></b>';
	}elseif ($new_name == ""){ 
		$message .= $EX.'<b>'.hsc($_['new_file_msg_03']).'</b>';
	}elseif (file_exists($filename)) {
		$message .= $EX.'<b>'.hsc($_['new_file_msg_04']);
		$message .= htmlentities($new_name).'</b>';
	}elseif ($handle = fopen($filename, 'w')) {
		fclose($handle);
		$message .= '<b>'.hsc($_['new_file_msg_05']).'</b> '.htmlentities($new_name);
		$page     = "edit";
		$param2   = '&amp;f='.rawurlencode(basename($filename));// for Edit_Page() buttons
		$param3   = '&amp;p=edit';                              // for Edit_Page() buttons 
	}else{
		$message .= $EX.'<b>'.hsc($_['new_file_msg_06']);
		$message .= htmlentities($new_name);
	}
}//end New_File_response() *****************************************************




function Copy_Ren_Move_Page($action, $title, $name_id, $isfile) { //************
	//$action = 'Copy' or 'Rename'. $isfile = 1 if acting on a file, not a folder
	global $_, $WEB_ROOT, $ipath, $filename, $FORM_COMMON;
	if ($isfile) { $old_name = $filename; }else{ $old_name = $ipath; }
	if ($isfile) { $new_name = $filename; }else{ $new_name = $ipath; }
	//if ($action == "Copy" ) { $new_name = ordinalize($ipath, basename($filename), $msg); }
?>
	<h2><?php echo $action.' '.$title ?></h2>
	<p><?php echo hsc($_['CRM_txt_01']) ?></p>
	<?php echo $FORM_COMMON ?>
		<p>
			<label><?php echo hsc($_['CRM_txt_02']) ?></label>
			<span class="web_root"><?php echo htmlentities($WEB_ROOT); ?></span><input type="text" 
				name="old_name" value="<?php echo hsc($old_name); ?>" readonly="readonly">
		</p>
		<p>
			<label><?php echo hsc($_['CRM_txt_03']) ?></label>
			<span class="web_root"><?php echo htmlentities($WEB_ROOT); ?></span><input type="text" 
				name="<?php echo $name_id ?>" id="<?php echo $name_id ?>" 
				value="<?php echo hsc($new_name); ?>">
		</p>
		<?php Cancel_Submit_Buttons($action, $name_id); ?>
	</form>
<?php 
} //end Copy_Ren_Move_Page() ***************************************************




//******************************************************************************
function Copy_Ren_Move_response($old_name, $new_name, $action, $msg1, $msg2, $isfile){
	//$action = 'copy' or 'rename'. $isfile = 1 if acting on a file, not a folder
	global $_, $WEB_ROOT, $ipath, $param1, $param2, $message, $EX, $page, $filename;

	$old_name = trim($old_name,'/ ');
	$new_name = trim($new_name,'/ ');
	$new_location = dirname($new_name);
	$filename = $old_name; //default if error
	if ($isfile) { $page = "edit"; }else{ $page = "index"; }
	
	if ( !is_dir($new_location) ){
		$message .= $EX.'<b>'.$msg1.' '.hsc($_['CRM_msg_01']).'</b><br>';
		$message .= htmlentities($WEB_ROOT.$new_location).'/<br>';
	}elseif ( !file_exists($filename) ){
		$message .= $EX.'<b>'.$msg1.' '.hsc($_['CRM_msg_02']).'</b><br>';
		$message .= htmlentities($filename);
	}elseif (file_exists($new_name)) {
		$message .= $EX.'<b>'.$msg1.' '.hsc($_['CRM_msg_03']).'<br>';
		$message .= htmlentities($WEB_ROOT.$new_name).'</b>';
	}elseif ($action($old_name, $new_name)) {
		$message .= '<b>'.htmlentities($WEB_ROOT.$old_name).'</b><br>';
		$message .= ' --- '.$msg2.' '.hsc($_['CRM_msg_04']).' ---<br>';
		$message .= '<b>'.htmlentities($WEB_ROOT.$new_name).'</b>';
		$filename = $new_name; //so edit page knows what to edit
		if ($isfile) { $ipath = Check_path(dirname($filename)); } //if changed,
		else         { $ipath = Check_path($filename); }          //return to new dir.
		$param1   = '?i='.URLencode_path($ipath);
		$param2   = '&amp;f='.rawurlencode(basename($filename));
		$param3   = '&amp;p=edit';
	}else{
		$message .= '<b>'.htmlentities($WEB_ROOT.$old_name).'</b><br>';
		$message .= $EX.'<b>'.hsc($_['CRM_msg_05a']).' '.$msg1.' '.hsc($_['CRM_msg_05b']).'</b><br>';
		$message .= '<b>'.htmlentities($WEB_ROOT.$new_name).'</b>';
	}
}//end Copy_Ren_Move_response() ************************************************




function Delete_File_Page() { //************************************************
	global $_, $filename, $FORM_COMMON;
?>
	<h2><?php echo hsc($_['delete_h2']) ?></h2>
	<?php echo $FORM_COMMON ?>
		<input type="hidden" name="delete_file" value="<?php echo hsc($filename); ?>" >
		<span class="verify"><?php echo htmlentities(basename($filename)); ?></span>
		<p><b><?php echo hsc($_['delete_txt_01']) ?></b></p>
		<?php Cancel_Submit_Buttons(hsc($_['DELETE']), "cancel"); ?>
	</form>
<?php 
} //end Delete_File_Page() *****************************************************




function Delete_File_response(){ //*********************************************
	global $_, $filename, $message, $EX, $page;

	$page = "index"; //Return to index
	$filename = $_POST["delete_file"];

	if (unlink($filename)) {
		$message .= '<b>'.hsc($_['delete_msg_01']).' '.htmlentities(basename($filename)).'</b>';
	}else{
		$message .= $EX.'<b>'.hsc($_['delete_msg_02']).' "'.htmlentities($filename).'"</b>.';
		$page = "edit";
	}
}//end Delete_File_response() **************************************************




function New_Folder_Page() { //*************************************************
	global $_, $FORM_COMMON, $INVALID_CHARS;
?>
	<h2><?php echo hsc($_['new_folder_h2']) ?></h2>
	<?php echo $FORM_COMMON ?>
		<p><?php echo hsc($_['new_folder_txt_1']) ?>
		<?php echo hsc($_['new_folder_txt_2']) ?> <span class="mono"><?php echo htmlentities($INVALID_CHARS) ?></span></p>
		<input type="text" name="new_folder" id="new_folder" value="">
		<?php Cancel_Submit_Buttons(hsc($_['Create']),"new_folder"); ?>
	</form>
<?php 
} //end New_Folder_Page() ******************************************************




function New_Folder_response(){ //**********************************************
	global $_, $ipath, $param1, $page, $message, $EX, $INVALID_CHARS, $INVALID_CHARS_array;

	$new_name = trim($_POST["new_folder"],'/ '); //Trim spaces, and make sure only has a single trailing slash.

	$invalid = false;
	foreach ($INVALID_CHARS_array as $bad_char) {
		if (strpos($new_name, $bad_char) !== false) { $invalid = true; }
	}
	$page = "index"; //Return to index

	$new_ipath = $ipath.$new_name.'/';

	if ($invalid){
		$message .= $EX.'<b>'.hsc($_['new_folder_msg_01']).'</b> '.htmlentities($new_name).'<br>'.
			'<b>'.hsc($_['new_folder_msg_02']).
			'<span class="mono">'.htmlentities($INVALID_CHARS).'</span></b>';
	}elseif ($new_name == ""){ 
		$message .= $EX.'<b>'.hsc($_['new_folder_msg_03']).'</b>';
	}elseif (is_dir($new_ipath)) {
		$message .= $EX.'<b>'.hsc($_['new_folder_msg_04']).' ';
		$message .= htmlentities($new_ipath).'</b>';
	}elseif (mkdir($new_ipath)) {
		$message .= '<b>'.hsc($_['new_folder_msg_05']).'</b> '.htmlentities($new_name);
		$ipath    = $new_ipath;  //return to new folder
		$param1   = '?i='.URLencode_path($ipath);
	}else{
		$message .= $EX.'<b>'.hsc($_['new_folder_msg_06']).' </b><br>';
		$message .= htmlentities($new_name);
	}
}//end New_Folder_response *****************************************************




function Delete_Folder_Page(){ //***********************************************
	global $_, $WEB_ROOT, $ipath, $FORM_COMMON;
?>
	<h2><?php echo hsc($_['delete_folder_h2']) ?></h2>
	<?php echo $FORM_COMMON ?>
		<input type="hidden" name="delete_folder" value="<?php echo hsc($ipath); ?>" >
		<span class="web_root"><?php echo htmlentities($WEB_ROOT.Check_path(dirname($ipath))); ?></span><span 
		class="verify"><?php echo htmlentities(basename($ipath)); ?></span> /
		<p><b><?php echo hsc($_['delete_folder_txt_01']) ?></b></p>
		<?php Cancel_Submit_Buttons(hsc($_['DELETE']), "cancel"); ?>
	</form>
<?php 
} //end Delete_Folder_Page() //*************************************************




function Delete_Folder_response() { //******************************************
	global $ipath, $param1, $page, $message, $EX;
	$page = "index"; //Return to index
	$foldername = trim($_POST["delete_folder"], '/');

	if ( !is_empty($ipath) ) {
		$message .= $EX.'<b>'.hsc($_['delete_folder_msg_01']).'</b>';
		$page = "index";
	}elseif (@rmdir($foldername)) {
		$message .= '<b>'.hsc($_['delete_folder_msg_02']).'</b> '.htmlentities(basename($foldername));
		$ipath  = Check_path($foldername); //Return to parent dir.
		$param1 = '?i='.URLencode_path($ipath);
	}else {
		$message .= $EX.'<b>"'.htmlentities($foldername).'/"</b> '.hsc($_['delete_folder_msg_03']);
	}
}//end Delete_Folder_response() ************************************************




function Page_Title(){ //***<title>Page_Title()</title>*************************
	global $_, $page;

	if     ($page == "login")        { return hsc($_['page_title_login']);     }
	elseif ($page == "hash")         { return hsc($_['page_title_hash']);      }
	elseif ($page == "edit")         { return hsc($_['page_title_edit']);      }
	elseif ($page == "upload")       { return hsc($_['page_title_upload']);    }
	elseif ($page == "newfile")      { return hsc($_['page_title_new_file']);  }
	elseif ($page == "copy" )        { return hsc($_['page_title_copy']);      }
	elseif ($page == "rename")       { return hsc($_['page_title_ren']);       }
	elseif ($page == "delete")       { return hsc($_['page_title_del']);       }
	elseif ($page == "newfolder")    { return hsc($_['page_title_folder_new']);}
	elseif ($page == "renamefolder") { return hsc($_['page_title_folder_ren']);}
	elseif ($page == "deletefolder") { return hsc($_['page_title_folder_del']);}
	else                             { return $_SERVER['SERVER_NAME']; }
}//end Page_Title() ************************************************************




function Load_Selected_Page(){ //***********************************************
	global $_, $ONESCRIPT, $page;

	if     ($page == "login")        { Login_Page();         }
	elseif ($page == "hash")         { Hash_Page();          }
	elseif ($page == "edit")         { Edit_Page();          }
	elseif ($page == "upload")       { Upload_Page();        }
	elseif ($page == "newfile")      { New_File_Page();      }
	elseif ($page == "copy")         { Copy_Ren_Move_Page(hsc($_['Copy']),   hsc($_['File']), 'copy_file', 1); }
	elseif ($page == "rename")       { Copy_Ren_Move_Page(hsc($_['Rename']), hsc($_['File']), 'rename_file', 1); }
	elseif ($page == "delete")       { Delete_File_Page();   }
	elseif ($page == "newfolder")    { New_Folder_Page();    }
	elseif ($page == "renamefolder") { Copy_Ren_Move_Page(hsc($_['Rename']), hsc($_['Folder']), 'rename_folder', 0); }
	elseif ($page == "deletefolder") { Delete_Folder_Page(); }
	else                             { Index_Page();         } //default
}//end Load_Selected_Page() ****************************************************




function Timer_scripts() { //***************************************************
	global $_;
?>
<script>
//pad() is also used by the Time_Stamp_scripts()
function pad(num){ if ( num < 10 ){ num = "0" + num; }; return num; }


function FormatTime(Seconds) {
	var Hours = Math.floor(Seconds / 3600); Seconds = Seconds % 3600;
	var Minutes = Math.floor(Seconds / 60); Seconds = Seconds % 60;
	if ((Hours == 0) && (Minutes == 0)) { Minutes = "" } else { Minutes = pad(Minutes) }
	if (Hours == 0) { Hours = ""} else { Hours = pad(Hours) + ":"}

	return (Hours + Minutes + ":" + pad(Seconds));
}


function Countdown(count, End_Time, Timer_ID, Timer_CLASS, Action){
	var Timer        = document.getElementById(Timer_ID);
	var Current_Time = Math.round(new Date().getTime()/1000); //js uses milliseconds
	    count        = End_Time - Current_Time;
	var params = count + ', "' + End_Time + '", "' + Timer_ID + '", "' + Timer_CLASS + '", "' + Action + '"';

	Timer.innerHTML = FormatTime(count);

	if ( (count < 120) && (Action != "") ) { //Two minute warning...
		Timer.style.backgroundColor = "white";
		Timer.style.color = "red";
		Timer.style.fontWeight = "900";
	}

	if ( count < 1 ) {
		if ( Action == 'LOGOUT') { 
			Timer.innerHTML = '<?php echo addslashes($_['session_expired']) ?>';
			//Load login screen, but delay first to make sure really expired:
			setTimeout('window.location = window.location.pathname',3000); //1000 = 1 second
		}
		return;
	}
	setTimeout('Countdown(' + params + ')',1000);
}


function Start_Countdown(count, ID, CLASS, Action){
	document.write('<span id="' + ID + '"  class="' + CLASS + '"></span>');

	var Time_Start  = Math.round(new Date().getTime()/1000);
	var Time_End    = Time_Start + count;

	Countdown(count, Time_End, ID, CLASS, Action); //(seconds to count, id of element)
}
</script>
<?php 
}//end Timer_scripts() *********************************************************




function Time_Stamp_scripts() { //**********************************************
?>
<script>//Dispaly file's timestamp in user's local time 

function FileTimeStamp(php_filemtime, show_date, show_offset){

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

	var GMT_offset = -(TIMESTAMP.getTimezoneOffset()); //Yes, I know - seems wrong, but it's works.

	if (GMT_offset < 0) { NEG=-1; SIGN="-"; } else { NEG=1; SIGN="+"; } 

	var offset_HOURS = Math.floor(NEG*GMT_offset/60);
	var offset_MINS  = pad( NEG * GMT_offset % 60 );
	var offset_FULL  = "UTC " + SIGN + offset_HOURS + ":" + offset_MINS;

	FULLDATE = YEAR + "-" + MONTH + "-" + DATE;
	FULLTIME = HOURS + ":" + MINS + ":" + SECS + " " + AMPM;

	var               DATETIME = FULLTIME;
	if (show_date)  { DATETIME = FULLDATE + " &nbsp;" + FULLTIME;}
	if (show_offset){ DATETIME += " ("+offset_FULL+")"; }
		
	document.write( DATETIME );

}//end FileTimeStamp(php_filemtime)
</script>
<?php 
}//end Time_Stamp_scripts() ****************************************************




function Edit_Page_scripts() { //***********************************************
	global $_;
?>
	<!--======== Provide feedback re: unsaved changes ========-->
	<script>
	// a few var's for Wide_View()
	var Main_div		 = document.getElementById('main');
	var Wide_View_button = document.getElementById('wide_view');
	var main_width_default = Main_div.style.width ;

	function Wide_View() {
		if ( File_textarea != null ) { File_textarea.style.width = '99.8%'; }
		
		if (Main_div.style.width == '95%') {
			Main_div.style.width = main_width_default;
			Wide_View_button.value = "<?php echo addslashes($_['Wide_View'])?>"; //'<?php echo $_['Wide_View'] ?>';
		}else{
			Main_div.style.width = '95%';
			Wide_View_button.value = '<?php echo addslashes($_['Normal_View']) ?>';
		}
	}

	var File_textarea    = document.getElementById('file_contents');
	var Save_File_button = document.getElementById('save_file');
	var Reset_button     = document.getElementById('reset');
	var start_value      = File_textarea.value;

	// The following events only apply when the element is active.
	// [Save] is disabled unless there are changes to the open file.
	Save_File_button.onfocus = function() {Save_File_button.style.backgroundColor = "rgb(255,250,150)";}
	Save_File_button.onblur  = function() {Save_File_button.style.backgroundColor ="#Fee";}
	Save_File_button.onmouseover = function() {Save_File_button.style.backgroundColor = "rgb(255,250,150)";}
	Save_File_button.onmouseout  = function() {Save_File_button.style.backgroundColor = "#Fee";}


	var submitted   = false;
	var changed     = false;

	function Reset_file_status_indicators() {
		changed = false;
		File_textarea.style.backgroundColor = "#F6FFF6";  //light green
		Save_File_button.style.backgroundColor = "";
		Save_File_button.style.borderColor = "";
		Save_File_button.style.borderWidth = "1px";
		Save_File_button.disabled = "disabled";
		Save_File_button.value = "Save";
		Reset_button.disabled = "disabled";
	}


	window.onbeforeunload = function() {
		if ( changed && !submitted) { 
			//FF4+ Ingores the supplied msg below & only uses a system msg for the prompt.
			return "<?php echo addslashes($_['unload_unsaved']) ?>";
		}
	}


	window.onunload = function() {
		//without this, a browser back then forward would reload file with local/
		// unsaved changes, but with a green b/g as tho that's the file's contents.
		if (!submitted) {
			File_textarea.value = start_value;
			Reset_file_status_indicators();
		}
	}


	//With selStart & selEnd == 0, moves cursor to start of text field.
	function setSelRange(inputEl, selStart, selEnd) { 
		if (inputEl.setSelectionRange) { 
			inputEl.focus(); 
			inputEl.setSelectionRange(selStart, selEnd); 
		} else if (inputEl.createTextRange) { 
			var range = inputEl.createTextRange(); 
			range.collapse(true); 
			range.moveEnd('character', selEnd); 
			range.moveStart('character', selStart); 
			range.select(); 
		} 
	}


	function Check_for_changes(event){
		var keycode=event.keyCode? event.keyCode : event.charCode;
		changed = (File_textarea.value != start_value);
		if (changed){
			document.getElementById('message').innerHTML = " "; // Must have a space, or it won't clear the msg.
			File_textarea.style.backgroundColor = "#Fee";  //light red
			Save_File_button.style.backgroundColor ="#Fee";
			Save_File_button.style.borderColor = "#F44";   //less light red
			Save_File_button.style.borderWidth = "1px";
			Save_File_button.disabled = "";
			Reset_button.disabled = "";
			Save_File_button.value = "SAVE CHANGES!";
		}else{
			Reset_file_status_indicators()
		}
	}


	//Reset textarea value to when page was loaded.
	//Used by [Reset] button, and when page unloads (browser back, etc). 
	//Needed becuase if the page is reloaded (ctl-r, or browser back/forward, etc.), 
	//the text stays changed, but "changed" gets set to false, which looses warning.
	function Reset_File() {
		if (changed) {
			if ( !(confirm("<?php echo addslashes($_['confirm_reset']) ?>")) ) { return; }
		}
		File_textarea.value = start_value;
		Reset_file_status_indicators();
		setSelRange(File_textarea, 0, 0) //Move cursor to start of textarea.
	}

	Reset_file_status_indicators();
	</script>
<?php 
}//End Edit_Page_scripts() *****************************************************




function style_sheet(){ //****************************************************?>
<style>
/* --- reset --- */
* { border : 0; outline: 0; margin: 0; padding: 0;
    font-family: inherit; font-weight: inherit; font-style : inherit;
    font-size  : 100%; vertical-align: baseline; }


/* --- general formatting --- */

body { font-size: 1em; background: #DDD; font-family: sans-serif; }

p, table { margin-bottom: .6em;}

div { position: relative; }

h1,h2,h3,h4,h5,h6 { font-weight: bold; }
h2, h3 { font-size: 1.2em; margin: .5em 1em .5em 0; } /*TRBL*/

i, em     { font-style : italic; }
b, strong { font-weight: bold;   }

:focus { outline:0; }

table { border-collapse:separate; border-spacing:0; }
th,td { text-align:left; font-weight:400; }

a       { border: 1px solid transparent; color: rgb(100,45,0); text-decoration: none; }
a:hover { border: 1px solid #807568; background-color: rgb(255,250,150); }
a:focus { border: 1px solid #807568; background-color: rgb(255,250,150); }

form p { margin-bottom: .3em; }

label { display: inline-block; width : 6em; font-size : 1em; font-weight: bold; }

svg { margin: 0; padding: 0; }

pre { /*Used around test output when trouble shooting*/
	background: white;
	border: 1px solid #807568;
	padding: .5em;
	margin: 0;
	}


/* --- layout --- */

.container {
	border : 0px solid #807568;
	width  : 810px;
	margin : 0 auto 2em auto;
	}


.header {
	border-bottom : 1px solid #807568;
	padding: 04px 0px 01px 0px;
	margin : 0 0 .5em 0;
	}


#logo {
	font-family: 'Trebuchet MS', sans-serif;
	font-size:2em;
	font-weight: bold;
	color: black;
	padding: .1em;
	}

.filename {
	border: 1px solid #807568;
	padding: .1em .2em .1em .2em;
	font-weight: 700;
	font-family: courier;
	background-color: #EEE;
	}

#message { margin-bottom: .5em;}

#message p {
	margin: 0;
	padding: 4px 0px 4px .5em;
	border: 1px solid #807568;
	Xfont-family: courier;
	font-size: 1em;
	line-height: 1.2em;
	background: #fff000;
	}

#message #Xbox { float: right; }

#message #dismiss { padding: 5px 4px 5px 4px; border-right: none; } /*TRBL*/ /*font-family: Courier; font-size: 1.2em;*/


/* --- INDEX directory listing, table format --- */
table.index_T {
	min-width: 30em;
	font-size: .95em;
	border-style: outset;
	border-width: 1px;
	border-color: #807568;
	border-collapse: collapse;
	margin-bottom: .7em;
	background-color: #FdFdFd;
	}
	
table.index_T  tr:hover { border: 1px solid #807568; }

table.index_T td { 
	border-width  : 1px;
	border-color  : silver;
	border-style  : inset;
	vertical-align: middle;
	}

.index_T a { 
	height : 1em;
	display: block;
	padding: .2em 1em .3em .3em;
	color  : rgb(100,45,0);
	border : none;
	overflow   : hidden;
	}

.index_T a:hover { background-color: rgb(255,250,150); }
.index_T a:focus { background-color: rgb(255,250,150); }



/* File size & date */

.meta_size { min-width:  6em; }

.meta_time { min-width: 15em; }

.meta_T {
	padding-right : .5em;
	text-align    : right;
	font-family   : courier;
    font-size     : .9em;
	color         : #333;
	}


.index_folders { min-height: 1.7em;  margin-bottom: .2em; }

.index_folders a {
	Xborder       : 1px solid #807568;
	display      : inline-block;
	line-height  : 1em;
	font-size    : 1em;
	margin-right : .6em;
	margin-bottom: .1em;
	padding      : 3px .4em 3px 5px; /*TRBL*/
	}

.index_folders a:hover { background-color: rgb(255,250,150); }
.index_folders a:focus { background-color: rgb(255,250,150); }



/*  [Upload File] [New File] [New Folder] etc... */

.front_links a {
	display: inline-block;
	border : 1px solid #807568;
	height      : 1em;
	font-size   : 1em;
	margin-right: 1em;
	padding     : 3px 5px 5px 4px; /*TRBL*/
	background-color: #EEE;
	}

.front_links a .icon_fldr {margin : 1.5px 5px 0 0; }
.front_links a .icon_file {margin : 1.0px 5px 0 0; }

.front_links a:hover  { background-color: rgb(255,250,150); }
.front_links a:focus  { background-color: rgb(255,250,150); }

input { margin-bottom: .6em; }

input[type="text"] {
	border: 1px solid #807568;
	margin-bottom: .6em;
	padding: 2px;
	width: 50em;
	font: 1em "Courier New", Courier, monospace;
	}


input:focus { background-color: rgb(255,250,150); }

input:hover { background-color: rgb(255,250,150); }

input[readonly]       { color: #333; background-color: #EEE; }
input[disabled]       { color: #555; background-color: #EEE; }
input[disabled]:hover { background-color: rgb(236,233,216);  } 
input[disabled]:hover { background-color: rgb(236,233,216);  } 


.buttons_right         { float: right; }
.buttons_right .button { margin-left: .5em; }

.button {
	border : 1px solid #807568;
	padding: 4px 10px;
	cursor : pointer;
	color      : black;
	font-size  : .9em;
	font-family: sans-serif;
	background-color: #EEE;  /*#d4d4d4*/
	}

.button[disabled]  { color: #777; background-color: #EEE; }


/* --- header --- */

.nav {
	float     : right;
	display   : inline-block;
	margin-top: 1.35em;
	font-size : 1em;
	}

.nav a {
	border: 1px solid transparent;
	font-weight : bold;
	padding     : .0em;
	padding-top   : .2em;
	padding-left  : .6em;
	padding-right : .6em;
	padding-bottom: .1em;
	}

.nav a:hover { border: 1px solid #807568; }
.nav a:focus { border: 1px solid #807568; }


/* --- edit --- */

#edit_header  {margin: 0;}

#edit_form    {margin: 0;}

.edit_disabled { 
	border : 1px solid #807568;
	width  : 99%;
	padding: .2em;
	margin : .5em 0 0 0;
	background-color: #FFF000; color: #333;
	line-height: 1.4em;
	}

.view_file { font: .9em Courier; background-color: #F8F8F8; }

#file_contents {
	border: 1px solid #999;
	font  : .9em Courier;
	margin: 0 0 .6em 0;
	width : 99.8%;
	height: 32em;
}

#file_contents:focus { border: 1px solid #Fdd; }

.file_meta	  {float: left;  margin-top: .5em; font-size: 1em; color: #333; } /*font-family: courier;*/

#edit_notes   {font-size: .8em; color: #333 ;margin-top: 1em; clear:both;}

.notes {margin-bottom: .4em;}


/* --- log in --- */

.login_page {
	margin  : 5em auto;
	border  : 1px solid #807568;
	padding : .5em 1em .2em 1em;
	width   : 370px;
	}

.login_page .nav { margin-top: .5em; }

.login_input {
	border  : 1px solid #807568;
	padding : 2px 0px 2px 2px;
	width   : 366px;
	font    : 1em courier;
	}

.login_page input[type="text"]{ width   : 364px; }



#upload_file {
	border: 1px solid #807568;
	margin-bottom: .6em;
	padding: 2px;
	width: 50em;
	}


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
	border-top   : 1px solid #807568;
	Xborder-bottom: 1px solid #eee;
	overflow: visible;
	}

.verify {
	border: 1px solid #F44;
	color: #333;
	background-color: #FFE7E7;
	padding: .1em .2em;
	font: 1.2em Courier;
	}

#admin {padding: .3em;}

.web_root { font:1em Courier; }

.icon {float: left; margin: 0 .3em 0 0;}

.mono {font-family: courier;}

.info {margin-top: .7em; background: #f9f9f9; padding: .2em .5em;}

.path {padding: 1px 5px 1px 5px} /*TRBL*/

.edit_onefile {padding: 5px; float: right;}

.timer {border: 1px solid gray; padding: 3px .5em 4px .5em;}

.timeout {float:right; font-size: .95em; color: #333; }

.edit_btns_top    { margin: .2em 0 .5em 0;}

.edit_btns_bottom { float: right; }
.edit_btns_bottom .button { margin-left: .5em; }
</style>
<?php 
}//end style_sheet() ***********************************************************




//******************************************************************************
//******************************************************************************
//Begin logic to determine page action


if( PHP_VERSION_ID < 50000 ) { exit("OneFileCMS requires PHP5 to operate. Tested on versions 5.2.17, 5.3.3 & 5.4"); }


// Load language settings
if ( is_file($LANGUAGE) ) { $_ = parse_ini_file($LANGUAGE); }
else                      { $_ = parse_ini_string(Default_Language()); }

// Output HTML inside iframe, without regenerating the session-id.
if ($_GET['p'] == 'iframe_edit') {
	Get_GET();  
	Output_HTML();
}

Session_Startup(); 

if ($_SESSION['valid']) {

	Get_GET();  

	Init_Macros();

	if ($VALID_POST) { //*******************************************************
		if     (isset($_FILES['upload_file']['name'])) { Upload_response(); }
		elseif (isset($_POST["whattohash"]   )) { Hash_response();          }
		elseif (isset($_POST["filename"]     )) { Edit_response();          }
		elseif (isset($_POST["new_file"]     )) { New_File_response();      }
		elseif (isset($_POST["copy_file"]    )) { Copy_Ren_Move_response($_POST[ "old_name"], $_POST["copy_file"], 'copy', hsc($_['Copy']), hsc($_['Copied']), 1); } 
		elseif (isset($_POST["rename_file"]  )) { Copy_Ren_Move_response($_POST[ "old_name"], $_POST["rename_file"],   'rename', hsc($_['Ren_Move']), hsc($_['Ren_Moved']), 1); } 
		elseif (isset($_POST["delete_file"]  )) { Delete_File_response();   }
		elseif (isset($_POST["new_folder"]   )) { New_Folder_response();    }
		elseif (isset($_POST["rename_folder"])) { Copy_Ren_Move_response($_POST[ "old_name"], $_POST["rename_folder"], 'rename', hsc($_['Ren_Move']), hsc($_['Ren_Moved']), 0); } 
		elseif (isset($_POST["delete_folder"])) { Delete_Folder_response(); }
	}//end if ($VALID_POST) ****************************************************


	//*** Verify valid $page and/or $filename **********************************

		//Don't load login screen if already in a valid session.
	if     ( $_SESSION['valid'] && ($page == "login") )  { $page = "index"; }

		//Don't load edit page if $filename doesn't exist.
	elseif ( ($page == "edit")  && !is_file($filename) ) { $page = "index"; }

	elseif ($page == "logout") {
		Logout();
		$message .= hsc($_['logout_msg']); }

		//Don't load delete page if folder not empty.
	elseif ( ($page == "deletefolder") && !is_empty($ipath) ) {
		$message .= $EX.'<b>'.hsc($_['folder_del_msg']).'</b>';
		$page = "index";}

		//if size of $_POST > post_max_size, PHP only returns empty $_POST & $_FILE arrays.
	elseif ($page == "uploaded" && !$VALID_POST){
		$message .= $EX.'<b>'.hsc($_['upload_error_01a']).ini_get('post_max_size').'</b> '.hsc($_['upload_error_01b']).'';
		$page = "index";}

	elseif ( ($page == "edit") && ($filename == trim(rawurldecode($ONESCRIPT), '/')) ) { 
		if ( $message == "" ) { $BR = ""; } else { $BR = '<br>';}
		$message .= '<style>#message p {background: red; color: white;}</style>';
		$message .= $EX.'<b>'.hsc($_['edit_caution_01']).' '.$EX.hsc($_['edit_caution_02']).'</b>';
	}
	//**************************************************************************
}//end if $_SESSION[valid] *****************************************************




//******************************************************************************
//******************************************************************************
?><!DOCTYPE html>

<html>
<head>

<title><?php echo $config_title.' - '.Page_Title() ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="robots" content="noindex">

<?php style_sheet(); ?>

<?php Timer_scripts() ?>

<?php if ( ($page == "index") || ($page == "edit") ) { Time_Stamp_scripts(); } ?>

</head>
<body>

<?php if ($page == "login"){ echo '<div id="main" class="login_page">'; }
      else                 { echo '<div id="main" class="container" >'; }
?>

<div class="header">
	<a href="<?php echo $ONESCRIPT.'" id="logo">'.$config_title; ?></a>
	<?php echo $version.' ('.hsc($_['on_']).'&nbsp;php&nbsp'.phpversion().')'; ?>

	<div class="nav">
		<a href="/" target="_blank"><?php show_favicon() ?>&nbsp;
		<b><?php echo htmlentities($WEBSITE) ?></b></a>
		<?php if ($page != "login") { ?>
		| <a href="<?php echo $ONESCRIPT ?>?p=logout"><?php echo hsc($_['Log_Out']) ?></a>
		<?php } ?>
	</div><div style="clear:both"></div>
</div><!-- end header -->

<?php if ( $page != "login"  &&  $page != "hash" ) { Current_Path_Header(); } ?>

<?php message_box() ?>

<?php Load_Selected_Page() ?>

<?php
//Countdown timer...
if ( $page != "login" ) { 
	echo '<hr>';
	echo Timeout_Timer($MAX_IDLE_TIME, 'timer0', 'timer timeout', 'LOGOUT');
	echo '<span class="timeout">'.hsc($_['time_out_txt']).' </span>';
}

//Admin link
if ( ($page != "login") && ($page != "hash") ){
	echo '<a id="admin" href="'.$ONESCRIPT.$param1.$param2.'&amp;p=hash">'.hsc($_['Admin']).'</a>';
}
?>

</div><!-- end container/login_page -->
</body>
</html>
