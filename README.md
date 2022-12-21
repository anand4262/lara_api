## Project Setup

-   Download the project from github using ``` git clone https://github.com/anand4262/lara_api.git ```
-   Open a terminal and navigate inside of your project folder
-   then type composer install
-   after that type cp .env.example to .env
-   create a databse
-   open .env file and update DB_DATABASE, DB_USERNAME, DB_PASSWORD to your creds
-   type php artisan migrate
-   run php artisan serve in the terminal
-   test the following endpoints in postman

## API Endpoints

-   Base Path: {local path}/api/v1/
-   Resources

    -   users {/users}
    -   posts {/posts}
    -   comments {/comments}

-   User Resource: {/users}
    -   register {base path}/users method: post
    -   update info {base path}/users method: patch
-   Post Resource: {/posts}
    -   create post {base_path}/{user_id}/posts method:post
    -   get post {base_path}/{user_id}/posts method:get
    -   update post {base_path}/{user_id}/posts/{post_id} method:patch
    -   delete post {base_path}/{user_id}/posts/{post_id} method:delete
-   Comments {/comments}
    -   create comments {base_path}/{post_id}/comments method:post

## Note

    Add _method="patch" as a param for update requests
    Add _method="delete" as a param for delete requets

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
