# Symfony Blog

This is a simple blog application built with the Symfony framework, designed to showcase the basic functionalities of a blogging platform. The application is containerized using Docker, which makes it easy to set up and run locally.

## Features

The Symfony Blog application includes the following features:

- **Admin / user authentication system:** Users can register and log in with different roles and permissions.
- **Pagination (KnpPaginator):** Users can navigate through a large number of posts or comments.
- **Infinite scrolling:** Users can load more posts or comments as they scroll down the homepage.
- **WYSIWYG editor (CKEditor) for the posts:** Users can format their text, insert images, and even add code snippets.
- **Leaving without saving warning:** Users are warned if they try to leave the post editor without saving their changes.
- **Audio playback for the posts:** Users can upload and listen to audio files associated with their blog posts.
- **Comment system:** Users can comment on blog posts and have discussions with other users.
- **Search functionality:** Users can search for blog posts by title (the search uses the Levenshtein algorithm to find the closest matches)
- **Admin dashboard:** Admin users can manage the blog posts, categories and comments.
- **Responsive design:** The application is fully responsive and works on all devices.

## Docker Development Environment

To set up the development environment using Docker, please follow the below steps:

### Prerequisites

- Docker and Docker Compose should be installed on your system.
- Clone the repository to your local machine.

### Build the Docker Image

To build the Docker image, navigate to the project root directory and run the following command:

```bash
docker compose -f docker-compose.dev.yml build
```

This will create the Docker image for the project and download all the necessary dependencies.

### Start the Docker Containers

Once the Docker image is built, start the containers by running the following command:

```bash
docker compose -f docker-compose.dev.yml up -d
```

This will start the containers in detached mode, allowing you to run other commands in the same terminal window.

### Run Doctrine Migrations

To set up the database schema, run the Doctrine migrations by executing the following command:

```bash
docker compose -f docker-compose.dev.yml exec php bin/console doctrine:migrations:migrate --no-interaction
```

This will create the necessary tables and schema for the application.

### Load the Fixtures

Finally, load the sample data into the database by running the following command:

```bash
docker compose -f docker-compose.dev.yml exec php bin/console doctrine:fixtures:load --no-interaction
```

This will populate the database with some sample blog posts and comments, allowing you to see the application in action.

## Accessing the Application

The application should now be accessible at http://localhost:8080. You can access the blog posts and comments by navigating to the relevant pages on the website.

## Conclusion

That's it! You now have a fully functional Symfony blog running on your local machine using Docker. You can make changes to the code and see them reflected in real time, without having to worry about setting up the environment. Happy blogging!
