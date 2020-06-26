# symfony

##### запустить докер и выполнить миграцию:
* docker-compose build
* docker-compose up -d
* docker exec -it fpm bash 
* php bin/console doctrine:migrations:migrate

##### Создание тем:
http://127.0.0.1:8098/theme  
Пример JSON:  
{
    "name":"Гитара"
}  
  
  ##### Создание учителя:
http://127.0.0.1:8098/teacher   
Пример JSON:  
{
    "name":"Teacher_2",
    "email":"teacher2@mail.ru",
    "password":"test_teacher",
    "themes":[1]
}

  ##### Создание ученика:
http://127.0.0.1:8098/student    
Пример JSON:  
{
    "name":"Ученик_3",
    "email":"student_3@test.ru",
    "password":"test_student"
}

  ##### Создание слота учителя:
http://127.0.0.1:8098/freetime    
Пример JSON:  
{
    "teacherId":1,
    "dateFrom":"01.07.2020 11:00",
    "dateTo":"01.07.2020 20:00"
}

  ##### Создание урока:
http://127.0.0.1:8098/lesson    
Пример JSON:  
{
    "teacherId":1,
    "studentId":1,
    "themeId":1,
    "freetimeId":1,
    "dateFrom":"01.07.2020 13:10",
    "dateTo":"01.07.2020 14:00"
}
