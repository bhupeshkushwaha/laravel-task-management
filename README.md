## Create a very simple Laravel web application for task management

### Description
 - Create task (info to save: task name, priority, timestamps)
 - Edit task
 - Delete task
 - Reorder tasks with drag and drop in the browser. Priority should automatically be updated based on this.
   - #1 priority goes at top,
    - #2 next down and so on 
  - Tasks should be saved to a mysql table.
  
BONUS POINT: add project functionality to the tasks. User should be able to select a project from a dropdown and only view tasks associated with that project.

You will be graded on how well-written & readable your code is, if it works, and if you did it the Laravel way.

### TECHNOLOGY
*  **Laravel**: Laravel 8.8 - PHP 7.4 or higher.
*  **MySQL**: Database.

  
### Installation and Configuration

**1. Enter git clone and the repository URL at your command line::**
~~~
git clone https://github.com/bhupeshkushwaha/laravel-task-management.git
~~~

**2. Goto survey-system directory and composer update:**
~~~
composer update
~~~

**3. Copy `env.example` to `.env` and generate app key:**
~~~
cp .env.example .env

php artisan key:generate
~~~

**3.1. You need to set your `APP_NAME` and `APP_URL` from `.env` file**


**4. Create a database `task_mng` or if you want to change database name just go in .env file and change value for `DB_DATABASE` key**


**5. Now, Run migration to create a table in your database:**
~~~
php artisan migration
~~~

**6. Finally, Start your server:**
~~~
php artisan serve
~~~
