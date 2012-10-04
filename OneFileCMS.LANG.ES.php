<?php
// OneFileCMS Language Settings v3.4.06

$_['LANGUAGE'] = 'Espanõl';
$_['LANG'] = 'ES';

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
$_['front_links_font_size'] = '1em';    //Buttons on Index page.
$_['front_links_margin_R']  = '.5em';
$_['button_font_size']      = '.9em';   //Buttons on Edit page.
$_['button_margin_L']       = '.4em';
$_['button_padding']        = '4px 5px';
$_['image_info_font_size']  = '.95em';  //show_img_msg_01  &  _02
$_['image_info_pos']        = '';      //If 1 or true, moves the info down a line for more space.
$_['select_all_label_size'] = '.84em';  //Font size of $_['Select_All']
$_['select_all_div_width']  = '73px';   //Width of space for $_['Select_All']

$_['R'] = 'R'; //R enombrar
$_['C'] = 'C'; //C Copiar
$_['D'] = 'E'; //E liminar

$_['Admin']   = 'Administrador';
$_['Cancel']  = 'Cancelar';
$_['Close']   = 'Cerrar';
$_['Copy']    = 'Copiar';
$_['Copied']  = 'Copiado';
$_['Create']  = 'Crear';
$_['Delete']  = 'Eliminar';
$_['DELETE']  = 'ELIMINAR';
$_['Deleted'] = 'Eliminado';
$_['Edit']    = 'Editar';
$_['Enter']   = 'Entrar';
$_['Error']   = 'Error';
$_['errors']  = 'errores';
$_['File']    = 'Archivo';
$_['Folder']  = 'Carpeta';
$_['From']    = 'De';
$_['Hash']    = 'Cadena';
$_['Move']    = 'Mover';
$_['Moved']   = 'Movido';
$_['on']      = 'activado';
$_['bytes']   = 'bytes';

$_['Password']   = 'Contraseña';
$_['Rename']     = 'Renombrar';
$_['successful'] = 'satisfactoriamente';
$_['To']         = 'Hacia';
$_['Upload']     = 'Subir';
$_['Username']   = 'Usuario';
$_['Log_In']     = 'Iniciar Sesión';
$_['Log_Out']    = 'Cerrar Sesión';

$_['Admin_Options']  = 'Opciones de Administración';
$_['Are_you_sure']   = '¿Estás seguro?';
$_['Edit_View']      = 'Editar / Ver Archivo';
$_['Upload_File']    = 'Subir Archivo';
$_['New_File']       = 'Archivo Nuevo';
$_['Ren_Move']       = 'Renombrar / Mover';
$_['Ren_Moved']      = 'Renombrado / Movido';
$_['New_Folder']     = 'Carpeta Nueva';
$_['Ren_Folder']     = 'Renombrar / Mover Carpeta';
$_['Del_Folder']     = 'Borrar Carpeta';
$_['Submit']         = 'Cargar';
$_['Move_Files']     = 'Mover Archivo(s)';
$_['Copy_Files']     = 'Copiar Archivo(s)';
$_['Del_Files']      = 'Eliminar Archivo(s)';
$_['Selected_Files'] = 'Seleccionar Archivos';
$_['Select_All']     = 'Seleccionar Todos';
$_['Clear_All']      = 'Limpiar';
$_['New_Location']   = 'Nueva Posición';
$_['No_files']       = 'No se seleccionó ningún archivo.';
$_['No_action']      = 'No se seleccionó ninguna acción.';
$_['Not_found']      = 'No encontrado';
$_['pass_to_hash']   = 'Contraseña del Hash:';
$_['Generate_Hash']  = 'Generar Hash';

$_['save_1']      = 'Guardar';
$_['save_2']      = '¡GUARDAR CAMBIOS!';
$_['reset']       = 'Reiniciar - perder los cambios';
$_['Wide_View']   = 'Vista Ampliada';
$_['Normal_View'] = 'Vista Normal';
$_['Open_View']   = 'Abrir/Ver en una ventana del navegador'; //## NT ##

$_['verify_msg_01']  = 'Sesión expirada.';
$_['verify_msg_02']  = 'POST INVÁLIDO';

$_['get_get_msg_01']    = 'El archivo no existe:';
$_['get_get_msg_02']    = 'Página requerida inválida:';
$_['check_path_msg_02'] = 'punto" o "punto punto" como segmentos no son permitidos.';
$_['check_path_msg_03'] = 'La dirección o el archivo contienen caracteres inválidos:';
$_['ord_msg_01']        = 'Un archivo con ese mismo nombre ya existe en el directorio asignado.';
$_['ord_msg_02']        = 'Guardando como';
$_['show_img_msg_01']   = 'Imagen mostrada a ~';
$_['show_img_msg_02']   = '% del tamaño (Ancho x Alto =';

$_['hash_txt_01'] = 'Las cadenas generadas por esta página pueden ser usadas para cambiar de forma manual la variable $HASHWORD en OneFileCMS, o en un archivo de configuración externo. De cualquier forma, ¡asegúrese de recordar la contraseña que usó para generar el hash (cadena)!';
$_['hash_txt_06'] = 'Ingrese la contraseña que quieras en la caja de texto siguiente y presioná enter.';
$_['hash_txt_07'] = 'La cadena se mostrará en un mensaje amarillo.';
$_['hash_txt_08'] = 'Copie y pegue esa cadena a la variable $HASHWORD en la sección de configuración.';
$_['hash_txt_09'] = 'Asegúrate de copiar TODO y SÓLO la cadena (sin dejar espacios en blanco o demás).';
$_['hash_txt_10'] = 'Haciendo doble click debería seleccionarlo...';
$_['hash_txt_12'] = 'Cuando estés listo, deslogueate y volvé a loguearte.';

$_['login_txt_01']  = 'Usuario:';
$_['login_txt_02']  = 'Contraseña:';
$_['login_msg_01a'] = 'Hubo ';
$_['login_msg_01b'] = 'intentos fallidos.';
$_['login_msg_02a'] = 'Por favor espere ';
$_['login_msg_02b'] = 'segundos para volver a intentar.';
$_['login_msg_03']  = 'INTENTO DE INICIO INVÁLIDO NÚMERO #';

$_['edit_note_00']  = 'NOTAS:';
$_['edit_note_01a'] = 'Recuérdalo- tu';
$_['edit_note_01b'] = 'es';
$_['edit_note_02']  = 'Entonces guardá antes que se acabe el tiempo, ¡o vas a perer los cambios!';
$_['edit_note_03']  = 'Con algunos navegadores, como Chrome, si clickeás el botón del navegador [Volver] y después [Continuar], puede que el estado del archivo no sea exacto. Para corregirlo, clickeá en el botón [Recargar].';
$_['edit_note_04']  = 'Chrome puede deshabilitar algunos textos si contienen javascript dentro en ciertos contextos.  Esto puede provocar problemas con el editor de OneFileCMS. Sin embargo, estos archivos pueden ser editados y guardados con OneFileCMS.  La función primaria que es perdida es el cambio de los colores del fondo (rojo/verde) indicando cuando o no el archivo tiene cambios no guardados.  El error se notificará después de la primera vez que se guarde ese archivo.';

$_['edit_h2_1']   = 'Viendo:';
$_['edit_h2_2']   = 'Editando:';
$_['edit_txt_01'] = 'No texto o tipo de archivo desconocido. Edición deshabilitada.';
$_['edit_txt_02'] = 'El archivo posiblemente contiene un caracter desconocido. Edición deshabilitada.';
$_['edit_txt_03'] = 'htmlspecialchars() devolvió una cadena vacía de lo que debería ser un archivo válido.';
$_['edit_txt_04'] = 'Este comportamiento puede ser inconsistente de versión a versión de PHP.';

$_['too_large_to_edit_01a'] = 'Edición deshabilita. Tamaño >';
$_['too_large_to_edit_02']  = 'Algunos navegadores (por ej.: IE) se vuelven inestables cuando se edita un texto largo dentro de un <textarea>.';
$_['too_large_to_edit_03']  = 'Ajustá la variable $MAX_EDIT_SIZE en la sección de configuración de OneFileCMS como sea necesario.';
$_['too_large_to_edit_04']  = 'Una simple prueba puede dar con el resultado necesario.';
$_['too_large_to_view_01a'] = 'Vista deshabilitada. Tamaño >';
$_['too_large_to_view_02']  = 'Clickeá en el botón de debajo para verlo como se ve normalmente en un navegador.';
$_['too_large_to_view_03']  = 'Ajustá $MAX_VIEW_SIZE en la sección de configuración de OneFileCMS como sea necesario.';
$_['too_large_to_view_04']  = '(El valor por defecto para $MAX_VIEW_SIZE es completamente arbitrario, y puede ser ajustado como sea necesario.)';

$_['meta_txt_01'] = 'Tamaño:';
$_['meta_txt_03'] = 'Actualizado:';
$_['edit_msg_01'] = 'Archivo Guardado:';
$_['edit_msg_02'] = 'bytes escritos.';
$_['edit_msg_03'] = 'Ocurrió un error guardando el archivo.';

$_['upload_txt_03']  = 'Nota: El tamaño máximo de subida es de:';
$_['upload_txt_01']  = 'por upload_max_filesize en php.ini.';
$_['upload_txt_04']  = 'Tamaño total de la subida:';
$_['upload_txt_02']  = 'por post_max_size en php.ini';

$_['upload_err_01']  = 'Error 1: Archivo demasiado pesado. Desde php.ini:';
$_['upload_err_02']  = 'Error 2: Archivo muy grande. (MAX_FILE_SIZE HTML form element)';
$_['upload_err_03']  = 'Error 3: El archivo se subió sólo parcialmente.';
$_['upload_err_04']  = 'Error 4: No se subió ningún archivo.';
$_['upload_err_05']  = 'Error 5: ';
$_['upload_err_06']  = 'Error 6: Carpeta temporal no encontrada.';
$_['upload_err_07']  = 'Error 7: No se pudo guardar el archivo en el disco.';
$_['upload_err_08']  = 'Error 8: Una extensión de PHP detuvo la subida del archivo.';

$_['upload_msg_01'] = 'No se seleccionó ningún archivo para subirlo.';
$_['upload_msg_02'] = 'La carpeta de destino no existe: ';
$_['upload_msg_03'] = 'Subida cancelada.';
$_['upload_msg_04'] = 'Subiendo:';
$_['upload_msg_05'] = '¡Subida satisfactoria!';
$_['upload_msg_06'] = 'Subida fallida: ';

$_['new_file_txt_01'] = 'Se creará un archivo nuevo en la carpeta actual.';
$_['new_file_txt_02'] = 'Algunos caracteres inválidos son: ';
$_['new_file_msg_01'] = 'Archivo nuevo no creado:';
$_['new_file_msg_02'] = 'El nombre contiene caracteres inválidos:';
$_['new_file_msg_03'] = 'Archivo nuevo no creado - no se especificó un nombre';
$_['new_file_msg_04'] = 'El archivo ya existe:';
$_['new_file_msg_05'] = 'Archivo creado:';
$_['new_file_msg_07'] = 'Carpeta creado:';

$_['CRM_txt_02']  = 'La nueva localización debe existir.';
$_['CRM_txt_03']  = 'Nombre antiguo y Carpeta:';
$_['CRM_txt_04']  = 'Nuevo nombre:';
$_['CRM_msg_01']  = 'Error - la localización padre no existe:';
$_['CRM_msg_02']  = 'Error - el archivo inicial no existe:';
$_['CRM_msg_03']  = 'Error - el archivo de objetivo no existe:';
$_['CRM_msg_05']  = 'Error en';

$_['delete_msg_01'] = 'Archivo Eliminado:';
$_['delete_msg_02'] = 'Error eliminando';

$_['delete_folder_msg_01'] = 'Carpeta no vacía.   Las carpetas deben estar vacías antes de ser eliminadas.';
$_['delete_folder_msg_02'] = 'Carpeta eliminada:';
$_['delete_folder_msg_03'] = 'ocurrió un error eliminándola.';

$_['session_warning'] = 'Advertencia: ¡La sesión terminará pronto!';
$_['session_expired'] = 'SESIÓN TERMINADA';
$_['unload_unsaved']  = '                 ¡Los cambios no guardados se perderán!';
$_['confirm_reset']   = '¿Reiniciar el archivo y descartar cambios no guardados?';

$_['OFCMS_requires']   = 'OneFileCMS necesita PHP';
$_['logout_msg']       = 'Has cerrado la sesión satisfactoriamente.';
$_['upload_error_01a'] = 'Eror de subida.  Total de datos POST (mayormente el peso del archivo) excedido post_max_size =';
$_['upload_error_01b'] = '(desde php.ini)';
$_['edit_caution_01']  = 'PRECAUCIÓN';
$_['edit_caution_02']  = 'Estás editando la copia activa de OneFileCMS - ¡HACÉ UNA COPIA DE SEGURIDAD Y TENÉ CUIDADO!';
$_['time_out_txt']     = 'Tiempo de Espera de Sesión Agotado:';

$_['error_reporting_01'] = 'Mostrar errores es'; //## Not sure about this one! ##
$_['error_reporting_02'] = 'El registro es';  //## Not sure about this one! ##
$_['error_reporting_03'] = 'El mostrar errores se ha marcado como'; //## Not sure about this one! ##
$_['error_reporting_04'] = 'Mostrando tipo de errores'; //## Not sure about this one! ##
$_['error_reporting_05'] = 'Fin de salida inesperado'; //## Not sure about this one! ##
$_['error_reporting_06'] = '(nada, nisiquiera espacios, han sido enviados aún)'; //## Not sure about this one! ##

$_['admin_txt_00'] = 'Backup Antiguo Encontrado';
$_['admin_txt_01'] = 'Este archivo fue creado en caso de error en caso de cambio fallido de usuario y contraseña. Por ello, puede contener información vieja y debería ser eliminado si no es necesario. De cualquier forma, se sobreescribirá automáticamente en el siguiente cambio de contraseña o usuario.';
$_['admin_txt_02'] = 'Información General';
$_['admin_txt_04'] = 'Desde la versión 3.3.13, OneFileCMS no tiene más la opción de tener la contraseña como texto plano, y sólo guarda una cadena, como la mayoría de los sistemas hacen.';
$_['admin_txt_12'] = 'Igualmente, por algunas consideraciones, este cambio fue un cambio académico. Esto significa que, en esta aplicación, hazte la idea de que no hace mucha mejora a la seguridad otorgada criptográficamente. Igualmente, elimina el texto como texto plano, lo que es algo bueno.';
$_['admin_txt_14'] = 'Para otro tip de seguridad, cambie la llave de seguridad y/o el método usado por OneFileCMS para almacenar la clave (y mantenlo en secreto, obviamente).  Acordate, cada granito ayuda...';
$_['admin_txt_16'] = 'Podés usar OneFileCMS para editarlo. Sin embargo, asegurate de hacer un backup...';

$_['pw_change']  = 'Cambiar Contraseña';
$_['pw_current'] = 'Contraseña Actual';
$_['pw_new']     = 'Nueva Contraseña';
$_['pw_confirm'] = 'Confirmar Contraseña Nueva';

$_['pw_txt_02'] = 'Reglas de Usuario / Contraseña:';
$_['pw_txt_04'] = '¡Se hace diferencia entre mayúsculas y minúsculas!';
$_['pw_txt_06'] = 'deben tener al menos un caracter.';
$_['pw_txt_08'] = 'Deben tener espacios en el medio. Por ejemplo: "¡Esta es una contraseña o usuario!"';
$_['pw_txt_10'] = 'Los espacios al inicio o al final serán eliminados.';
$_['pw_txt_12'] = 'Para guardar el cambio, sólo un archivo es actualizado: la copia activa de OneFileCMS, o, si fue especificado, un archivo de configuración externa.';
$_['pw_txt_14'] = 'Si se ingresa la contraseña actual de forma incorrecta, serás deslogueado y tendrás que volver a loguearte.';

$_['change_pw_01'] = '¡Contraseña Cambiada!';
$_['change_pw_02'] = 'Contraseña NO cambiada:';
$_['change_pw_03'] = 'Contraseña anterior inválida. Logueate e intenta de nuevo.';
$_['change_pw_04'] = 'La contraseña y su confirmación no coinciden.';
$_['change_pw_05'] = 'Actualizando';
$_['change_pw_06'] = 'archivo de configuración externa';

$_['un_change']     = 'Cambiar Nombre de Usuario';
$_['un_new']        = 'Nuevo Usuario';
$_['un_confirm']    = 'Confirmar Nuevo Nombre de Usuario';
$_['change_un_01']  = '¡Nombre de Usuario Actualizado!';
$_['change_un_02']  = 'Nombre de Usuario NO Actualizado:';
$_['update_failed'] = 'Actualización fallida. No se pudo guardar el archivo.';
$_['mcd_msg_01']    = 'archivos movidos satisfactoriamente.';
$_['mcd_msg_02']    = 'archivos copiados satisfactoriamente.';
$_['mcd_msg_03']    = 'archivos eliminados satisfactoriamente.';

