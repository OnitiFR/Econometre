### Installation

- copier le fichier call_oniti.lua dans le même dossier que le fichier Econometre.lua
- Editer le fichier config.php avec les bonnes valeurs pour lua_file_name si jamais vous l'avez renomé et lua_path correspondant au dossier de Econometre.lua

## Test
-  lancer php -S localhost:8000
- et vous pouvez teser avec la commande suivante :

`curl --request POST 
  --url http://localhost:8000/ 
  --header 'accept: application/json, text/plain, */*' 
  --header 'content-type: application/json;charset=UTF-8' 
  --data '{
  "culture":"fr",
  "nbPersons":"1",
  "department":69,
  "city":"Trappes",
  "constYear":3,
  "glazing":1,
  "works":2,
  "tempCons":2,
  "actualSys":1,
  "transmitter":2,
  "dHWActualSystem":"1",
  "dHWChangement":"true",
  "occupancy":[
     1,
     1,
     1,
     1,
     1,
     1,
     1,
     1,
     1,
     1,
     1,
     1
  ],
  "systemAge":1,
  "area":70
}'`