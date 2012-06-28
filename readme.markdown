### June 25, 2012

### Unable to upload current version to the download page.

- If you are interested in obtaining the current version - 3.2.0, just get it from the list of project files.  For some reason, whenever I try to upload it to the download page, I get the error:  
  "Something went wrong that shouldn't have. Please try again or contact support if the problem persists."  
  
  
Most of the recent changes have been to increase login and session security. However, I'm slowly learning that there's only so much that can be done, particulary when the base connection is un-encrypted.   Online security, it seems, is a nebulous subject of a rather dubious nature.  Never-the-less, I have tried to do those things that can be done.  

So, for those that care, here is a synopsis of the measures that have been employed:
- A password's hash can now be stored by OneFileCMS, instead of the plain text password.  
  (The plain text method remains an option for those that just don't care. )
- A Login delay is triggered after too many invalid attempts.
- Adjustable max idle time before auto-logout.
- Check consistancy of user agent during session.
- Generation of a new session id after login or logout.
- Set session.use_only_cookies == true.
- Use httponly cookies
- Ability to modify the default salt and password hash method.  
  (Since OneFileCMS is open source, this is recommended)
    
Now, keep in mind that while, individually, any one of these measures may not provide much security, collectivly, they're a little better than nothing.  
  
Lastly, always remember that some of the most important security measures concern user behavior - such as avoiding the use of un-encrypted wifi connections...
  
# Current stable version: 3.2.0

- 3.0+ : "Full" version - uses svg icons
- 2.0+ : "Lite" version - uses no icons.

--------------------------------------------------------------------------------

# OneFileCMS

## Yes, that's exactly what it is!

Main screen:
![OneFileCMS](http://self-evident.github.com/OneFileCMS/images/OneFileCMS_screenshot.png)

Edit screen:
![OneFileCMS](http://self-evident.github.com/OneFileCMS/images/OneFileCMS_screenshot_edit.png)


OneFileCMS is just that. It's a flat, light, one file CMS (Content Management System) entirely contained in an easy-to-implement, highly customizable, database-less PHP script.

Coupling a utilitarian code editor with basic file managing functions, OneFileCMS can maintain a whole website completely in-browser without any external programs.

## Demo

- Just download & try the current stable version - it's one file!

## Features
 
- All the basic features of an FTP application like renaming, deleting, copying, and uploading
  _(Of course, for more complex processes like batch renaming or mass uploads/deletions, you're going to want to break out an actual FTP program.)_
- Alert if you try to leave without saving your edits
- Easily modifiable & re-brandable.
- Possibly the easiest installation process ever!

## Installation

1) Download [this file](https://raw.github.com/Self-Evident/OneFileCMS/master/onefilecms.php).

2) Set your username and password - edit them to something less obvious.

    // CONFIGURATION INFO
    $USERNAME = "username";
    $PASSWORD = "password";

3) Upload to anywhere on your site!

Depending on how your web stack is set up, you may also have to modify the file permissions of your site's folders to allow OneFileCMS to modify and create files. ([More about that here.](http://catcode.com/teachmod/)) Make sure onefilecms.php and its parent folder are allowed to execute, with CHMOD at 755. Check with your host if you're not sure, and be aware of any inherent security concerns.

You can also change the file name of OneFileCMS.php to something else, such as "Admin.php" . _(Be careful making it a folder's default file: your server may get stuck in redirects.)_

## FAQ

### Where's the WYSIWYG? What about syntax highlighting?

WYSWIWYG editors have been requested, but probably won’t become standard, as they’d probably make it more than one file, sort of defeating the "OneFile" point. Plus, if you’re working in PHP or non-HTML code, they're can be more of a hindrance than an asset.

However, just because I don't want to do it, doesn't mean it's impossible.  Look for the Edit_Page_form() function. Its textarea can be modified to work with whatever editor you like. 

### I found something that could be better. Can I suggest it to you?

Yes, of course!

I may not have the time/bandwidth/inclination to implement every feature, but I'll do what I can. If it's urgent, contact me.  

Otherwise, try [forking the file and submitting your changes to me](https://github.com/blog/844-forking-with-the-edit-button).

### This is basically just a file manager with a text editor. Why is it being called a Content Management System?

Well, because "OneFileFileManagerTextEditor" just doesn't have the same ring to it...

### Multi-Language Support?

Probably not, as that would also most likely make it more than "OneFile".

### Can I have more than one username/password?

Well, indirectly - yes: Upload or create addional copies of OneFileCMS, but give them different file names.(ie: OneFile1.php and OneFile2.php etc...)  Then, with each copy, maintain different user names and passwords.  Also, so one user does not log out the other, change the session names set in session_startup().  
  
Now, since there is no data base or other means of granular control and acess logging, multiple users may be kind of pointless.  On the other hand, having at least one working backup copy of OneFileCMS available is recommended in case the primary copy get's corrupted.

## Requirements

- PHP 5.2+
  (Only tested on versions 5.2.17, 5.3.3, 5.4, and 5.4.3)
- File permission privileges on your host
- Javascript enabled browswer
- And, for OneFileCMS 3+, a browser that supports inline SVG.

## Credit, License, Et Cetera

Original concept and development by github.com/rocktronica

Written in PHP, JavaScript, HTML, CSS, and SVG.

Available under the MIT and BSD licenses.

Icons for versions thru 1.1.6 by [famfamfam](http://www.famfamfam.com/).

To report a bug or request a feature, please file an issue via Github. Forks encouraged!

##Needed/potential/upcoming improvements

- With Chrome, and possibly Safari, issue with Edit page: Clicking browser [back] & then browser [forward],  with file changed and not saved. On return (after [forward] clicked), file still has changes, but indicators are green (saved/unchanged). Does not affect FF 7+ or IE 8+.
- Issue with Chrome's XSS filter: Editing some legitimate files with OneFileCMS will trigger the filter and disable most javascript provided functionallity, but only while on edit page of such a file.
- Connection is not encrypted (doesn't use SSL), so passwords & usernames are sent in clear text during login.  
  (However, this is true of most online login systems, unless SSL or the like is employed.)
- Be aware that only some very basic data & error checking is performed.  (But, it's getting better...)  
  On Windows, for instance, it's possible to create folders that are subsequently inaccessible and undeletable by Windows.  (Yea, I found out the hard way...)
- Multiple login names.
- Multiple languages support
- External configuration file, so one doesn't need to edit the php-file
- Internal documentation with Doxygen
- Anything else?

--------------------------------------------------------------------------------

### General layout/structure of OneFileCMS.php
  
CONFIGURATION SECTION  
  
SOME STANDARD GLOBAL VARIABLES  
  
SESSION & MISC FUNCTIONS  
  
SVG ICON FUNCTIONS  
  
PAGE & RESPONSE FUNCTIONS  
    Index, Upload, New, Copy, Rename, etc...  
  
JAVASCRIPT & STYLESHEET FUNCTIONS  
  
LOGIC TO DETERMINE PAGE ACTION  
    Call Session\_Startup()  
    Call Get\_GET()  
    Call Init\_Macros()  
    If $VALID\_POST, do $\_POST['someaction']  
    Validate which $page to show  
  
GENERATE THE PAGE  
    &lt;HTML&gt;  
    ...  
    Load\_Selected\_Page($page)  
    ...  
    &lt;/HTML&gt;  

--------------------------------------------------------------------------------

## Change Log

### 3.2.1

- Added the possibility to filter listed files. Now it is possible to -- for instance -- display HTML- and HTM-files only.

### 3.2.0

- Added a few security improvements.
- Added "timeout" timer as a warning to save edits before they're lost.


### 3.1.9

- Password may now be stored as an encrypted hash, instead of in plain text.
- Added an "Admin" page to generate password hashes.
- A bunch of other code tweakin' & improvements.

### 3.1.6 thru 3.1.8

- Converted bulk of rest of code into functions (easier to work with)
- Resolved issue (I hope) with differing versions of PHP and how magic_quotes & stripslashes are handeled.

### 3.1.2 thru 3.1.5

- Added file size limits to the Edit/View page. (Some browsers don't like large files in an HTML textarea.
- Added some data validation to _GET parameters
- Some misc code cleanup & organization etc.
- And other misc stuff...

### 3.1.1

- Fixed minor issue with data encoding of file to exit in <textarea>

### 3.1

- (Very) moderate data validation improvements.
- Reorganized & funcionalized() most of the code.

### 3.0

- Implemented svg icons

### 2.0

- OneFileCMS is now actually ONE FILE! No external style sheets or icons.
  __(Of course, external style sheets & icons can be added back in, if you like.)__

- This is OneFileCMS "Lite", and will be maintained along with v3.0

### 1.5 

- Style sheet is now part of onfilecms.php file, but still uses external icons.
- Some minor logic improvements on Edit & Index pages.

### 1.4.0

- Substantial code reorganization & updates.


### 1.2.4 - 1.3.0

- DO NOT USE THESE VERSIONS!
- Mostly just a bunch of code modifications.
- These versions have issues, primarily when on the home/root page your site. 

### 1.2.3

- Fixed check for local css. If not found, loads hosted copy. 
  (This will soon be a moot point...)

### 1.2.2

- On "Edit" page, images are now displayed directly, instead of a disabled textarea.
- Logout page replaced with standard "alert" message on login screen.

### 1.2.1

- Fixed security hole that affected versions 1.1.7 - 1.2.0.

### 1.2.0

- List of files now sorted alphabetically, without regard to case.
- Further improved Edit page & screen feedback of file state (changed/unchanged).
- Added [X] dismiss button on message box
- File date shown on Index & Edit pages is now in user's local time.
- Moved from xhtml to html syntax & doctype.

### 1.1.9

- Improved Edit page & screen feedback of file state (changed/unchanged).
- Removed use of jquery in move towards a true "OneFileCMS".

### 1.1.8  

- Added a table list view option (default).  Either List or original "Block" view selectable with $VIEW_MODE variable. (On screen selection in the works)
- (And, of course, numerous other code tweaks/improvements.

### 1.1.7

- Added [Cancel] button to most screens. Numerous minor UI & code tweaks/improvements.  Changed where .css is hosted (may change back later).  Removed "Rendered in (microseconds)...".  Added license info & copyright notice.

### 1.1.6

- Breadcrumb navigation (courtesy of [Self-Evident](https://github.com/Self-Evident/)), CSS file and some minor changes to it<br />
  Installation is still as usual, but, now, if you have _onefilecms.css_ in the same folder as _onefilecms.php_, it'll be linked instead of the normal [http://onefilecms.com/style.css](http://onefilecms.com/style.css).

### 1.1.5

- Fixed a disallowed redirect vulnerability<br />Many thanks to Abhi M Balakrishnan from [OWASP Mantra Team](http://www.getmantra.com/) for his help

### 1.1.4

- JavaScript cleanup and jQuery upgrade
- Visit Site = /
- Now on GitHub!

### 1.1.3 (1/10/2012)

- Fixed a upload bug leftover from 1.1.2's CSRF protection

### 1.1.2 (9/21/11)

- More CSRF protection for logged-in users

### 1.1.1 (1/9/10)

- CSRF protection (thanks Steve and Rene)
- Support for storing password as an MD5 hash (thanks, durilka!)

### 1.1.0 (10/18/09)

- config_footer variable for branding or analytics code
- config_disabled variable to disallow editing of files like images, zips, icons, etc
- config_excluded variable to exclude specific files (or filetypes) from being shown in the index
- Shows hidden files (files that start with a "." like ".htaccess") on index listing
- "noindex" meta tag so Google doesn't crawl your backend
- Fixed a couple minor CSS and link bugs in the example site.
- Updated license page to clarify commercial license usage per domain and upgrade.

### 1.0.1 (9/24/09)

- Relative CSS links and navigation in example site to work better with the demo (No change to OneFileCMS itself)

### 1.0 (9/5/09)

- Launch!
 
