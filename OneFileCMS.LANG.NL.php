<?php
// OneFileCMS Language Settings v3.4.11

$_['LANGUAGE'] = 'Dutch (Nederlands)'; //NL
$_['LANG'] = 'NL';

// If no translation or value is desired for a particular setting, do not delete
// the actual setting variable, just set it to an empty string.
// For example:  $_['some_unused_setting'] = '';
//
// Remember to slash-escape any single quotes that may be within the text:  \'
// The back-slash itself may or may not also need to be escaped:  \\
//
// If present as a trailing comment, "## NT ##" means 'Need Translation'.
//
// In some instances, some langauges may use significantly longer words or phrases than others.
// So, a smaller font or less spacing may be desirable in those places to preserve page layout.
//
$_['front_links_font_size']  = '1.0em';  //Buttons on Index page.
$_['front_links_margin_L']   = '1.0em';
$_['button_font_size']       = '0.9em';  //Buttons on Edit page.
$_['button_margin_L']        = '0.7em';
$_['button_padding']         = '4px 10px';
$_['image_info_font_size']   = '1em';    //show_img_msg_01  &  _02
$_['image_info_pos']         = '';       //If 1 or true, moves the info down a line for more space.
$_['select_all_label_size']  = '.84em';  //Font size of $_['Select_All']
$_['select_all_label_width'] = '76px';   //Width of space for $_['Select_All']

$_['Admin']   = 'Beheer';
$_['Cancel']  = 'Annuleren';
$_['Close']   = 'Sluiten';
$_['Copy']    = 'Kopiëren';
$_['Copied']  = 'Gekopiëerd';
$_['Create']  = 'Aanmaken';
$_['Delete']  = 'Verwijderen';
$_['DELETE']  = 'VERWIJDER';
$_['Deleted'] = 'Verwijderd';
$_['Edit']    = 'Bewerken';
$_['Enter']   = 'Enter';
$_['Error']   = 'Fout';
$_['errors']  = 'fouten';
$_['File']    = 'Bestand';
$_['Folder']  = 'Map';
$_['From']    = 'Van';
$_['Hash']    = 'Hash';
$_['Move']    = 'Verplaats';
$_['Moved']   = 'Verplaatst';
$_['on']      = 'on';
$_['bytes']   = 'bytes';   //####

$_['Password']   = 'Wachtwoord';
$_['Rename']     = 'Hernoemen';
$_['successful'] = 'succesvol';
$_['To']         = 'Aan';
$_['Upload']     = 'Upload';
$_['Username']   = 'Gebruikersnaam';
$_['Log_In']     = 'Inloggen';
$_['Log_Out']    = 'Uitloggen';

$_['Admin_Options']  = 'Opties voor beheer';
$_['Are_you_sure']   = 'Weet u het zeker?';
$_['Edit_View']      = 'Bewerken / weergeven';
$_['Upload_File']    = 'Bestand Uploaden';
$_['New_File']       = 'Nieuw Bestand';
$_['Ren_Move']       = 'Hernoemen / Verplaatsen';
$_['Ren_Moved']      = 'Hernoemend / Verplaatst';
$_['New_Folder']     = 'Nieuwe Map';
$_['Ren_Folder']     = 'Hernoem / Verplaats Map';
$_['Submit']         = 'Verzoek Indienen';
$_['Move_Files']     = 'Verplaats Bestand(en)';
$_['Copy_Files']     = 'Kopieër Bestand(en)';
$_['Del_Files']      = 'Verwijder Bestand(en)';
$_['Selected_Files'] = 'Geselecteerde Mappen en Bestanden';
$_['Select_All']     = 'Selecteer Alles';
$_['Clear_All']      = 'Verwijder Alles';
$_['New_Location']   = 'Nieuwe Locatie';
$_['No_files']       = 'Geen bestanden geselecteerd.';
$_['Not_found']      = 'Niet gevonden';
$_['pass_to_hash']   = 'Wachtwoord verwarren:';
$_['Generate_Hash']  = 'Genereer Verward Wachtwoord (Hash)';

$_['save_1']      = 'Opslaan';
$_['save_2']      = 'WIJZIGINGEN OPSLAAN!';
$_['reset']       = 'Reset - wijzingen ongedaan maken';
$_['Wide_View']   = 'Wijd Gezichtsveld';
$_['Normal_View'] = 'Normaal Gezichtsveld';
$_['Open_View']   = 'Openen/Bekijken in browser venster';

$_['verify_msg_01']     = 'Sessie verlopen.';
$_['verify_msg_02']     = 'ONGELDIGE POST';
$_['get_get_msg_01']    = 'Bestand bestaat niet:';
$_['get_get_msg_02']    = 'Ongeldig verzoek voor pagina:';
$_['check_path_msg_02'] = '"puntje" of "puntje puntje" pad segmenten zijn niet toegestaan.';
$_['check_path_msg_03'] = 'Pad of bestandsnaam bevat een ongeldig teken:';
$_['ord_msg_01']        = 'Een bestand met die naam bestaat reeds in de doelmap.';
$_['ord_msg_02']        = 'Opslaan als';
$_['rCopy_msg_01']      = 'Een map kan niet naar de eigen submap gekopiëerd worden.';
$_['show_img_msg_01']   = 'Afbeelding weergegeven bij ~';
$_['show_img_msg_02']   = '% van volledige grootte (W x H =';

$_['hash_txt_01'] = 'De hashes gegenereerd door deze pagina kunnen gebruikt worden om handmatig het $HASHWORD in OneFileCMS, of in een extern configuratiebestand, bijgewerkt te worden. Hoe dan ook: draag er zorg voor dat u het wachtwoord gebruikt om de hash te genereren onthoudt!';
$_['hash_txt_06'] = 'Typ uw gewenste wachtwoord in het invoerveld hierboven en druk op Enter.';
$_['hash_txt_07'] = 'De hash wordt weergegeven in een geel berichtenvenster erboven.';
$_['hash_txt_08'] = 'Kopiëer en plak de nieuwe hash waarde naar de $HASHWORD variabele in de configuratie sectie.';
$_['hash_txt_09'] = 'Zorg ervoor dat u alles, en alleen, de hash correct (geen voor- naloop spaties enz.) kopiëert!';
$_['hash_txt_10'] = 'Een dubbele klik op de linker muisknop zou het moeten selecteren...';
$_['hash_txt_12'] = 'Wanneer gereed: log opnieuw in en uit.';

$_['login_txt_01']  = 'Gebruikersnaam:';
$_['login_txt_02']  = 'Wachtwoord:';
$_['login_msg_01a'] = 'Er zijn diverse';
$_['login_msg_01b'] = 'ongeldige inlog pogingen.';
$_['login_msg_02a'] = 'Aub wachten';
$_['login_msg_02b'] = 'seconden tot nieuwe poging.';
$_['login_msg_03']  = 'ONJUISTE INLOG POGING #';

$_['edit_note_00']  = 'NOTITIES:';
$_['edit_note_01a'] = 'Onthoudt- uw';
$_['edit_note_01b'] = 'is';
$_['edit_note_02']  = 'Dus sla uw wijzigingen op voordat de klok afloopt of ze zullen verloren gaan!';
$_['edit_note_03']  = 'Bij sommige browers, zoals Chrome, komt het voor als u op de [Terug] knop klikt, en daarna [Voorwaarts], dat de toestand van uw instellingen incorrect zijn. Om te corrigeren, klik op de knop [Vernieuwen].';
$_['edit_note_04']  = 'Chrome may disable some javascript in a page if the page even appears to contain inline javascript in certain contexts. This can affect some features of the OneFileCMS edit page when editing files that legitimately contain such code, such as OneFileCMS itself. However, such files can still be edited and saved with OneFileCMS. The primary function lost is the incidental change of background colors (red/green) indicating whether or not the file has unsaved changes. The issue will be noticed after the first save of such a file.';

$_['edit_h2_1']   = 'Weergeven:';
$_['edit_h2_2']   = 'Bewerken:';
$_['edit_txt_01'] = 'Non-tekst of onbekend bestandstype. Bewerken uitgeschakeld.';
$_['edit_txt_02'] = 'Bestand bevat mogelijk een ongeldig teken. Bewerken en weergeven uitgeschakeld.';
$_['edit_txt_03'] = 'htmlspecialchars() heeft een lege string teruggegeven van wat normaalgesproken een valide bestand is.';
$_['edit_txt_04'] = 'Dit gedrag kan per versie van PHP verschillen.';

$_['too_large_to_edit_01'] = 'Bewerken uitgeschakeld. Bestandsgrootte >';
$_['too_large_to_edit_02'] = 'Sommige browsers (bijv. Internet Explorer) lopen vast of worden onstabiel bij het bewerken van een groot bestand in een <textarea>.';
$_['too_large_to_edit_03'] = 'Bewerk $MAX_EDIT_SIZE in de configuratiesectie van OneFileCMS wanneer nodig.';
$_['too_large_to_edit_04'] = 'Een eenvoudige proef en ondervind test kan de praktische limieten van uw browser / computer aantonen.';
$_['too_large_to_view_01'] = 'Weergave uitgeschakeld. Bestandsgrootte >';
$_['too_large_to_view_02'] = 'Klik de bestandsnaam boven de weergave om te zien hoe deze normaal in een browservenster wordt weergegeven.';
$_['too_large_to_view_03'] = 'Bewerk $MAX_VIEW_SIZE in de configuratiesectie van OneFileCMS wanneer nodig.';
$_['too_large_to_view_04'] = '(De standaardwaarde voor $MAX_VIEW_SIZE is volledig willekeurig en mag, indien gewenst, naar eigen inzicht aangepast worden.)';

$_['meta_txt_01'] = 'Bestandsgrootte:';
$_['meta_txt_03'] = 'Bijgewerkt:';
$_['edit_msg_01'] = 'Bestand opgeslagen:';
$_['edit_msg_02'] = 'bytes geschreven.';
$_['edit_msg_03'] = 'Er was een fout bij het opslaan van bestand:';

$_['upload_txt_03']  = 'Maximum grootte van ieder bestand:';
$_['upload_txt_01']  = '(upload_max_filesize in php.ini)';
$_['upload_txt_04']  = 'Maximum totaal upload grootte:';
$_['upload_txt_02']  = '(post_max_size in php.ini)';

$_['upload_err_01']  = 'Fout 1: Bestand te groot. Uit php.ini:';
$_['upload_err_02']  = 'Fout 2: Bestand te groot. (Overschrijdt MAX_FILE_SIZE HTML form element)';
$_['upload_err_03']  = 'Fout 3: Het upload bestand was slechts gedeeltelijk verzonden.';
$_['upload_err_04']  = 'Fout 4: Geen bestand verzonden.';
$_['upload_err_05']  = 'Fout 5: ';
$_['upload_err_06']  = 'Fout 6: Geen tijdelijke map aanwezig.';
$_['upload_err_07']  = 'Fout 7: Schrijven van bestand naar opslagmedium mislukt.';
$_['upload_err_08']  = 'Fout 8: Een PHP extensie heeft de zending van bestanden gestopt.';

$_['upload_msg_01'] = 'Geen bestand geselecteerd om te verzenden.';
$_['upload_msg_02'] = 'Doelmap ongeldig:';
$_['upload_msg_03'] = 'Upload geannuleerd.';
$_['upload_msg_04'] = 'Uploaden:';
$_['upload_msg_05'] = 'Upload succesvol!';
$_['upload_msg_06'] = 'Upload mislukt:';

$_['new_file_txt_01'] = 'Bestand of map zullen in de huidige map gemaakt worden.';
$_['new_file_txt_02'] = 'Sommige ongeldige tekens zijn:';
$_['new_file_msg_01'] = 'Bestand of map niet aangemaakt:';
$_['new_file_msg_02'] = 'Naam bevat een ongeldig teken:';
$_['new_file_msg_03'] = 'Niet aangemaakt - geen naam opgegeven';
$_['new_file_msg_04'] = 'Bestand of map bestaat reeds:';
$_['new_file_msg_05'] = 'Aangemaakt bestand:';
$_['new_file_msg_07'] = 'Aangemaakt map:';

$_['CRM_txt_02']  = 'De nieuwe locatie moet reeds bestaan.';
$_['CRM_txt_04']  = 'Nieuwe Naam';
$_['CRM_msg_01']  = 'Fout - nieuwe bovenliggende locatie bestaat niet:';
$_['CRM_msg_02']  = 'Fout - bronbestand bestaat niet:';
$_['CRM_msg_03']  = 'Fout - nieuwe bestand of map bestaat reeds:';
$_['CRM_msg_05']  = 'Fout gedurende';

$_['delete_msg_03']   = 'Verwijderfout:';
$_['session_warning'] = 'Waarschuwing: Sessie verloopt binnenkort!';
$_['session_expired'] = 'SESSIE VERLOPEN';
$_['unload_unsaved']  = 'Niet opgeslagen wijzigen zullen verloren gaan!';
$_['confirm_reset']   = 'Herstel bestand en verlies niet opgeslagen wijzigingen?';

$_['OFCMS_requires']   = 'OneFileCMS vereist PHP';
$_['logout_msg']       = 'U bent succesvol afgemeld.';
$_['upload_error_01a'] = 'Upload Fout. Totale POST data (meerendeel bestandsgrootte) overschrijdt post_max_size =';
$_['upload_error_01b'] = '(van php.ini)';
$_['edit_caution_01']  = 'VOORZICHTIG';
$_['edit_caution_02']  = 'U bent de actieve kopie van OneFileCMS aan het bewerken - MAAK EEN BACK-UP & WEES VOORZICHTIG !!';
$_['time_out_txt']     = 'Sessie verloopt in:';

$_['error_reporting_01'] = 'Weergave van fouten is';
$_['error_reporting_02'] = 'Loggen van fouten is';
$_['error_reporting_03'] = 'Foutrapportage is ingesteld op';
$_['error_reporting_04'] = 'Toon foutsoorten';
$_['error_reporting_05'] = 'Onverwacht vroege uitvoer';
$_['error_reporting_06'] = '(niet, zelfs niet een blanko regel, zou al getoond mogen worden)';

$_['admin_txt_00'] = 'Oude Backup Gevonden';
$_['admin_txt_01'] = 'Een backup bestand is aangemaakt voor het geval er een fout tijdens het wijzigen van de gebruikersnaam of het wachtwoord plaatsvindt. Met andere woorden, het kan oude informatie bevatten en dient verwijderd te worden indien niet benodigd. In ieder geval, het bestand zal tijdens de volgende wijziging overschreven worden.';
$_['admin_txt_02'] = 'Algemene Informatie';
$_['admin_txt_14'] = 'Voor een kleine verbetering van de beveiliging, verander het standaard "salt" en/of methode gebruikt door OneFileCMS om het wachtwoord te hashen (en houdt deze geheim, natuurlijk). Alle kleine beetjes helpen...'; //####
$_['admin_txt_16'] = 'OneFileCMS kan gebruikt worden om zichzelf te wijzigen. Echter, draagt u zorg voor een backup indien er iets misgaat zoals de onvermijdelijke typvout...'; //####

$_['pw_change']  = 'Bewerk Wachtwoord';
$_['pw_current'] = 'Huidig Wachtwoord';
$_['pw_new']     = 'Nieuw Wachtwoord';
$_['pw_confirm'] = 'Bevestig Nieuw Wachtwoord';

$_['pw_txt_02'] = 'Wachtwoord / Gebruikersnaam regels:';
$_['pw_txt_04'] = 'Hoofdlettergevoelig: "A" is geen "a"';
$_['pw_txt_06'] = 'Moet minimaal 1 niet-spatie teken bevatten.';
$_['pw_txt_08'] = 'Mag spaties in het midden bevatten. Vb: "Dit is een wachtwoord of gebruikersnaam!"';
$_['pw_txt_10'] = 'Voorafgaande of afsluitende spaties worden genegeerd.';
$_['pw_txt_12'] = 'Bij het opnemen van wijzigingen wordt alleen 1 bestand bijgewerkt: of de actieve kopie van OneFileCMS of, indien opgegeven, een extern configuratiebestand.';
$_['pw_txt_14'] = 'Indien een onjuist huidig wachtwoord opgegeven wordt, zult u automatisch uitgelogd worden. U mag dan wel weer meteen inloggen.';

$_['change_pw_01'] = 'Wachtwoord gewijzigd!';
$_['change_pw_02'] = 'Wachtwoord NIET gewijzigd:';
$_['change_pw_03'] = 'Onjuist huidig wachtwoord opgegeven. Log in en probeert u het nog eens.';
$_['change_pw_04'] = '"Nieuw" en "Bevestig Nieuw" waardes komen niet overeen.';
$_['change_pw_05'] = 'Bijwerken';
$_['change_pw_06'] = 'extern configuratiebestand';

$_['un_change']     = 'Wijzig Gebruikersnaam';
$_['un_new']        = 'Nieuwe Gebruikersnaam';
$_['un_confirm']    = 'Bevestig Nieuwe Gebruikersnaam';
$_['change_un_01']  = 'Gebruikersnaam gewijzigd!';
$_['change_un_02']  = 'Gebruikersnaam NIET gewijzigd:';
$_['update_failed'] = 'Update mislukt - onmogelijk bestand op te slaan.';
$_['mcd_msg_01']    = 'bestanden verplaatst.';
$_['mcd_msg_02']    = 'bestanden gekopiëerd.';
$_['mcd_msg_03']    = 'bestanden verwijderd.';
