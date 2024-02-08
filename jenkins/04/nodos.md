# Creación de nodos (agents)  
***
- Nodo conectado via Java Web Start (JNLP) (Agent.jar)  
- Nodo en máquina EC2 de AWS (SSH)  
Detalla los pasos seguidos con capturas de pantalla y muestra que el nodo se ha conectado y que ejecuta correctamente alguna tarea.  

Antes no lo necesitábamos, pero para esta práctica sí vamos a necesitar acceder al puerto 50000 por defecto para el nodo, por lo que levantaremos el chiringuito con el siguiente docker-compose.yml:  
```
version: "3"

services:
jenkins:
    user: root
    image: jenkins/jenkins:lts
    container_name: jenkins
    ports:
    - "8080:8080"
    # Puerto necesario para el nodo
    - "50000:50000"
    volumes:
    # Para la persistencia
    - ./jenkins_home:/var/jenkins_home
    networks:
    - mynet
    
networks:
mynet:
    driver: bridge
```
**Importante:** Necesitamos javo 8 o java 11 instalado **en los nodos**  
Comprobamos si lo tenemos instalado con ```java -version```  
Si no lo tenemos instalado, en un sistema Unix instalamos la versión 11 con ```apt install openjdk-11-jdk```
1. Vamos a crear un nodo en nuestra red local conectado mediante Java Web Start (JNLP) (Agent.jar)  
    - Administrar Jenkins -> Nodes -> New Node  
    Le damos un nombre y de tipo permanente  
    ![](./img/2024-02-03_172352.png)  
    Lo configuramos tal que así y el resto por defecto  
    ![](./img/2024-02-03_190515.png)  
    - Ya tenemos creado el nodo, ahora para configurar la conexión hacemos click sobre el nombre  
    ![](./img/2024-02-03_191051.png)  
    Dado que el nodo está basado en Unix, éste es el código que deberemos ejecutar en el nodo  
    ![](./img/2024-02-03_191415.png)  
    Salida de la ejecución del código en el nodo  
    ![](./img/2024-02-04_130321.png)  
    El nodo ya no aparece en rojo  
    ![](./img/2024-02-04_130737.png)  
    - Ahora que ya tenemos el nodo y está conectado podemos asignarle un job facilito de estilo libre que cree el archivo job04.txt en su workspace y contenido "Job 04 exitoso"  
    ![](./img/2024-02-04_134455.png)  
    Importante indicar que la tarea se ejecutará en el nodo  
    ![](./img/2024-02-04_135018.png)  
    - Tras la ejecución del job 04 podemos comprobar que en el nodo se han creado las carpetas workspace y el nombre del job, junto con el archivo job04.txt con contenido "Job 04 exitoso"  
    ![](./img/2024-02-04_140358.png)  
    ![](./img/Captura%20de%20pantalla_2024-02-08_08-19-11.png)  
2. Vamos a crear un nodo en máquina EC2 de AWS conectado mediante SSH  
    **Si no localizamos el archivo .pem que nos descargamos al crear la instancia en AWS no podremos usarlo como credenciales, por lo que tendremos que seguir los siguientes pasos:**  
    - Con el usuario ubuntu generamos un certificado/clave SSH con ```ssh-keygen```  
    - Añadimos el contenido de ~/.ssh/id_rsa.pub al archivo ~/.ssh/authorized_keys con ```cat ~/.ssh/id_rsa.pub | sudo tee -a ~/.ssh/authorized_keys```  
    - Copiamos la salida de la clave privada ```cat ~/.ssh/id_rsa``` ya que lo necesitaremos cuando configuremos las nuevas credenciales que crearemos en el paso siguiente   
    - Administrar Jenkins -> Credencials -> System -> Global credentials (unrestricted) -> Add Credentials  
    Las configuraremos así pegando la clave privada copiada anteriormente  
    ![](./img/2024-02-04_205913.png)  
    - Administrar Jenkins -> Nodes -> New Node  
    Le damos un nombre y de tipo permanente  
    ![](./img/2024-02-04_150222.png)  
    Lo configuramos tal que así seleccionando en credentials las anteriormente creadas, y el resto por defecto  
    ![](./img/2024-02-04_210324.png)  
    Launch agent para iniciar la conexión  
    Salida de los logs  
    ![](./img/2024-02-04_211931.png)  
    El nodo ya no aparece en rojo  
    ![](./img/2024-02-04_212158.png)  
    - Ahora que ya tenemos el nodo y está conectado podemos asignarle un job facilito de estilo libre que cree el archivo job05.txt en su workspace y contenido "Job 05 exitoso"  
    ![](./img/2024-02-04_212930.png)  
    Importante indicar que la tarea se ejecutará en el nodo  
    ![](./img/2024-02-04_213128.png)  
    - Tras la ejecución del job 05 podemos comprobar que en el nodo se han creado las carpetas workspace y el nombre del job, junto con el archivo job04.txt con contenido "Job 05 exitoso"  
    ![](./img/2024-02-04_213503.png)  
    ![](./img/Captura%20de%20pantalla_2024-02-08_08-21-59.png)  