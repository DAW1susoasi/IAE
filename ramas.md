# Trabajando con ramas por parejas
***
1. Crear un repositorio.
- asirpapa crea el repositorio "colaborativo" en github:
![](./images/11.png)
- asirpapa invita a colaborar en el proyecto a DAW1susoasi:
![](./images/12.png)
![](./images/13.png)
***
2. Trabajar por parejas sobre este repositorio creando ramas y haciendo commits sobre el mismo fichero generando que aparezca un conflicto.
- asirpapa clona el repositorio en local:
`$ git clone` <https://github.com/asirpapa/colaborativo.git>
![](./images/21.png)
- asirpapa añade los archivos index.html y styles.css: hjhijhiuhiuhiuhiuhui 
![](./images/22.png)
- asirpapa añade los nuevos archivos al repositorio local y los sincroniza con el repositorio remoto:
```bash
$ git add .
$ git commit -m "Nuevos archivos web"
$ git push
```
![](./images/23.png)
- DAW1susoasi clona el repositorio con los archivos web iniciales sobre los que luego cada uno creará su rama y modificará lo que tenga que modificar:
`$ git clone` <https://github.com/asirpapa/colaborativo.git>
![](./images/31.png)
- DAW1susoasi crea su rama para trabajar con ella:
```bash
$ git branch suso
$ git remote -v
$ git push origin suso:suso (la rama en GitHub no existe pero nos la crea)
```
![](./images/32.png)
![](./images/33.png)
- asirpapa crea su rama para trabajar con ella:
```bash
$ git branch papa
$ git remote -v
$ git push origin papa:papa (la rama en GitHub no existe pero nos la crea)
```
![](./images/41.png)
![](./images/42.png)
- asirpapa modifica la línea 3 del archivo styles.css en su rama, hace un merge con la la rama principal, lo sube a github y finalmente elimina la rama tanto local como remota.
```bash
$ git checkout papa
$ git add .
$ git commit -m "modificado systes.css"
$ git push origin papa:papa
```
![](./images/43.png)
![](./images/51.png)
```bash
$ git checkout main
$ git merge papa
$ git push
```
![](./images/52.png)
![](./images/53.png)
```bash
$ git branch -d papa
$ git branch
```
![](./images/61.png)
```bash
$ git push origin --delete papa
```
![](./images/62.png)
![](./images/63.png)
- DAW1susoasi modifica la línea 3 del archivo styles.css en su rama, hace un merge con la la rama principal (**sin hacer previamente pull en la rama principal para actualizarla**) y lo sube a github:
```bash
$ git checkout suso
$ git add .
$ git commit -m "modificado styles.css"
$ git push origin suso:suso
```
![](./images/64.png)
```bash
$ git checkout main
$ git merge suso
$ git push
```
![](./images/71.png)
***
3. Gestión y resolución del conflicto.
- DAW1susoasi que fue quien tuvo el problema lo soluciona con:
```bash
$ git pull
$ git config pull.rebase false
$ git pull
$ git add .
$ git commit -m "solucion conflicto"
$ git push
$ git status
```
![](./images/72.png)
- DAW1susoasi finalmente elimina la rama tanto local como remota:
```bash
$ git branch -d suso
$ git branch
$ git push origin --delete suso
```
![](./images/81.png)
***
4. Mostrar cómo aparece el historial de commits con las fechas y los autores, tanto desde consola como desde github.
```bash
$ git log
```
![](./images/82.png)
![](./images/83.png)
Moraleja: antes de que se produzca el error (antes de hacer merge) hay que hacer **pull** en la rama principal del repositorio local para que se actualice (internamente hace un merge del repositorio local con el remoto).