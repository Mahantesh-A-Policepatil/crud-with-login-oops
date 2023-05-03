# crud-with-login-oops
  - Start XAMPP or WAMP server
  - Create a new database `testcrud`
  - Create following tables
  
      ```
      DROP TABLE IF EXISTS `users`;
      CREATE TABLE IF NOT EXISTS `users` (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `user_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        `password` varchar(100) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
      
      
      DROP TABLE IF EXISTS `products`;
      CREATE TABLE IF NOT EXISTS `products` (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `quantity` int NOT NULL,
        `price` decimal(10,2) NOT NULL,
        `user_id` int NOT NULL,
        PRIMARY KEY (`id`),
        KEY `FK_products_1` (`user_id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
      `
   - Navigate to following path on your browser 
     -- http://localhost/Login-Crud/views/user/login.php

