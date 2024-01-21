# Freestyle job - despliegue web/git  
***
Crear un job de Jenkins que descargue el código de un proyecto web alojado en tu repositorio de github.  
El job debe contactar con el repositorio y descargarse el proyecto web. Una vez descargado se debe copiar el proyecto web en la carpeta www de tu servidor Apache de prácticas anteriores.  
Documentar gráficamente los pasos seguidos, así como detallar brevemente los pasos  y problemas encontrados.  

El truco está en conectar la carpeta /home/papi/Escritorio/docker-lamp/www del servidor web Apache con el workspace del nuevo job /var/jenkins_home/workspace/02 mediante un volumen.  
Arrancamos jenkins mediante el siguiente comando:  
```docker run -p 8080:8080 -p 50000:50000 -v /home/papi/Escritorio/jenkins:/var/jenkins_home -v /etc/passwd:/data/passwd:ro -v /home/papi/Escritorio/docker-lamp/www:/var/jenkins_home/workspace/02 --name jenkins jenkins/jenkins:lts```  

Creamos el job **02** de tipo estilo libre.  
1. Configuramos el origen del código fuente **Git**  
![](./img/Captura%20de%20pantalla_2024-01-21_13-59-08.png)  
2. Introducimos la URL de nuestro repositorio (dado que el acceso es libre no introducimos credenciales).  
![](./img/Captura%20de%20pantalla_2024-01-21_14-04-20.png)  
3. Comprobamos que la rama del repositorio es correcta.  
![](./img/Captura%20de%20pantalla_2024-01-21_14-06-55.png)  
4. Para que se descargue el repositorio añadimos una Acción para ejecutar después de tipo Git Publisher -> Push Only If Build Succeeds  
![](./img/Captura%20de%20pantalla_2024-01-21_14-19-35.png)  
5. Tras guardar el job y ponerlo en marcha podemos comprobar que el contenido de ambas carpetas es el mismo.
![](./img/Captura%20de%20pantalla_2024-01-21_14-29-26.png)  