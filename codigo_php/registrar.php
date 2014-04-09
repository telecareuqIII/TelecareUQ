<?php 
session_start();//crea una sesión para ser usada mediante una petición GET o POST, o pasado por una cookie y la sentencia include_once es la usaremos para incluir el archivo de conexión a la base de datos que creamos anteriormente. 
include_once "conexion.php"; 
<form action="" method="post" class="registro"> 
<div><label>Nombre:</label> 
<input type="text" name="nombre"></div> 
<div><label>Nombre de Usuario:</label> 
<input type="text" name="nombreusuario"></div> 
<div><label>Email:</label> 
<input type="text" name="email"></div> 
<div><label>Contraseña:</label> 
<input type="password" name="contrasena"></div> 
<div><label>Repetir Contraseña:</label> 
<input type="password" name="repassword"></div> 
<div> 
<input type="submit" name="enviar" value="Registrar"></div> 
</form> 
/*Creamos el formulario con el campo de Usuario que se llamara $_POST['usuario'] y 2 campos para la clave y uno mas para confirmar si escribió bien la clave, se llamaran $_POST['password'] y $_POST['repassword'] respectivamente, procedemos a escribir el codigo que procesara y validara lo que el usuario ingrese:*/ 
if(isset($_POST['enviar']))//para saber si el botón registrar fue presionado. 
{ 
    if($_POST['nombre'] == '' or $_POST['nombreusuario'] == '' or $_POST['email'] == ''or $_POST['contrasena'] == ''or $_POST['repassword'] == '') 
    { 
        echo 'Por favor llene todos los campos.';//Si los campos están vacíos muestra el siguiente mensaje, caso contrario sigue el siguiente codigo. 
    } 
    else 
    { 
        $sql = 'SELECT * FROM au83c_users'; 
        $rec = mysql_query($sql); 
        $verificar_usuario = 0;//Creamos la variable $verificar_usuario que empieza con el valor 0 y si la condición que verifica el usuario(abajo), entonces la variable toma el valor de 1 que quiere decir que ya existe ese nombre de usuario por lo tanto no se puede registrar 
  
        while($result = mysql_fetch_object($rec)) 
        { 
            if($result->name == $_POST['nombreusuario']) //Esta condición verifica si ya existe el usuario 
            { 
                $verificar_usuario = 1; 
            } 
        } 
  
        if($verificar_usuario == 0) 

        { 
				
            if($_POST['password'] == $_POST['repassword'])//Si los campos son iguales, continua el registro y caso contrario saldrá un mensaje de error. 
            { 
                $usuario = $_POST['usuario']; 
                $password = $_POST['password']; 
                $sql = "INSERT INTO au83c_users (name,username,email,password) VALUES ('$nombre','$nombreusuario','$email','$contrasena')";//Se insertan los datos a la base de datos y el usuario ya fue registrado con exito. 
                mysql_query($sql); 
  
                echo 'Usted se ha registrado correctamente.'; 
            } 
            else 
            { 
                echo 'Las claves no son iguales, intente nuevamente.'; 
            } 
        } 
        else 
        { 
            echo 'Este usuario ya ha sido registrado anteriormente.'; 
        } 
    } 
}?> 